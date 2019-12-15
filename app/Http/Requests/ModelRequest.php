<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModelRequest extends FormRequest {
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
			'name.*' => 'required|string|max:191',
			'category_id' => 'required|integer',
			'brand_id' => 'required|integer',
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
