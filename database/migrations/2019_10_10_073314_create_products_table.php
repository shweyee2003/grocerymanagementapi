<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('prodtype_id')->unsigned()->nullable();
			$table->foreign('prodtype_id')->references('id')->on('producttypes')->onDelete('cascade');
			$table->string('product_code');
			$table->string('product_name');
			$table->string('from_product');
			$table->string('remark');
			$table->integer('min_qnty');
			$table->binary('prod_image');
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
        Schema::dropIfExists('products');
		$table->dropForeign('category_id'); //
		$table->dropForeign('prodtype_id'); //
		$table->dropForeign('warehouse_id'); //
    }
}
