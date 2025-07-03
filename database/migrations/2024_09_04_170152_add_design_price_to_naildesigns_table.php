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
            $table->decimal('design_price')->nullable(); // เพิ่มคอลัมน์ design_price
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('naildesigns', function (Blueprint $table) {
            $table->dropColumn('design_price'); // ลบคอลัมน์ design_price
        });
    }
};
