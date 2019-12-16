<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationGroupPricesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('variation_group_prices', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('variation_id');
			$table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');
			$table->unsignedBigInteger('price_group_id');
			$table->foreign('price_group_id')->references('id')->on('selling_price_groups')->onDelete('cascade');
			$table->decimal('price_inc_tax', 20, 2);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('variation_group_prices');
	}
}
