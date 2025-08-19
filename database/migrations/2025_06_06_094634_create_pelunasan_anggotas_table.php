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
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('pinjaman_id')->constrained('pengajuan_pinjaman')->onDelete('cascade');
                $table->decimal('jumlah_dibayar', 15, 2);
                $table->decimal('sisa_pinjaman', 15, 2);
                $table->date('tanggal_pengajuan')->nullable();
                $table->date('tanggal_dikonfirmasi')->nullable();
                $table->datetime('tanggal_bayar')->nullable()->change();
                $table->text('tengat')->nullable();
                $table->string('metode_pembayaran')->default('tunai');
                $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
                $table->text('keterangan')->nullable();
                $table->enum('status', ['belum_lunas', 'lunas', 'terlambat'])->default('belum_lunas');
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
