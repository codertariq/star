<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Business extends Model
{
    use LogsActivity;
	protected $primaryKey = 'id';
	protected $table = 'businesses';
	protected static $logName = 'businesses';
	protected static $logFillable = true;
	protected static $logOnlyDirty = true;
	protected static $ignoreChangedAttributes = ['updated_at'];
}
