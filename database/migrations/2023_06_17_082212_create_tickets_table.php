<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->enum('problem', ['ACCOUNT', 'TECHNIC', 'OTHER']);
            $table->enum('priority', ['NORMAL', 'URGENT']);
            $table->string('detailed_problem');
            $table->boolean('status')->default(false)->comment('false - open | true - closed');
            $table->foreignId('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
