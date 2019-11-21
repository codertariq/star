<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contact extends Model {
	/**
	 * Return list of contact dropdown for a business
	 *
	 * @param $business_id int
	 * @param $exclude_default = false (boolean)
	 * @param $prepend_none = true (boolean)
	 *
	 * @return array users
	 */
	public static function contactDropdown($business_id, $exclude_default = false, $prepend_none = true, $append_id = true) {
		$query = Contact::where('business_id', $business_id);
		if ($exclude_default) {
			$query->where('is_default', 0);
		}

		if ($append_id) {
			$query->select(
				DB::raw("IF(contact_id IS NULL OR contact_id='', name, CONCAT(name, ' - ', COALESCE(supplier_business_name, ''), '(', contact_id, ')')) AS supplier"),
				'id'
			);
		} else {
			$query->select(
				'id',
				DB::raw("IF (supplier_business_name IS not null, CONCAT(name, ' (', supplier_business_name, ')'), name) as supplier")
			);
		}

		$contacts = $query->pluck('supplier', 'id');

		//Prepend none
		if ($prepend_none) {
			$contacts = $contacts->prepend(__('lang_v1.none'), '');
		}

		return $contacts;
	}
}
