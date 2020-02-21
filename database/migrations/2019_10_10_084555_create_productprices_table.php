<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductpricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productprices', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('product_id')->unsigned()->nullable();
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->decimal('pur_price',8,2);
			$table->decimal('sell_price',8,2);
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
        Schema::dropIfExists('productprices');
		$table->dropForeign('product_id');
		
    }
}
