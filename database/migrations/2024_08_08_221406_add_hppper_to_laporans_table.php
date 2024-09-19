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
        Schema::table('laporans', function (Blueprint $table) {
            $table->string('akun_hpp')->after('debit')->nullable();
            $table->string('hpp')->after('debit')->nullable();
            $table->string('akun_persediaan')->after('kredit')->nullable();
            $table->string('persediaan')->after('kredit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropColumn('akun_hpp');
            $table->dropColumn('hpp');
            $table->dropColumn('akun_persediaan');
            $table->dropColumn('persediaan');
        });
    }
};