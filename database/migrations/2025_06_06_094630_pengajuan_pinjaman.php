<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuan_pinjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('jumlah', 15, 2);
            $table->integer('lama_angsuran');
            $table->string('tujuan');
            $table->enum('jenis_pinjaman', ['kms', 'barang']);
            $table->decimal('potongan_propisi', 15, 2)->nullable();
            $table->decimal('jumlah_diterima', 15, 2)->nullable();
            $table->decimal('jumlah_harus_dibayar', 15, 2)->nullable();
            $table->decimal('total_jasa', 15, 2)->nullable();
            $table->decimal('cicilan_per_bulan', 15, 2)->nullable();
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_dikonfirmasi')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'keluar'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_pinjaman');
    }
};
