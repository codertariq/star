<?php

namespace App\Repositories\Admin;

use App\Repositories\Admin\RoleRepositoriy;
use App\Repositories\Repository;
use App\User;
use App\Utils\Util;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class SalesCommissionAgentRepositoriy extends Repository {
	protected $role;
	protected $moduleUtil;

	public function __construct(
		User $model,
		RoleRepositoriy $role,
		Util $moduleUtil
	) {
		$this->model = $model;
		$this->role = $role;
		$this->moduleUtil = $moduleUtil;
		$this->permission = '';
		$this->route = 'admin.sales-commission-agents.';
		$this->action_exeption = ['show'];
	}

	public function getBussinessId() {
		return request()->session()->get('user.business_id');
	}
	public function getUserId() {
		return request()->session()->get('user.id');
	}

	/**
	 * Get model query
	 *
	 * @return User query
	 */
	public function getQuery() {
		return $this->model->query();
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
		return $this->model->all()->pluck('name', 'id')->prepend(__('service.select', ['attribute' => __('page.sales_commission_agents')]), '');
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
	 * @return User
	 */
	public function find($id) {
		return $this->model->find($id);
	}

	public function preRequisite($id = Null) {

		//
	}

	/**
	 * Find model with given id or throw an error.
	 *
	 * @param integer $id
	 * @return User
	 */
	public function findOrFail($id, $field = 'message') {
		$model = $this->model->where('business_id', $this->getBussinessId())->find($id);
		if (!$model) {
			throw ValidationException::withMessages([$field => __('service.not_found', ['attribute' => __('page.sales_commission_agents')])]);
		}
		return $model;
	}

	/**
	 * Get all data for Index
	 */
	public function datatable() {
		$models = $this->model
			->where('business_id', $this->getBussinessId())
			->where('id', '!=', $this->getUserId())
			->where('is_cmmsn_agnt', 1)
			->select(['id', 'first_name', 'last_name', 'prefix', 'email', 'contact_no', 'address', 'cmmsn_percent']);
		return Datatables::of($models)
			->addIndexColumn()
			->editColumn('full_name', function ($model) {
				return '<strong>' . $model->full_name . '</strong>';
			})
			->addColumn('action', function ($model) {
				$action['route'] = $this->route;
				$action['permission'] = $this->permission;
				$action['action_exeption'] = $this->action_exeption;
				return view('action', compact('model', 'action'));
			})
			->removeColumn(['created_at', 'updated_at'])
			->rawColumns(['action', 'full_name', 'status'])
			->make(true);
	}

	/**
	 * Create a new model.
	 *
	 * @param array $params
	 * @return User
	 */
	public function create($params) {
		$model = $this->model->forceCreate($this->formatParams($params));
		return $model;
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
			'prefix' => gv($params, 'prefix'),
			'first_name' => gv($params, 'first_name'),
			'last_name' => gv($params, 'last_name'),
			'email' => gv($params, 'email'),
			'contact_no' => gv($params, 'contact_no'),
			'address' => gv($params, 'address'),
			'cmmsn_percent' => gv($params, 'cmmsn_percent', 0),
			'is_cmmsn_agnt' => 1,
			'username' => uniqid(),
			'password' => 'Tariqul',
			'business_id' => $this->getBussinessId(),
		];

		return $formatted;

	}

	/**
	 * Update given model.
	 *
	 * @param User $model
	 * @param array $params
	 *
	 * @return User
	 */
	public function update(User $model, $params) {
		return $model->forceFill($this->formatParams($params, $model->id))->save();
	}

	/**
	 * Find model & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return User
	 */
	public function deletable($id) {
		$model = $this->findOrFail($id);
		if (auth()->user()->id == $id) {
			throw ValidationException::withMessages(['message' => __('service.unauthorized')]);
		}
		return $model;
	}

	public function updateable($id) {
		$model = $this->findOrFail($id);
		if (auth()->user()->id == $id) {
			throw ValidationException::withMessages(['message' => __('service.unauthorized')]);
		}
		return $model;
	}
	/**
	 * Delete model.
	 *
	 * @param integer $id
	 * @return bool|null
	 */
	public function delete(User $model) {
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
		$msg = trans_choice('service.multiple_deleted', count($ids), ['attribute' => __('page.sales_commission_agents'), 'value' => count($ids)]);
		return $msg;
	}

	public function actions($data) {
		if ($data['action'] == 'delete') {
			return $this->deleteMultiple($data['ids']);
		}
	}
}
