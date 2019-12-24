<?php
namespace App\Repositories\Admin;

use App\Models\Brand;
use App\Models\Business;
use App\Models\BusinessLocation;
use App\Models\Category;
use App\Models\ModelTemplate;
use App\Models\Product;
use App\Models\SellingPriceGroup;
use App\Models\TaxRate;
use App\Models\Unit;
use App\Models\Variation;
use App\Repositories\Repository;
use App\Utils\ProductUtil;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;

class ProductRepositoriy extends Repository {

	public $productUtil;
	protected $moduleUtil;

	private $barcode_types;

	public function __construct(Product $model, ProductUtil $productUtil, Util $moduleUtil) {
		$this->model = $model;
		$this->permission = '';
		$this->route = 'admin.products.';
		$this->action_exeption = ['show'];
		$this->productUtil = $productUtil;
		$this->moduleUtil = $moduleUtil;

		//barcode types
		$this->barcode_types = $this->productUtil->barcode_types();
	}
	/**
	 * Get model query
	 *
	 * @return Product query
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
		return $this->model->all()->pluck('name', 'id')->prepend(__('service.select', ['attribute' => __('page.brand')]), '');
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
	 * @return Product
	 */
	public function find($id) {
		return $this->model->find($id);
	}

	/**
	 * Find model with given id or throw an error.
	 *
	 * @param integer $id
	 * @return Product
	 * @throws ValidationException
	 */
	public function findOrFail($id, $field = 'message') {
		$model = $this->model->find($id);
		if (!$model) {
			throw ValidationException::withMessages([$field => __('service.not_found', ['attribute' => __('page.brand')])]);
		}
		return $model;
	}
	/**
	 * Get all data for Index
	 */
	public function datatable() {
		$business_id = $this->getBussinessId();
		$models = $this->model->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
			->join('units', 'products.unit_id', '=', 'units.id')
			->leftJoin('categories as c1', 'products.category_id', '=', 'c1.id')
			->leftJoin('models as m', 'products.model_id', '=', 'm.id')
			->leftJoin('tax_rates', 'products.tax', '=', 'tax_rates.id')
			->leftJoin('variation_location_details as vld', 'vld.product_id', '=', 'products.id')
			->join('variations as v', 'v.product_id', '=', 'products.id')
			->where('products.business_id', $business_id)
			->where('products.type', '!=', 'modifier')
			->select(
				'products.id',
				'products.name as product',
				'products.type',
				'c1.name as category',
				'm.name as model',
				'units.actual_name as unit',
				'brands.name as brand',
				'tax_rates.name as tax',
				'products.sku',
				'products.image',
				'products.enable_stock',
				'products.is_inactive',
				DB::raw('SUM(vld.qty_available) as current_stock'),
				DB::raw('MAX(v.sell_price_inc_tax) as max_price'),
				DB::raw('MIN(v.sell_price_inc_tax) as min_price')
			)->groupBy('products.id');

		$type = request()->get('type', null);
		if (!empty($type)) {
			$models->where('products.type', $type);
		}

		$category_id = request()->get('category_id', null);
		if (!empty($category_id)) {
			$models->where('products.category_id', $category_id);
		}

		$brand_id = request()->get('brand_id', null);
		if (!empty($brand_id)) {
			$models->where('products.brand_id', $brand_id);
		}

		$unit_id = request()->get('unit_id', null);
		if (!empty($unit_id)) {
			$models->where('products.unit_id', $unit_id);
		}

		$tax_id = request()->get('tax_id', null);
		if (!empty($tax_id)) {
			$models->where('products.tax', $tax_id);
		}

		return Datatables::of($models)
			->addIndexColumn()
			->editColumn('product', function ($row) {
				$product = $row->is_inactive == 1 ? $row->product . ' <span class="label bg-gray">Inactive
                        </span>' : $row->product;
				return $product;
			})

			->editColumn('image', function ($row) {
				return '<div style="display: flex;"><img src="' . $row->image_url . '" alt="Product image" class="product-thumbnail-small"></div>';
			})
			->editColumn('type', '@lang("service." . $type)')

			->editColumn('current_stock', '@if($enable_stock == 1) {{@number_format($current_stock)}} @else -- @endif {{$unit}}')
			->addColumn(
				'price',
				'<div style="white-space: nowrap;"><span class="display_currency" data-currency_symbol="true">{{$min_price}}</span> @if($max_price != $min_price && $type == "variable") -  <span class="display_currency" data-currency_symbol="true">{{$max_price}}</span>@endif </div>'
			)
		// ->setRowAttr([
		// 	'data-url' => function ($row) {
		// 		if (auth()->user()->can("product.view")) {
		// 			return route('admin.products.view', [$row->id]);
		// 		} else {
		// 			return '';
		// 		}
		// 	}, 'id' => 'content_managment'])
			->addColumn('action', function ($model) {

				$action['route'] = $this->route;
				$action['permission'] = $this->permission;
				$action['action_exeption'] = $this->action_exeption;
				return view('admin.product.action', compact('model', 'action'));

			})

			->removeColumn(['created_at', 'updated_at'])
			->rawColumns(['action', 'product', 'image', 'current_stock', 'price'])
			->make(true);
	}
	public function preRequisite($id = Null) {
		$business_id = $this->getBussinessId();
		$categories = Category::where('business_id', $business_id)
			->where('parent_id', 0)
			->pluck('name', 'id')->prepend('Please Select', '');
		$brands = Brand::where('business_id', $business_id)
			->pluck('name', 'id')->prepend('Please Select', '');
		$units = Unit::forDropdown($business_id, true);

		$tax_dropdown = TaxRate::forBusinessDropdown($business_id, true, true);
		$taxes = $tax_dropdown['tax_rates'];
		$tax_attributes = $tax_dropdown['attributes'];

		$barcode_types = $this->barcode_types;
		$barcode_default = $this->productUtil->barcode_default();

		$default_profit_percent = Business::where('id', $business_id)->value('default_profit_percent');

		//Get all business locations
		$business_locations = BusinessLocation::forDropdown($business_id);

		//Duplicate product
		$duplicate_product = null;
		$rack_details = null;

		$sub_categories = [];

		$selling_price_group_count = SellingPriceGroup::countSellingPriceGroups($business_id);
		if (!empty(request()->input('d'))) {
			$duplicate_product = $this->model->where('business_id', $business_id)->find(request()->input('d'));
			$duplicate_product->name .= ' (copy)';

			if (!empty($duplicate_product->category_id)) {
				$sub_categories = Category::where('business_id', $business_id)
					->where('parent_id', $duplicate_product->category_id)
					->pluck('name', 'id')->prepend('Please Select', '')
					->toArray();
			}

			//Rack details
			if (!empty($duplicate_product->id)) {
				$rack_details = $this->productUtil->getRackDetails($business_id, $duplicate_product->id);
			}
		} elseif ($id) {
			$product = $this->findOrFail($id);
			$models = ModelTemplate::where('business_id', $business_id)
				->where('category_id', $product->category_id)
				->where('brand_id', $product->brand_id)
				->pluck('name', 'id')
				->toArray();

			$models = ["" => "None"] + $models;
			$compact = compact('categories', 'brands', 'units', 'tax_dropdown', 'taxes', 'tax_attributes', 'barcode_types', 'barcode_default', 'default_profit_percent', 'business_locations', 'duplicate_product', 'rack_details', 'sub_categories', 'models', 'selling_price_group_count');
			return $compact;
		}
		$compact = compact('categories', 'brands', 'units', 'tax_dropdown', 'taxes', 'tax_attributes', 'barcode_types', 'barcode_default', 'default_profit_percent', 'business_locations', 'duplicate_product', 'rack_details', 'sub_categories', 'selling_price_group_count');
		return $compact;
	}
	/**
	 * Create a new model.
	 *
	 * @param array $params
	 * @return Product
	 */
	public function create($params) {
		$product = $this->model->forceCreate($this->formatParams($params));

		if (!trim(gv($params, 'sku'))) {
			$sku = $this->productUtil->generateProductSku($product->id);
			$product->sku = $sku;
			$product->save();
		}

		if ($product->type == 'single') {
			$this->productUtil->createSingleProductVariation($product->id, $product->sku, gv($params, 'single_dpp'), gv($params, 'single_dpp_inc_tax'), gv($params, 'profit_percent'), gv($params, 'single_dsp'), gv($params, 'single_dsp_inc_tax'));
		} elseif ($product->type == 'variable') {
			if (gv($params, 'product_variation')) {
				$input_variations = gv($params, 'product_variation');
				$this->productUtil->createVariableProductVariations($product->id, $input_variations);
			}
		}

		//Add product racks details.
		$product_racks = gv($params, 'product_racks');
		if (!empty($product_racks)) {
			$this->productUtil->addRackDetails($business_id, $product->id, $product_racks);
		}
		return $product;
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
			'brand_id' => gv($params, 'brand_id'),
			'unit_id' => gv($params, 'unit_id'),
			'category_id' => gv($params, 'category_id'),
			'model_id' => gv($params, 'model_id'),
			'tax' => gv($params, 'tax'),
			'type' => gv($params, 'type'),
			'barcode_type' => gv($params, 'barcode_type'),
			'sku' => gv($params, 'sku'),
			'alert_quantity' => gv($params, 'alert_quantity'),
			'tax_type' => gv($params, 'tax_type'),
			'weight' => gv($params, 'weight'),
			'product_custom_field1' => gv($params, 'product_custom_field1'),
			'product_custom_field2' => gv($params, 'product_custom_field2'),
			'product_custom_field3' => gv($params, 'product_custom_field3'),
			'product_custom_field4' => gv($params, 'product_custom_field4'),
			'product_description' => gv($params, 'product_description'),

			'created_by' => $this->getUserId(),
			'business_id' => $this->getBussinessId(),
		];

