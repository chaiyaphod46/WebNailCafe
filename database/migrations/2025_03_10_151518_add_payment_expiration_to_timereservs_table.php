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
    Schema::table('timereservs', function (Blueprint $table) {
        $table->timestamp('payment_expiration')->nullable()->after('statusdetail');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('timereservs', function (Blueprint $table) {
        $table->dropColumn('payment_expiration');
    });
}
};
