<?php
namespace App\Repositories\Admin;

use App\Models\BusinessLocation;
use App\Models\InvoiceLayout;
use App\Models\InvoiceScheme;
use App\Repositories\Repository;
use App\Utils\Util;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;

class BusinessLocationRepositoriy extends Repository {
	protected $commonUtil;
	public function __construct(BusinessLocation $model, Util $commonUtil) {
		$this->model = $model;
		$this->permission = '';
		$this->route = 'admin.business-location.';
		$this->action_exeption = ['show', 'destroy'];
		$this->commonUtil = $commonUtil;
	}
	/**
	 * Get model query
	 *
	 * @return BusinessLocation query
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
	 * @return BusinessLocation
	 */
	public function find($id) {
		return $this->model->find($id);
	}
	/**
	 * Find model with given id or throw an error.
	 *
	 * @param integer $id
	 * @return BusinessLocation
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
		$models = $this->model->where('business_locations.business_id', $this->getBussinessId())
			->leftjoin(
				'invoice_schemes as ic',
				'business_locations.invoice_scheme_id',
				'=',
				'ic.id'
			)
			->leftjoin(
				'invoice_layouts as il',
				'business_locations.invoice_layout_id',
				'=',
				'il.id'
			)
			->select(['business_locations.name', 'location_id', 'landmark', 'city', 'zip_code', 'state',
				'country', 'business_locations.id', 'ic.name as invoice_scheme', 'il.name as invoice_layout']);

		$permitted_locations = auth()->user()->permitted_locations();
		if ($permitted_locations != 'all') {
			$models->whereIn('business_locations.id', $permitted_locations);
		}
		return Datatables::of($models)
			->addIndexColumn()
			->editColumn('name', function ($model) {
				return '<strong>' . $model->name . '</strong>';
			})
			->addColumn('action', function ($model) {

				$action['route'] = $this->route;
				$action['permission'] = $this->permission;
				$action['action_exeption'] = $this->action_exeption;
				return view('admin.business_location.action', compact('model', 'action'));

			})

			->removeColumn(['created_at', 'updated_at'])
			->rawColumns(['action', 'name', 'status'])
			->make(true);
	}
	public function preRequisite($id = Null) {
		$business_id = request()->session()->get('user.business_id');

		//Check if subscribed or not, then check for location quota

		$invoice_layouts = InvoiceLayout::where('business_id', $business_id)
			->get()
			->pluck('name', 'id');

		$invoice_schemes = InvoiceScheme::where('business_id', $business_id)
			->get()
			->pluck('name', 'id');
		$compact = compact('invoice_schemes', 'invoice_layouts');
		return $compact;
	}
	/**
	 * Create a new model.
	 *
	 * @param array $params
	 * @return BusinessLocation
	 */
	public function create($params) {
		$location = $this->model->forceCreate($this->formatParams($params));
		Permission::create(['name' => 'location.' . $location->id]);
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
			'landmark' => gv($params, 'landmark'),
			'city' => gv($params, 'city'),
			'state' => gv($params, 'state'),
			'country' => gv($params, 'country'),
			'zip_code' => gv($params, 'zip_code'),
			'invoice_scheme_id' => gv($params, 'invoice_scheme_id'),
			'invoice_layout_id' => gv($params, 'invoice_layout_id'),
			'mobile' => gv($params, 'mobile'),
			'alternate_number' => gv($params, 'alternate_number'),
			'email' => gv($params, 'email'),
			'website' => gv($params, 'website'),
			'custom_field1' => gv($params, 'custom_field1'),
			'custom_field2' => gv($params, 'custom_field2'),
			'custom_field3' => gv($params, 'custom_field3'),
			'custom_field4' => gv($params, 'custom_field4'),
			'location_id' => gv($params, 'location_id'),
			'business_id' => $this->getBussinessId(),
		];

		if (!gv($params, 'location_id')) {
			$ref_count = $this->commonUtil->setAndGetReferenceCount('business_location');
			$formatted['location_id'] = $this->commonUtil->generateReferenceNumber('business_location', $ref_count);
		}
		return $formatted;
	}
	/**
	 * Update given model.
	 *
	 * @param BusinessLocation $model
	 * @param array $params
	 *
	 * @return BusinessLocation
	 */
	public function update(BusinessLocation $model, $params) {
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
	 * @return BusinessLocation
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
	public function delete(BusinessLocation $model) {
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