<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            // Menambahkan kolom tanggal_dikembalikan setelah tanggal_kembali
            $table->date('tanggal_dikembalikan')->nullable()->after('tanggal_kembali');
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn('tanggal_dikembalikan');
        });
    }
};