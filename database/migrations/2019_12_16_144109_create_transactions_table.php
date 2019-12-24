<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('transactions', function (Blueprint $table) {
			$table->bigIncrements('id');

			$table->unsignedBigInteger('business_id');
			$table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
			$table->unsignedBigInteger('location_id');
			$table->foreign('location_id')->references('id')->on('business_locations');

			$table->enum('type', ['purchase', 'sell', 'expense', 'stock_adjustment', 'sell_transfer', 'purchase_transfer', 'opening_stock', 'sell_return', 'opening_balance', 'purchase_return']);
			$table->text('order_addresses')->nullable();
			$table->string('sub_type', 20)->nullable();
			$table->enum('status', ['received', 'pending', 'ordered', 'draft', 'final']);
			$table->enum('payment_status', ['paid', 'due', 'partial']);
			$table->enum('adjustment_type', ['normal', 'abnormal'])->nullable();
			$table->decimal('total_amount_recovered', 20, 2)->comment("Used for stock adjustment.")->nullable();
			$table->integer('transfer_parent_id')->nullable();
			$table->integer('opening_stock_product_id')->nullable();
			$table->unsignedBigInteger('contact_id')->nullable();
			$table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
			$table->integer('customer_group_id')->nullable()->comment('used to add customer group while selling');
			$table->string('invoice_no')->nullable();
			$table->string('ref_no')->nullable();
			$table->dateTime('transaction_date');
			$table->decimal('total_before_tax', 20, 2)->default(0)->comment('Total before the purchase/invoice tax, this includeds the indivisual product tax');
			$table->unsignedBigInteger('tax_id')->nullable();
			$table->foreign('tax_id')->references('id')->on('tax_rates')->onDelete('cascade');
			$table->decimal('tax_amount', 20, 2)->default(0);
			$table->enum('discount_type', ['fixed', 'percentage'])->nullable();
			$table->string('discount_amount', 10)->nullable();
			$table->string('shipping_details')->nullable();
			$table->decimal('shipping_charges', 20, 2)->default(0);
			$table->text('additional_notes')->nullable();
			$table->text('staff_note')->nullable();
			$table->decimal('final_total', 20, 2)->default(0);
			$table->unsignedBigInteger('expense_category_id')->nullable();
			$table->foreign('expense_category_id')->references('id')->on('expense_categories')->onDelete('cascade');
			$table->unsignedBigInteger('expense_for')->nullable();
			$table->foreign('expense_for')->references('id')->on('users')->onDelete('cascade');
			$table->integer('commission_agent')->nullable();
			$table->string('document')->nullable();
			$table->decimal('exchange_rate', 20, 3)->default(1);

			$table->boolean('is_quotation')->default(0);
			$table->boolean('is_direct_sale')->default(0);
			$table->boolean('is_suspend')->default(0);

			$table->boolean('is_recurring')->default(0);
			$table->float('recur_interval', 8, 2)->nullable();

			$table->string('subscription_no')->nullable();

			$table->integer('pay_term_number')->nullable();
			$table->enum('pay_term_type', ['days', 'months'])->nullable();

			$table->unsignedBigInteger('res_table_id')->nullable()->comment('fields to restaurant module');
			$table->unsignedBigInteger('res_waiter_id')->nullable()->comment('fields to restaurant module');
			$table->enum('res_order_status', ['received', 'cooked', 'served'])->nullable();

			$table->unsignedBigInteger('created_by');
			$table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
			$table->unsignedBigInteger('selling_price_group_id')->nullable();
			$table->timestamps();

			//Indexing
			$table->index('business_id');
			$table->index('type');
			$table->index('contact_id');
			$table->index('transaction_date');
			$table->index('created_by');
			$table->index('expense_category_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('transactions');
	}
}
