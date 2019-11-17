<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('prefix');
			$table->string('first_name');
			$table->string('last_name')->nullable();
			$table->string('username')->unique();
			$table->string('email')->nullable();
			$table->string('password');
			$table->char('language', 4)->default('en');
			$table->timestamp('email_verified_at')->nullable();
			$table->char('contact_no', 15)->nullable();
			$table->text('address')->nullable();
			$table->boolean('is_cmmsn_agnt')->default(false);
			$table->decimal('cmmsn_percent', 4, 2)->default(0);
			$table->date('dob')->nullable();
			$table->boolean('selected_contacts')->default(false);
			$table->enum('marital_status', ['married', 'unmarried', 'divorced'])->nullable();
			$table->char('blood_group', 10)->nullable();
			$table->char('contact_number', 20)->nullable();
			$table->string('fb_link')->nullable();
			$table->string('twitter_link')->nullable();
			$table->string('social_media_1')->nullable();
			$table->string('social_media_2')->nullable();
			$table->text('permanent_address')->nullable();
			$table->text('current_address')->nullable();
			$table->string('guardian_name')->nullable();
			$table->string('custom_field_1')->nullable();
			$table->string('custom_field_2')->nullable();
			$table->string('custom_field_3')->nullable();
			$table->string('custom_field_4')->nullable();
			$table->longText('bank_details')->nullable();
			$table->string('id_proof_name')->nullable();
			$table->string('id_proof_number')->nullable();

			$table->enum('status', ['active', 'inactive', 'terminated'])->default('active');
			$table->rememberToken();
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
		Schema::dropIfExists('users');
	}
}
