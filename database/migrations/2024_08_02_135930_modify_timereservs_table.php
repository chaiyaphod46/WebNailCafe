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
        
            $table->unsignedBigInteger('nail')->nullable()->change();
            // เพิ่ม foreign key constraint
            $table->foreign('nail')->references('nail_design_id')->on('naildesigns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timereservs', function (Blueprint $table) {
            // ยกเลิกการเปลี่ยนแปลงคอลัมน์
            $table->dropForeign(['nail']);
            
        });
    }
};
