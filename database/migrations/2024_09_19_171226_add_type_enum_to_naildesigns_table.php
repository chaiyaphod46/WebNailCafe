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
            // เพิ่มคอลัมน์ 'type' ที่มีประเภทเป็น enum และจำกัดค่าได้
            $table->enum('type', [
                'พื้น', 
                'กริตเตอร์', 
                'แมท', 
                'มาร์เบิล', 
                'เฟรนช์', 
                'ออมเบร', 
                'เพ้นท์ลาย', 
                '3D', 
                'แม่เหล็ก'
            ])->nullable()->after('design_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('naildesigns', function (Blueprint $table) {
            // ลบคอลัมน์ 'type' ออกเมื่อ rollback
            $table->dropColumn('type');
        });
    }
};
