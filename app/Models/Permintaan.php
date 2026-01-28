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

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Generate nomor permintaan otomatis
    public static function generateNomorPermintaan()
    {
        $prefix = 'REQ-' . date('Ym') . '-';
        $last = self::where('nomor_permintaan', 'like', $prefix . '%')
            ->orderBy('permintaan_id', 'desc')
            ->first();
        
        $number = $last ? (int) substr($last->nomor_permintaan, -4) + 1 : 1;
        
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    // Hitung progress berdasarkan part list
    public function getProgressAttribute()
    {
        $totalParts = $this->partLists()->count();
        if ($totalParts === 0) return 0;
        
        $completedParts = $this->partLists()->where('status_part', 'ready')->count();
        
        return round(($completedParts / $totalParts) * 100);
    }
}