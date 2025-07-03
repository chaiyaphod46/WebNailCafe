<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('detail_promotions', function (Blueprint $table) {
            $table->dropColumn('design_type'); // ลบคอลัมน์ design_type
        });
    }

    public function down()
    {
        Schema::table('detail_promotions', function (Blueprint $table) {
            $table->enum('design_type', [
                'พื้น', 'กริตเตอร์', 'แมท', 'มาร์เบิล', 'เฟรนช์', 'ออมเบร', 'เพ้นท์ลาย', '3D', 'แม่เหล็ก'
            ])->nullable(); // เพิ่มคอลัมน์ design_type กลับคืน
        });
    }
};
