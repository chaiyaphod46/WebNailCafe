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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id('promotion_id');
            $table->string('promotion_name'); // ชื่อโปรโมชั่น
            $table->string('promotion_code')->unique(); // รหัสโปรโมชั่น
            $table->enum('discount_type', ['percentage', 'fixed']); // ประเภทของส่วนลด
            $table->decimal('discount_value', 8, 2); // มูลค่าส่วนลด
            $table->timestamp('start_time')->default(now()); // เวลาที่เริ่มโปรโมชั่น
            $table->timestamp('end_time')->nullable(); // เวลาที่สิ้นสุดโปรโมชั่น
            $table->enum('status', ['A', 'D'])->default('A'); // สถานะโปรโมชั่น (A=Active, D=Deactive)
            $table->tinyInteger('all_design_type')->default(0); // ระบุว่าส่วนลดนี้ใช้กับประเภทการออกแบบทั้งหมดหรือไม่
            $table->timestamps(); // คอลัมน์ created_at และ updated_at
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
