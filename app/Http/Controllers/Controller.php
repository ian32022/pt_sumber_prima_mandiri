<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use App\Models\Mesin;
use App\Models\ProsesMfg;
use App\Models\Schedule;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $data = [
            'total_permintaan' => Permintaan::count(),
            'permintaan_pending' => Permintaan::where('status', 'draft')->count(),
            'permintaan_inprogress' => Permintaan::where('status', 'in_progress')->count(),
            'mesin_aktif' => Mesin::where('status', 'active')->count(),
            'mesin_maintenance' => Mesin::where('status', 'maintenance')->count(),
            'proses_running' => ProsesMfg::where('status', 'running')->count(),
            'schedule_today' => Schedule::whereDate('tanggal_plan', today())->count(),
        ];

        // Data untuk chart
        $data['permintaan_by_status'] = Permintaan::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $data['permintaan_by_month'] = Permintaan::selectRaw('DATE_FORMAT(tanggal_permintaan, "%Y-%m") as month, count(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->take(6)
            ->pluck('total', 'month')
            ->toArray();

        return view('dashboard.index', compact('data', 'user'));
    }

    public function dashboardOperator()
    {
        $user = auth()->user();
        
        $tugas_hari_ini = Schedule::where('pic', $user->user_id)
            ->whereDate('tanggal_plan', today())
            ->whereIn('status', ['planned', 'in_progress'])
            ->with(['mesin', 'partList'])
            ->get();

        $proses_aktif = ProsesMfg::where('operator_id', $user->user_id)
            ->where('status', 'running')
            ->with(['partList', 'mesin'])
            ->get();

        return view('dashboard.operator', compact('user', 'tugas_hari_ini', 'proses_aktif'));
    }

    public function dashboardEngineer()
    {
        $user = auth()->user();
        
        $permintaan_baru = Permintaan::where('status', 'submitted')
            ->with('user')
            ->orderBy('tanggal_permintaan', 'desc')
            ->take(10)
            ->get();

        $mesin_maintenance = Mesin::where('status', 'maintenance')
            ->get();

        return view('dashboard.engineer', compact('user', 'permintaan_baru', 'mesin_maintenance'));
    }
}