		$formatted['enable_stock'] = (gbv($params, 'enable_stock') && gbv($params, 'enable_stock') == 1) ? 1 : 0;
		$formatted['alert_quantity'] = gv($params, 'alert_quantity');

		if (empty($formatted['sku'])) {
			$formatted['sku'] = ' ';
		}

		$expiry_enabled = request()->session()->get('business.enable_product_expiry');
		if (gv($params, 'expiry_period_type') && gv($params, 'expiry_period') && !empty($expiry_enabled) && ($formatted['enable_stock'] == 1)) {
			$formatted['expiry_period_type'] = gv($params, 'expiry_period_type');
			$formatted['expiry_period'] = $this->productUtil->num_uf(gv($params, 'expiry_period'));
		}
		$formatted['is_lifetime'] = gbv($params, 'is_lifetime');
		if (gbv($params, 'is_lifetime') && gv($params, 'warenty_period_type') && gv($params, 'warenty_period')) {
			$formatted['warenty_period_type'] = gv($params, 'warenty_period_type');
			$formatted['warenty_period'] = $this->productUtil->num_uf(gv($params, 'warenty_period'));
			$formatted['is_lifetime'] = 0;
		}

		if (gbv($params, 'enable_sr_no') && gbv($params, 'enable_sr_no') == 1) {
			$formatted['enable_sr_no'] = 1;
		}

