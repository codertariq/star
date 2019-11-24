<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('units', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->unsignedBigInteger('business_id');
			$table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
			$table->string('actual_name');
			$table->string('short_name');
			$table->boolean('allow_decimal');
			$table->bigInteger('base_unit_id')->nullable();
			$table->decimal('base_unit_multiplier', 20, 4)->nullable();
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
		Schema::dropIfExists('units');
	}
}
