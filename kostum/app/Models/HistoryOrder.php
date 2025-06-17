<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryOrder extends Model
{
    use HasFactory;
    
    protected $table = 'history_orders';

     protected $fillable = [
        'order_id',
        'tanggal_selesai',
        'total_bayar',
        'status',
    ];

    // Relasi: HistoryOrder dimiliki oleh Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi: HistoryOrder dimiliki oleh User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
