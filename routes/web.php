<?php

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');

Route::get('/', function () {
	return view('welcome');
})->name('welcome');

Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'active'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
	Route::put('action/user', 'ManageUserController@action')->name('user.action');
	Route::resource('user', 'ManageUserController');

	Route::put('action/role', 'RoleController@action')->name('role.action');
	Route::resource('role', 'RoleController');
});
