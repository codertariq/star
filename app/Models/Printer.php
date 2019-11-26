<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Printer extends Model {
	/**
	 * Return list of printers for a business
	 *
	 * @param int $business_id
	 * @param boolean $show_select = true
	 *
	 * @return array
	 */
	public static function forDropdown($business_id, $show_select = true) {
		$query = Printer::where('business_id', $business_id);

		$printers = $query->pluck('name', 'id');
		if ($show_select) {
			$printers->prepend(__('messages.please_select'), '');
		}
		return $printers;
	}
}
