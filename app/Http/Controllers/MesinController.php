<?php

namespace App\Http\Controllers;

use App\Models\Mesin;
use Illuminate\Http\Request;

class MesinController extends Controller
{
    public function index()
    {
        $mesins = Mesin::all();
        return view('mesin.index', compact('mesins'));
    }

    public function create()
    {
        return view('mesin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mesin' => 'required|unique:mesin',
            'nama_mesin' => 'required',
            'jenis_proses' => 'required',
            'status' => 'required',
            'kapasitas' => 'nullable|numeric',
            'lokasi' => 'required',
        ]);

        Mesin::create($request->all());

        return redirect()->route('mesin.index')
            ->with('success', 'Mesin berhasil ditambahkan.');
    }

    public function edit(Mesin $mesin)
    {
        return view('mesin.edit', compact('mesin'));
    }

    public function update(Request $request, Mesin $mesin)
    {
        $request->validate([
            'kode_mesin' => 'required|unique:mesin,kode_mesin,' . $mesin->mesin_id . ',mesin_id',
            'nama_mesin' => 'required',
            'jenis_proses' => 'required',
            'status' => 'required',
            'kapasitas' => 'nullable|numeric',
            'lokasi' => 'required',
        ]);

        $mesin->update($request->all());

        return redirect()->route('mesin.index')
            ->with('success', 'Mesin berhasil diperbarui.');
    }

    public function destroy(Mesin $mesin)
    {
        $mesin->delete();

        return redirect()->route('mesin.index')
            ->with('success', 'Mesin berhasil dihapus.');
    }

    public function updateStatus(Request $request, Mesin $mesin)
    {
        $request->validate([
            'status' => 'required|in:active,maintenance,inactive',
            'last_maintenance' => 'nullable|date',
        ]);

        $mesin->update([
            'status' => $request->status,
            'last_maintenance' => $request->last_maintenance ?? $mesin->last_maintenance,
        ]);

        return back()->with('success', 'Status mesin berhasil diperbarui.');
    }
}