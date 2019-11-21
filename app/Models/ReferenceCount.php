<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferenceCount extends Model {
	protected $fillable = [
		'ref_type',
		'business_id',
		'ref_count',
	];
}
