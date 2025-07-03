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
    // ใช้ raw SQL ในการเปลี่ยนชื่อคอลัมน์
    DB::statement('ALTER TABLE promotions CHANGE id promotion_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    // ในฟังก์ชัน down จะเปลี่ยนชื่อกลับ
    DB::statement('ALTER TABLE promotions CHANGE promotion_id id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
}

};
