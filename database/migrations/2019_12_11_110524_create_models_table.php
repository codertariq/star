<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('models', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');

			$table->unsignedBigInteger('category_id');
			$table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

			$table->unsignedBigInteger('brand_id');
			$table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');

			$table->unsignedBigInteger('business_id');
			$table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('model_templates');
	}
}
