<?php
namespace App\Repositories\Admin;

use App\Models\VariationTemplate;
use App\Models\VariationValueTemplate;
use App\Repositories\Repository;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;

class VariationTemplateRepositoriy extends Repository {
	public function __construct(VariationTemplate $model) {
		$this->model = $model;
		$this->permission = '';
		$this->route = 'admin.variation-templates.';
		$this->action_exeption = ['show'];

	}
	/**
	 * Get model query
	 *
	 * @return VariationTemplate query
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
		return $this->model->all()->pluck('name', 'id')->prepend(__('service.select', ['attribute' => __('page.variation_template')]), '');
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
	 * @return VariationTemplate
	 */
	public function find($id) {
		return $this->model->find($id);
	}
	/**
	 * Find model with given id or throw an error.
	 *
	 * @param integer $id
	 * @return VariationTemplate
	 */
	public function findOrFail($id, $field = 'message') {
		$model = $this->model->where('business_id', $this->getBussinessId())->find($id);
		if (!$model) {
			throw ValidationException::withMessages([$field => __('service.not_found', ['attribute' => __('page.variation_template')])]);
		}
		return $model;
	}
	/**
	 * Get all data for Index
	 */
	public function datatable() {
		$models = $this->model->where('business_id', $this->getBussinessId())
			->with(['values']);
		// ->select('id', 'name', DB::raw("(SELECT COUNT(id) FROM product_variations WHERE product_variations.variation_template_id=variation_template.id) as total_pv"));

		return Datatables::of($models)
			->addIndexColumn()
			->editColumn('name', function ($model) {
				return '<strong>' . $model->name . '</strong>';
			})
			->editColumn('values', function ($data) {
				$values_arr = [];
				foreach ($data->values as $attr) {
					$values_arr[] = $attr->name;
				}
				return implode(', ', $values_arr);
			})
			->addColumn('action', function ($model) {
				$action['route'] = $this->route;
				$action['permission'] = $this->permission;
				$action['action_exeption'] = $this->action_exeption;
				return view('admin.variation_template.action', compact('model', 'action'));

			})

			->removeColumn(['created_at', 'updated_at'])
			->rawColumns(['action', 'name'])
			->make(true);
	}
	public function preRequisite($id = Null) {

		//
	}
	/**
	 * Create a new model.
	 *
	 * @param array $params
	 * @return VariationTemplate
	 */
	public function create($params) {
		$variation = $this->model->forceCreate($this->formatParams($params));
		if (gv($params, 'variation_values')) {
			$values = gv($params, 'variation_values');
			$data = [];
			foreach ($values as $value) {
				if (!empty($value)) {
					$data[] = ['name' => $value];
				}
			}
			$variation->values()->createMany($data);
		}

		return $variation;
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
			'business_id' => $this->getBussinessId(),
		];

		return $formatted;
	}
	/**
	 * Update given model.
	 *
	 * @param VariationTemplate $model
	 * @param array $params
	 *
	 * @return VariationTemplate
	 */
	public function update(VariationTemplate $model, $params) {

		if ($model->name != gv($params, 'name')) {
			$model->name = gv($params, 'name');
			$model->save();

			// ProductVariation::where('variation_template_id', $variation->id)
			// ->update(['name' => $variation->name]);
		}

		//update variation
		$data = [];
		if (gv($params, 'edit_variation_values')) {
			$values = gv($params, 'edit_variation_values');
			foreach ($values as $key => $value) {
				if (!empty($value)) {
					$variation_val = VariationValueTemplate::findOrFail($key);
					if (!$variation_val) {
						throw ValidationException::withMessages([$field => __('service.not_found', ['attribute' => __('page.variation_template_value')])]);
					}

					if ($variation_val->name != $value) {
						$variation_val->name = $value;
						$data[] = $variation_val;
						// Variation::where('variation_value_id', $key)
						// 	->update(['name' => $value]);
					}
				}
			}
			$model->values()->saveMany($data);
		}
		if (gv($params, 'variation_values')) {
			$values = gv($params, 'variation_values');
			foreach ($values as $value) {
				if (!empty($value)) {
					$data[] = new VariationValueTemplate(['name' => $value]);
				}
			}
		}
		$model->values()->saveMany($data);
		// $model->forceFill($this->formatParams($params, $model->id))->save();
		return $model;
	}

	/**
	 * Find model & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return VariationTemplate
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
	public function delete(VariationTemplate $model) {
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
		$msg = trans_choice('service.multiple_deleted', count($ids), ['attribute' => __('page.variation_template'), 'value' => count($ids)]);
		return $msg;
	}
	public function actions($data) {
		if ($data['action'] == 'delete') {
			return $this->deleteMultiple($data['ids']);
		}
	}
}