<?php
namespace App\Repositories\Admin;

use App\Models\Contact;
use App\Models\CustomerGroup;
use App\Repositories\Repository;
use App\Utils\ModuleUtil;
use App\Utils\TransactionUtil;
use App\Utils\Util;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;

class ContactRepositoriy extends Repository {
	protected $commonUtil;
	protected $transactionUtil;

	public function __construct(
		Contact $model,
		Util $commonUtil,
		ModuleUtil $moduleUtil,
		TransactionUtil $transactionUtil
	) {
		$this->model = $model;
		$this->permission = '';
		$this->route = 'admin.contacts.';
		$this->action_exeption = [];
		$this->commonUtil = $commonUtil;
		$this->moduleUtil = $moduleUtil;
		$this->transactionUtil = $transactionUtil;
	}
	/**
	 * Get model query
	 *
	 * @return Contact query
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
	 * @return Contact
	 */
	public function find($id) {
		return $this->model->find($id);
	}
	/**
	 * Find model with given id or throw an error.
	 *
	 * @param integer $id
	 * @return Contact
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

	/**
	 * Returns the database object for supplier
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function indexSupplier() {
		if (!auth()->user()->can('supplier.view')) {
			abort(403, 'Unauthorized action.');
		}

		$business_id = request()->session()->get('user.business_id');

		$contact = Contact::leftjoin('transactions AS t', 'contacts.id', '=', 't.contact_id')
			->where('contacts.business_id', $business_id)
			->onlySuppliers()
			->select(['contacts.contact_id', 'supplier_business_name', 'name', 'mobile',
				'contacts.type', 'contacts.id',
				DB::raw("SUM(IF(t.type = 'purchase', final_total, 0)) as total_purchase"),
				DB::raw("SUM(IF(t.type = 'purchase', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as purchase_paid"),
				DB::raw("SUM(IF(t.type = 'purchase_return', final_total, 0)) as total_purchase_return"),
				DB::raw("SUM(IF(t.type = 'purchase_return', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as purchase_return_paid"),
				DB::raw("SUM(IF(t.type = 'opening_balance', final_total, 0)) as opening_balance"),
				DB::raw("SUM(IF(t.type = 'opening_balance', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid"),
			])
			->groupBy('contacts.id');

		return Datatables::of($contact)
			->addColumn(
				'due',
				'<span class="display_currency contact_due" data-orig-value="{{$total_purchase - $purchase_paid}}" data-currency_symbol=true data-highlight=false>{{$total_purchase - $purchase_paid }}</span>'
			)
			->addColumn(
				'return_due',
				'<span class="display_currency return_due" data-orig-value="{{$total_purchase_return - $purchase_return_paid}}" data-currency_symbol=true data-highlight=false>{{$total_purchase_return - $purchase_return_paid }}</span>'
			)
			->addColumn('action', function ($model) {
				$action['route'] = $this->route;
				$action['permission'] = $this->permission;
				$action['action_exeption'] = $this->action_exeption;
				return view('admin.contact.supplier_action', compact('model', 'action'));
			})
			->removeColumn('opening_balance')
			->removeColumn('opening_balance_paid')
			->removeColumn('type')
			->removeColumn('id')
			->removeColumn('total_purchase')
			->removeColumn('purchase_paid')
			->removeColumn('total_purchase_return')
			->removeColumn('purchase_return_paid')
			->rawColumns([4, 5, 6])
			->make(false);
	}

	/**
	 * Returns the database object for customer
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function indexCustomer() {
		if (!auth()->user()->can('customer.view')) {
			abort(403, 'Unauthorized action.');
		}

		$business_id = request()->session()->get('user.business_id');

		$contact = Contact::leftjoin('transactions AS t', 'contacts.id', '=', 't.contact_id')
			->leftjoin('customer_groups AS cg', 'contacts.customer_group_id', '=', 'cg.id')
			->where('contacts.business_id', $business_id)
			->onlyCustomers()
			->addSelect(['contacts.contact_id', 'contacts.name', 'cg.name as customer_group', 'city', 'state', 'country', 'landmark', 'mobile', 'contacts.id', 'is_default',
				DB::raw("SUM(IF(t.type = 'sell' AND t.status = 'final', final_total, 0)) as total_invoice"),
				DB::raw("SUM(IF(t.type = 'sell' AND t.status = 'final', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as invoice_received"),
				DB::raw("SUM(IF(t.type = 'sell_return', final_total, 0)) as total_sell_return"),
				DB::raw("SUM(IF(t.type = 'sell_return', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as sell_return_paid"),
				DB::raw("SUM(IF(t.type = 'opening_balance', final_total, 0)) as opening_balance"),
				DB::raw("SUM(IF(t.type = 'opening_balance', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid"),
			])
			->groupBy('contacts.id');

		return Datatables::of($contact)
			->editColumn(
				'landmark',
				'{{implode(array_filter([$landmark, $city, $state, $country]), ", ")}}'
			)
			->addColumn(
				'due',
				'<span class="display_currency contact_due" data-orig-value="{{$total_invoice - $invoice_received}}" data-currency_symbol=true data-highlight=true>{{($total_invoice - $invoice_received)}}</span>'
			)
			->addColumn(
				'return_due',
				'<span class="display_currency return_due" data-orig-value="{{$total_sell_return - $sell_return_paid}}" data-currency_symbol=true data-highlight=false>{{$total_sell_return - $sell_return_paid }}</span>'
			)
			->addColumn('action', function ($model) {
				$action['route'] = $this->route;
				$action['permission'] = $this->permission;
				$action['action_exeption'] = $this->action_exeption;
				return view('admin.contact.customer_action', compact('model', 'action'));
			})
			->removeColumn('total_invoice')
			->removeColumn('opening_balance')
			->removeColumn('opening_balance_paid')
			->removeColumn('invoice_received')
			->removeColumn('state')
			->removeColumn('country')
			->removeColumn('city')
			->removeColumn('type')
			->removeColumn('id')
			->removeColumn('is_default')
			->removeColumn('total_sell_return')
			->removeColumn('sell_return_paid')
			->rawColumns([5, 6, 7])
			->make(false);
	}
	public function datatable() {
		$models = $this->model->where('business_id', $this->getBussinessId())
			->select(['id', 'name', 'description', 'is_default']);

		return Datatables::of($models)
			->addIndexColumn()
			->addColumn('action', function ($model) {
				$action['route'] = $this->route;
				$action['permission'] = $this->permission;
				$action['action_exeption'] = $this->action_exeption;
				return view('admin.barcodes.action', compact('model', 'action'));

			})
			->editColumn('prefix', function ($row) {
				if ($row->scheme_type == 'year') {
					return date('Y') . '-';
				} else {
					return $row->prefix;
				}
			})
			->editColumn('name', function ($row) {
				if ($row->is_default == 1) {
					return $row->name . ' &nbsp; <span class="badge badge-success">' . __("barcode.default") . '</span>';
				} else {
					return $row->name;
				}
			})
			->setRowClass(function ($model) {
				if (!$model->is_default) {
					return '';
				} else {
					return 'is_default';
				}
			})
			->removeColumn(['created_at', 'updated_at', 'is_default', 'scheme_type'])
			->rawColumns(['action', 'name'])
			->make(true);
	}
	public function preRequisite($id = Null) {
		$types = [];
		if (auth()->user()->can('supplier.create')) {
			$types['supplier'] = __('report.supplier');
		}
		if (auth()->user()->can('customer.create')) {
			$types['customer'] = __('report.customer');
		}
		if (auth()->user()->can('supplier.create') && auth()->user()->can('customer.create')) {
			$types['both'] = __('service.both_supplier_customer');
		}

		$customer_groups = CustomerGroup::forDropdown($this->getBussinessId());

		$compact = compact('types', 'customer_groups');
		return $compact;
	}
	/**
	 * Create a new model.
	 *
	 * @param array $params
	 * @return Contact
	 */
	public function create($params) {
		$contact = $this->model->forceCreate($this->formatParams($params));

		//Add opening balance
		if (!empty($params['opening_balance'])) {
			$this->transactionUtil->createOpeningBalanceTransaction($this->getBussinessId(), $contact->id, $params['opening_balance']);
		}

		return $contact;
	}
	/**
	 * Prepare given params for inserting into database.
	 *
	 * @param array $params
	 * @param integer $model_id
	 * @return array
	 */
	private function formatParams($params, $model_id = null) {

		if (!$this->moduleUtil->isSubscribed($this->getBussinessId())) {
			return $this->moduleUtil->expiredResponse();
		}

		//Check Contact id

		$formatted = [
			'type' => gv($params, 'type'),
			'supplier_business_name' => gv($params, 'supplier_business_name'),
			'name' => gv($params, 'name'),
			'tax_number' => gv($params, 'tax_number'),
			'pay_term_number' => gv($params, 'pay_term_number'),
			'pay_term_type' => gv($params, 'pay_term_type'),
			'mobile' => gv($params, 'mobile'),
			'landline' => gv($params, 'landline'),
			'alternate_number' => gv($params, 'alternate_number'),
			'city' => gv($params, 'city'),
			'state' => gv($params, 'state'),
			'country' => gv($params, 'country'),
			'landmark' => gv($params, 'landmark'),
			'customer_group_id' => gv($params, 'customer_group_id'),
			'contact_id' => gv($params, 'contact_id'),
			'custom_field1' => gv($params, 'custom_field1'),
			'custom_field2' => gv($params, 'custom_field2'),
			'custom_field3' => gv($params, 'custom_field3'),
			'custom_field4' => gv($params, 'custom_field4'),
			'email' => gv($params, 'email'),
			'credit_limit' => gv($params, 'credit_limit') ? $this->commonUtil->num_uf($params['credit_limit']) : null,

			'created_by' => $this->getUserId(),
			'business_id' => $this->getBussinessId(),
		];

		$count = 0;
		if (!empty($params['contact_id'])) {
			$count = $this->model->where('business_id', $this->getBussinessId())
				->where('contact_id', $params['contact_id'])
				->count();
		}

		if ($count == 0) {
			//Update reference count
			$ref_count = $this->commonUtil->setAndGetReferenceCount('contacts');

			if (empty($params['contact_id'])) {
				//Generate reference number
				$formatted['contact_id'] = $this->commonUtil->generateReferenceNumber('contacts', $ref_count);
			}
		}
		return $formatted;
	}
	/**
	 * Update given model.
	 *
	 * @param Contact $model
	 * @param array $params
	 *
	 * @return Contact
	 */
	public function update(Contact $model, $params) {
		$model->forceFill($this->formatParams($params, $model->id))->save();
		return $model;
	}

	public function updateStatus(Contact $model) {
		$this->model->where('business_id', $this->getBussinessId())
			->where('is_default', 1)
			->update(['is_default' => 0]);
		return $model->update(['is_default' => 1]);

	}

	/**
	 * Find model & check it can be deleted or not.
	 *
	 * @param integer $id
	 * @return Contact
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
	 * @return Contact
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
	public function delete(Contact $model) {
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