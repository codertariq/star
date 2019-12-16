<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('products', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
			$table->unsignedBigInteger('business_id');
			$table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
			$table->enum('type', ['single', 'variable']);
			$table->unsignedBigInteger('unit_id');
			$table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
			$table->unsignedBigInteger('brand_id')->nullable();
			$table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
			$table->unsignedBigInteger('category_id')->nullable();
			$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
			$table->unsignedBigInteger('sub_category_id')->nullable();
			$table->foreign('sub_category_id')->references('id')->on('categories')->onDelete('cascade');
			$table->unsignedBigInteger('model_id')->nullable();
			$table->foreign('model_id')->references('id')->on('models')->onDelete('cascade');
			$table->unsignedBigInteger('tax')->nullable();
			$table->foreign('tax')->references('id')->on('tax_rates');
			$table->enum('tax_type', ['inclusive', 'exclusive']);
			$table->boolean('enable_stock')->default(0);
			$table->integer('alert_quantity')->default(0);
			$table->string('sku');
			$table->enum('barcode_type', ['C39', 'C128', 'EAN-13', 'EAN-8', 'UPC-A', 'UPC-E', 'ITF-14']);

			$table->string('weight')->nullable();
			$table->unsignedBigInteger('created_by');
			$table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
			$table->boolean('is_inactive')->default(0);
			$table->string('image')->nullable();
			$table->text('product_description')->nullable();
			$table->boolean('enable_sr_no')->default(0);
			$table->decimal('expiry_period', 4, 2)->nullable();
			$table->enum('expiry_period_type', ['days', 'months'])->nullable();
			$table->boolean('is_lifetime')->default(false);
			$table->string('warenty_period')->nullable();
			$table->string('warenty_period_type')->nullable();
			$table->string('product_custom_field1')->nullable();
			$table->string('product_custom_field2')->nullable();
			$table->string('product_custom_field3')->nullable();
			$table->string('product_custom_field4')->nullable();
			$table->timestamps();

			//Indexing
			$table->index('name');
			$table->index('business_id');
			$table->index('unit_id');
			$table->index('created_by');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('products');
	}
}
