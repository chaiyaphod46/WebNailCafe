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
        // ตั้งค่า default สำหรับ statusdetail เป็น 'รอชำระเงินมัดจำ'
        Schema::table('timereservs', function (Blueprint $table) {
            $table->string('statusdetail')->default('รอชำระเงินมัดจำ')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // รีเซ็ตค่า statusdetail ให้เป็น nullable ในกรณี rollback
        Schema::table('timereservs', function (Blueprint $table) {
            $table->string('statusdetail')->nullable()->change();
        });
    }
};
