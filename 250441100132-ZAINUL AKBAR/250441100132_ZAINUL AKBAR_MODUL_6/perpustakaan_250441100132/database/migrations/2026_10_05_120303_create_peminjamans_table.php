<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('peminjamans', function (Blueprint $table) { // <-- Pastikan 'peminjaman'
        $table->id();
        $table->foreignId('anggota_id')->constrained('anggotas');
        $table->foreignId('buku_id')->constrained('bukus');
        $table->date('tanggal_pinjam');
        $table->date('tanggal_kembali');
        $table->string('status');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};