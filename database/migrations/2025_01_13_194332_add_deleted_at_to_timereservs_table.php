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
            $table->softDeletes(); // เพิ่มคอลัมน์ deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timereservs', function (Blueprint $table) {
            $table->dropSoftDeletes(); // ลบคอลัมน์ deleted_at
        });
    }
};
