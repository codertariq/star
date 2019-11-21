<?php
namespace App\Repositories\Admin;
use App\Models\BusinessLocation;
use App\Repositories\Repository;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;

class RoleRepositoriy extends Repository {
	public function __construct(Role $model) {
		$this->model = $model;
		$this->permission = 'roles';
		$this->route = 'admin.role.';
		$this->action_exeption = ['show'];
	}
	/**
	 * Get model query
	 *
	 * @return Role query
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
		$models = $this->model->where('business_id', $this->getBussinessId())
			->select(['name', 'id', 'is_default', 'business_id'])->orderBy('id', 'Asc');
		return Datatables::of($models)
			->addIndexColumn()
			->editColumn('role', function ($row) {
				$role_name = str_replace('#' . $this->getBussinessId(), '', $row->name);
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
				if (!$model->is_default || $model->name == "Cashier#" . $model->business_id) {
					$action['route'] = $this->route;
					$action['permission'] = $this->permission;
					$action['action_exeption'] = $this->action_exeption;
					return view('action', compact('model', 'action'));
				} else {
					return '';
				}
			})
			->setRowClass(function ($model) {
				if (!$model->is_default || $model->name == "Cashier#" . $model->business_id) {
					return '';
				} else {
					return 'is_default';
				}
			})
			->removeColumn(['created_at', 'updated_at'])
			->rawColumns(['action', 'name', 'status'])
			->make(true);
	}
	public function preRequisite($id = Null) {
		$locations = BusinessLocation::where('business_id', $this->getBussinessId())
			->get();
		// $selling_price_groups = SellingPriceGroup::where('business_id', $this->getBussinessId())
		// 	->get();
		// $module_permissions = $this->moduleUtil->getModuleData('user_permissions');
		$compact = compact('locations');
		if ($id) {
			$model = $this->model->where('business_id', $this->getBussinessId())
				->with(['permissions'])
				->find($id);
			$role_permissions = [];
			foreach ($model->permissions as $role_perm) {
				$role_permissions[] = $role_perm->name;
			}
			$compact = compact('locations', 'role_permissions', 'model');
		}
		return $compact;
	}
	/**
	 * Create a new model.
	 *
	 * @param array $params
	 * @return Role
	 */
	public function create($params) {
		$role = $this->model->forceCreate($this->formatParams($params));
		$this->assignPermission($role, $params);
		return $role;
	}
	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param integer $model_id
	 * @return array
	 */
	private function formatParams($params, $model_id = null) {
		$role_name = gv($params, 'name');
		$business_id = $this->getBussinessId();
		if (!$role_name) {
			throw ValidationException::withMessages(['name' => __('validation.required', ['attribute' => __('page.role')])]);
		}
		$is_default = 0;
		if ($model_id) {
			$count = Role::where('name', $role_name . '#' . $business_id)
				->where('business_id', $business_id)
				->where('id', '!=', $model_id)
				->count();
			if ($count) {
				throw ValidationException::withMessages(['name' => __('validation.unique', ['attribute' => __('page.role')])]);
			}
			$model = $this->findOrFail($model_id);
			if ($model->name == 'Cashier#' . $business_id) {
				$is_default = 0;
			}
		} else {
			$count = $this->model->where('name', $role_name . '#' . $business_id)
				->where('business_id', $business_id)
				->count();
			if ($count) {
				throw ValidationException::withMessages(['name' => __('validation.unique', ['attribute' => __('page.role')])]);
			}
		}
		$is_service_staff = gbv($params, 'is_service_staff');
		$formatted = [
			'name' => $role_name . '#' . $business_id,
			'business_id' => $business_id,
			'is_service_staff' => $is_service_staff,
			'is_default' => $is_default,
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
		$model->forceFill($this->formatParams($params, $model->id))->save();
		$this->assignPermission($model, $params);
		return $model;
	}
	protected function assignPermission($role, $params) {
		//Include location permissions
		$permissions = gv($params, 'permissions');
		$location_permissions = gv($params, 'location_permissions');
		if (!in_array('access_all_locations', $permissions) &&
			!empty($location_permissions)) {
			foreach ($location_permissions as $location_permission) {
				$permissions[] = $location_permission;
			}
		}
		//Include selling price group permissions
		$spg_permissions = gv($params, 'spg_permissions');
		if (!empty($spg_permissions)) {
			foreach ($spg_permissions as $spg_permission) {
				$permissions[] = $spg_permission;
			}
		}
		if (!empty($permissions)) {
			$role->syncPermissions($permissions);
		}
	}
	/**
	 * Find model & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return Role
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
	public function actions($data) {
		if ($data['action'] == 'delete') {
			return $this->deleteMultiple($data['ids']);
		}
	}
}