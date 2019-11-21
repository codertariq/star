<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BusinessController extends Controller {
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

		if (!empty($request->input('username_ext'))) {
			$username .= $request->input('username_ext');
		}

		$count = User::where('username', $username)->count();
		if ($count) {
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
}
