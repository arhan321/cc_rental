<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSchedule extends Model
{
    use HasFactory;

    protected $table = 'product_schedules';

    protected $fillable = [
        'kostum_id', 'tanggal_mulai', 'tanggal_akhir', 'jumlah_dibooking', 'status'
    ];

    // Relasi: ProductSchedule dimiliki oleh Kostum
    public function kostum()
    {
        return $this->belongsTo(Kostum::class);
    }
}
