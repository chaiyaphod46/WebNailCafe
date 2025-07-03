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
        Schema::create('detail_timereservs', function (Blueprint $table) {
            $table->id('D_id'); // Primary key ของตารางนี้
            $table->unsignedBigInteger('C_id'); // User ID จากตาราง users
            $table->unsignedBigInteger('reservs_id'); // Foreign key ไปยังตาราง timereservs
            $table->unsignedBigInteger('nail')->nullable(); // Foreign key ไปยังตาราง naildesigns 
            $table->unsignedBigInteger('additional_services')->nullable(); // Foreign key ไปยังตาราง other_services (บริการเพิ่มเติม)
            
            // กำหนดความสัมพันธ์ Foreign key
            $table->foreign('C_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reservs_id')->references('reservs_id')->on('timereservs')->onDelete('cascade');
            $table->foreign('nail')->references('nail_design_id')->on('naildesigns')->onDelete('cascade');
            $table->foreign('additional_services')->references('service_id')->on('other_services')->onDelete('cascade');
            
            $table->timestamps(); // timestamps สำหรับ created_at และ updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_timereservs');
    }
};
