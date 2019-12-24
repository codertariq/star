<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Business;
use App\Models\ModelTemplate;
use App\Models\ProductVariation;
use App\Models\SellingPriceGroup;
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
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(ProductRequest $request) {

		if (!auth()->user()->can('product.create')) {
			abort(403, 'Unauthorized action.');
		}

		$product = $this->repo->create($this->request->all());
		$goto = '';
		if ($request->input('submit_type') == 'submit_n_add_opening_stock') {
			$goto = route('admin.opening-stock.create', $product->id);
		} elseif ($request->input('submit_type') == 'submit_n_add_selling_prices') {
			$goto = route('admin.add-selling-prices.create', $product->id);
		} elseif ($request->input('submit_type') == 'save_n_add_another') {
			$goto = route('admin.products.create', $product->id);
		} else {
			$goto = route('admin.products.index');
		}

		return response()->json(['message' => __('service.created_successfull', ['attribute' => __('page.product')]), 'goto' => $goto]);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		if (!auth()->user()->can('product.view')) {
			abort(403, 'Unauthorized action.');
		}

		$business_id = request()->session()->get('user.business_id');
		$details = $this->repo->productUtil->getRackDetails($business_id, $id, true);

		return view('admin.product.show')->with(compact('details'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function view($id) {
		if (!auth()->user()->can('product.view')) {
			abort(403, 'Unauthorized action.');
		}

		$business_id = request()->session()->get('user.business_id');

		$product = $this->repo->model->where('business_id', $business_id)
			->where('id', $id)
			->with(['brand', 'unit', 'category', 'sub_category', 'product_tax', 'variations', 'variations.product_variation', 'variations.group_prices'])
			->first();

		$price_groups = SellingPriceGroup::where('business_id', $business_id)->pluck('name', 'id');

		$allowed_group_prices = [];
		foreach ($price_groups as $key => $value) {
			if (auth()->user()->can('selling_price_group.' . $key)) {
				$allowed_group_prices[$key] = $value;
			}
		}

		$group_price_details = [];

		foreach ($product->variations as $variation) {
			foreach ($variation->group_prices as $group_price) {
				$group_price_details[$variation->id][$group_price->price_group_id] = $group_price->price_inc_tax;
			}
		}

		$rack_details = $this->repo->productUtil->getRackDetails($business_id, $id, true);

		return view('admin.product.view-modal')->with(compact(
			'product',
			'rack_details',
			'allowed_group_prices',
			'group_price_details'
		));
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
		return view('admin.product.edit', $pre_requisite, compact('model'));
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
		$goto = '';
		if ($request->input('submit_type') == 'submit_n_add_opening_stock') {
			$goto = route('admin.opening-stock.create', $product->id);
		} elseif ($request->input('submit_type') == 'submit_n_add_selling_prices') {
			$goto = route('admin.add-selling-prices.create', $product->id);
		} elseif ($request->input('submit_type') == 'save_n_add_another') {
			$goto = route('admin.products.create', $product->id);
		} else {
			$goto = route('admin.products.index');
		}
		return response()->json(['message' => __('service.updated_successfull', ['attribute' => __('page.product')]), 'goto' => $goto]);
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
	/**
	 * Get subcategories list for a category.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function getSubModels() {
		$business_id = $this->request->session()->get('user.business_id');
		$models = ModelTemplate::where('business_id', $business_id);
		if ($this->request->cat_id) {
			$category_id = $this->request->cat_id;
			$models->where('category_id', $category_id);
		}
		if ($this->request->brand_id) {
			$brand_id = $this->request->brand_id;
			$models->where('brand_id', $brand_id);
		}

		$models = $models->get();

		$html = '<option value="">None</option>';
		if (!empty($models)) {
			foreach ($models as $model) {
				$html .= '<option value="' . $model->id . '">' . $model->name . '</option>';
			}
		}
		echo $html;
		exit;
	}
}
