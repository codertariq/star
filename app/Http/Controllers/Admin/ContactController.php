<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\CustomerGroup;
use App\Repositories\Admin\ContactRepositoriy;
use App\Transaction;
use App\Utils\ModuleUtil;
use App\Utils\TransactionUtil;
use App\Utils\Util;
use DB;
use Excel;
use Illuminate\Http\Request;

class ContactController extends Controller {
	protected $commonUtil;
	protected $transactionUtil;
	protected $request;
	protected $repo;

	/**
	 * Constructor
	 *
	 * @param Util $commonUtil
	 * @return void
	 */
	public function __construct(
		Util $commonUtil,
		ModuleUtil $moduleUtil,
		TransactionUtil $transactionUtil,
		Request $request,
		ContactRepositoriy $repo
	) {
		$this->commonUtil = $commonUtil;
		$this->moduleUtil = $moduleUtil;
		$this->transactionUtil = $transactionUtil;
		$this->request = $request;
		$this->repo = $repo;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$type = $this->request->get('type');

		$types = ['supplier', 'customer'];

		if (empty($type) || !in_array($type, $types)) {
			return redirect('/home');
		}

		if ($this->request->ajax() and $this->request->get == 'datatable') {
			if ($type == 'supplier') {
				return $this->repo->indexSupplier();
			} elseif ($type == 'customer') {
				return $this->repo->indexCustomer();
			} else {
				die("Not Found");
			}
		}

		return view('admin.contact.index')
			->with(compact('type'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		if (!auth()->user()->can('supplier.create') && !auth()->user()->can('customer.create')) {
			abort(403, 'Unauthorized action.');
		}

		$business_id = $this->request->session()->get('user.business_id');
		$type = $this->request->get('type');

		//Check if subscribed or not
		if (!$this->moduleUtil->isSubscribed($business_id)) {
			return $this->moduleUtil->expiredResponse();
		}
		$pre_requisite = $this->repo->preRequisite();
		return view('admin.contact.create', $pre_requisite, compact('type'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		if (!auth()->user()->can('supplier.create') && !auth()->user()->can('customer.create')) {
			abort(403, 'Unauthorized action.');
		}

		$this->repo->create($this->request->all());
		return response()->json(['message' => __('service.created_successfull', ['attribute' => __('page.tax_rates')])]);

		$business_id = $request->session()->get('user.business_id');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		if (!auth()->user()->can('supplier.view') && !auth()->user()->can('customer.view')) {
			abort(403, 'Unauthorized action.');
		}

		$contact = Contact::where('contacts.id', $id)
			->join('transactions AS t', 'contacts.id', '=', 't.contact_id')
			->select(
				DB::raw("SUM(IF(t.type = 'purchase', final_total, 0)) as total_purchase"),
				DB::raw("SUM(IF(t.type = 'sell' AND t.status = 'final', final_total, 0)) as total_invoice"),
				DB::raw("SUM(IF(t.type = 'purchase', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as purchase_paid"),
				DB::raw("SUM(IF(t.type = 'sell' AND t.status = 'final', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as invoice_received"),
				DB::raw("SUM(IF(t.type = 'opening_balance', final_total, 0)) as opening_balance"),
				DB::raw("SUM(IF(t.type = 'opening_balance', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid"),
				'contacts.*'
			)->first();
		return view('admin.contact.show')
			->with(compact('contact'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		if (!auth()->user()->can('supplier.update') && !auth()->user()->can('customer.update')) {
			abort(403, 'Unauthorized action.');
		}

		if ($this->request->ajax()) {
			$business_id = $this->request->session()->get('user.business_id');
			$contact = Contact::where('business_id', $business_id)->find($id);

			if (!$this->moduleUtil->isSubscribed($business_id)) {
				return $this->moduleUtil->expiredResponse();
			}

			$types = [];
			if (auth()->user()->can('supplier.create')) {
				$types['supplier'] = __('report.supplier');
			}
			if (auth()->user()->can('customer.create')) {
				$types['customer'] = __('report.customer');
			}
			if (auth()->user()->can('supplier.create') && auth()->user()->can('customer.create')) {
				$types['both'] = __('lang_v1.both_supplier_customer');
			}

			$customer_groups = CustomerGroup::forDropdown($business_id);

			$ob_transaction = Transaction::where('contact_id', $id)
				->where('type', 'opening_balance')
				->first();
			$opening_balance = !empty($ob_transaction->final_total) ? $ob_transaction->final_total : 0;

			//Deduct paid amount from opening balance.
			if (!empty($opening_balance)) {
				$opening_balance_paid = $this->transactionUtil->getTotalAmountPaid($ob_transaction->id);
				if (!empty($opening_balance_paid)) {
					$opening_balance = $opening_balance - $opening_balance_paid;
				}

				$opening_balance = $this->commonUtil->num_f($ob_transaction->final_total);
			}

			return view('admin.contact.edit')
				->with(compact('contact', 'types', 'customer_groups', 'opening_balance'));
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		if (!auth()->user()->can('supplier.update') && !auth()->user()->can('customer.update')) {
			abort(403, 'Unauthorized action.');
		}

		if ($this->request->ajax()) {
			try {
				$input = $request->only(['type', 'supplier_business_name', 'name', 'tax_number', 'pay_term_number', 'pay_term_type', 'mobile', 'landline', 'alternate_number', 'city', 'state', 'country', 'landmark', 'customer_group_id', 'contact_id', 'custom_field1', 'custom_field2', 'custom_field3', 'custom_field4', 'email']);

				$input['credit_limit'] = $request->input('credit_limit') != '' ? $this->commonUtil->num_uf($request->input('credit_limit')) : null;

				$business_id = $request->session()->get('user.business_id');

				if (!$this->moduleUtil->isSubscribed($business_id)) {
					return $this->moduleUtil->expiredResponse();
				}

				$count = 0;

				//Check Contact id
				if (!empty($input['contact_id'])) {
					$count = Contact::where('business_id', $business_id)
						->where('contact_id', $input['contact_id'])
						->where('id', '!=', $id)
						->count();
				}

				if ($count == 0) {
					$contact = Contact::where('business_id', $business_id)->findOrFail($id);
					foreach ($input as $key => $value) {
						$contact->$key = $value;
					}
					$contact->save();

					//Get opening balance if exists
					$ob_transaction = Transaction::where('contact_id', $id)
						->where('type', 'opening_balance')
						->first();

					if (!empty($ob_transaction)) {
						$amount = $this->commonUtil->num_uf($request->input('opening_balance'));
						$opening_balance_paid = $this->transactionUtil->getTotalAmountPaid($ob_transaction->id);
						if (!empty($opening_balance_paid)) {
							$amount += $opening_balance_paid;
						}

						$ob_transaction->final_total = $amount;
						$ob_transaction->save();
						//Update opening balance payment status
						$this->transactionUtil->updatePaymentStatus($ob_transaction->id, $ob_transaction->final_total);
					} else {
						//Add opening balance
						if (!empty($request->input('opening_balance'))) {
							$this->transactionUtil->createOpeningBalanceTransaction($business_id, $contact->id, $request->input('opening_balance'));
						}
					}

					$output = ['success' => true,
						'msg' => __("contact.updated_success"),
					];
				} else {
					throw new \Exception("Error Processing Request", 1);
				}
			} catch (\Exception $e) {
				\Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

				$output = ['success' => false,
					'msg' => __("messages.something_went_wrong"),
				];
			}

			return $output;
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		if (!auth()->user()->can('supplier.delete') && !auth()->user()->can('customer.delete')) {
			abort(403, 'Unauthorized action.');
		}

		if ($this->request->ajax()) {
			try {
				$business_id = $this->request->user()->business_id;

				//Check if any transaction related to this contact exists
				$count = Transaction::where('business_id', $business_id)
					->where('contact_id', $id)
					->count();
				if ($count == 0) {
					$contact = Contact::where('business_id', $business_id)->findOrFail($id);
					if (!$contact->is_default) {
						$contact->delete();
					}
					$output = ['success' => true,
						'msg' => __("contact.deleted_success"),
					];
				} else {
					$output = ['success' => false,
						'msg' => __("lang_v1.you_cannot_delete_this_contact"),
					];
				}
			} catch (\Exception $e) {
				\Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

				$output = ['success' => false,
					'msg' => __("messages.something_went_wrong"),
				];
			}

			return $output;
		}
	}

	/**
	 * Retrieves list of customers, if filter is passed then filter it accordingly.
	 *
	 * @param  string  $q
	 * @return JSON
	 */
	public function getCustomers() {
		if ($this->request->ajax()) {
			$term = $this->request->input('q', '');

			$business_id = $this->request->session()->get('user.business_id');
			$user_id = $this->request->session()->get('user.id');

			$contacts = Contact::where('business_id', $business_id);

			$selected_contacts = User::isSelectedContacts($user_id);
			if ($selected_contacts) {
				$contacts->join('user_contact_access AS uca', 'contacts.id', 'uca.contact_id')
					->where('uca.user_id', $user_id);
			}

			if (!empty($term)) {
				$contacts->where(function ($query) use ($term) {
					$query->where('name', 'like', '%' . $term . '%')
						->orWhere('supplier_business_name', 'like', '%' . $term . '%')
						->orWhere('mobile', 'like', '%' . $term . '%')
						->orWhere('contacts.contact_id', 'like', '%' . $term . '%');
				});
			}

			$contacts = $contacts->select(
				'contacts.id',
				DB::raw("IF(contacts.contact_id IS NULL OR contacts.contact_id='', name, CONCAT(name, ' (', contacts.contact_id, ')')) AS text"),
				'mobile',
				'landmark',
				'city',
				'state',
				'pay_term_number',
				'pay_term_type'
			)
				->onlyCustomers()
				->get();
			return json_encode($contacts);
		}
	}

	/**
	 * Checks if the given contact id already exist for the current business.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function checkContactId(Request $request) {
		$contact_id = $request->input('contact_id');

		$valid = 'true';
		if (!empty($contact_id)) {
			$business_id = $request->session()->get('user.business_id');
			$hidden_id = $request->input('hidden_id');

			$query = Contact::where('business_id', $business_id)
				->where('contact_id', $contact_id);
			if (!empty($hidden_id)) {
				$query->where('id', '!=', $hidden_id);
			}
			$count = $query->count();
			if ($count > 0) {
				$valid = 'false';
			}
		}
		echo $valid;
		exit;
	}

	/**
	 * Shows import option for contacts
	 *
	 * @param  \Illuminate\Http\Request
	 * @return \Illuminate\Http\Response
	 */
	public function getImportContacts() {
		if (!auth()->user()->can('supplier.create') && !auth()->user()->can('customer.create')) {
			abort(403, 'Unauthorized action.');
		}

		$zip_loaded = extension_loaded('zip') ? true : false;

		//Check if zip extension it loaded or not.
		if ($zip_loaded === false) {
			$output = ['success' => 0,
				'msg' => 'Please install/enable PHP Zip archive for import',
			];

			return view('admin.contact.import')
				->with('notification', $output);
		} else {
			return view('admin.contact.import');
		}
	}

	/**
	 * Imports contacts
	 *
	 * @param  \Illuminate\Http\Request
	 * @return \Illuminate\Http\Response
	 */
	public function postImportContacts(Request $request) {
		if (!auth()->user()->can('supplier.create') && !auth()->user()->can('customer.create')) {
			abort(403, 'Unauthorized action.');
		}

		try {
			//Set maximum php execution time
			ini_set('max_execution_time', 0);

			if ($request->hasFile('contacts_csv')) {
				$file = $request->file('contacts_csv');
				$imported_data = Excel::load($file->getRealPath())
					->noHeading()
					->skipRows(1)
					->get()
					->toArray();
				$business_id = $request->session()->get('user.business_id');
				$user_id = $request->session()->get('user.id');

				$formated_data = [];

				$is_valid = true;
				$error_msg = '';

				DB::beginTransaction();
				foreach ($imported_data as $key => $value) {
					//Check if 21 no. of columns exists
					if (count($value) != 21) {
						$is_valid = false;
						$error_msg = "Number of columns mismatch";
						break;
					}

					$row_no = $key + 1;
					$contact_array = [];

					//Check contact type
					$contact_type = '';
					if (!empty($value[0])) {
						$contact_type = strtolower(trim($value[0]));
						if (in_array($contact_type, ['supplier', 'customer', 'both'])) {
							$contact_array['type'] = $contact_type;
						} else {
							$is_valid = false;
							$error_msg = "Invalid contact type in row no. $row_no";
							break;
						}
					} else {
						$is_valid = false;
						$error_msg = "Contact type is required in row no. $row_no";
						break;
					}

					//Check contact name
					if (!empty($value[1])) {
						$contact_array['name'] = $value[1];
					} else {
						$is_valid = false;
						$error_msg = "Contact name is required in row no. $row_no";
						break;
					}

					//Check supplier fields
					if (in_array($contact_type, ['supplier', 'both'])) {
						//Check business name
						if (!empty(trim($value[2]))) {
							$contact_array['supplier_business_name'] = $value[2];
						} else {
							$is_valid = false;
							$error_msg = "Business name is required in row no. $row_no";
							break;
						}

						//Check pay term
						if (trim($value[6]) != '') {
							$contact_array['pay_term_number'] = trim($value[6]);
						} else {
							$is_valid = false;
							$error_msg = "Pay term is required in row no. $row_no";
							break;
						}

						//Check pay period
						$pay_term_type = strtolower(trim($value[7]));
						if (in_array($pay_term_type, ['days', 'months'])) {
							$contact_array['pay_term_type'] = $pay_term_type;
						} else {
							$is_valid = false;
							$error_msg = "Pay term period is required in row no. $row_no";
							break;
						}
					}

					//Check contact ID
					if (!empty(trim($value[3]))) {
						$count = Contact::where('business_id', $business_id)
							->where('contact_id', $value[3])
							->count();

						if ($count == 0) {
							$contact_array['contact_id'] = $value[3];
						} else {
							$is_valid = false;
							$error_msg = "Contact ID already exists in row no. $row_no";
							break;
						}
					}

					//Tax number
					if (!empty(trim($value[4]))) {
						$contact_array['tax_number'] = $value[4];
					}

					//Check opening balance
					if (!empty(trim($value[5])) && $value[5] != 0) {
						$contact_array['opening_balance'] = trim($value[5]);
					}

					//Check credit limit
					if (trim($value[8]) != '' && in_array($contact_type, ['customer', 'both'])) {
						$contact_array['credit_limit'] = trim($value[8]);
					}

					//Check email
					if (!empty(trim($value[9]))) {
						if (filter_var(trim($value[9]), FILTER_VALIDATE_EMAIL)) {
							$contact_array['email'] = $value[9];
						} else {
							$is_valid = false;
							$error_msg = "Invalid email id in row no. $row_no";
							break;
						}
					}

					//Mobile number
					if (!empty(trim($value[10]))) {
						$contact_array['mobile'] = $value[10];
					} else {
						$is_valid = false;
						$error_msg = "Mobile number is required in row no. $row_no";
						break;
					}

					//Alt contact number
					$contact_array['alternate_number'] = $value[11];

					//Landline
					$contact_array['landline'] = $value[12];

					//City
					$contact_array['city'] = $value[13];

					//State
					$contact_array['state'] = $value[14];

					//Country
					$contact_array['country'] = $value[15];

					//Landmark
					$contact_array['landmark'] = $value[16];

					//Cust fields
					$contact_array['custom_field1'] = $value[17];
					$contact_array['custom_field2'] = $value[18];
					$contact_array['custom_field3'] = $value[19];
					$contact_array['custom_field4'] = $value[20];

					$formated_data[] = $contact_array;
				}
				if (!$is_valid) {
					throw new \Exception($error_msg);
				}

				if (!empty($formated_data)) {
					foreach ($formated_data as $contact_data) {
						$ref_count = $this->transactionUtil->setAndGetReferenceCount('contacts');
						//Set contact id if empty
						if (empty($contact_data['contact_id'])) {
							$contact_data['contact_id'] = $this->commonUtil->generateReferenceNumber('contacts', $ref_count);
						}

						$opening_balance = 0;
						if (isset($contact_data['opening_balance'])) {
							$opening_balance = $contact_data['opening_balance'];
							unset($contact_data['opening_balance']);
						}

						$contact_data['business_id'] = $business_id;
						$contact_data['created_by'] = $user_id;

						$contact = Contact::create($contact_data);

						if (!empty($opening_balance)) {
							$this->transactionUtil->createOpeningBalanceTransaction($business_id, $contact->id, $opening_balance);
						}
					}
				}

				$output = ['success' => 1,
					'msg' => __('product.file_imported_successfully'),
				];

				DB::commit();
			}
		} catch (\Exception $e) {
			DB::rollBack();
			\Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());

			$output = ['success' => 0,
				'msg' => $e->getMessage(),
			];
			return redirect()->route('contacts.import')->with('notification', $output);
		}

		return redirect()->action('ContactController@index', ['type' => 'supplier'])->with('status', $output);
	}
}
