<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceSchemeRequest;
use App\Repositories\Admin\InvoiceLayoutRepositoriy;
use Illuminate\Http\Request;

class InvoiceLayoutController extends Controller {

	protected $request;
	protected $repo;
	public function __construct(Request $request, InvoiceLayoutRepositoriy $repo) {
		$this->request = $request;
		$this->repo = $repo;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		if (!auth()->user()->can('invoice_settings.access')) {
			abort(403, 'Unauthorized action.');
		}
		$models = $this->repo->model->where('business_id', $this->repo->getBussinessId())->with(['locations'])
			->get();
		return view('admin.invoice_layouts.index', compact('models'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		if (!auth()->user()->can('invoice_settings.access')) {
			abort(403, 'Unauthorized action.');
		}
		$pre_requisite = $this->repo->preRequisite();
		return view('admin.invoice_layouts.create', $pre_requisite);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(InvoiceSchemeRequest $request) {
		if (!auth()->user()->can('invoice_settings.access')) {
			abort(403, 'Unauthorized action.');
		}

		$this->repo->create($this->request->all());
		return response()->json(['message' => __('service.created_successfull', ['attribute' => __('page.invoice_layouts')])]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		if (!auth()->user()->can('invoice_settings.access')) {
			abort(403, 'Unauthorized action.');
		}

		// $model = $this->repo->getQuery()->with(['contactAccess'])->findOrFail($id);
		$model = $this->repo->findOrFail($id);
		return view('admin.invoice_layouts.show', compact('model'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		if (!auth()->user()->can('invoice_settings.access')) {
			abort(403, 'Unauthorized action.');
		}

		$model = $this->repo->findOrFail($id);
		return view('admin.invoice_layouts.edit', compact('model'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(InvoiceSchemeRequest $request, $id) {

		if (!auth()->user()->can('invoice_settings.access')) {
			abort(403, 'Unauthorized action.');
		}$model = $this->repo->findOrFail($id);
		$this->repo->update($model, $this->request->all());
		return response()->json(['message' => __('service.updated_successfull', ['attribute' => __('page.invoice_layouts')])]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		if (!auth()->user()->can('invoice_settings.access')) {
			abort(403, 'Unauthorized action.');
		}
		$model = $this->repo->findOrFail($id);
		if ($this->request->action and $this->request->action == 'status') {

			$this->repo->updateStatus($model);
			return response()->json(['message' => __('service.status_updated', ['attribute' => __('page.invoice_layouts')])]);
		}
		$this->repo->deletable($id);
		$this->repo->delete($model);
		return response()->json(['message' => __('service.deleted', ['attribute' => __('page.invoice_layouts')])]);

	}

	public function set_default($id) {
		if (!auth()->user()->can('invoice_settings.access')) {
			abort(403, 'Unauthorized action.');
		}
		$model = $this->repo->updateable($id);
		$this->repo->updateStatus($model);
		return response()->json(['message' => __('service.status_updated', ['attribute' => __('page.invoice_layouts')])]);
		return response()->json(['message' => __('service.deleted', ['attribute' => __('page.invoice_layouts')])]);

	}

	/**
	 * Action the specified resources from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function action() {
		if (!auth()->user()->can('invoice_settings.access')) {
			abort(403, 'Unauthorized action.');
		}

		if (!$this->request->action) {
			throw ValidationException::withMessages(['message' => __('service.unauthorized')]);
		}

		if (!$this->request->ids or !count($this->request->ids)) {
			throw ValidationException::withMessages(['message' => trans_choice('service.multiple_deleted', 0, ['attribute' => __('page.invoice_layouts')])]);
		}

		$action = $this->repo->actions($this->request->all());
		return response()->json(['message' => $action]);

	}
}
