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
        Schema::create('pengajuan_pinjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // relasi ke user
            $table->decimal('jumlah', 15, 2); // total pinjaman
            $table->integer('lama_angsuran'); // dalam bulan (max 20)
            $table->string('tujuan'); // alasan peminjaman
            $table->enum('jenis_pinjaman', ['kms', 'barang']); // tipe pinjaman
            $table->decimal('potongan_propisi', 15, 2)->nullable(); // 2% dari pinjaman
            $table->decimal('total_jasa', 15, 2)->nullable(); // akumulasi bunga
            $table->decimal('cicilan_per_bulan', 15, 2)->nullable(); // estimasi cicilan awal
            $table->date('tanggal_pengajuan');
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'keluar'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_pinjamen');
    }
};
