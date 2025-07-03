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
    Schema::create('use_code', function (Blueprint $table) {
        $table->id('use_code_id'); // รหัส primary key ของตาราง use_code
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // รหัสผู้ใช้ที่ใช้โค้ดโปรโมชั่น (เชื่อมกับตาราง users)
        $table->foreignId('promotion_id')->constrained('promotions', 'promotion_id')->onDelete('cascade'); // รหัสโปรโมชั่นที่ผู้ใช้ใช้ (เชื่อมกับคอลัมน์ promotion_id ในตาราง promotions)
        $table->timestamps(); // คอลัมน์ created_at และ updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('use_code');
    }
};
