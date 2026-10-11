<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {

            $table->date('tanggal_kembali')
                ->nullable()
                ->after('tanggal');

            $table->time('jam_kembali')
                ->nullable()
                ->after('tanggal_kembali');

        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {

            $table->dropColumn([
                'tanggal_kembali',
                'jam_kembali'
            ]);

        });
    }
};