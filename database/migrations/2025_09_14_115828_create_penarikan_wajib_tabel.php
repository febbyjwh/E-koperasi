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
         Schema::create('penarikan_wajib', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('total_ditarik', 15, 2); // simpan total saldo ditarik
            $table->date('tanggal_penarikan');
            $table->text('keterangan')->nullable(); // opsional (misal: keluar koperasi, resign)
            $table->timestamps();

            // relasi ke tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penarikan_wajib_tabel');
    }
};
