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
    Schema::table('promotions', function (Blueprint $table) {
        $table->boolean('all_design_type')->default(false); // คอลัมน์ใหม่
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('promotions', function (Blueprint $table) {
        $table->dropColumn('all_design_type'); // ลบคอลัมน์เมื่อย้อนกลับ
    });
}
};
