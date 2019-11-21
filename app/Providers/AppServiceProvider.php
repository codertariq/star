<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {

		View::composer(
			['*'],
			function ($view) {
				$enabled_modules = !empty(session('business.enabled_modules')) ? session('business.enabled_modules') : [];

				$view->with('enabled_modules', $enabled_modules);
			}
		);
		//Blade directive to display help text.
		Blade::directive('show_tooltip', function ($message) {
			return " <?php
                    echo '<i class=\"icon-help ml-1 text-info hover-q no-print \"
                    data-popup=\"tooltip\" title=\"' . $message . '\" data-html=\"true\"></i>';

                ?>";
		});

		//Blade directive to format number into required format.
		Blade::directive('num_format', function ($expression) {
			return "number_format($expression, config('constants.currency_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator'])";
		});

		//Blade directive to format quantity values into required format.
		Blade::directive('format_quantity', function ($expression) {
			return "number_format($expression, config('constants.quantity_precision', 2), session('currency')['decimal_separator'], session('currency')['thousand_separator'])";
		});

		//Blade directive to return appropiate class according to transaction status
		Blade::directive('transaction_status', function ($status) {
			return "<?php if($status == 'ordered'){
                echo 'bg-aqua';
            }elseif($status == 'pending'){
                echo 'bg-red';
            }elseif ($status == 'received') {
                echo 'bg-light-green';
            }?>";
		});

		//Blade directive to return appropiate class according to transaction status
		Blade::directive('payment_status', function ($status) {
			return "<?php if($status == 'partial'){
                echo 'bg-aqua';
            }elseif($status == 'due'){
                echo 'bg-red';
            }elseif ($status == 'paid') {
                echo 'bg-light-green';
            }?>";
		});
//Blade directive to convert.
		Blade::directive('format_date', function ($date) {
			if (!empty($date)) {
				return "\Carbon::createFromTimestamp(strtotime($date))->format(session('business.date_format'))";
			} else {
				return null;
			}
		});

		Activity::saving(function (Activity $activity) {
			$activity->properties = $activity->properties->put('ip', getClientIp());
			$activity->properties = $activity->properties->put('user_agent', \Request::header('User-Agent'));
		});

	}
}
