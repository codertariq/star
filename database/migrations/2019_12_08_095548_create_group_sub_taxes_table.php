<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupSubTaxesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('group_sub_taxes', function (Blueprint $table) {
			$table->unsignedBigInteger('group_tax_id');
			$table->foreign('group_tax_id')->references('id')->on('tax_rates')->onDelete('cascade');
			$table->unsignedBigInteger('tax_id');
			$table->foreign('tax_id')->references('id')->on('tax_rates')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('group_sub_taxes');
	}
}
