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
    Schema::create('detail_promotions', function (Blueprint $table) {
        $table->bigIncrements('DP_id'); // Primary Key
        $table->unsignedBigInteger('promotion_id'); // Foreign Key เชื่อมกับ promotions
        $table->foreign('promotion_id')->references('promotion_id')->on('promotions')->onDelete('cascade');
        $table->unsignedBigInteger('nail_design_id')->nullable(); // Foreign Key เชื่อมกับ naildesigns
        $table->foreign('nail_design_id')->references('nail_design_id')->on('naildesigns')->onDelete('cascade');
        $table->enum('design_type', [
            'พื้น', 'กริตเตอร์', 'แมท', 'มาร์เบิล', 'เฟรนช์', 'ออมเบร', 'เพ้นท์ลาย', '3D', 'แม่เหล็ก'
        ])->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_promotions');
    }
};
