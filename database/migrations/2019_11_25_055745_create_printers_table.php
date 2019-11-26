<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrintersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('printers', function (Blueprint $table) {
			$table->bigIncrements('id');

			$table->unsignedBigInteger('business_id');
			$table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');

			$table->string('name', 256);
			$table->enum('connection_type', ['network', 'windows', 'linux']);
			$table->enum('capability_profile', ['default', 'simple', 'SP2000', 'TEP-200M', 'P822D'])->default('default');
			$table->string('char_per_line')->nullable();
			$table->string('ip_address')->nullable();
			$table->string('port')->nullable();
			$table->string('path')->nullable();

			$table->unsignedBigInteger('created_by');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('printers');
	}
}
