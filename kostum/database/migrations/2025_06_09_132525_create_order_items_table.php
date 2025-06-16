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
        Schema::create('order_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Relasi ke tabel orders
        $table->foreignId('kostum_id')->constrained('kostums')->onDelete('cascade'); // Relasi ke tabel kostums
        $table->integer('qty'); // Jumlah produk yang dipesan
        $table->decimal('total', 10, 2); // Total harga berdasarkan harga_item * qty
        $table->timestamps(); // Timestamps untuk created_at dan updated_at
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
