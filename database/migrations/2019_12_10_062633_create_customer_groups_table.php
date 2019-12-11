<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerGroupsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('customer_groups', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('business_id');
			$table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
			$table->string('name');
			$table->float('amount', 5, 2);
			$table->integer('created_by')->unsigned();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('customer_groups');
	}
}
