<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultTaxToBusinessesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('businesses', function (Blueprint $table) {
			$table->unsignedBigInteger('default_sales_tax')->nullable()->after('tax_label_2');
			$table->foreign('default_sales_tax')->references('id')->on('tax_rates');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('businesses', function (Blueprint $table) {
			//
		});
	}
}
