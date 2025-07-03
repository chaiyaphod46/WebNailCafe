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
            // ใช้คำสั่ง SQL ดิบเพื่อย้ายคอลัมน์ design_type ไปไว้หลัง design_time
            DB::statement('ALTER TABLE `naildesigns` MODIFY `design_type` ENUM(\'พื้น\', \'กริตเตอร์\', \'แมท\', \'มาร์เบิล\', \'เฟรนช์\', \'ออมเบร\', \'เพ้นท์ลาย\', \'3D\', \'แม่เหล็ก\') NULL AFTER `design_time`');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('naildesigns', function (Blueprint $table) {
            // ใช้คำสั่ง SQL ดิบเพื่อย้ายคอลัมน์กลับไปไว้หลัง design_price
            DB::statement('ALTER TABLE `naildesigns` MODIFY `design_type` ENUM(\'พื้น\', \'กริตเตอร์\', \'แมท\', \'มาร์เบิล\', \'เฟรนช์\', \'ออมเบร\', \'เพ้นท์ลาย\', \'3D\', \'แม่เหล็ก\') NULL AFTER `design_price`');
        });
    }
};
