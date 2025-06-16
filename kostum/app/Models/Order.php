<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'orders';

    protected $fillable = [
        'user_id',   // Menambahkan user_id ke dalam fillable
        'kode_order',
        'tanggal_order',
        'total',
        'status',
    ];

    // Relasi: Order memiliki banyak OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi: Order dimiliki oleh User
    public function profile()
    {
        return $this->belongsTo(Profile::class); // Relasi ke model Profile
    }


    // Relasi: Order memiliki satu HistoryOrder
    public function historyOrder()
    {
        return $this->hasOne(HistoryOrder::class);
    }
}
