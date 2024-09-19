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
        Schema::create('order_stoks', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_id');
            $table->string('baku_id');
            // $table->string('produk_id');
            $table->string('no_order');
            $table->string('satuan')->nullable();
            $table->string('qty');
            $table->string('harga')->nullable();
            $table->string('sub_total')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_stoks');
    }
};
