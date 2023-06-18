<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('employees')) {
            Schema::create('employees', function (Blueprint $table) {
                $table->id();
                $table->string('last_name');
                $table->string('first_name');
                $table->unsignedBigInteger('personal_code');
                $table->string('title')->default(__('muncitor necalificat'));
                $table->date('employment_date');
                $table->date('unemployment_date')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            Schema::table('employees', function (Blueprint $table) {
                $table->string('ssm_document')->nullable();
                $table->date('date_ssm_begin')->nullable();
                $table->date('date_ssm_end')->nullable();
                $table->string('health_document')->nullable();
                $table->date('date_health_begin')->nullable();
                $table->date('date_health_end')->nullable();
            });
        }
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
