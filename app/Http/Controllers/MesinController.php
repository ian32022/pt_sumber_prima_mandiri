<?php

namespace App\Http\Controllers;

use App\Models\Mesin;
use Illuminate\Http\Request;

class MesinController extends Controller
{
    public function index()
    {
        $mesins = Mesin::orderBy('kode_mesin')->get();
        return view('admin.mesin', compact('mesins'));
    }

    public function create()
    {
        // ✅ Tidak perlu view terpisah, pakai modal di admin.mesin
        return redirect()->route('admin.mesin.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mesin'   => 'required|unique:mesin,kode_mesin',
            'nama_mesin'   => 'required|string|max:100',
            'jenis_proses' => 'required|string|max:100',
            'status'       => 'required|in:active,maintenance,inactive',
            'kapasitas'    => 'nullable|numeric|min:0',
            'lokasi'       => 'required|string|max:100',
        ], [
            'kode_mesin.required'   => 'Kode mesin wajib diisi.',
            'kode_mesin.unique'     => 'Kode mesin sudah digunakan.',
            'nama_mesin.required'   => 'Nama mesin wajib diisi.',
            'jenis_proses.required' => 'Jenis proses wajib diisi.',
            'status.required'       => 'Status wajib dipilih.',
            'lokasi.required'       => 'Lokasi wajib diisi.',
        ]);

        Mesin::create($request->all());

        // ✅ Fix: route name disesuaikan
        return redirect()->route('admin.mesin.index')
            ->with('success', 'Mesin berhasil ditambahkan.');
    }

    public function edit(Mesin $mesin)
    {
        // ✅ Kembalikan JSON untuk modal edit
        if (request()->ajax()) {
            return response()->json($mesin);
        }
        return redirect()->route('admin.mesin.index');
    }

    public function update(Request $request, Mesin $mesin)
    {
        $request->validate([
            'kode_mesin'   => 'required|unique:mesin,kode_mesin,' . $mesin->mesin_id . ',mesin_id',
            'nama_mesin'   => 'required|string|max:100',
            'jenis_proses' => 'required|string|max:100',
            'status'       => 'required|in:active,maintenance,inactive',
            'kapasitas'    => 'nullable|numeric|min:0',
            'lokasi'       => 'required|string|max:100',
        ], [
            'kode_mesin.required' => 'Kode mesin wajib diisi.',
            'kode_mesin.unique'   => 'Kode mesin sudah digunakan.',
            'nama_mesin.required' => 'Nama mesin wajib diisi.',
            'lokasi.required'     => 'Lokasi wajib diisi.',
        ]);

        $mesin->update($request->all());

        // ✅ Fix: route name disesuaikan
        return redirect()->route('admin.mesin.index')
            ->with('success', 'Mesin berhasil diperbarui.');
    }

    public function destroy(Mesin $mesin)
    {
        $mesin->delete();

        // ✅ Fix: route name disesuaikan
        return redirect()->route('admin.mesin.index')
            ->with('success', 'Mesin berhasil dihapus.');
    }

    public function updateStatus(Request $request, Mesin $mesin)
    {
        $request->validate([
            'status'           => 'required|in:active,maintenance,inactive',
            'last_maintenance' => 'nullable|date',
        ]);

        $mesin->update([
            'status'           => $request->status,
            'last_maintenance' => $request->last_maintenance ?? $mesin->last_maintenance,
        ]);

        return back()->with('success', 'Status mesin berhasil diperbarui.');
    }
}