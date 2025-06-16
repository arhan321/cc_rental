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
        Schema::create('kostums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('image');
            $table->string('nama_kostum');
            $table->enum('ukuran', ['S', 'M', 'L', 'One Size']);
            $table->integer('harga_sewa');
            $table->integer('stok');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['Tersedia', 'Terbooking'])->default('Tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kostums');
    }
};
