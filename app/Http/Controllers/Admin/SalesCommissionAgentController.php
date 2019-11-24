<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesCommissionAgentRequest;
use App\Repositories\Admin\SalesCommissionAgentRepositoriy;
use Illuminate\Http\Request;

class SalesCommissionAgentController extends Controller {

	protected $request;
	protected $repo;
	public function __construct(Request $request, SalesCommissionAgentRepositoriy $repo) {
		$this->request = $request;
		$this->repo = $repo;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		if (!auth()->user()->can('user.view') && !auth()->user()->can('user.create')) {
			abort(403, 'Unauthorized action.');
		}

		if ($this->request->ajax() and $this->request->get == 'datatable') {
			return $this->repo->datatable();
		}
		return view('admin.sales_commission_agent.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		if (!auth()->user()->can('user.create')) {
			abort(403, 'Unauthorized action.');
		}

		return view('admin.sales_commission_agent.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(SalesCommissionAgentRequest $request) {
		if (!auth()->user()->can('user.create')) {
			abort(403, 'Unauthorized action.');
		}

		$this->repo->create($this->request->all());
		return response()->json(['message' => __('service.created_successfull', ['attribute' => __('page.sales_commission_agents')])]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		if (!auth()->user()->can('user.view')) {
			abort(403, 'Unauthorized action.');
		}

		// $model = $this->repo->getQuery()->with(['contactAccess'])->findOrFail($id);
		$model = $this->repo->findOrFail($id);
		return view('admin.sales_commission_agent.show', compact('model'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		if (!auth()->user()->can('user.update')) {
			abort(403, 'Unauthorized action.');
		}

		$model = $this->repo->findOrFail($id);
		return view('admin.sales_commission_agent.edit', compact('model'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(SalesCommissionAgentRequest $request, $id) {

		if (!auth()->user()->can('user.update')) {
			abort(403, 'Unauthorized action.');
		}
		$model = $this->repo->findOrFail($id);
		$this->repo->update($model, $this->request->all());
		return response()->json(['message' => __('service.updated_successfull', ['attribute' => __('page.sales_commission_agents')])]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		if (!$this->request->ajax()) {
			abort(404);
		}

		$model = $this->repo->findOrFail($id);

		if ($this->request->action and $this->request->action == 'status') {
			$this->repo->updateable($id);
			$this->repo->updateStatus($model);
			return response()->json(['message' => __('service.status_updated', ['attribute' => __('page.sales_commission_agents')])]);
		}
		$this->repo->deletable($id);
		$this->repo->delete($model);
		return response()->json(['message' => __('service.deleted', ['attribute' => __('page.sales_commission_agents')])]);

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
			throw ValidationException::withMessages(['message' => trans_choice('service.multiple_deleted', 0, ['attribute' => __('page.sales_commission_agents')])]);
		}

		$action = $this->repo->actions($this->request->all());
		return response()->json(['message' => $action]);

	}
}
