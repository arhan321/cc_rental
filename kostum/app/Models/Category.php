<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
            'nama', // Add this field
        ];
    // Relasi: Category memiliki banyak Kostum
    public function kostums()
    {
        return $this->hasMany(Kostum::class);
    }
}
