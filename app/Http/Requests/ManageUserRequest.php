<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManageUserRequest extends FormRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'prefix' => 'required|string|max:191',
			'first_name' => 'required|string|max:191',
			'email' => 'required|email|unique:users,email,' . $this->id,
			'username' => 'required|string|unique:users,username,' . $this->id,
			'password' => 'required|string|min:6|',
			'confirm_password' => 'required|string|min:6|same:password',
		];
	}
}
