<?php
namespace App\Repositories\Admin;

use App\Models\TaxRate;
use App\Repositories\Repository;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;

class GroupTaxRepositoriy extends Repository {
	public function __construct(TaxRate $model) {
		$this->model = $model;
		$this->permission = '';
		$this->route = 'admin.group-taxes.';
		$this->action_exeption = ['show'];
	}
	/**
	 * Get model query
	 *
	 * @return TaxRate query
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
		return $this->model->all()->pluck('name', 'id')->prepend(__('service.select', ['attribute' => __('page.group_taxes')]), '');
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
	 * @return TaxRate
	 */
	public function find($id) {
		return $this->model->find($id);
	}
	/**
	 * Find model with given id or throw an error.
	 *
	 * @param integer $id
	 * @return TaxRate
	 */
	public function findOrFail($id, $field = 'message') {
		$model = $this->model->find($id);
		if (!$model) {
			throw ValidationException::withMessages([$field => __('service.not_found', ['attribute' => __('page.business_location')])]);
		}
		return $model;
	}
	/**
	 * Get all data for Index
	 */
	public function datatable() {
		$models = $this->model->where('business_id', $this->getBussinessId())
			->where('is_tax_group', '1')
			->with(['sub_taxes']);

		return Datatables::of($models)
			->addIndexColumn()
			->editColumn('name', function ($model) {
				return '<strong>' . $model->name . '</strong>';
			})
			->editColumn('sub_taxes', function ($model) {
				$sub_taxes = [];
				foreach ($model->sub_taxes as $sub_tax) {
					$sub_taxes[] = $sub_tax->name;
				}
				return implode(' + ', $sub_taxes);
			})
			->addColumn('action', function ($model) {
				$action['route'] = $this->route;
				$action['permission'] = $this->permission;
				$action['action_exeption'] = $this->action_exeption;
				return view('admin.tax_rates.action', compact('model', 'action'));

			})

			->removeColumn(['created_at', 'updated_at'])
			->rawColumns(['action', 'name', 'status'])
			->make(true);
	}
	public function preRequisite($id = Null) {
		$taxes = TaxRate::where('business_id', $this->getBussinessId())->where('is_tax_group', '0')->pluck('name', 'id');
		$compact = compact('taxes');

		if ($id) {
			$model = TaxRate::where('business_id', $this->getBussinessId())->with(['sub_taxes'])->find($id);

			$sub_taxes = [];
			foreach ($model->sub_taxes as $sub_tax) {
				$sub_taxes[] = $sub_tax->id;
			}

			$compact = compact('model', 'taxes', 'sub_taxes');
		}
		return $compact;
	}
	/**
	 * Create a new model.
	 *
	 * @param array $params
	 * @return TaxRate
	 */
	public function create($params) {
		$tax_rate = $this->model->forceCreate($this->formatParams($params));
		$sub_tax_ids = gv($params, 'taxes');
		$tax_rate->sub_taxes()->sync($sub_tax_ids);
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

		$sub_tax_ids = gv($params, 'taxes');

		$formatted = [
			'name' => gv($params, 'name'),
			'created_by' => $this->getUserId(),
			'business_id' => $this->getBussinessId(),
		];

		$sub_taxes = TaxRate::whereIn('id', $sub_tax_ids)->get();
		$amount = 0;
		foreach ($sub_taxes as $sub_tax) {
			$amount += $sub_tax->amount;
		}
		$formatted['amount'] = $amount;
		$formatted['is_tax_group'] = 1;

		return $formatted;

	}
	/**
	 * Update given model.
	 *
	 * @param TaxRate $model
	 * @param array $params
	 *
	 * @return TaxRate
	 */
	public function update(TaxRate $model, $params) {
		$model->forceFill($this->formatParams($params, $model->id))->save();
		return $model;
	}

	/**
	 * Find model & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return TaxRate
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
	public function delete(TaxRate $model) {
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
		$msg = trans_choice('service.multiple_deleted', count($ids), ['attribute' => __('page.group_taxes'), 'value' => count($ids)]);
		return $msg;
	}
	public function actions($data) {
		if ($data['action'] == 'delete') {
			return $this->deleteMultiple($data['ids']);
		}
	}
}