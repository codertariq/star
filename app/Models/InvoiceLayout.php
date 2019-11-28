<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceLayout extends Model {
	/**
	 * Get the location associated with the invoice layout.
	 */
	public function locations() {
		return $this->hasMany(BusinessLocation::class);
	}
}
