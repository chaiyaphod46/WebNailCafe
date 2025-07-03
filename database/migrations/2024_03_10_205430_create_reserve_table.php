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
        Schema::create('reservs', function (Blueprint $table) {
            $table->id('reservs_id');
            $table->unsignedBigInteger('id');
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
            $table->date('reservs_date');
            $table->time('reservs_time');
            $table->integer('price')->nullable();
            $table->string('statusdetail')->nullable()->default('จองแล้วรอดำเนินการ');
            $table->string('nail')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservs');
    }
};
