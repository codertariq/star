<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('contacts', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('business_id');
			$table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
			$table->enum('type', ['supplier', 'customer', 'both']);
			$table->string('supplier_business_name')->nullable();
			$table->string('name');
			$table->string('tax_number')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('country')->nullable();
			$table->string('landmark')->nullable();
			$table->string('mobile')->nullable();;
			$table->string('landline')->nullable();
			$table->string('alternate_number')->nullable();
			$table->integer('pay_term_number')->nullable();
			$table->enum('pay_term_type', ['days', 'months'])->nullable();
			$table->boolean('is_default')->default(0);
			$table->unsignedBigInteger('created_by');
			$table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('contacts');
	}
}