		//upload document
		$formatted['image'] = $this->productUtil->uploadFile($params, 'image', config('constants.product_img_path'));

		return $formatted;
	}
	/**
	 * Update given model.
	 *
	 * @param Product $model
	 * @param array $params
	 *
	 * @return Product
	 */
	public function update(Product $model, $params) {
		$model->forceFill($this->formatParams($params, $model->id))->save();
		$product = $this->findOrFail($model->id);
		if ($product->type == 'single') {

			$variation = Variation::find($params['single_variation_id']);

			$variation->sub_sku = $product->sku;
			$variation->default_purchase_price = $this->productUtil->num_uf($params['single_dpp']);
			$variation->dpp_inc_tax = $this->productUtil->num_uf($params['single_dpp_inc_tax']);
			$variation->profit_percent = $this->productUtil->num_uf($params['profit_percent']);
			$variation->default_sell_price = $this->productUtil->num_uf($params['single_dsp']);
			$variation->sell_price_inc_tax = $this->productUtil->num_uf($params['single_dsp_inc_tax']);
			$variation->save();
		} elseif ($product->type == 'variable') {
			//Update existing variations
			$input_variations_edit = $params['product_variation_edit'];
			if (!empty($input_variations_edit)) {
				$this->productUtil->updateVariableProductVariations($product->id, $input_variations_edit);
			}

			//Add new variations created.
			$input_variations = $params['product_variation'];
			if (!empty($input_variations)) {
				$this->productUtil->createVariableProductVariations($product->id, $input_variations);
			}
		}

		//Add product racks details.
		$product_racks = gv($params, 'product_racks');
		if (!empty($product_racks)) {
			$this->productUtil->addRackDetails($business_id, $product->id, $product_racks);
		}

		$product_racks_update = gv($params, 'product_racks_update');
		if (!empty($product_racks_update)) {
			$this->productUtil->updateRackDetails($business_id, $product->id, $product_racks_update);
		}
		return $model;
	}

	/**
	 * Find model & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return Product
	 * @throws ValidationException
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
	 * @throws \Exception
	 */
	public function delete(Product $model) {
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
		$msg = trans_choice('service.multiple_deleted', count($ids), ['attribute' => __('page.brand'), 'value' => count($ids)]);
		return $msg;
	}
	public function actions($data) {
		if ($data['action'] == 'delete') {
			return $this->deleteMultiple($data['ids']);
		}
	}
}
