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
            // เพิ่มคอลัม promotion_id
            $table->unsignedBigInteger('promotion_id')->nullable()->after('price');
            $table->foreign('promotion_id')->references('promotion_id')->on('promotions')->onDelete('set null');
            
            // เพิ่มคอลัม use_promotion_price
            $table->integer('use_promotion_price')->nullable()->after('promotion_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timereservs', function (Blueprint $table) {
            // ลบคอลัม promotion_id และ use_promotion_price
            $table->dropForeign(['promotion_id']);
            $table->dropColumn('promotion_id');
            $table->dropColumn('use_promotion_price');
        });
    }
};
