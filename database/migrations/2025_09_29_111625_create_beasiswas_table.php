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
        Schema::create('beasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_beasiswa');
            $table->string('jenis_beasiswa');
            $table->text('deskripsi')->nullable();
            $table->integer('kuota')->default(0);
            $table->decimal('nominal', 15, 2)->nullable();
            $table->date('tanggal_buka');
            $table->date('tanggal_tutup');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->string('tahun_ajaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beasiswa');
    }
};
