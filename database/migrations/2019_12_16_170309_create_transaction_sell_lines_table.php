<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionSellLinesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('transaction_sell_lines', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('transaction_id');
			$table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
			$table->unsignedBigInteger('product_id');
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->unsignedBigInteger('variation_id');
			$table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');
			$table->integer('quantity');
			$table->decimal('unit_price', 20, 2)->comment("Sell price excluding tax")->nullable();
			$table->decimal('unit_price_inc_tax', 20, 2)->comment("Sell price including tax")->nullable();
			$table->decimal('item_tax', 20, 2)->comment("Tax for one quantity");
			$table->unsignedBigInteger('tax_id')->nullable();
			$table->foreign('tax_id')->references('id')->on('tax_rates')->onDelete('cascade');
			$table->text('sell_line_note', 300)->nullable();
			$table->unsignedBigInteger('parent_sell_line_id')->nullable();
			$table->integer('lot_no_line_id')->nullable();
			$table->enum('line_discount_type', ['fixed', 'percentage'])->nullable();
			$table->decimal('line_discount_amount', 20, 2)->default(0);
			$table->decimal('unit_price_before_discount', 20, 2)->default(0);
			$table->decimal('quantity_returned', 20, 4)->default(0);
			$table->decimal('qty_returned', 20, 4)->default(0);
			$table->integer('sub_unit_id')->nullable();
			$table->integer('discount_id')->nullable();
			$table->integer('res_service_staff_id')->nullable();
			$table->string('res_line_order_status')->nullable();
			$table->string('serial_no')->nullable();
			$table->boolean('is_lifetime')->default(false);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('transaction_sell_lines');
	}
}
