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
        Schema::create('product_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kostum_id')->constrained('kostums')->onDelete('cascade');
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir');
            $table->integer('jumlah_dibooking')->default(1);
            $table->enum('status', ['Booked', 'Selesai', 'Batal'])->default('Booked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_schedules');
    }
};
