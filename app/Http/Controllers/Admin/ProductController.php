<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Business;
use App\Models\ProductVariation;
use App\Models\VariationTemplate;
use App\Repositories\Admin\ProductRepositoriy;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller {
	protected $request;
	protected $repo;
	public function __construct(Request $request, ProductRepositoriy $repo) {
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
		return view('admin.product.index');
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
		$pre_requisite = $this->repo->preRequisite();
		return view('admin.product.create', $pre_requisite);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(ProductRequest $request) {
		if (!auth()->user()->can('product.create')) {
			abort(403, 'Unauthorized action.');
		}

		$this->repo->create($this->request->all());
		return response()->json(['message' => __('service.created_successfull', ['attribute' => __('page.product')])]);
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
		// return view('admin.product.show', compact('model'));
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

		$model = $this->repo->findOrFail($id);
		$pre_requisite = $this->repo->preRequisite($id);
		return view('admin.product.edit', compact('model'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(ProductRequest $request, $id) {

		if (!auth()->user()->can('product.update')) {
			abort(403, 'Unauthorized action.');
		}

		$model = $this->repo->findOrFail($id);
		$this->repo->update($model, $this->request->all());
		return response()->json(['message' => __('service.updated_successfull', ['attribute' => __('page.product')])]);
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
			return response()->json(['message' => __('service.status_updated', ['attribute' => __('page.product')])]);
		}
		$this->repo->deletable($id);
		$this->repo->delete($model);
		return response()->json(['message' => __('service.deleted', ['attribute' => __('page.product')])]);

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
			throw ValidationException::withMessages(['message' => trans_choice('service.multiple_deleted', 0, ['attribute' => __('page.product')])]);
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
				throw ValidationException::withMessages(['location_id' => __('validation.unique', ['attribute' => __('page.product')])]);
			}

		}
		return response()->json(['message' => __('service.available', ['attribute' => __('page.product')])]);

	}

	public function getProductVariationFormPart(Request $request) {
		$business_id = $request->session()->get('user.business_id');
		$business = Business::findorfail($business_id);
		$profit_percent = $business->default_profit_percent;

		$action = $request->input('action');
		if ($request->input('action') == "add") {
			if ($request->input('type') == 'single') {
				return view('admin.product.partials.single_product_form_part')
					->with(['profit_percent' => $profit_percent]);
			} elseif ($request->input('type') == 'variable') {
				$variation_templates = VariationTemplate::where('business_id', $business_id)->pluck('name', 'id')->toArray();
				$variation_templates = ["" => __('messages.please_select')] + $variation_templates;

				return view('admin.product.partials.variable_product_form_part')
					->with(compact('variation_templates', 'profit_percent', 'action'));
			}
		} elseif ($request->input('action') == "edit" || $request->input('action') == "duplicate") {
			$product_id = $request->input('product_id');
			if ($request->input('type') == 'single') {
				$product_deatails = ProductVariation::where('product_id', $product_id)
					->with(['variations'])
					->first();

				return view('admin.product.partials.edit_single_product_form_part')
					->with(compact('product_deatails'));
			} elseif ($request->input('type') == 'variable') {
				$product_variations = ProductVariation::where('product_id', $product_id)
					->with(['variations'])
					->get();
				return view('admin.product.partials.variable_product_form_part')
					->with(compact('product_variations', 'profit_percent', 'action'));
			}
		}
	}

	public function getVariationValueRow(Request $request) {
		$business_id = $request->session()->get('user.business_id');
		$business = Business::findorfail($business_id);
		$profit_percent = $business->default_profit_percent;

		$variation_index = $request->input('variation_row_index');
		$value_index = $request->input('value_index') + 1;

		$row_type = $request->input('row_type', 'add');

		return view('admin.product.partials.variation_value_row')
			->with(compact('profit_percent', 'variation_index', 'value_index', 'row_type'));
	}

	public function getProductVariationRow(Request $request) {
		$business_id = $request->session()->get('user.business_id');
		$business = Business::findorfail($business_id);
		$profit_percent = $business->default_profit_percent;

		$variation_templates = VariationTemplate::where('business_id', $business_id)
			->pluck('name', 'id')->toArray();
		$variation_templates = ["" => __('messages.please_select')] + $variation_templates;

		$row_index = $request->input('row_index', 0);
		$action = $request->input('action');

		return view('admin.product.partials.product_variation_row')
			->with(compact('variation_templates', 'row_index', 'action', 'profit_percent'));
	}

	public function getVariationTemplate(Request $request) {
		$business_id = $request->session()->get('user.business_id');
		$business = Business::findorfail($business_id);
		$profit_percent = $business->default_profit_percent;

		$template = VariationTemplate::where('id', $request->input('template_id'))
			->with(['values'])
			->first();
		$row_index = $request->input('row_index');

		return view('admin.product.partials.product_variation_template')
			->with(compact('template', 'row_index', 'profit_percent'));
	}
}
