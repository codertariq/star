<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationTemplatesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('variation_templates', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('name');
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
		Schema::dropIfExists('variation_templates');
	}
}
