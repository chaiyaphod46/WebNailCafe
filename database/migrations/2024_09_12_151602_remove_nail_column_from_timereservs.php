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
        Schema::table('timereservs', function (Blueprint $table) {
            // ลบ foreign key ก่อนลบคอลัมน์
            $table->dropForeign(['nail']);  // ลบ foreign key constraint
            $table->dropColumn('nail');  // ลบคอลัมน์ nail
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timereservs', function (Blueprint $table) {
            // เพิ่มคอลัมน์กลับหากทำการ rollback
            $table->unsignedBigInteger('nail')->nullable();
            $table->foreign('nail')->references('nail_design_id')->on('naildesigns')->onDelete('cascade');
        });
    }
};
