<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalians';
    protected $fillable = [
        'pesananan_item_id',
        'tanggal_kembali',
        'keterlambatan',
        'status',
    ];

    // Relasi: Pengembalian dimiliki oleh OrderItem
    public function pesananItem()
    {
        return $this->belongsTo(PesananItem::class);
    }
}
