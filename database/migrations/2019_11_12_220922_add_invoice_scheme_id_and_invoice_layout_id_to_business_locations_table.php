<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoiceSchemeIdAndInvoiceLayoutIdToBusinessLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_locations', function (Blueprint $table) {
            $table->unsignedBigInteger('invoice_scheme_id')->after('zip_code');
            $table->foreign('invoice_scheme_id')->references('id')->on('invoice_schemes')->onDelete('cascade');
             $table->unsignedBigInteger('invoice_layout_id')->after('invoice_scheme_id');
            $table->foreign('invoice_layout_id')->references('id')->on('invoice_layouts')->onDelete('cascade');
            $table->boolean('print_receipt_on_invoice')->nullable()->default(1)->after('invoice_layout_id');

            $table->enum('receipt_printer_type', ['browser', 'printer'])->default('browser')->after('print_receipt_on_invoice');

            $table->integer('printer_id')->nullable()->after('receipt_printer_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_locations', function (Blueprint $table) {
            //
        });
    }
}
