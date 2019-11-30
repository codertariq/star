<?php
namespace App\Repositories\Admin;

use App\Models\InvoiceLayout;
use App\Repositories\Repository;
use App\Utils\Util;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;

class InvoiceLayoutRepositoriy extends Repository {
	protected $commonUtil;
	public function __construct(InvoiceLayout $model, Util $commonUtil) {
		$this->model = $model;
		$this->permission = '';
		$this->route = 'admin.invoice-layouts.';
		$this->action_exeption = [];
		$this->commonUtil = $commonUtil;
	}
	/**
	 * Get model query
	 *
	 * @return InvoiceLayout query
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
	 * @return InvoiceLayout
	 */
	public function find($id) {
		return $this->model->find($id);
	}
	/**
	 * Find model with given id or throw an error.
	 *
	 * @param integer $id
	 * @return InvoiceLayout
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

	public function preRequisite($id = Null) {
		$designs = ['classic' => 'Classic',
			'elegant' => 'Elegant',
			'detailed' => 'Detailed',
			'columnize-taxes' => 'Columnize Taxes',
		];
		$compact = compact('designs');

		return $compact;
	}
	/**
	 * Create a new model.
	 *
	 * @param array $params
	 * @return InvoiceLayout
	 */
	public function create($params) {
		$location = $this->model->forceCreate($this->formatParams($params));
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

		//Upload Logo
		$logo_name = $this->commonUtil->uploadFile($request, 'logo', 'invoice_logos');
		if (!empty($logo_name)) {
			$input['logo'] = $logo_name;
		}

		if (!empty($request->input('is_default'))) {
			//get_default
			$default = InvoiceLayout::where('business_id', $business_id)
				->where('is_default', 1)
				->update(['is_default' => 0]);
			$input['is_default'] = 1;
		}

		//Module info
		if ($request->has('module_info')) {
			$input['module_info'] = json_encode($request->input('module_info'));
		}

		if (!empty($request->input('table_tax_headings'))) {
			$input['table_tax_headings'] = json_encode($request->input('table_tax_headings'));
		}
		$input['product_custom_fields'] = !empty($request->input('product_custom_fields')) ? $request->input('product_custom_fields') : null;
		$input['contact_custom_fields'] = !empty($request->input('contact_custom_fields')) ? $request->input('contact_custom_fields') : null;
		$input['location_custom_fields'] = !empty($request->input('location_custom_fields')) ? $request->input('location_custom_fields') : null;

		InvoiceLayout::create($input);

		$formatted = [
			'name' => gv($params, 'name'),
			'header_text' => gv($params, 'header_text', 'blank'),
			'invoice_no_prefix' => gv($params, 'invoice_no_prefix'),
			'invoice_heading' => gv($params, 'invoice_heading'),
			'sub_total_label' => gv($params, 'sub_total_label'),
			'discount_label' => gv($params, 'discount_label'),
			'tax_label' => gv($params, 'tax_label'),
			'total_label' => gv($params, 'total_label'),
			'highlight_color' => gv($params, 'highlight_color'),
			'footer_text' => gv($params, 'footer_text'),
			'invoice_heading_not_paid' => gv($params, 'invoice_heading_not_paid'),
			'invoice_heading_paid' => gv($params, 'invoice_heading_paid'),
			'total_due_label' => gv($params, 'total_due_label'),
			'customer_label' => gv($params, 'customer_label'),
			'paid_label' => gv($params, 'paid_label'),
			'sub_heading_line1' => gv($params, 'sub_heading_line1'),
			'sub_heading_line2' => gv($params, 'sub_heading_line2'),
			'sub_heading_line3' => gv($params, 'sub_heading_line3'),
			'sub_heading_line4' => gv($params, 'sub_heading_line4'),
			'sub_heading_line5' => gv($params, 'sub_heading_line5'),
			'table_product_label' => gv($params, 'table_product_label'),
			'table_qty_label' => gv($params, 'table_qty_label'),
			'table_unit_price_label' => gv($params, 'table_unit_price_label'),
			'table_subtotal_label' => gv($params, 'table_subtotal_label'),
			'client_id_label' => gv($params, 'client_id_label'),
			'date_label' => gv($params, 'date_label'),
			'quotation_heading' => gv($params, 'quotation_heading'),
			'quotation_no_prefix' => gv($params, 'quotation_no_prefix'),
			'design' => gv($params, 'design'),
			'client_tax_label' => gv($params, 'client_tax_label'),
			'cat_code_label' => gv($params, 'cat_code_label'),
			'cn_heading' => gv($params, 'cn_heading'),
			'cn_no_label' => gv($params, 'cn_no_label'),
			'cn_amount_label' => gv($params, 'cn_amount_label'),
			'sales_person_label' => gv($params, 'sales_person_label'),
			'prev_bal_label' => gv($params, 'prev_bal_label'),
			'date_time_format' => gv($params, 'date_time_format'),

			'show_business_name' => gbv($params, 'show_business_name'),
			'show_location_name' => gbv($params, 'show_location_name'),
			'show_landmark' => gbv($params, 'show_landmark'),
			'show_city' => gbv($params, 'show_city'),
			'show_state' => gbv($params, 'show_state'),
			'show_country' => gbv($params, 'show_country'),
			'show_zip_code' => gbv($params, 'show_zip_code'),
			'show_mobile_number' => gbv($params, 'show_mobile_number'),
			'show_alternate_number' => gbv($params, 'show_alternate_number'),
			'show_email' => gbv($params, 'show_email'),
			'show_tax_1' => gbv($params, 'show_tax_1'),
			'show_tax_2' => gbv($params, 'show_tax_2'),
			'show_logo' => gbv($params, 'show_logo'),
			'show_barcode' => gbv($params, 'show_barcode'),
			'show_payments' => gbv($params, 'show_payments'),
			'show_customer' => gbv($params, 'show_customer'),
			'show_client_id' => gbv($params, 'show_client_id'),
			'show_brand' => gbv($params, 'show_brand'),
			'show_sku' => gbv($params, 'show_sku'),
			'show_cat_code' => gbv($params, 'show_cat_code'),
			'show_sale_description' => gbv($params, 'show_sale_description'),
			'show_sales_person' => gbv($params, 'show_sales_person'),
			'show_expiry' => gbv($params, 'show_expiry'),
			'show_lot' => gbv($params, 'show_lot'),
			'show_previous_bal' => gbv($params, 'show_previous_bal'),
			'show_image' => gbv($params, 'show_image'),
			'business_id' => $this->getBussinessId(),
		];

		if (gv($params, 'is_default')) {
			//get_default
			$default = $this->model->where('business_id', $this->getBussinessId())
				->where('is_default', 1)
				->update(['is_default' => 0]);
			$formatted['is_default'] = 1;
		}

		return $formatted;
	}
	/**
	 * Update given model.
	 *
	 * @param InvoiceLayout $model
	 * @param array $params
	 *
	 * @return InvoiceLayout
	 */
	public function update(InvoiceLayout $model, $params) {
		$model->forceFill($this->formatParams($params, $model->id))->save();
		return $model;
	}

	public function updateStatus(InvoiceLayout $model) {
		$this->model->where('business_id', $this->getBussinessId())
			->where('is_default', 1)
			->update(['is_default' => 0]);
		return $model->update(['is_default' => 1]);

	}

	/**
	 * Find model & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return InvoiceLayout
	 */
	public function updateable($id) {
		$model = $this->findOrFail($id);
		if ($model->is_default) {
			throw ValidationException::withMessages(['message' => __('service.default_invoice')]);
		}
		return $model;
	}

	/**
	 * Find model & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return InvoiceLayout
	 */
	public function deletable($id) {
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
	public function delete(InvoiceLayout $model) {
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