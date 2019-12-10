<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarcodeRequest extends FormRequest {
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
			'description' => 'required|string',
			'top_margin' => 'required|numeric',
			'left_margin' => 'required|numeric',
			'width' => 'required|numeric',
			'height' => 'required|numeric',
			'paper_width' => 'required|numeric',
			'stickers_in_one_row' => 'required|numeric',
			'row_distance' => 'required|numeric',
			'col_distance' => 'required|numeric',
		];

		return $rules;
	}
}
