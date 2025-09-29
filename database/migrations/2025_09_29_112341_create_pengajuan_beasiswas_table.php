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
        Schema::create('pengajuan_beasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('beasiswa_id')->nullable()->constrained('beasiswa')->onDelete('set null');
            $table->enum('status', ['pending', 'diverifikasi', 'ditolak'])->default('pending');
            $table->text('alasan_pengajuan');
            $table->string('berkas_pendukung')->nullable();
            $table->date('tanggal_pengajuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_beasiswa');
    }
};
