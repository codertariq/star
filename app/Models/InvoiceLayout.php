<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceLayout extends Model {

	protected $casts = [
		'product_custom_fields' => 'array',
		'contact_custom_fields' => 'array',
		'location_custom_fields' => 'array',
	];
	/**
	 * Get the location associated with the invoice layout.
	 */
	public function locations() {
		return $this->hasMany(BusinessLocation::class);
	}
}
