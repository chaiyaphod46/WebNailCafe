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
        Schema::create('opening_hours', function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->time('opening_time')->default('11:00:00');
            $table->time('closing_time')->default('20:00:00');
            $table->boolean('is_open')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opening_hours');
    }
};
