<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kostum extends Model
{
    use HasFactory;

    protected $table = 'kostums';

    protected $fillable = [
        'category_id',  // Add this line to allow category_id to be mass-assigned
        'image',
        'nama_kostum',
        'ukuran',
        'harga_sewa',
        'stok',
        'deskripsi',
        'status',
    ];

    // Relasi: Kostum memiliki banyak OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi: Kostum dimiliki oleh Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: Kostum memiliki banyak ProductSchedule
    public function productSchedules()
    {
        return $this->hasMany(ProductSchedule::class);
    }
}
