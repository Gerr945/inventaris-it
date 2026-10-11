<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalian', function (Blueprint $table) {

            $table->id();

            $table->foreignId('peminjaman_id')
                ->constrained('peminjaman')
                ->cascadeOnDelete();

            $table->date('tanggal');

            $table->time('jam');

            $table->string('nama_penerima')->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'rejected'
            ])->default('pending');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};