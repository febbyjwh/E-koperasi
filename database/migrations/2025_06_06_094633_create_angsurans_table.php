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
        Schema::create('angsurans', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('pinjaman_id')->constrained('pengajuan_pinjaman')->onDelete('cascade');
            $table->integer('bulan_ke');
            $table->decimal('pokok', 15, 2);
            $table->decimal('bunga', 15, 2);
            $table->decimal('total_angsuran', 15, 2);
            $table->date('tanggal_jatuh_tempo')->nullable();
            $table->enum('status', ['belum_bayar', 'sudah_bayar', 'terlambat'])->default('belum_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angsurans');
    }
};
