<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BarcodeRequest;
use App\Repositories\Admin\BarcodeRepositoriy;
use Illuminate\Http\Request;

class BarcodeController extends Controller {

	protected $request;
	protected $repo;
	public function __construct(Request $request, BarcodeRepositoriy $repo) {
		$this->request = $request;
		$this->repo = $repo;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		if (!auth()->user()->can('business_settings.access')) {
			abort(403, 'Unauthorized action.');
		}
		if ($this->request->ajax() and $this->request->get == 'datatable') {
			return $this->repo->datatable();
		}
		return view('admin.barcodes.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		if (!auth()->user()->can('business_settings.access')) {
			abort(403, 'Unauthorized action.');
		}
		return view('admin.barcodes.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(BarcodeRequest $request) {
		if (!auth()->user()->can('business_settings.access')) {
			abort(403, 'Unauthorized action.');
		}

		$this->repo->create($this->request->all());
		return response()->json(['message' => __('service.created_successfull', ['attribute' => __('page.barcodes')])]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		abort(404);
		// if (!auth()->user()->can('business_settings.access')) {
		// 	abort(403, 'Unauthorized action.');
		// }

		// // $model = $this->repo->getQuery()->with(['contactAccess'])->findOrFail($id);
		// $model = $this->repo->findOrFail($id);
		// return view('admin.barcodes.show', compact('model'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		if (!auth()->user()->can('business_settings.access')) {
			abort(403, 'Unauthorized action.');
		}

		$model = $this->repo->findOrFail($id);
		return view('admin.barcodes.edit', compact('model'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(BarcodeRequest $request, $id) {

		if (!auth()->user()->can('business_settings.access')) {
			abort(403, 'Unauthorized action.');
		}$model = $this->repo->findOrFail($id);
		$this->repo->update($model, $this->request->all());
		return response()->json(['message' => __('service.updated_successfull', ['attribute' => __('page.barcodes')])]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		if (!auth()->user()->can('business_settings.access')) {
			abort(403, 'Unauthorized action.');
		}
		$model = $this->repo->findOrFail($id);
		if ($this->request->action and $this->request->action == 'status') {

			$this->repo->updateStatus($model);
			return response()->json(['message' => __('service.status_updated', ['attribute' => __('page.barcodes')])]);
		}
		$this->repo->deletable($id);
		$this->repo->delete($model);
		return response()->json(['message' => __('service.deleted', ['attribute' => __('page.barcodes')])]);

	}

	public function set_default($id) {
		if (!auth()->user()->can('business_settings.access')) {
			abort(403, 'Unauthorized action.');
		}
		$model = $this->repo->updateable($id);
		$this->repo->updateStatus($model);
		return response()->json(['message' => __('service.status_updated', ['attribute' => __('page.barcodes')])]);
		return response()->json(['message' => __('service.deleted', ['attribute' => __('page.barcodes')])]);

	}

	/**
	 * Action the specified resources from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function action() {
		if (!auth()->user()->can('business_settings.access')) {
			abort(403, 'Unauthorized action.');
		}

		if (!$this->request->action) {
			throw ValidationException::withMessages(['message' => __('service.unauthorized')]);
		}

		if (!$this->request->ids or !count($this->request->ids)) {
			throw ValidationException::withMessages(['message' => trans_choice('service.multiple_deleted', 0, ['attribute' => __('page.barcodes')])]);
		}

		$action = $this->repo->actions($this->request->all());
		return response()->json(['message' => $action]);

	}
}
