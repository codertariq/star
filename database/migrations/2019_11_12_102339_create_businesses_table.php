<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('businesses', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name', 256);

			$table->unsignedBigInteger('currency_id');
			$table->foreign('currency_id')->references('id')->on('currencies');

			$table->date('start_date')->nullable();
			$table->string('tax_number_1', 100)->nullable();
			$table->string('tax_label_1', 10)->nullable();
			$table->string('tax_number_2', 100)->nullable();
			$table->string('tax_label_2', 10)->nullable();

			$table->float('default_profit_percent', 5, 2)->default(0);
			$table->boolean('profit_on_fixed')->default(false);

			$table->unsignedBigInteger('owner_id');
			$table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');

			$table->string('time_zone')->default('Asia/Dhaka');
			$table->tinyInteger('fy_start_month')->default(1);
			$table->enum('accounting_method', ['fifo', 'lifo', 'avco'])->default('fifo');
			$table->decimal('default_sales_discount', 20, 2)->nullable();
			$table->enum('sell_price_tax', ['includes', 'excludes'])->default('includes');
			$table->string('logo')->nullable();
			$table->string('sku_prefix')->nullable();
			$table->boolean('enable_product_expiry')->default(0);
			$table->enum('expiry_type', ['add_expiry', 'add_manufacturing'])->default('add_expiry');
			$table->enum('on_product_expiry', ['keep_selling', 'stop_selling', 'auto_delete'])->default('keep_selling');
			$table->integer('stop_selling_before')->default(0)->comment('Stop selling expied item n days before expiry');
			$table->boolean('enable_tooltip')->default(1);
			$table->boolean('purchase_in_diff_currency')->default(0)->comment("Allow purchase to be in different currency then the business currency");
			$table->unsignedBigInteger('purchase_currency_id')->nullable()->references('id')->on('currencies');
			$table->decimal('p_exchange_rate', 5, 3)->default(1)->comment("1 Purchase currency = ? Base Currency");
			$table->integer('transaction_edit_days')->unsigned()->default(30);
			$table->integer('stock_expiry_alert_days')->unsigned()->default(30);
			$table->text('keyboard_shortcuts')->nullable();
			$table->text('pos_settings')->nullable();
			$table->boolean('enable_group')->default(true);
			$table->boolean('enable_brand')->default(true);
			$table->boolean('enable_category')->default(true);
			$table->boolean('enable_sub_category')->default(true);
			$table->boolean('enable_model')->default(true);
			$table->boolean('enable_lot_number')->default(false);
			$table->boolean('enable_price_tax')->default(true);
			$table->boolean('enable_purchase_status')->nullable()->default(true);
			$table->integer('default_unit')->nullable();
			$table->boolean('enable_row')->default(false);
			$table->boolean('enable_position')->default(false);
			$table->boolean('enable_racks')->default(false);
			$table->text('enabled_modules')->nullable();
			$table->string('date_format')->default('m/d/Y');
			$table->enum('time_format', [12, 24])->default(24);
			$table->text('ref_no_prefixes')->nullable();
			$table->integer('created_by')->nullable();
			$table->boolean('is_active')->default(true);
			$table->char('theme_color', 20)->nullable();
			$table->text('email_settings')->nullable();
			$table->text('sms_settings')->nullable();
			$table->boolean('enable_editing_product_from_purchase')->default(1);
			$table->enum('sales_cmsn_agnt', ['logged_in_user', 'user', 'cmsn_agnt'])->nullable();
			$table->boolean('item_addition_method')->default(1);
			$table->boolean('enable_inline_tax')->default(1);
			$table->enum('currency_symbol_placement', ['before', 'after'])->default('before');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('businesses');
	}
}
