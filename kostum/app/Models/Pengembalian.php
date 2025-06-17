<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;
    
    protected $table = 'pengembalians';

    // Relasi: Pengembalian dimiliki oleh OrderItem
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
