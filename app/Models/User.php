<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    protected $table = 'users';
    
    protected $fillable = [
        'nama',
        'email',
        'password_hash',
        'role',
        'last_login'
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
    ];

    protected $casts = [
        'last_login' => 'datetime',
    ];

    // Relationship dengan Permintaan sebagai requester
    public function permintaan()
    {
        return $this->hasMany(Permintaan::class, 'user_id');
    }

    // Relationship dengan PartList sebagai designer
    public function designedParts()
    {
        return $this->hasMany(PartList::class, 'designer_id');
    }

    // Relationship dengan ProsesMfg sebagai operator
    public function prosesMfg()
    {
        return $this->hasMany(ProsesMfg::class, 'operator_id');
    }

    // Relationship dengan Schedule sebagai PIC
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'pic');
    }

    // Helper methods untuk role checking
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isDesign()
    {
        return $this->role === 'design';
    }

    public function isMachining()
    {
        return $this->role === 'machining';
    }

    // Override password field
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}