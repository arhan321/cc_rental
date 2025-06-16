<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'roles';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',  // Pastikan kamu sudah memiliki kolom 'title' di tabel 'roles'
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Relasi Many-to-Many dengan model Permission
     * 
     * Pastikan kamu sudah membuat model Permission dan tabel pivot untuk relasi ini
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Relasi Many-to-Many dengan model User
     * 
     * Relasi ini sudah ada di model User, jadi ini akan otomatis menghubungkan kedua model.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Cek apakah peran ini memiliki izin tertentu.
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return $this->permissions()->where('name', $permission)->exists();
    }
}
