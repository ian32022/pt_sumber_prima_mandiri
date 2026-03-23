<?php

namespace App\Http\Controllers;

use App\Models\PartList;
use App\Models\Permintaan;
use App\Models\User;
use Illuminate\Http\Request;

class PartListController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX — Tampilkan semua part list
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        // ✅ Support AJAX untuk load part list per permintaan (dari request.blade.php)
        if ($request->ajax() && $request->has('permintaan_id')) {
            $parts = PartList::where('permintaan_id', $request->permintaan_id)->get();
            return response()->json($parts);
        }

        $parts = PartList::with(['permintaan', 'designer'])
            ->orderBy('created_at', 'desc')
            ->get();

        // ✅ Fix: view disesuaikan dengan folder admin/
        return view('admin.part-list', compact('parts'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE — Form tambah part (redirect ke index, pakai modal)
    |--------------------------------------------------------------------------
    */
    public function create($permintaan_id = null)
    {
        // ✅ Fix: tidak perlu view terpisah, pakai modal di admin.part-list
        return redirect()->route('admin.part-list.index');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE — Simpan part baru
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'permintaan_id'  => 'required|exists:permintaan,permintaan_id',
            'nama_part'      => 'required|string|max:150',
            'material'       => 'nullable|string|max:100',
            'dimensi'        => 'nullable|string|max:100',
            'dimensi_belanja'=> 'nullable|string|max:100',
            'quantity'       => 'required|integer|min:1',
            'unit'           => 'required|string|max:20',
            'berat'          => 'nullable|numeric|min:0',
            'status_part'    => 'required|in:draft,belum_dibeli,dibeli,indent,ready',
        ], [
            'permintaan_id.required' => 'Permintaan wajib dipilih.',
            'nama_part.required'     => 'Nama part wajib diisi.',
            'quantity.required'      => 'Quantity wajib diisi.',
            'unit.required'          => 'Unit wajib diisi.',
            'status_part.required'   => 'Status wajib dipilih.',
        ]);

        $data = $request->all();
        $data['kode_part'] = PartList::generateKodePart($request->permintaan_id);

        PartList::create($data);

        // ✅ Fix: route disesuaikan
        return redirect()->route('admin.part-list.index')
            ->with('success', 'Part berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW — Detail part
    |--------------------------------------------------------------------------
    */
    public function show(PartList $partList)
    {
        $partList->load(['permintaan', 'designer', 'prosesMfg', 'schedules']);

        // ✅ Fix: view disesuaikan
        return view('admin.part-list', compact('partList'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT — Form edit (kembalikan JSON untuk modal)
    |--------------------------------------------------------------------------
    */
    public function edit(PartList $partList)
    {
        if (request()->ajax()) {
            return response()->json($partList);
        }
        return redirect()->route('admin.part-list.index');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE — Perbarui data part
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, PartList $partList)
    {
        $request->validate([
            'nama_part'      => 'required|string|max:150',
            'material'       => 'nullable|string|max:100',
            'dimensi'        => 'nullable|string|max:100',
            'dimensi_belanja'=> 'nullable|string|max:100',
            'quantity'       => 'required|integer|min:1',
            'unit'           => 'required|string|max:20',
            'berat'          => 'nullable|numeric|min:0',
            'status_part'    => 'required|in:draft,belum_dibeli,dibeli,indent,ready',
            'designer_id'    => 'nullable|exists:users,user_id',
        ], [
            'nama_part.required'   => 'Nama part wajib diisi.',
            'quantity.required'    => 'Quantity wajib diisi.',
            'unit.required'        => 'Unit wajib diisi.',
            'status_part.required' => 'Status wajib dipilih.',
        ]);

        $partList->update($request->all());

        // ✅ Fix: route disesuaikan
        return redirect()->route('admin.part-list.index')
            ->with('success', 'Part berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY — Hapus part
    |--------------------------------------------------------------------------
    */
    public function destroy(PartList $partList)
    {
        $partList->delete();

        // ✅ Fix: route disesuaikan
        return redirect()->route('admin.part-list.index')
            ->with('success', 'Part berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | ASSIGN DESIGNER — Tugaskan designer ke part
    |--------------------------------------------------------------------------
    */
    public function assignDesigner(Request $request, PartList $partList)
    {
        $request->validate([
            'designer_id' => 'required|exists:users,user_id',
        ], [
            'designer_id.required' => 'Designer wajib dipilih.',
            'designer_id.exists'   => 'Designer tidak ditemukan.',
        ]);

        $partList->update([
            'designer_id' => $request->designer_id,
            'status_part' => 'draft',
        ]);

        return back()->with('success', 'Designer berhasil ditugaskan.');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS — Perbarui status part
    |--------------------------------------------------------------------------
    */
    public function updatePartStatus(Request $request, PartList $partList)
    {
        $request->validate([
            'status_part' => 'required|in:draft,belum_dibeli,dibeli,indent,ready',
        ], [
            'status_part.required' => 'Status wajib dipilih.',
            'status_part.in'       => 'Status tidak valid.',
        ]);

        $partList->update(['status_part' => $request->status_part]);

        return back()->with('success', 'Status part berhasil diperbarui.');
    }
}