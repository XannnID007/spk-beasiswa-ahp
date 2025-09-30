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
        Schema::create('ahp_comparisons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_1')->constrained('kriteria')->onDelete('cascade');
            $table->foreignId('kriteria_2')->constrained('kriteria')->onDelete('cascade');
            $table->decimal('nilai_perbandingan', 8, 6);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Pastikan tidak ada duplikasi pasangan kriteria
            $table->unique(['kriteria_1', 'kriteria_2']);
        });

        // Tabel untuk menyimpan hasil perhitungan AHP
        Schema::create('ahp_calculations', function (Blueprint $table) {
            $table->id();
            $table->json('comparison_matrix');
            $table->json('normalized_matrix');
            $table->json('priority_vector');
            $table->decimal('lambda_max', 10, 6);
            $table->decimal('consistency_index', 10, 6);
            $table->decimal('consistency_ratio', 10, 6);
            $table->boolean('is_consistent');
            $table->timestamp('calculated_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ahp_calculations');
        Schema::dropIfExists('ahp_comparisons');
    }
};
