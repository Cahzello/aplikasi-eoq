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
        Schema::create('calculates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->string('bahan_baku');
            $table->integer('eoq');
            $table->decimal('rop');
            $table->decimal('safety_stock');
            $table->integer('frekuensi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculates');
    }
};