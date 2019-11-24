<?php

namespace App\Repositories\Admin;

use App\Repositories\Admin\RoleRepositoriy;
use App\Repositories\Repository;
use App\User;
use App\Utils\Util;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class ManageUserRepositoriy extends Repository {
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
		$this->route = 'admin.user.';
		$this->action_exeption = [];
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

		$roles_array = $this->role->model->where('business_id', $this->getBussinessId())->get()->pluck('name', 'id');
		$roles = [];
		foreach ($roles_array as $key => $value) {
			$roles[$key] = str_replace('#' . $this->getBussinessId(), '', $value);
		}

		$username_ext = $this->getUsernameExtension();
		// $contacts = Contact::contactDropdown($this->getBussinessId(), true, false);
		$contacts = [];
		$compact = compact('roles', 'username_ext', 'contacts');

		if ($id) {
			$model = $this->findOrFail($id);
			if ($model->status == 'active') {
				$is_checked_checkbox = true;
			} else {
				$is_checked_checkbox = false;
			}
			// $contact_access = $model->contactAccess->pluck('id')->toArray();
			$contact_access = [];
			$compact = compact('is_checked_checkbox', 'roles', 'username_ext', 'contacts', 'contact_access');
		}

		return $compact;
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
			throw ValidationException::withMessages([$field => __('service.not_found', ['attribute' => __('page.user')])]);
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
			->where('is_cmmsn_agnt', 0)
			->select(['id', 'username', 'first_name', 'last_name', 'prefix', 'email', 'status']);
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
			->setRowClass(function ($model) {
				$class = '';
				if ($model->status == 'inactive') {
					$class = 'table-danger';
				}
				return $class;
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
		$this->assignUser($model, $params);
		return;
	}

	public function assignUser($user, $params) {

		$user_role = $user->roles->first();
		$role_id = gv($params, 'role');

		$role = $this->role->findOrFail($role_id);

		if ($user_role and $user_role->id != $role_id) {
			$user->removeRole($user_role->name);
			$user->assignRole($role->name);
		} else {
			$user->assignRole($role->name);
		}

		//Assign selected contacts
		if (gbv($params, 'selected_contacts')) {
			$contact_ids = gv($params, 'selected_contact_ids');
			$this->model->contactAccess()->sync($contact_ids);
		}
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
			'username' => gv($params, 'username'),
			'email' => gv($params, 'email'),
			'password' => gv($params, 'password'),
			'selected_contacts' => gv($params, 'selected_contacts'),
			'marital_status' => gv($params, 'marital_status'),
			'blood_group' => gv($params, 'blood_group'),
			'contact_number' => gv($params, 'contact_number'),
			'fb_link' => gv($params, 'fb_link'),
			'twitter_link' => gv($params, 'twitter_link'),
			'social_media_1' => gv($params, 'social_media_1'),
			'social_media_2' => gv($params, 'social_media_2'),
			'permanent_address' => gv($params, 'permanent_address'),
			'current_address' => gv($params, 'current_address'),
			'guardian_name' => gv($params, 'guardian_name'),
			'custom_field_1' => gv($params, 'custom_field_1'),
			'custom_field_2' => gv($params, 'custom_field_2'),
			'custom_field_3' => gv($params, 'custom_field_3'),
			'custom_field_4' => gv($params, 'custom_field_4'),
			'id_proof_name' => gv($params, 'id_proof_name'),
			'id_proof_number' => gv($params, 'id_proof_number'),
			'status' => gv($params, 'is_active') ? 'active' : 'inactive',
			'selected_contacts' => gbv($params, 'selected_contacts'),
			'dob' => gv($params, 'dob') ? $this->moduleUtil->uf_date(gv($params, 'dob')) : Null,
			'bank_details' => gv($params, 'bank_details') ? json_encode(gv($params, 'bank_details')) : Null,
			'password' => bcrypt(gv($params, 'password')),
			'cmmsn_percent' => gv($params, 'cmmsn_percent', 0),
			'business_id' => $this->getBussinessId(),
		];

		if ($model_id) {
			$model = $this->findOrFail($model_id);
			$formatted['password'] = gv($params, 'password', $model->password);
		}

		$ref_count = $this->moduleUtil->setAndGetReferenceCount('username');
		if (!gv($params, 'username')) {
			$formatted['username'] = $this->moduleUtil->generateReferenceNumber('username', $ref_count);
		}

		$username_ext = $this->getUsernameExtension();
		if (!empty($username_ext)) {
			$formatted['username'] .= $username_ext;
		}

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
		$model->forceFill($this->formatParams($params, $model->id))->save();
		$this->assignUser($model, $params);
		return;
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

	private function getUsernameExtension() {
		$extension = !true ? '-' . str_pad(session()->get('business.id'), 2, 0, STR_PAD_LEFT) : null;
		return $extension;
	}
}
