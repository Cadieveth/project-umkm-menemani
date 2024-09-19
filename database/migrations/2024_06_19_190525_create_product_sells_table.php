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
        Schema::create('product_sells', function (Blueprint $table) {
            $table->id();
            $table->string('no_resep');
            $table->string('kode_product');
            $table->string('nama_product');
            $table->string('harga_jual');
            $table->string('qty_in');
            $table->string('qty_out');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sells');
    }
};
