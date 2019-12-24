<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseLinesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('purchase_lines', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('transaction_id');
			$table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
			$table->unsignedBigInteger('product_id');
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->unsignedBigInteger('variation_id');
			$table->foreign('variation_id')->references('id')->on('variations')->onDelete('cascade');
			$table->integer('quantity');
			$table->decimal('purchase_price', 20, 2);
			$table->decimal('purchase_price_inc_tax', 20, 2)->default(0);
			$table->decimal('item_tax', 20, 2)->comment("Tax for one quantity");
			$table->unsignedBigInteger('tax_id')->nullable();
			$table->foreign('tax_id')->references('id')->on('tax_rates')->onDelete('cascade');
			$table->date('mfg_date')->nullable();
			$table->date('exp_date')->nullable();

			$table->decimal('quantity_sold', 20, 2)->default(0)->comment("Quanity sold from this purchase line");
			$table->decimal('quantity_adjusted', 20, 2)->default(0)->comment("Quanity adjusted in stock adjustment from this purchase line");
			$table->decimal('quantity_returned', 20, 4)->default(0);

			$table->decimal('pp_without_discount', 20, 2)->default(0)->comment('Purchase price before inline discounts');
			$table->decimal('discount_percent', 5, 2)->default(0)->comment('Inline discount percentage');
			$table->string('lot_number', 256)->nullable();
			$table->integer('sub_unit_id')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('purchase_lines');
	}
}
