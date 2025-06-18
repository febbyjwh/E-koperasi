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
        Schema::create('modal_logs', function (Blueprint $table) {
        $table->id();
        $table->enum('tipe', ['masuk', 'keluar']);
        $table->decimal('jumlah', 15, 2);
        $table->string('sumber');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modal_logs');
    }
};
