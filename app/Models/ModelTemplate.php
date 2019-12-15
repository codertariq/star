<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTemplate extends Model {
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $table = 'models';
	protected $guarded = ['id'];

	public function category() {
		return $this->belongsTo(Category::class);
	}

	public function brand() {
		return $this->belongsTo(Brand::class);
	}

}
