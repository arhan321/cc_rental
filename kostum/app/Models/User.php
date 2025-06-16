<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, HasFactory;

    public $table = 'users';

    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Menggunakan fungsi hasRole untuk memeriksa apakah pengguna memiliki peran tertentu.
     */
    public function hasRole($role)
    {
        return $this->roles()->where('title', $role)->exists();
    }

    /**
     * Menyediakan akses ke atribut "is_admin" untuk memeriksa apakah pengguna adalah admin.
     */
    public function getIsAdminAttribute()
    {
        return $this->hasRole('Admin');
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    /**
     * Mutator untuk memastikan password di-hash saat diset.
     */
    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = Hash::make($input);
        }
    }

    /**
     * Fungsi untuk mengirim notifikasi reset password.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Relasi many-to-many antara User dan Role.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Relasi one-to-one antara User dan Profile.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}

