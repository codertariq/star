<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationLocationDetailsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('variation_location_details', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('product_id');
			$table->integer('product_variation_id')->unsigned()->comment('id from product_variations table');

			$table->unsignedBigInteger('variation_id');
			$table->foreign('variation_id')->references('id')->on('variations');

			$table->unsignedBigInteger('location_id');
			$table->foreign('location_id')->references('id')->on('business_locations');

			$table->decimal('qty_available', 8, 2)->nullable();

			$table->timestamps();

			//Indexing
			$table->index('product_id');
			$table->index('product_variation_id');
			$table->index('variation_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('variation_location_details');
	}
}
