<?php

namespace App\Repositories\Admin;

use App\Repositories\Repository;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;

class RoleRepositoriy extends Repository {

	public function __construct(Role $model) {
		$this->model = $model;
		$this->permission = '';
		$this->route = 'admin.role.';
		$this->action_exeption = [];
	}

	/**
	 * Get model query
	 *
	 * @return Role query
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
		return $this->model->all()->pluck('name', 'id')->prepend(__('service.select', ['attribute' => __('page.role')]), '');
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
	 * @return Role
	 */
	public function find($id) {
		return $this->model->find($id);
	}

	public function preRequisite($id = Null) {

		//return $compact;
	}

	/**
	 * Find model with given id or throw an error.
	 *
	 * @param integer $id
	 * @return Role
	 */
	public function findOrFail($id, $field = 'message') {
		$model = $this->model->find($id);
		if (!$model) {
			throw ValidationException::withMessages([$field => __('service.not_found', ['attribute' => __('page.role')])]);
		}
		return $model;
	}

	/**
	 * Get all data for Index
	 */
	public function datatable() {
		$user_id = auth()->user()->id;
		$business_id = auth()->user()->business->id;

		$models = $this->model->where('business_id', $business_id)
			->select(['name', 'id', 'is_default', 'business_id']);

		return Datatables::of($models)
			->addIndexColumn()
			->editColumn('role', function ($row) {
				$role_name = str_replace('#' . $business_id, '', $row->name);
				if (in_array($role_name, ['Admin', 'Cashier'])) {
					$role_name = __('role.' . $role_name);
				}
				return $role_name;
			}
			)
			->editColumn('name', function ($model) {
				return '<strong>' . $model->name . '</strong>';
			})
			->addColumn('action', function ($model) {
				$action['route'] = $this->route;
				$action['permission'] = $this->permission;
				$action['action_exeption'] = $this->action_exeption;
				return view('action', compact('model', 'action'));
			})
			->removeColumn(['created_at', 'updated_at'])
			->rawColumns(['action', 'name', 'status'])
			->make(true);
	}

	/**
	 * Create a new model.
	 *
	 * @param array $params
	 * @return Role
	 */
	public function create($params) {
		return $this->model->forceCreate($this->formatParams($params));
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
		];
		return $formatted;
	}

	/**
	 * Update given model.
	 *
	 * @param Role $model
	 * @param array $params
	 *
	 * @return Role
	 */
	public function update(Role $model, $params) {
		return $model->forceFill($this->formatParams($params, $model->id))->save();
	}

	/**
	 * Find model & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return Role
	 */
	public function deletable($id) {
		$model = $this->findOrFail($id);
		if (auth()->role()->id == $id) {
			throw ValidationException::withMessages(['message' => __('service.unauthorized')]);
		}
		return $model;
	}

	public function updateable($id) {
		$model = $this->findOrFail($id);
		if (auth()->role()->id == $id) {
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
	public function delete(Role $model) {
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
		$msg = trans_choice('service.multiple_deleted', count($ids), ['attribute' => __('page.role'), 'value' => count($ids)]);
		return $msg;
	}

	/**
	 * Online multiple model.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function onlineMultiple($ids) {
		foreach ($ids as $id) {
			$model = $this->findOrFail($id);
			$model->status = 1;
			$model->save();
		}
		return true;
	}

	/**
	 * Online multiple model.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function offlineMultiple($ids) {
		foreach ($ids as $id) {
			$model = $this->findOrFail($id);
			$model->status = 0;
			$model->save();
		}
		return true;
	}

	/**
	 * Online multiple model.
	 *
	 * @param array $ids
	 * @return bool|null
	 */
	public function toggleMultiple($ids) {
		foreach ($ids as $id) {
			$model = $this->findOrFail($id);
			$model->status = !$model->status;
			$model->save();
		}
		return true;
	}

	public function updateStatus(Role $model) {
		$model->status = !$model->status;
		return $model->save();
	}

	public function actions($data) {
		if ($data['action'] == 'delete') {
			return $this->deleteMultiple($data['ids']);
		} else if ($data['action'] == 'online') {
			$this->onlineMultiple($data['ids']);
		} else if ($data['action'] == 'offline') {
			$this->offlineMultiple($data['ids']);
		} else if ($data['action'] == 'toggle') {
			$this->toggleMultiple($data['ids']);
		}
	}
}
