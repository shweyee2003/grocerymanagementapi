<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurorderdtlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purorderdtls', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('purhdr_id')->unsigned();
			$table->foreign('purhdr_id')->references('id')->on('purorders')->onDelete('cascade');
			$table->integer('product_id')->unsigned();
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
			$table->integer('supr_id')->unsigned();
			$table->foreign('supr_id')->references('id')->on('suppliers')->onDelete('cascade');
			$table->decimal('prod_qnty',8,5);
			$table->decimal('prod_price',8,5);
			$table->decimal('prod_amt',8,5);
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
        Schema::dropIfExists('purorderdtls');
    }
}
