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
        Schema::create('laporankaryawan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_karyawan');
            $table->string('waktu')->nullable();
            $table->integer('pendapatan');
            $table->integer('pengeluaran');
            $table->integer('pendapatan_bersih');
            $table->timestamp('tanggal')->useCurrent(); // Kolom tanggal dengan default waktu saat ini
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporankaryawan');
    }
};
