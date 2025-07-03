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
        Schema::table('naildesigns', function (Blueprint $table) {
            // เพิ่มคำสั่งสำหรับการเปลี่ยนชื่อคอลัมน์ด้วยการใช้ SQL ดิบ
            DB::statement('ALTER TABLE `naildesigns` CHANGE `type` `design_type` ENUM(\'พื้น\', \'กริตเตอร์\', \'แมท\', \'มาร์เบิล\', \'เฟรนช์\', \'ออมเบร\', \'เพ้นท์ลาย\', \'3D\', \'แม่เหล็ก\') NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('naildesigns', function (Blueprint $table) {
            // เพิ่มคำสั่งสำหรับการเปลี่ยนชื่อคอลัมน์กลับ
            DB::statement('ALTER TABLE `naildesigns` CHANGE `design_type` `type` ENUM(\'พื้น\', \'กริตเตอร์\', \'แมท\', \'มาร์เบิล\', \'เฟรนช์\', \'ออมเบร\', \'เพ้นท์ลาย\', \'3D\', \'แม่เหล็ก\') NULL');
        });
    }
};
