<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessLocationRequest extends FormRequest {
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
			'name' => 'required|string|max:191',
			'location_id' => 'sometimes|nullable|string|max:191|unique:business_locations,id,' . $this->business_location,
			'city' => 'required|string|max:191',
			'state' => 'required|string|max:191',
			'country' => 'required|string|max:191',
			'zip_code' => 'required|string|max:191',
			'invoice_scheme_id' => 'required|integer',
			'invoice_layout_id' => 'required|integer',
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
