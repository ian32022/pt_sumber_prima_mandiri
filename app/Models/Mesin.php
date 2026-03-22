<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProsesMfg;
use App\Models\Schedule;

class Mesin extends Model
{
    use HasFactory;

    protected $primaryKey = 'mesin_id';
    protected $table = 'mesin';

    protected $fillable = [
        'kode_mesin',
        'nama_mesin',
        'jenis_proses',
        'status',
        'kapasitas',
        'lokasi',
        'last_maintenance'
    ];

    protected $casts = [
        'kapasitas' => 'decimal:2',
        'last_maintenance' => 'date',
    ];

    // Relationship dengan ProsesMfg
    public function prosesMfg()
    {
        return $this->hasMany(ProsesMfg::class, 'mesin_id');
    }

    // Relationship dengan Schedule
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'mesin_id');
    }

    // Check if machine is available
    public function isAvailable()
    {
        return $this->status === 'active';
    }

    // Machine utilization rate
    public function getUtilizationRate()
    {
        $totalScheduled = $this->schedules()->where('status', 'completed')->count();
       $totalPossible = now()->daysInMonth;
        
        return $totalPossible > 0 ? ($totalScheduled / $totalPossible) * 100 : 0;
    }
}