<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Tentukan primary key custom
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';

    // Nama tabel sesuai database
    protected $table = 'users';

    // Kolom yang bisa diisi
    protected $fillable = [
        'nama',
        'email',
        'password_hash',
        'role',
    ];

    // Kolom yang harus di-hide
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    // Casting tipe data
    protected $casts = [
        'last_login' => 'datetime',
    ];

    // Override method untuk password
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
