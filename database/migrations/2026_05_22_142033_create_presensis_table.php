<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presensis', function (Blueprint $table) {

            $table->id();

            $table->foreignId('mahasiswa_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('qr_session_id')
                ->constrained()
                ->onDelete('cascade');

            $table->timestamp('waktu_scan');

            $table->enum('status', [
                'hadir',
                'izin',
                'absen'
            ])->default('hadir');

            // GPS mahasiswa
            $table->double('latitude')->nullable();

            $table->double('longitude')->nullable();

            // jarak dari titik dosen/kampus
            $table->double('distance')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensis');
    }
};
