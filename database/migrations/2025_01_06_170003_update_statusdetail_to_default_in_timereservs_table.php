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
        // อัปเดตคอลัมน์ statusdetail ที่เป็น NULL ให้เป็น 'รอชำระเงินมัดจำ'
        DB::table('timereservs')->whereNull('statusdetail')->update([
            'statusdetail' => 'รอชำระเงินมัดจำ',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // รีเซ็ตค่า statusdetail กลับเป็น NULL ในกรณี rollback
        DB::table('timereservs')->where('statusdetail', 'รอชำระเงินมัดจำ')->update([
            'statusdetail' => null,
        ]);
    }
};
