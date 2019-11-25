<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Currency;
use App\Models\System;
use App\Models\TaxRate;
use App\Models\Unit;
use App\User;
use App\Utils\BusinessUtil;
use App\Utils\ModuleUtil;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BusinessController extends Controller {

	/*
		    |--------------------------------------------------------------------------
		    | BusinessController
		    |--------------------------------------------------------------------------
		    |
		    | This controller handles the registration of new business/business as well as their
		    | validation and creation.
		    |
	*/

	/**
	 * All Utils instance.
	 *
	 */
	protected $businessUtil;
	protected $restaurantUtil;
	protected $moduleUtil;
	protected $mailDrivers;

	/**
	 * Constructor
	 *
	 * @param ProductUtils $product
	 * @return void
	 */
	public function __construct(BusinessUtil $businessUtil, ModuleUtil $moduleUtil) {
		$this->businessUtil = $businessUtil;
		$this->moduleUtil = $moduleUtil;

		$this->avlble_modules = [

			'service_staff' => [
				'name' => __('technisian.service_staff'),
				'tooltip' => __('technisian.tooltip_service_staff'),
			],
			'account' => ['name' => __('service.account')],
		];

		$this->theme_colors = [
			'blue' => 'Blue',
			'black' => 'Black',
			'purple' => 'Purple',
			'green' => 'Green',
			'red' => 'Red',
			'yellow' => 'Yellow',
			'blue-light' => 'Blue Light',
			'black-light' => 'Black Light',
			'purple-light' => 'Purple Light',
			'green-light' => 'Green Light',
			'red-light' => 'Red Light',
		];

		$this->mailDrivers = [
			'smtp' => 'SMTP',
			'sendmail' => 'Sendmail',
			'mailgun' => 'Mailgun',
			'mandrill' => 'Mandrill',
			'ses' => 'SES',
			'sparkpost' => 'Sparkpost',
		];
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}

	public function postCheckUsername(Request $request) {
		$username = $request->input('username');
		$user_id = $request->input('user_id');

		if (!empty($request->input('username_ext'))) {
			$username .= $request->input('username_ext');
		}

		$query = User::where('username', $username);

		if (!empty($request->input('user_id'))) {
			$user_id = $request->input('user_id');
			$query->where('id', '!=', $user_id);
		}

		$exists = $query->count();

		if ($exists) {
			throw ValidationException::withMessages(['username' => __('validation.unique', ['attribute' => __('page.username')])]);
		}
		return response()->json(['message' => __('service.available', ['attribute' => __('business.username')])]);
	}
	/**
	 * Handles the validation email
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postCheckEmail(Request $request) {
		$email = $request->input('email');

		$query = User::where('email', $email);

		if (!empty($request->input('user_id'))) {
			$user_id = $request->input('user_id');
			$query->where('id', '!=', $user_id);
		}

		$exists = $query->count();
		if ($exists) {
			throw ValidationException::withMessages(['email' => __('validation.unique', ['attribute' => __('page.email')])]);
		}
		return response()->json(['message' => __('service.available', ['attribute' => __('business.email')])]);

	}

	/**
	 * Shows business settings form
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getBusinessSettings() {
		if (!auth()->user()->can('business_settings.access')) {
			abort(403, 'Unauthorized action.');
		}

		$timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
		$timezone_list = [];
		foreach ($timezones as $timezone) {
			$timezone_list[$timezone] = $timezone;
		}

		$business_id = request()->session()->get('user.business_id');
		$business = Business::where('id', $business_id)->first();

		$currencies = $this->businessUtil->allCurrencies();
		$tax_details = TaxRate::forBusinessDropdown($business_id);
		$tax_rates = $tax_details['tax_rates'];

		$months = [];
		for ($i = 1; $i <= 12; $i++) {
			$months[$i] = __('business.months.' . $i);
		}

		$accounting_methods = [
			'fifo' => __('business.fifo'),
			'lifo' => __('business.lifo'),
		];
		$commission_agent_dropdown = [
			'' => __('service.disable'),
			'logged_in_user' => __('service.logged_in_user'),
			'user' => __('service.select_from_users_list'),
			'cmsn_agnt' => __('service.select_from_commisssion_agents_list'),
		];

		$units_dropdown = Unit::forDropdown($business_id, true);

		$date_formats = Business::date_formats();

		$shortcuts = json_decode($business->keyboard_shortcuts, true);

		if (empty($business->pos_settings)) {
			$pos_settings = $this->businessUtil->defaultPosSettings();
		} else {
			$pos_settings = json_decode($business->pos_settings, true);
		}

		$email_settings = [];
		if (empty($business->email_settings)) {
			$email_settings = $this->businessUtil->defaultEmailSettings();
		} else {
			$email_settings = $business->email_settings;
		}

		$sms_settings = [];
		if (empty($business->sms_settings)) {
			$sms_settings = $this->businessUtil->defaultSmsSettings();
		} else {
			$sms_settings = $business->sms_settings;
		}

		$modules = $this->avlble_modules;

		$theme_colors = $this->theme_colors;

		$mail_drivers = $this->mailDrivers;

		$allow_superadmin_email_settings = System::getProperty('allow_email_settings_to_businesses');

		return view('admin.business.settings', compact('business', 'currencies', 'tax_rates', 'timezone_list', 'months', 'accounting_methods', 'commission_agent_dropdown', 'units_dropdown', 'date_formats', 'shortcuts', 'pos_settings', 'modules', 'theme_colors', 'email_settings', 'sms_settings', 'mail_drivers', 'allow_superadmin_email_settings'));
	}

	/**
	 * Updates business settings
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postBusinessSettings(Request $request) {
		if (!auth()->user()->can('business_settings.access')) {
			abort(403, 'Unauthorized action.');
		}

		$business_details = $request->only(['name', 'start_date', 'currency_id', 'tax_label_1', 'tax_number_1', 'tax_label_2', 'tax_number_2', 'default_profit_percent', 'default_sales_tax', 'default_sales_discount', 'sell_price_tax', 'sku_prefix', 'time_zone', 'fy_start_month', 'accounting_method', 'transaction_edit_days', 'sales_cmsn_agnt', 'item_addition_method', 'currency_symbol_placement', 'on_product_expiry',
			'stop_selling_before', 'default_unit', 'expiry_type', 'date_format', 'time_format', 'ref_no_prefixes', 'theme_color', 'email_settings', 'sms_settings']);

		if (!empty($business_details['start_date'])) {
			$business_details['start_date'] = Carbon::createFromFormat('m/d/Y', $business_details['start_date'])->toDateString();
		}

		if (!empty($request->input('enable_tooltip')) && $request->input('enable_tooltip') == 1) {
			$business_details['enable_tooltip'] = 1;
		} else {
			$business_details['enable_tooltip'] = 0;
		}

		$business_details['enable_product_expiry'] = !empty($request->input('enable_product_expiry')) && $request->input('enable_product_expiry') == 1 ? 1 : 0;
		if ($business_details['on_product_expiry'] == 'keep_selling') {
			$business_details['stop_selling_before'] = 0;
		}

		$business_details['stock_expiry_alert_days'] = !empty($request->input('stock_expiry_alert_days')) ? $request->input('stock_expiry_alert_days') : 30;

		//Check for Purchase currency
		if (!empty($request->input('purchase_in_diff_currency')) && $request->input('purchase_in_diff_currency') == 1) {
			$business_details['purchase_in_diff_currency'] = 1;
			$business_details['purchase_currency_id'] = $request->input('purchase_currency_id');
			$business_details['p_exchange_rate'] = $request->input('p_exchange_rate');
		} else {
			$business_details['purchase_in_diff_currency'] = 0;
			$business_details['purchase_currency_id'] = null;
			$business_details['p_exchange_rate'] = 1;
		}

		//upload logo
		$logo_name = $this->businessUtil->uploadFile($request, 'business_logo', 'business_logos');
		if (!empty($logo_name)) {
			$business_details['logo'] = $logo_name;
		}

		$checkboxes = ['enable_editing_product_from_purchase', 'enable_inline_tax',
			'enable_brand', 'enable_category', 'enable_model', 'enable_price_tax', 'enable_purchase_status', 'profit_on_fixed',
			'enable_lot_number', 'enable_racks', 'enable_row', 'enable_position'];
		foreach ($checkboxes as $value) {
			$business_details[$value] = !empty($request->input($value)) && $request->input($value) == 1 ? 1 : 0;
		}

		$business_id = request()->session()->get('user.business_id');

		$business = Business::where('id', $business_id)->first();

		//Update business settings
		if (!empty($business_details['logo'])) {
			$business->logo = $business_details['logo'];
		} else {
			unset($business_details['logo']);
		}

		//System settings
		$shortcuts = $request->input('shortcuts');
		$business_details['keyboard_shortcuts'] = json_encode($shortcuts);

		//pos_settings
		$pos_settings = $request->input('pos_settings');
		$default_pos_settings = $this->businessUtil->defaultPosSettings();
		foreach ($default_pos_settings as $key => $value) {
			if (!isset($pos_settings[$key])) {
				$pos_settings[$key] = $value;
			}
		}
		$business_details['pos_settings'] = json_encode($pos_settings);

		//Enabled modules
		$enabled_modules = $request->input('enabled_modules');
		$business_details['enabled_modules'] = !empty($enabled_modules) ? $enabled_modules : null;

		$business->update_business($business_id, $business_details);
		$business->save();

		//update session data
		$request->session()->put('business', $business);

		//Update Currency details
		$currency = Currency::find($business->currency_id);
		$request->session()->put('currency', [
			'id' => $currency->id,
			'code' => $currency->code,
			'symbol' => $currency->symbol,
			'thousand_separator' => $currency->thousand_separator,
			'decimal_separator' => $currency->decimal_separator,
		]);

		//update current financial year to session
		$financial_year = $this->businessUtil->getCurrentFinancialYear($business->id);
		$request->session()->put('financial_year', $financial_year);

		return response()->json(['message' => __('business.settings_updated_success'), 'goto' => route('admin.business.getBusinessSettings')]);
	}
}
