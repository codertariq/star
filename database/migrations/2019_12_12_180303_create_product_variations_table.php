<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->bigIncrements('id');
          $table->string('name');
          $table->unsignedBigInteger('product_id');
          $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

          $table->unsignedBigInteger('variation_template_id')->nullable();
          $table->foreign('variation_template_id')->references('id')->on('variation_templates')->onDelete('cascade');


          $table->boolean('is_dummy')->default(1);
          $table->timestamps();

          //Indexing
          $table->index('name');
          $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variations');
    }
}
