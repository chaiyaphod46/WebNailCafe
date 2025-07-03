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
        Schema::create('naildesigns', function (Blueprint $table) {
            $table->id('nail_design_id');
            $table->string('nailname')->nullable();
            $table->string('image')->nullable();
            $table->decimal('design_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('naildesigns');
    }
};
