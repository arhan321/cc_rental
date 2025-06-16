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
        Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('profile_id')->constrained()->onDelete('cascade'); // Relasi ke tabel profiles
        $table->string('kode_order')->unique(); // Kode unik untuk setiap order
        $table->date('tanggal_sewa'); // Tanggal mulai sewa
        $table->date('tanggal_dikembalikan'); // Tanggal pengembalian
        $table->decimal('total', 10, 2); // Total harga sewa
        $table->enum('status', ['Menunggu', 'Diproses', 'Siap Di Ambil', 'Selesai'])->default('Menunggu'); // Status order
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
