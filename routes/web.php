<?php

Auth::routes();

Route::get('home', 'HomeController@index')->name('home')->middleware(['active', 'auth', 'SetSessionData', 'timezone']);

Route::get('/', function () {
	return view('welcome');
})->name('welcome');

Route::post('/business/register/check-username', 'BusinessController@postCheckUsername')->name('business.postCheckUsername');
Route::post('/business/register/check-email', 'BusinessController@postCheckEmail')->name('business.postCheckEmail');

Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'active', 'auth', 'SetSessionData', 'timezone'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
	Route::put('action/user', 'ManageUserController@action')->name('user.action');
	Route::resource('user', 'ManageUserController');

	Route::put('action/role', 'RoleController@action')->name('role.action');
	Route::resource('role', 'RoleController');

	Route::put('action/sales-commission-agents', 'SalesCommissionAgentController@action')->name('role.sales-commission-agents');
	Route::resource('sales-commission-agents', 'SalesCommissionAgentController');

	Route::prefix('business-location/{location_id}')->name('business-location.')->group(function () {
		Route::get('settings', 'LocationSettingsController@index')->name('settings');
		Route::post('settings', 'LocationSettingsController@updateSettings')->name('settings_update');
	});

	Route::put('action/business-location', 'BusinessLocationController@action')->name('role.sales-commission-agents');
	Route::post('business-location/check-location-id', 'BusinessLocationController@checkLocationId');
	Route::resource('business-location', 'BusinessLocationController');

	Route::put('action/invoice-schemes', 'InvoiceSchemeController@action')->name('role.sales-commission-agents');
	Route::delete('/invoice-schemes/set_default/{id}', 'InvoiceSchemeController@set_default')->name('invoice-schemes.set_default');
	Route::resource('invoice-schemes', 'InvoiceSchemeController');

	Route::resource('invoice-layouts', 'InvoiceLayoutController');

	Route::delete('/barcodes/set_default/{id}', 'BarcodeController@set_default')->name('barcodes.set_default');
	Route::put('action/barcodes', 'BarcodeController@action')->name('role.sales-commission-agents');
	Route::resource('barcodes', 'BarcodeController');

	Route::put('action/tax-rates', 'TaxRateController@action')->name('tax-rates.action');
	Route::resource('tax-rates', 'TaxRateController');

	Route::put('action/group-taxes', 'GroupTaxController@action')->name('group-taxes.action');
	Route::resource('group-taxes', 'GroupTaxController');

	Route::resource('notification-templates', 'NotificationTemplateController')->only(['index', 'store']);
	Route::get('notification/get-template/{transaction_id}/{template_for}', 'NotificationController@getTemplate');
	Route::post('notification/send', 'NotificationController@send');

	Route::get('/contacts/import', 'ContactController@getImportContacts')->name('contacts.import');
	Route::post('/contacts/import', 'ContactController@postImportContacts');
	Route::post('/contacts/check-contact-id', 'ContactController@checkContactId');
	Route::get('/contacts/customers', 'ContactController@getCustomers');
	Route::resource('contacts', 'ContactController');

	Route::put('action/customer-group', 'CustomerGroupController@action')->name('customer-group.action');
	Route::resource('customer-group', 'CustomerGroupController');

	Route::put('action/units', 'UnitController@action')->name('units.action');
	Route::resource('units', 'UnitController');

	Route::put('action/categories', 'CategoryController@action')->name('categories.action');
	Route::resource('categories', 'CategoryController');

	Route::put('action/brands', 'BrandController@action')->name('brands.action');
	Route::resource('brands', 'BrandController');

	Route::put('action/variation-templates', 'VariationTemplateController@action')->name('variation-templates.action');
	Route::resource('variation-templates', 'VariationTemplateController');

	Route::put('action/models', 'ModelController@action')->name('models.action');
	Route::resource('models', 'ModelController');

	Route::put('action/selling-price-group', 'SellingPriceGroupController@action')->name('selling-price-group.action');
	Route::resource('selling-price-group', 'SellingPriceGroupController');

	Route::post('/products/get_models', 'ProductController@getSubModels');
	Route::post('/products/get_sub_categories', 'ProductController@getSubCategories');
	Route::post('/products/product_form_part', 'ProductController@getProductVariationFormPart');
	Route::post('/products/get_product_variation_row', 'ProductController@getProductVariationRow');
	Route::post('/products/get_variation_template', 'ProductController@getVariationTemplate');
	Route::get('/products/get_variation_value_row', 'ProductController@getVariationValueRow');
	Route::post('/products/check_product_sku', 'ProductController@checkProductSku');
	Route::get('/products/quick_add', 'ProductController@quickAdd');
	Route::post('/products/save_quick_product', 'ProductController@saveQuickProduct');

	Route::get('/products/add-selling-prices/{id}', 'ProductController@addSellingPrices')->name('add-selling-prices.create');
	Route::post('/products/save-selling-prices', 'ProductController@saveSellingPrices')->name('add-selling-prices.store');

	Route::get('/products/view/{id}', 'ProductController@view')->name('products.view');
	Route::resource('products', 'ProductController');

	Route::get('/opening-stock/add/{product_id}', 'OpeningStockController@add')->name('opening-stock.create');
	Route::post('/opening-stock/save', 'OpeningStockController@save')->name('opening-stock.store');

	Route::get('/purchases/get_products', 'PurchaseController@getProducts');
	Route::get('/purchases/get_suppliers', 'PurchaseController@getSuppliers');
	Route::post('/purchases/get_purchase_entry_row', 'PurchaseController@getPurchaseEntryRow');
	Route::post('/purchases/check_ref_number', 'PurchaseController@checkRefNumber');
	Route::get('/purchases/print/{id}', 'PurchaseController@printInvoice');
	Route::resource('purchases', 'PurchaseController');

});

Route::group(['middleware' => ['auth', 'active', 'auth', 'SetSessionData', 'timezone'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

	Route::get('/business/settings', 'BusinessController@getBusinessSettings')->name('business.getBusinessSettings');
	Route::post('/business/update', 'BusinessController@postBusinessSettings')->name('business.postBusinessSettings');

});
