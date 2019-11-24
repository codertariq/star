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

		$rules = [
			'prefix' => 'required|string|max:191',
			'first_name' => 'required|string|max:191',
			'email' => 'required|email|unique:users,email,' . $this->user,
			'username' => 'required|string|unique:users,username,' . $this->user,
			'cmmsn_percent' => 'sometimes|nullable|numeric|max:99.99',
		];

		if (!$this->user) {
			$rule['password'] = 'required|string|min:6';
			$rule['confirm_password'] = 'required|string|min:6|same:password';
		}

		return $rules;
	}
}
