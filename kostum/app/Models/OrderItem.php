<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'kostum_id',
        'qty',
        'durasi_sewa',
        'tanggal_mulai',
        'tanggal_akhir',
        'harga_item',
        'total',
        'status'
    ];

    // Relasi: OrderItem dimiliki oleh Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi: OrderItem berhubungan dengan Kostum
    public function kostum()
    {
        return $this->belongsTo(Kostum::class);
    }

    // Relasi: OrderItem memiliki satu Pengembalian
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }
}
