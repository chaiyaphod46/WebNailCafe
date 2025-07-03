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
        Schema::create('other_services', function (Blueprint $table) {
            $table->id('service_id');  // ID ของบริการ
            $table->string('service_name');  // ชื่อบริการ
            $table->decimal('service_time');  // ระยะเวลาในการให้บริการ (ชั่วโมง)
            $table->decimal('service_price');  // ราคาค่าบริการ
            $table->timestamps();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_services');
    }
};
