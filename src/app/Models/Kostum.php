<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kostum extends Model
{
    use HasFactory;

    protected $table = 'kostums';

    protected $fillable = [
        'golongan_id',  // Add this line to allow category_id to be mass-assigned
        'image',
        'nama_kostum',
        'ukuran',
        'harga_sewa',
        'stok',
        'deskripsi',
        'status',
        'tanggal_tersedia',
    ];

    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

}
