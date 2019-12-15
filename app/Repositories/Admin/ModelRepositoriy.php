<?php
namespace App\Repositories\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ModelTemplate;
use App\Repositories\Repository;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;

class ModelRepositoriy extends Repository {
	public function __construct(ModelTemplate $model) {
		$this->model = $model;
		$this->permission = '';
		$this->route = 'admin.models.';
		$this->action_exeption = ['show'];
	}
	/**
	 * Get model query
	 *
	 * @return ModelTemplate query
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
		return $this->model->all()->pluck('name', 'id')->prepend(__('service.select', ['attribute' => __('page.model')]), '');
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
	 * @return ModelTemplate
	 */
	public function find($id) {
		return $this->model->find($id);
	}
	/**
	 * Find model with given id or throw an error.
	 *
	 * @param integer $id
	 * @return ModelTemplate
	 */
	public function findOrFail($id, $field = 'message') {
		$model = $this->model->find($id);
		if (!$model) {
			throw ValidationException::withMessages([$field => __('service.not_found', ['attribute' => __('page.model')])]);
		}
		return $model;
	}
	/**
	 * Get all data for Index
	 */
	public function datatable() {
		$models = $this->model->where('business_id', $this->getBussinessId())
			->select(['name', 'category_id', 'brand_id', 'id']);

		return Datatables::of($models)
			->addIndexColumn()
			->editColumn('name', function ($model) {
				return '<strong>' . $model->name . '</strong>';
			})
			->editColumn('category_id', function ($model) {
				return $model->category->name;
			})
			->editColumn('brand_id', function ($model) {
				return $model->brand->name;
			})
			->addColumn('action', function ($model) {
				$action['route'] = $this->route;
				$action['permission'] = $this->permission;
				$action['action_exeption'] = $this->action_exeption;
				return view('admin.model.action', compact('model', 'action'));

			})

			->removeColumn(['created_at', 'updated_at'])
			->rawColumns(['action', 'name', 'status'])
			->make(true);
	}
	public function preRequisite($id = Null) {

		$categories = Category::where('parent_id', 0)->pluck('name', 'id');
		$brands = Brand::all()->pluck('name', 'id');

		$compact = compact('categories', 'brands');
		return $compact;
	}
	/**
	 * Create a new model.
	 *
	 * @param array $params
	 * @return ModelTemplate
	 */
	public function create($params) {
		$name = gv($params, 'name');
		$category_id = gv($params, 'category_id');
		$brand_id = gv($params, 'brand_id');
		$business_id = $this->getBussinessId();
		$formatted = [];
		foreach ($name as $value) {
			$formatted = [
				'name' => $value,
				'category_id' => $category_id,
				'brand_id' => $brand_id,
				'business_id' => $business_id,
			];
			$tax_rate = $this->model->forceCreate($formatted);
		}
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

		$name = gv($params, 'name');
		$category_id = gv($params, 'category_id');
		$brand_id = gv($params, 'brand_id');
		$business_id = $this->getBussinessId();
		$formatted = [
			'name' => $name,
			'category_id' => $category_id,
			'brand_id' => $brand_id,
			'business_id' => $business_id,
		];
		return $formatted;
	}
	/**
	 * Update given model.
	 *
	 * @param ModelTemplate $model
	 * @param array $params
	 *
	 * @return ModelTemplate
	 */
	public function update(ModelTemplate $model, $params) {
		$model->forceFill($this->formatParams($params, $model->id))->save();
		return $model;
	}

	/**
	 * Find model & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return ModelTemplate
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
	public function delete(ModelTemplate $model) {
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
		$msg = trans_choice('service.multiple_deleted', count($ids), ['attribute' => __('page.model'), 'value' => count($ids)]);
		return $msg;
	}
	public function actions($data) {
		if ($data['action'] == 'delete') {
			return $this->deleteMultiple($data['ids']);
		}
	}
}