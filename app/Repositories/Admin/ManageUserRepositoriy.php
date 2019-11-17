<?php

namespace App\Repositories\Admin;

use App\Repositories\Repository;
use App\User;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class ManageUserRepositoriy extends Repository {

	public function __construct(User $model) {
		$this->model = $model;
		$this->permission = '';
		$this->route = 'admin.user.';
		$this->action_exeption = [];
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
		return $this->model->all()->pluck('name', 'id')->prepend(__('service.select', ['attribute' => __('page.user')]), '');
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

		//return $compact;
	}

	/**
	 * Find model with given id or throw an error.
	 *
	 * @param integer $id
	 * @return User
	 */
	public function findOrFail($id, $field = 'message') {
		$model = $this->model->find($id);
		if (!$model) {
			throw ValidationException::withMessages([$field => __('service.not_found', ['attribute' => __('page.user')])]);
		}
		return $model;
	}

	/**
	 * Get all data for Index
	 */
	public function datatable() {
		$user_id = auth()->user()->id;
		$business_id = auth()->user()->business->id;
		$models = $this->model
			->where('business_id', $business_id)
		// ->where('id', '!=', $user_id)
			->where('is_cmmsn_agnt', 0)
			->select(['id', 'username', 'first_name', 'last_name', 'prefix', 'email']);
		return Datatables::of($models)
			->addIndexColumn()
			->addColumn(
				'role',
				function ($row) {
					$role_name = getUserRoleName($row->id);
					return $role_name;
				}
			)
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
		$msg = trans_choice('service.multiple_deleted', count($ids), ['attribute' => __('page.user'), 'value' => count($ids)]);
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

	public function updateStatus(User $model) {
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
