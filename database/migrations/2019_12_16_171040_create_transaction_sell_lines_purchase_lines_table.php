<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionSellLinesPurchaseLinesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('transaction_sell_lines_purchase_lines', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('sell_line_id')->comment("id from transaction_sell_lines")->nullable();
			$table->unsignedBigInteger('stock_adjustment_line_id')->comment("id from stock_adjustment_lines")->nullable();
			$table->unsignedBigInteger('purchase_line_id')->comment("id from purchase_lines");
			$table->decimal('quantity', 20, 4);
			$table->decimal('qty_returned', 20, 4)->default(0);
			$table->timestamps();

			$table->index('sell_line_id', 'sell_line_id');
			$table->index('stock_adjustment_line_id', 'stock_adjustment_line_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('transaction_sell_lines_purchase_lines');
	}
}
