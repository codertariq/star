<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\RoleRepositoriy;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller {

	protected $request;
	protected $repo;
	public function __construct(
		Request $request,
		RoleRepositoriy $repo
	) {
		$this->request = $request;
		$this->repo = $repo;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		if ($this->request->ajax() and $this->request->get == 'datatable') {
			return $this->repo->datatable();
		}

		return view('admin.role.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		if (!$this->request->ajax()) {
			abort(404);
		}
		if (!auth()->user()->can('roles.create')) {
			abort(403, 'Unauthorized action.');
		}
		$pre_requsite = $this->repo->preRequisite();

		return view('admin.role.create', $pre_requsite);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		if (!$this->request->ajax()) {
			abort(404);
		}
		if (!auth()->user()->can('roles.create')) {
			abort(403, 'Unauthorized action.');
		}
		$this->repo->create($this->request->all());

		return response()->json(['message' => __('service.created_successfull', ['attribute' => __('page.role')])]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		if (!$this->request->ajax()) {
			abort(404);
		}
		if (!auth()->user()->can('roles.update')) {
			abort(403, 'Unauthorized action.');
		}
		$pre_requsite = $this->repo->preRequisite($id);
		return view('admin.role.edit', $pre_requsite);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		if (!$this->request->ajax()) {
			abort(404);
		}
		if (!auth()->user()->can('roles.update')) {
			abort(403, 'Unauthorized action.');
		}
		$this->repo->updateable($id);
		$model = $this->repo->findOrFail($id);
		$this->repo->update($model, $this->request->all());

		return response()->json(['message' => __('service.updated_successfull', ['attribute' => __('page.role')])]);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		if (!auth()->user()->can('roles.delete')) {
			abort(403, 'Unauthorized action.');
		}
		if (!$this->request->ajax()) {
			abort(404);
		}

		$model = $this->repo->deletable($id);

		$this->repo->delete($model);

		return response()->json(['message' => __('service.deleted', ['attribute' => __('page.role')])]);

	}
	/**
	 * Action the specified resources from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function action() {
		if (!$this->request->ajax()) {
			abort(404);
		}

		if (!$this->request->action) {
			throw ValidationException::withMessages(['message' => __('service.unauthorized')]);
		}

		if (!$this->request->ids or !count($this->request->ids)) {
			throw ValidationException::withMessages(['message' => trans_choice('service.multiple_deleted', 0, ['attribute' => __('page.role')])]);
		}

		$action = $this->repo->actions($this->request->all());
		return response()->json(['message' => $action]);

	}
}
