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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Laravel จะสร้าง primary key เป็น id ให้อัตโนมัติ
            $table->integer('amount'); // จำนวนเงิน
            $table->unsignedBigInteger('reservs_id'); // เชื่อมกับ timereservs
            // สร้าง foreign key ที่เชื่อมกับตาราง timereservs
            $table->foreign('reservs_id')->references('reservs_id')->on('timereservs')->onDelete('cascade');
            
            $table->dateTime('payment_date')->nullable(); // วันที่ชำระเงิน (เป็น nullable เผื่อยังไม่ได้จ่าย)
            $table->string('session_id')->unique();
            $table->string('status')->default('pending');
            $table->uuid('order_id')->unique();
        
            $table->timestamps(); // created_at และ updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
