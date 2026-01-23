<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    use HasFactory;

    protected $primaryKey = 'permintaan_id';
    protected $table = 'permintaan';
    
    protected $fillable = [
        'user_id',
        'nomor_permintaan',
        'deskripsi_kebutuhan',
        'jenis_produk',
        'priority',
        'status',
        'tanggal_permintaan',
        'tanggal_selesai',
        'catatan'
    ];

    protected $casts = [
        'tanggal_permintaan' => 'date',
        'tanggal_selesai' => 'date',
    ];

    // Relationship dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship dengan PartList
    public function partLists()
    {
        return $this->hasMany(PartList::class, 'permintaan_id');
    }
}