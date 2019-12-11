<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToContactsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('contacts', function (Blueprint $table) {
			$table->string('contact_id')->nullable()->after('name');

			$table->string('email')->nullable()->after('contact_id');
			$table->decimal('credit_limit', 20, 2)->nullable()->after('pay_term_type');
			$table->integer('customer_group_id')->nullable()->after('is_default');
			$table->string('custom_field1')->nullable()->after('customer_group_id');
			$table->string('custom_field2')->nullable()->after('custom_field1');
			$table->string('custom_field3')->nullable()->after('custom_field2');
			$table->string('custom_field4')->nullable()->after('custom_field3');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('contacts', function (Blueprint $table) {
			//
		});
	}
}
