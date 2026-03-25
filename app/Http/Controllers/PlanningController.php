<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesin;
use App\Models\ProsesMfg;

class PlanningController extends Controller
{
    /**
     * Tampilkan halaman Production Planning
     */
    public function index()
    {
        // Ambil semua mesin beserta jumlah activity per status
        $mesins = Mesin::withCount([
            'prosesMfg as total_activity',
            'prosesMfg as plan_count'  => fn($q) => $q->where('status', 'plan'),
            'prosesMfg as act_count'   => fn($q) => $q->where('status', 'running'),
            'prosesMfg as done_count'  => fn($q) => $q->where('status', 'done'),
        ])->get();

        return view('admin.planning', compact('mesins'));
    }

    /**
     * Tampilkan detail activity untuk 1 mesin
     */
    public function show($id)
    {
        $mesin      = Mesin::findOrFail($id);
        $activities = ProsesMfg::where('mesin_id', $id)
                        ->orderBy('tanggal_plan', 'asc')
                        ->get();

        return view('admin.planning.show', compact('mesin', 'activities'));
    }

    /**
     * Simpan activity baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'mesin_id'     => 'required|exists:mesin,mesin_id',
            'nama_activity'=> 'required|string|max:255',
            'pic'          => 'required|string|max:100',
            'tanggal_plan' => 'required|date',
            'request_id'   => 'nullable|string|max:50',
        ]);

        ProsesMfg::create([
            'mesin_id'      => $request->mesin_id,
            'nama_proses'   => $request->nama_activity,
            'pic'           => $request->pic,
            'tanggal_plan'  => $request->tanggal_plan,
            'request_id'    => $request->request_id ?? null,
            'status'        => 'plan',
        ]);

        return redirect()->route('admin.planning.show', $request->mesin_id)
                         ->with('success', 'Activity berhasil ditambahkan.');
    }

    /**
     * Update activity
     */
    public function update(Request $request, $id)
    {
        $activity = ProsesMfg::findOrFail($id);

        $request->validate([
            'nama_activity'=> 'required|string|max:255',
            'pic'          => 'required|string|max:100',
            'tanggal_plan' => 'required|date',
        ]);

        $activity->update([
            'nama_proses'  => $request->nama_activity,
            'pic'          => $request->pic,
            'tanggal_plan' => $request->tanggal_plan,
        ]);

        return redirect()->route('admin.planning.show', $activity->mesin_id)
                         ->with('success', 'Activity berhasil diperbarui.');
    }

    /**
     * Hapus activity
     */
    public function destroy($id)
    {
        $activity = ProsesMfg::findOrFail($id);
        $mesinId  = $activity->mesin_id;
        $activity->delete();

        return redirect()->route('admin.planning.show', $mesinId)
                         ->with('success', 'Activity berhasil dihapus.');
    }
}