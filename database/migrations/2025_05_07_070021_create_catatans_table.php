<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatatansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('catatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_karyawan');
            $table->string('nama');
            $table->integer('harga');
            $table->string('status');
            $table->text('keterangan')->nullable();
            $table->string('waktu');
            $table->boolean('checked')->default(false);
            $table->timestamps(); // ini membuat created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatans');
    }
}
