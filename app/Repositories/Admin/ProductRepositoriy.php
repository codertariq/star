<?php
namespace App\Repositories\Admin;

use App\Models\Brand;
use App\Models\Business;
use App\Models\BusinessLocation;
use App\Models\Category;
use App\Models\Product;
use App\Models\SellingPriceGroup;
use App\Models\TaxRate;
use App\Models\Unit;
use App\Repositories\Repository;
use App\Utils\ProductUtil;
use App\Utils\Util;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;

class ProductRepositoriy extends Repository {

	protected $productUtil;
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
		$models = $this->model->where('business_id', $this->getBussinessId())
			->select(['name', 'description', 'id']);

		return Datatables::of($models)
			->addIndexColumn()
			->editColumn('name', function ($model) {
				return '<strong>' . $model->name . '</strong>';
			})

			->removeColumn('id')
			->addColumn('action', function ($model) {

				$action['route'] = $this->route;
				$action['permission'] = $this->permission;
				$action['action_exeption'] = $this->action_exeption;
				return view('admin.brand.action', compact('model', 'action'));

			})

			->removeColumn(['created_at', 'updated_at'])
			->rawColumns(['action', 'name', 'status'])
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
		}

		$selling_price_group_count = SellingPriceGroup::countSellingPriceGroups($business_id);
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
		$tax_rate = $this->model->forceCreate($this->formatParams($params));
		return $tax_rate;
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
			'description' => gv($params, 'description'),
			'created_by' => $this->getUserId(),
			'business_id' => $this->getBussinessId(),
		];

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
		return $model;
	}

	/**
	 * Find model & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return Product
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