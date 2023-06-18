<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutomobilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('automobiles')) {
            Schema::create('automobiles', function (Blueprint $table) {
                $table->id();
                $table->string('type')->nullable()->default(null);
                $table->string('registration_number')->nullable()->default(null);
                $table->date('date_itp_begin')->nullable()->default(null);
                $table->date('date_itp_end')->nullable()->default(null);
                $table->date('date_insurance_begin')->nullable()->default(null);
                $table->date('date_insurance_end')->nullable()->default(null);
                $table->timestamps();
            });
        } else {
            Schema::table('automobiles', function (Blueprint $table) {
                $table->json('files')->nullable()->default(null);
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
        Schema::dropIfExists('automobiles');
    }
}
