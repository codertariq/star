<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest {
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
			'actual_name' => 'required|string|max:191',
			'short_name' => 'required|string|max:191',
			'allow_decimal' => 'required|numeric',
		];

		return $rules;
	}

	public function attribute() {

		$rules = [
//
		];

		return $rules;
	}
}
