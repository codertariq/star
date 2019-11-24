<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {
	use Notifiable;
	use HasRoles;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'username', 'status', 'mobile_no', 'image', 'bio',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	/**
	 * Get the user's full name.
	 *
	 * @return string
	 */
	public function getFullNameAttribute() {
		return "{$this->prefix} {$this->first_name} {$this->last_name}";
	}

	/**
	 * Get the business that owns the user.
	 */
	public function business() {
		return $this->belongsTo(\App\Models\Business::class);
	}

	public function getRoleNameAttribute() {
		return explode('#', $this->getRoleNames()[0])[0];
	}

	public function contactAccess() {
		return $this->belongsToMany(\App\Models\Contact::class, 'user_contact_accesses');
	}

}
