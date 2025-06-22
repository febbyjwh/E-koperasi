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
        Schema::create('pelunasan_pinjaman', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade'); // relasi ke tabel users

            $table->foreignId('pinjaman_id')
                  ->constrained('pengajuan_pinjaman')
                  ->onDelete('cascade');

            $table->decimal('jumlah_dibayar', 15, 2);
            $table->date('tanggal_bayar');

            // Kolom tambahan
            $table->decimal('bunga', 15, 2)->nullable(); // bunga cicilan
            $table->decimal('sisa_pokok', 15, 2)->nullable(); // sisa pokok setelah cicilan
            $table->unsignedInteger('cicilan_ke')->nullable(); // cicilan ke-berapa

            $table->string('metode_pembayaran')->default('tunai');
            $table->text('keterangan')->nullable();

            $table->enum('status', ['pending', 'terverifikasi', 'ditolak'])->default('pending');

            $table->foreignId('admin_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelunasan_pinjaman');
    }
};
