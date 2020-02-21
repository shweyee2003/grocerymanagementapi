<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('empe_name');
			$table->string('nrcno')->nullable();
			$table->date('date_of_birth')->nullable();
			$table->string('phone')->nullable();
            $table->string('address')->nullable();
			$table->decimal('basic_salary',9,3);
			$table->string('empe_image',255)->default('image.png')->nullable();
			$table->date('effective_date')->nullable();
			$table->string('remark')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
