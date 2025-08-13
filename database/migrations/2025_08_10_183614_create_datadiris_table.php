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
        Schema::create('datadiris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // field step 1
            $table->string('foto_ktp');
            $table->string('nik', 16)->unique();
            $table->string('nama_pengguna', 255);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('email', 255)->unique();
            $table->string('no_wa', 15)->nullable();
            $table->text('alamat');
            
            // field step 2
            $table->string('no_anggota', 50)->unique();
            $table->string('nip', 50)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->string('unit_kerja', 100)->nullable();
            $table->date('tanggal_mulai_kerja')->nullable();
            $table->string('status_kepegawaian', 50)->nullable();
            $table->date('tanggal_bergabung')->nullable();
            $table->string('status_keanggotaan', 50)->nullable();

            // field step 3
            $table->string('nama_keluarga', 255)->nullable();
            $table->string('hubungan_keluarga', 50)->nullable();
            $table->string('nomor_telepon_keluarga', 15)->nullable();
            $table->text('alamat_keluarga')->nullable();
            $table->string('email_keluarga')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datadiris');
    }
};
