<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockAdjustmentLinesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('stock_adjustment_lines', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('transaction_id');
			$table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
			$table->unsignedBigInteger('product_id');
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->unsignedBigInteger('variation_id');
			$table->foreign('variation_id')->references('id')->on('variations')
				->onDelete('cascade');
			$table->decimal('quantity', 20, 4);
			$table->decimal('unit_price', 20, 4)->comment("Last purchase unit price")->nullable();
			$table->integer('removed_purchase_line')->nullable();
			$table->integer('lot_no_line_id')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('stock_adjustment_lines');
	}
}
