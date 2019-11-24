<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model {
	/**
	 * Return list of tax rate dropdown for a business
	 *
	 * @param $business_id int
	 * @param $prepend_none = true (boolean)
	 * @param $include_attributes = false (boolean)
	 *
	 * @return array['tax_rates', 'attributes']
	 */
	public static function forBusinessDropdown(
		$business_id,
		$prepend_none = true,
		$include_attributes = false
	) {
		$all_taxes = TaxRate::where('business_id', $business_id);
		$result = $all_taxes->get();
		$tax_rates = $result->pluck('name', 'id');

		//Prepend none
		if ($prepend_none) {
			$tax_rates = $tax_rates->prepend(__('service.none'), '');
		}

		//Add tax attributes
		$tax_attributes = null;
		if ($include_attributes) {
			$tax_attributes = collect($result)->mapWithKeys(function ($item) {
				return [$item->id => ['data-rate' => $item->amount]];
			})->all();
		}

		$output = ['tax_rates' => $tax_rates, 'attributes' => $tax_attributes];
		return $output;
	}
}
