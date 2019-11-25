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

	Route::post('business-location/check-location-id', 'BusinessLocationController@checkLocationId');
	Route::resource('business-location', 'BusinessLocationController');

});

Route::group(['middleware' => ['auth', 'active', 'auth', 'SetSessionData', 'timezone'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

	Route::get('/business/settings', 'BusinessController@getBusinessSettings')->name('business.getBusinessSettings');
	Route::post('/business/update', 'BusinessController@postBusinessSettings')->name('business.postBusinessSettings');

});
