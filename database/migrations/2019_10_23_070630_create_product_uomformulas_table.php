<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductUomformulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_uomformulas', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('producttype_id')->unsigned();
			$table->foreign('producttype_id')->references('id')->on('producttypes')->onDelete('cascade');;
			$table->string('UOM');
			$table->integer('qnty_formula');
			$table->string('equality_UOM');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_uomformulas');
    }
}
