<?php

namespace App\Repositories\Admin;

use App\Business;
use App\Repositories\Admin\RoleRepositoriy;
use App\Repositories\Repository;
use Illuminate\Validation\ValidationException;
use Yajra\Datatables\Datatables;

class BusinessRepositoriy extends Repository {
	protected $role;
	public function __construct(Business $model, RoleRepositoriy $role) {
		$this->model = $model;
		$this->role = $role;
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
	 * @return Business query
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
	 * @return Business
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

		$username_ext = $this->getBusinessnameExtension();
		// $contacts = Contact::contactDropdown($this->getBussinessId(), true, false);
		$contacts = [];

		$compact = compact('roles', 'username_ext', 'contacts');
		return $compact;
	}

	/**
	 * Find model with given id or throw an error.
	 *
	 * @param integer $id
	 * @return Business
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
		$models = $this->model
			->where('business_id', $this->getBussinessId())
			->where('id', '!=', $this->getUserId())
			->where('is_cmmsn_agnt', 0)
			->select(['id', 'username', 'first_name', 'last_name', 'prefix', 'email']);
		return Datatables::of($models)
			->addIndexColumn()
			->addColumn(
				'role',
				function ($row) {
					$role_name = getBusinessRoleName($row->id);
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
	 * @return Business
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

		$user_details = $request->only(['prefix', 'first_name', 'last_name', 'username', 'email', 'password', 'selected_contacts', 'marital_status',
			'blood_group', 'contact_number', 'fb_link', 'twitter_link', 'social_media_1',
			'social_media_2', 'permanent_address', 'current_address',
			'guardian_name', 'custom_field_1', 'custom_field_2',
			'custom_field_3', 'custom_field_4', 'id_proof_name', 'id_proof_number']);

		$user_details['status'] = !empty($request->input('is_active')) ? 'active' : 'inactive';

		if (!isset($user_details['selected_contacts'])) {
			$user_details['selected_contacts'] = false;
		}

		if (!empty($request->input('dob'))) {
			$user_details['dob'] = $this->moduleUtil->uf_date($request->input('dob'));
		}

		if (!empty($request->input('bank_details'))) {
			$user_details['bank_details'] = json_encode($request->input('bank_details'));
		}

		$business_id = $request->session()->get('user.business_id');
		$user_details['business_id'] = $business_id;
		$user_details['password'] = bcrypt($user_details['password']);

		$ref_count = $this->moduleUtil->setAndGetReferenceCount('username');
		if (blank($user_details['username'])) {
			$user_details['username'] = $this->moduleUtil->generateReferenceNumber('username', $ref_count);
		}

		$username_ext = $this->getBusinessnameExtension();
		if (!empty($username_ext)) {
			$user_details['username'] .= $username_ext;
		}

		//Check if subscribed or not, then check for users quota
		if (!$this->moduleUtil->isSubscribed($business_id)) {
			return $this->moduleUtil->expiredResponse();
		} elseif (!$this->moduleUtil->isQuotaAvailable('users', $business_id)) {
			return $this->moduleUtil->quotaExpiredResponse('users', $business_id, action('ManageBusinessController@index'));
		}

		//Sales commission percentage
		$user_details['cmmsn_percent'] = $request->get('cmmsn_percent');
		if (empty($user_details['cmmsn_percent'])) {
			$user_details['cmmsn_percent'] = 0;
		}

		//Create the user
		$user = Business::create($user_details);

		$role_id = $request->input('role');
		$role = Role::findOrFail($role_id);
		$user->assignRole($role->name);

		//Assign selected contacts
		if ($user_details['selected_contacts'] == 1) {
			$contact_ids = $request->get('selected_contact_ids');
			$user->contactAccess()->sync($contact_ids);
		}
		$formatted = [
			'name' => gv($params, 'name'),
		];
		return $formatted;
	}

	/**
	 * Update given model.
	 *
	 * @param Business $model
	 * @param array $params
	 *
	 * @return Business
	 */
	public function update(Business $model, $params) {
		return $model->forceFill($this->formatParams($params, $model->id))->save();
	}

	/**
	 * Find model & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return Business
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
	public function delete(Business $model) {
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

	public function updateStatus(Business $model) {
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

	private function getBusinessnameExtension() {
		$extension = !true ? '-' . str_pad(session()->get('business.id'), 2, 0, STR_PAD_LEFT) : null;
		return $extension;
	}
}
