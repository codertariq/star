<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessLocation extends Model {
	use LogsActivity;

	protected $primaryKey = 'id';
	protected $table = 'business_locations';
	protected static $logName = 'business_locations';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];
}
