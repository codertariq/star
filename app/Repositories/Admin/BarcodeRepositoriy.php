<?php
namespace App\Repositories\Admin;

use App\Models\Barcode;
use App\Repositories\Repository;
use App\Utils\Util;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;

class BarcodeRepositoriy extends Repository {
	protected $commonUtil;
	public function __construct(Barcode $model, Util $commonUtil) {
		$this->model = $model;
		$this->permission = '';
		$this->route = 'admin.barcodes.';
		$this->action_exeption = [];
		$this->commonUtil = $commonUtil;
	}
	/**
	 * Get model query
	 *
	 * @return Barcode query
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
	 * @return Barcode
	 */
	public function find($id) {
		return $this->model->find($id);
	}
	/**
	 * Find model with given id or throw an error.
	 *
	 * @param integer $id
	 * @return Barcode
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
			->select(['id', 'name', 'description', 'is_default']);

		return Datatables::of($models)
			->addIndexColumn()
			->addColumn('action', function ($model) {
				$action['route'] = $this->route;
				$action['permission'] = $this->permission;
				$action['action_exeption'] = $this->action_exeption;
				return view('admin.barcodes.action', compact('model', 'action'));

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
	 * @return Barcode
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

		$formatted = [
			'name' => gv($params, 'name'),
			'description' => gv($params, 'description', 'blank'),
			'width' => gv($params, 'width', 0),
			'height' => gv($params, 'height', 0),
			'top_margin' => gv($params, 'top_margin', 0),
			'left_margin' => gv($params, 'left_margin', 0),
			'row_distance' => gv($params, 'row_distance', 0),
			'col_distance' => gv($params, 'col_distance', 0),
			'stickers_in_one_row' => gv($params, 'stickers_in_one_row', 0),
			'paper_width' => gv($params, 'paper_width', 0),

			'business_id' => $this->getBussinessId(),
		];

		if (gbv($params, 'is_default')) {
			//get_default
			$default = $this->model->where('business_id', $this->getBussinessId())
				->where('is_default', 1)
				->update(['is_default' => 0]);
			$formatted['is_default'] = 1;
		}

		if (gbv($params, 'is_continuous')) {
			$formatted['is_continuous'] = 1;
			$formatted['stickers_in_one_sheet'] = 28;
		} else {
			$formatted['stickers_in_one_sheet'] = gv($params, 'stickers_in_one_sheet');
			$formatted['paper_height'] = gv($params, 'paper_height');
		}

		return $formatted;
	}
	/**
	 * Update given model.
	 *
	 * @param Barcode $model
	 * @param array $params
	 *
	 * @return Barcode
	 */
	public function update(Barcode $model, $params) {
		$model->forceFill($this->formatParams($params, $model->id))->save();
		return $model;
	}

	public function updateStatus(Barcode $model) {
		$this->model->where('business_id', $this->getBussinessId())
			->where('is_default', 1)
			->update(['is_default' => 0]);
		return $model->update(['is_default' => 1]);

	}

	/**
	 * Find model & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return Barcode
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
	 * @return Barcode
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
	public function delete(Barcode $model) {
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