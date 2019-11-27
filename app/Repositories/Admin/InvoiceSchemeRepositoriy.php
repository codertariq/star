<?php
namespace App\Repositories\Admin;

use App\Models\InvoiceScheme;
use App\Repositories\Repository;
use App\Utils\Util;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;

class InvoiceSchemeRepositoriy extends Repository {
	protected $commonUtil;
	public function __construct(InvoiceScheme $model, Util $commonUtil) {
		$this->model = $model;
		$this->permission = '';
		$this->route = 'admin.invoice-schemes.';
		$this->action_exeption = [];
		$this->commonUtil = $commonUtil;
	}
	/**
	 * Get model query
	 *
	 * @return InvoiceScheme query
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
		return $this->model->all()->pluck('name', 'id')->prepend(__('service.select', ['attribute' => __('page.business_location')]), '');
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
	 * @return InvoiceScheme
	 */
	public function find($id) {
		return $this->model->find($id);
	}
	/**
	 * Find model with given id or throw an error.
	 *
	 * @param integer $id
	 * @return InvoiceScheme
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
			->select(['id', 'name', 'scheme_type', 'prefix', 'start_number', 'invoice_count', 'total_digits', 'is_default']);

		return Datatables::of($models)
			->addIndexColumn()
			->addColumn('action', function ($model) {
				$action['route'] = $this->route;
				$action['permission'] = $this->permission;
				$action['action_exeption'] = $this->action_exeption;
				return view('admin.invoice_schemes.action', compact('model', 'action'));

			})
			->editColumn('prefix', function ($row) {
				if ($row->scheme_type == 'year') {
					return date('Y') . '-';
				} else {
					return $row->prefix;
				}
			})
			->editColumn('name', function ($row) {
				if ($row->is_default == 1) {
					return $row->name . ' &nbsp; <span class="badge badge-success">' . __("barcode.default") . '</span>';
				} else {
					return $row->name;
				}
			})
			->setRowClass(function ($model) {
				if (!$model->is_default) {
					return '';
				} else {
					return 'is_default';
				}
			})
			->removeColumn(['created_at', 'updated_at', 'is_default', 'scheme_type'])
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
	 * @return InvoiceScheme
	 */
	public function create($params) {
		$location = $this->model->forceCreate($this->formatParams($params));
		return $location;
	}
	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param integer $model_id
	 * @return array
	 */
	private function formatParams($params, $model_id = null) {

		$location_id = gv($params, 'location_id');

		if ($location_id) {
			$business_id = $this->getBussinessId();

			$query = $this->getQuery()->where('business_id', $business_id)
				->where('location_id', $location_id);

			if ($model_id) {
				$query->where('id', '!=', $model_id);
			}
			$count = $query->count();
			if ($count) {
				throw ValidationException::withMessages(['location_id' => __('validation.unique', ['attribute' => __('page.business_location')])]);
			}

		}

		$formatted = [
			'name' => gv($params, 'name'),
			'scheme_type' => gv($params, 'scheme_type', 'blank'),
			'prefix' => gv($params, 'prefix'),
			'start_number' => gv($params, 'start_number', 0),
			'total_digits' => gv($params, 'total_digits', 4),
			'business_id' => $this->getBussinessId(),
		];

		if (gv($params, 'is_default')) {
			//get_default
			$default = $this->model->where('business_id', $this->getBussinessId())
				->where('is_default', 1)
				->update(['is_default' => 0]);
			$formatted['is_default'] = 1;
		}

		return $formatted;
	}
	/**
	 * Update given model.
	 *
	 * @param InvoiceScheme $model
	 * @param array $params
	 *
	 * @return InvoiceScheme
	 */
	public function update(InvoiceScheme $model, $params) {
		$model->forceFill($this->formatParams($params, $model->id))->save();
		return $model;
	}

	public function updateStatus(InvoiceScheme $model) {
		$this->model->where('business_id', $this->getBussinessId())
			->where('is_default', 1)
			->update(['is_default' => 0]);
		return $model->update(['is_default' => 1]);

	}

	/**
	 * Find model & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return InvoiceScheme
	 */
	public function updateable($id) {
		$model = $this->findOrFail($id);
		if ($model->is_default) {
			throw ValidationException::withMessages(['message' => __('service.default_invoice')]);
		}
		return $model;
	}

	/**
	 * Find model & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return InvoiceScheme
	 */
	public function deletable($id) {
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
	public function delete(InvoiceScheme $model) {
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
		$msg = trans_choice('service.multiple_deleted', count($ids), ['attribute' => __('page.business_location'), 'value' => count($ids)]);
		return $msg;
	}
	public function actions($data) {
		if ($data['action'] == 'delete') {
			return $this->deleteMultiple($data['ids']);
		}
	}
}