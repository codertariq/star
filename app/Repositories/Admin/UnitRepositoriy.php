<?php
namespace App\Repositories\Admin;

use App\Models\Unit;
use App\Repositories\Repository;
use App\Utils\Util;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;

class UnitRepositoriy extends Repository {
	public $commonUtil;
	public function __construct(Unit $model, Util $commonUtil) {
		$this->model = $model;
		$this->commonUtil = $commonUtil;
		$this->permission = '';
		$this->route = 'admin.units.';
		$this->action_exeption = ['show'];
	}
	/**
	 * Get model query
	 *
	 * @return Unit query
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
		return $this->model->all()->pluck('name', 'id')->prepend(__('service.select', ['attribute' => __('page.unit')]), '');
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
	 * @return Unit
	 */
	public function find($id) {
		return $this->model->find($id);
	}
	/**
	 * Find model with given id or throw an error.
	 *
	 * @param integer $id
	 * @return Unit
	 */
	public function findOrFail($id, $field = 'message') {
		$model = $this->model->find($id);
		if (!$model) {
			throw ValidationException::withMessages([$field => __('service.not_found', ['attribute' => __('page.unit')])]);
		}
		return $model;
	}
	/**
	 * Get all data for Index
	 */
	public function datatable() {
		$models = $this->model->where('business_id', $this->getBussinessId())
			->with(['base_unit'])
			->select(['actual_name', 'short_name', 'allow_decimal', 'id',
				'base_unit_id', 'base_unit_multiplier']);

		return Datatables::of($models)
			->addIndexColumn()
			->editColumn('allow_decimal', function ($model) {
				if ($model->allow_decimal) {
					return __('messages.yes');
				} else {
					return __('messages.no');
				}
			})
			->editColumn('actual_name', function ($model) {
				if (!empty($model->base_unit_id)) {
					return $model->actual_name . ' (' . (float) $model->base_unit_multiplier . $model->base_unit->short_name . ')';
				}
				return $model->actual_name;
			})
			->addColumn('action', function ($model) {

				$action['route'] = $this->route;
				$action['permission'] = $this->permission;
				$action['action_exeption'] = $this->action_exeption;
				return view('admin.unit.action', compact('model', 'action'));

			})

			->removeColumn(['created_at', 'updated_at'])
			->rawColumns(['action', 'name', 'status'])
			->make(true);
	}
	public function preRequisite($id = Null) {

		$units = $this->model->forDropdown($this->getBussinessId());
		$compact = compact('units');
		return $compact;
	}
	/**
	 * Create a new model.
	 *
	 * @param array $params
	 * @return Unit
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
			'actual_name' => gv($params, 'actual_name'),
			'short_name' => gv($params, 'short_name'),
			'allow_decimal' => gv($params, 'allow_decimal', 0),
			'created_by' => $this->getUserId(),
			'business_id' => $this->getBussinessId(),
		];

		if (gv($params, 'define_base_unit')) {
			if (gv($params, 'base_unit_id') && gv($params, 'base_unit_multiplier')) {
				$base_unit_multiplier = $this->commonUtil->num_uf(gv($params, 'base_unit_multiplier'));
				if ($base_unit_multiplier != 0) {
					$formatted['base_unit_id'] = gv($params, 'base_unit_id');
					$formatted['base_unit_multiplier'] = $base_unit_multiplier;
				}
			}
		}

		return $formatted;
	}
	/**
	 * Update given model.
	 *
	 * @param Unit $model
	 * @param array $params
	 *
	 * @return Unit
	 */
	public function update(Unit $model, $params) {
		$model->forceFill($this->formatParams($params, $model->id))->save();
		return $model;
	}

	/**
	 * Find model & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return Unit
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
	public function delete(Unit $model) {
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
		$msg = trans_choice('service.multiple_deleted', count($ids), ['attribute' => __('page.unit'), 'value' => count($ids)]);
		return $msg;
	}
	public function actions($data) {
		if ($data['action'] == 'delete') {
			return $this->deleteMultiple($data['ids']);
		}
	}
}