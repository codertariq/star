<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTemplatesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('notification_templates', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('business_id');
			$table->string('template_for');
			$table->text('email_body')->nullable();
			$table->text('sms_body')->nullable();
			$table->string('subject')->nullable();
			$table->boolean('auto_send')->default(0);
			$table->boolean('auto_send_sms')->default(0);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('notification_templates');
	}
}
