<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartList extends Model
{
    use HasFactory;

    protected $primaryKey = 'partlist_id';
    protected $table = 'part_list';

    protected $fillable = [
        'permintaan_id',
        'kode_part',
        'nama_part',
        'material',
        'dimensi',
        'dimensi_belanja',
        'quantity',
        'unit',
        'berat',
        'gambar_part',
        'catatan'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'berat' => 'decimal:2',
    ];

    // Relationship dengan Permintaan
    public function permintaan()
    {
        return $this->belongsTo(Permintaan::class, 'permintaan_id');
    }

    // Relationship dengan Proses MFG
    public function prosesMfg()
    {
        return $this->hasMany(ProsesMfg::class, 'partlist_id');
    }

    // Relationship dengan Schedule
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'partlist_id');
    }

    // Total OK quantity dari semua proses
    public function getTotalOkAttribute()
    {
        return $this->prosesMfg->sum('hasil_ok');
    }

    // Total NG quantity dari semua proses
    public function getTotalNgAttribute()
    {
        return $this->prosesMfg->sum('hasil_ng');
    }

    // Yield rate
    public function getYieldRateAttribute()
    {
        $total = $this->total_ok + $this->total_ng;
        return $total > 0 ? ($this->total_ok / $total) * 100 : 0;
    }
}