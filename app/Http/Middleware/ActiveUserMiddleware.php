<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class ActiveUserMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null) {
		if (Auth::user()->deleted_at) {
			Auth::guard($guard)->logout();
			Session::put('login_suspend', __('auth.suspend'));
			if (!$request->expectsJson()) {
				return redirect()->route('login');
			}

			if ($request->ajax()) {
				// $request->session()->invalidate();
				throw ValidationException::withMessages(['message' => __('auth.suspend')]);
			}
		}
		return $next($request);
	}
}
