<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Mesin;
use App\Models\PartList;
use App\Models\ProsesMfg;
use App\Models\User;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['mesin', 'partList', 'picUser'])
            ->orderBy('tanggal_plan', 'asc')
            ->get();
        
        return view('schedule.index', compact('schedules'));
    }

    public function create($partlist_id = null)
    {
        $part = $partlist_id ? PartList::find($partlist_id) : null;
        $mesins = Mesin::where('status', 'active')->get();
        $machinings = User::where('role', 'machining')->get();
        $proses_mfg = $partlist_id ? ProsesMfg::where('partlist_id', $partlist_id)->get() : collect();
        
        return view('schedule.create', compact('part', 'mesins', 'machinings', 'proses_mfg'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mesin_id' => 'required|exists:mesin,mesin_id',
            'partlist_id' => 'required|exists:part_list,partlist_id',
            'mfg_id' => 'required|exists:proses_mfg,mfg_id',
            'activity' => 'required',
            'pic' => 'required|exists:users,user_id',
            'tanggal_plan' => 'required|date',
            'start_time_plan' => 'nullable',
            'end_time_plan' => 'nullable',
            'durasi_plan_minutes' => 'nullable|integer',
        ]);

        $schedule = Schedule::create($request->all());

        // Update proses mfg status
        $prosesMfg = ProsesMfg::find($request->mfg_id);
        $prosesMfg->update(['status' => 'pending']);

        return redirect()->route('schedule.index')
            ->with('success', 'Schedule berhasil dibuat.');
    }

    public function startSchedule(Schedule $schedule)
    {
        if (auth()->user()->user_id !== $schedule->pic) {
            return back()->with('error', 'Anda bukan PIC untuk schedule ini.');
        }

        $schedule->update([
            'status' => 'in_progress',
            'machining_status' => 'in_progress',
            'tanggal_act' => now()->toDateString(),
            'start_time_act' => now()->toTimeString(),
        ]);

        // Update proses mfg
        $prosesMfg = ProsesMfg::find($schedule->mfg_id);
        $prosesMfg->update([
            'status' => 'running',
            'start_time' => now(),
            'operator_id' => auth()->id(),
        ]);

        return back()->with('success', 'Schedule berhasil dimulai.');
    }

    public function completeSchedule(Request $request, Schedule $schedule)
    {
        $request->validate([
            'durasi_act_minutes' => 'required|integer',
            'catatan' => 'nullable',
        ]);

        $schedule->update([
            'status' => 'completed',
            'machining_status' => 'completed',
            'end_time_act' => now()->toTimeString(),
            'durasi_act_minutes' => $request->durasi_act_minutes,
            'catatan' => $request->catatan,
        ]);

        // Update proses mfg
        $prosesMfg = ProsesMfg::find($schedule->mfg_id);
        $prosesMfg->update([
            'status' => 'completed',
            'end_time' => now(),
            'hasil_ok' => $request->hasil_ok ?? 0,
            'hasil_ng' => $request->hasil_ng ?? 0,
        ]);

        return back()->with('success', 'Schedule berhasil diselesaikan.');
    }
}