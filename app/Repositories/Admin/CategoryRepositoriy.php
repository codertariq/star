<?php
namespace App\Repositories\Admin;

use App\Models\Category;
use App\Repositories\Repository;
use App\Utils\Util;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;

class CategoryRepositoriy extends Repository {
	public $commonUtil;
	public function __construct(Category $model, Util $commonUtil) {
		$this->model = $model;
		$this->commonUtil = $commonUtil;
		$this->permission = '';
		$this->route = 'admin.categories.';
		$this->action_exeption = ['show'];
	}
	/**
	 * Get model query
	 *
	 * @return Category query
	 */
	public function getQuery() {
		return $this->model->query();
	}

	public function getBussinessId() {
		return request()->session()->get('user.business_id');
	}
	public function getUserId() {
		return request()->session()->get('user.id');
	}
	/**
	 * Count model
	 *
	 * @return integer
	 */
	public function count() {
		return $this->model->count();
	}

	/**
	 * List all model by name & id
	 *
	 * @return array
	 */
	public function selectAll() {
		return $this->model->all()->pluck('name', 'id')->prepend(__('service.select', ['attribute' => __('page.category')]), '');
	}
	/**
	 * List all model by id
	 *
	 * @return array
	 */
	public function listId() {
		return $this->model->all()->pluck('id')->all();
	}
	/**
	 * Get all model
	 *
	 * @return array
	 */
	public function getAll() {
		return $this->model->all();
	}
	/**
	 * Find model with given id.
	 *
	 * @param integer $id
	 * @return Category
	 */
	public function find($id) {
		return $this->model->find($id);
	}
	/**
	 * Find model with given id or throw an error.
	 *
	 * @param integer $id
	 * @return Category
	 */
	public function findOrFail($id, $field = 'message') {
		$model = $this->model->find($id);
		if (!$model) {
			throw ValidationException::withMessages([$field => __('service.not_found', ['attribute' => __('page.category')])]);
		}
		return $model;
	}
	/**
	 * Get all data for Index
	 */
	public function datatable() {
		$models = $this->model->where('business_id', $this->getBussinessId())
			->select(['name', 'short_code', 'id', 'parent_id']);

		return Datatables::of($models)
			->addIndexColumn()
			->editColumn('name', function ($row) {
				if ($row->parent_id != 0) {
					return '--' . $row->name;
				} else {
					return $row->name;
				}
			})
			->addColumn('action', function ($model) {

				$action['route'] = $this->route;
				$action['permission'] = $this->permission;
				$action['action_exeption'] = $this->action_exeption;
				return view('admin.category.action', compact('model', 'action'));

			})

			->removeColumn(['created_at', 'updated_at'])
			->rawColumns(['action', 'name', 'status'])
			->make(true);
	}
	public function preRequisite($id = Null) {

		$categories = Category::where('business_id', $this->getBussinessId())
			->where('parent_id', 0)
			->select(['name', 'short_code', 'id'])
			->get();
		$parent_categories = [];
		if (!empty($categories)) {
			foreach ($categories as $category) {
				$parent_categories[$category->id] = $category->name;
			}
		}
		$compact = compact('parent_categories');
		if ($id) {
			$categories = Category::where('business_id', $this->getBussinessId())
				->where('parent_id', 0)
				->where('id', '!=', $id)
				->select(['name', 'short_code', 'id'])
				->get();

			$parent_categories = [];
			if (!empty($categories)) {
				foreach ($categories as $category) {
					$parent_categories[$category->id] = $category->name;
				}
			}
			$is_parent = false;

			if ($category->parent_id == 0) {
				$is_parent = true;
				$selected_parent = null;
			} else {
				$selected_parent = $category->parent_id;
			}
			$compact = compact('parent_categories', 'selected_parent', 'is_parent');
		}
		return $compact;
	}
	/**
	 * Create a new model.
	 *
	 * @param array $params
	 * @return Category
	 */
	public function create($params) {
		$tax_rate = $this->model->forceCreate($this->formatParams($params));
		return $tax_rate;
	}
	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param integer $model_id
	 * @return array
	 */
	private function formatParams($params, $model_id = null) {
		$formatted = [
			'name' => gv($params, 'name'),
			'short_code' => gv($params, 'short_code'),
			'created_by' => $this->getUserId(),
			'business_id' => $this->getBussinessId(),
		];

		if (gbv($params, 'add_as_sub_cat') && gbv($params, 'add_as_sub_cat') == 1 && gv($params, 'parent_id')) {
			$formatted['parent_id'] = gv($params, 'parent_id');
		} else {
			$formatted['parent_id'] = 0;
		}

		return $formatted;
	}
	/**
	 * Update given model.
	 *
	 * @param Category $model
	 * @param array $params
	 *
	 * @return Category
	 */
	public function update(Category $model, $params) {
		$model->forceFill($this->formatParams($params, $model->id))->save();
		return $model;
	}

	/**
	 * Find model & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return Category
	 */
	public function deletable($id) {
		$model = $this->findOrFail($id);
		if ($model->is_default) {
			throw ValidationException::withMessages(['message' => __('service.default_role')]);
		}
		return $model;
	}
	public function updateable($id) {
		$model = $this->findOrFail($id);
		if ($model->is_default) {
			throw ValidationException::withMessages(['message' => __('service.default_role')]);
		}
		return $model;
	}
	/**
	 * Delete model.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(Category $model) {
		return $model->delete();
	}
	/**
	 * Delete multiple model.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function deleteMultiple($ids) {
		foreach ($ids as $id) {
			$model = $this->deletable($id);
			$model = $this->findOrFail($id)->delete();
		}
		$msg = trans_choice('service.multiple_deleted', count($ids), ['attribute' => __('page.category'), 'value' => count($ids)]);
		return $msg;
	}
	public function actions($data) {
		if ($data['action'] == 'delete') {
			return $this->deleteMultiple($data['ids']);
		}
	}
}