<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductqntiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productqnties', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('product_id')->unsigned();
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->date('pur_date')->nullable();
			$table->integer('warehouse_id')->unsigned()->nullable();
			$table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
			$table->decimal('prod_qnty',8,2);
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
        Schema::dropIfExists('productqnties');
    }
}
