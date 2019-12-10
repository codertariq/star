<?php

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');

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

});

Route::group(['middleware' => ['auth', 'active', 'auth', 'SetSessionData', 'timezone'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

	Route::get('/business/settings', 'BusinessController@getBusinessSettings')->name('business.getBusinessSettings');
	Route::post('/business/update', 'BusinessController@postBusinessSettings')->name('business.postBusinessSettings');

});
