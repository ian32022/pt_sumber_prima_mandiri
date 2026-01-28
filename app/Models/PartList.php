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
        'designer_id',
        'kode_part',
        'nama_part',
        'material',
        'dimensi',
        'dimensi_belanja',
        'quantity',
        'unit',
        'berat',
        'gambar_part',
        'status_part',
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

    // Relationship dengan Designer
    public function designer()
    {
        return $this->belongsTo(User::class, 'designer_id');
    }

    // Relationship dengan ProsesMfg
    public function prosesMfg()
    {
        return $this->hasMany(ProsesMfg::class, 'partlist_id');
    }

    // Relationship dengan Schedule
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'partlist_id');
    }

    // Status part options
    public static function getStatusOptions()
    {
        return [
            'draft' => 'Draft',
            'belum_dibeli' => 'Belum Dibeli',
            'dibeli' => 'Sudah Dibeli',
            'indent' => 'Indent',
            'ready' => 'Ready'
        ];
    }

    // Check if part is ready for machining
    public function isReadyForMachining()
    {
        return $this->status_part === 'ready';
    }

    // Generate kode part otomatis
    public static function generateKodePart($permintaanId)
    {
        $permintaan = Permintaan::find($permintaanId);
        $prefix = 'PART-' . date('ym') . '-';
        
        $count = self::where('permintaan_id', $permintaanId)->count();
        
        return $prefix . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    }
}