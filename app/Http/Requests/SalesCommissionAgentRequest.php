<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesCommissionAgentRequest extends FormRequest {
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
			'first_name' => 'required|string|max:191',
			'cmmsn_percent' => 'required|numeric|max:99.99',
		];

		return $rules;
	}

	public function attribute() {

		$rules = [
			'first_name' => __('business.first_name'),
			'cmmsn_percent' => __('service.cmmsn_percent'),
		];

		return $rules;
	}
}
