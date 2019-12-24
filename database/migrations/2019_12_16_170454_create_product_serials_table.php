<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSerialsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('product_serials', function (Blueprint $table) {
			$table->bigIncrements('id');

			$table->unsignedBigInteger('product_id');
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

			$table->unsignedBigInteger('variation_id');
			$table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');

			$table->unsignedBigInteger('sell_line_id')->comment("id from transaction_sell_lines")->nullable();
			// $table->foreign('sell_line_id')->references('id')->on('transaction_sell_lines')->onDelete('SET NULL');

			$table->unsignedBigInteger('purchase_line_id')->comment("id from purchase_lines");

			$table->string('serial_no')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('product_serials');
	}
}
