<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menghubungkan akun login (users) dengan profil keanggotaan (anggotas),
     * agar peminjaman bisa ditelusuri ke pemiliknya.
     */
    public function up(): void
    {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->unique()
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
