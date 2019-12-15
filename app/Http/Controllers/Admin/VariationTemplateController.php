<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariationTemplateRequest;
use App\Repositories\Admin\VariationTemplateRepositoriy;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VariationTemplateController extends Controller {
	protected $request;
	protected $repo;
	public function __construct(Request $request, VariationTemplateRepositoriy $repo) {
		$this->request = $request;
		$this->repo = $repo;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		if (!auth()->user()->can('product.view') && !auth()->user()->can('product.create')) {
			abort(403, 'Unauthorized action.');
		}
		if ($this->request->ajax() and $this->request->get == 'datatable') {
			return $this->repo->datatable();
		}
		return view('admin.variation_template.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		if (!auth()->user()->can('product.create')) {
			abort(403, 'Unauthorized action.');
		}
		// $pre_requisite = $this->repo->preRequisite();
		return view('admin.variation_template.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(VariationTemplateRequest $request) {
		if (!auth()->user()->can('product.create')) {
			abort(403, 'Unauthorized action.');
		}

		$this->repo->create($this->request->all());
		return response()->json(['message' => __('service.created_successfull', ['attribute' => __('page.variation_template')])]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		abort(404);
		// if (!auth()->user()->can('product.view')) {
		// 	abort(403, 'Unauthorized action.');
		// }

		// // $model = $this->repo->getQuery()->with(['contactAccess'])->findOrFail($id);
		// $model = $this->repo->findOrFail($id);
		// return view('admin.variation_template.show', compact('model'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		if (!auth()->user()->can('product.update')) {
			abort(403, 'Unauthorized action.');
		}

		$model = $this->repo->model->with(['values'])->findOrFail($id);
		$pre_requisite = $this->repo->preRequisite($id);
		return view('admin.variation_template.edit', compact('model'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(VariationTemplateRequest $request, $id) {

		if (!auth()->user()->can('product.update')) {
			abort(403, 'Unauthorized action.');
		}

		$model = $this->repo->findOrFail($id);
		$this->repo->update($model, $this->request->all());
		return response()->json(['message' => __('service.updated_successfull', ['attribute' => __('page.variation_template')])]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		if (!auth()->user()->can('product.delete')) {
			abort(403, 'Unauthorized action.');
		}
		$model = $this->repo->findOrFail($id);

		if ($this->request->action and $this->request->action == 'status') {
			$this->repo->updateable($id);
			$this->repo->updateStatus($model);
			return response()->json(['message' => __('service.status_updated', ['attribute' => __('page.variation_template')])]);
		}
		$this->repo->deletable($id);
		$this->repo->delete($model);
		return response()->json(['message' => __('service.deleted', ['attribute' => __('page.variation_template')])]);

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
			throw ValidationException::withMessages(['message' => trans_choice('service.multiple_deleted', 0, ['attribute' => __('page.variation_template')])]);
		}

		$action = $this->repo->actions($this->request->all());
		return response()->json(['message' => $action]);

	}

	public function checkLocationId() {
		$location_id = $this->request->input('location_id');

		if (!empty($location_id)) {
			$business_id = $this->request->session()->get('user.business_id');
			$hidden_id = $this->request->input('hidden_id');

			$query = $this->repo->getQuery()->where('business_id', $business_id)
				->where('location_id', $location_id);
			if ($hidden_id) {
				$query->where('id', '!=', $hidden_id);
			}
			$count = $query->count();
			if ($count) {
				throw ValidationException::withMessages(['location_id' => __('validation.unique', ['attribute' => __('page.variation_template')])]);
			}

		}
		return response()->json(['message' => __('service.available', ['attribute' => __('page.variation_template')])]);

	}
}
