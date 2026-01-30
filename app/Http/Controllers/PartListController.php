<?php

namespace App\Http\Controllers;

use App\Models\PartList;
use App\Models\Permintaan;
use App\Models\User;
use Illuminate\Http\Request;

class PartListController extends Controller
{
    public function index()
    {
        $parts = PartList::with(['permintaan', 'designer'])->get();
        return view('part-list.index', compact('parts'));
    }

    public function create($permintaan_id = null)
    {
        $permintaan = $permintaan_id ? Permintaan::find($permintaan_id) : null;
        $designers = User::where('role', 'design')->get();
        
        return view('part-list.create', compact('permintaan', 'designers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'permintaan_id' => 'required|exists:permintaan,permintaan_id',
            'nama_part' => 'required',
            'material' => 'nullable',
            'dimensi' => 'nullable',
            'dimensi_belanja' => 'nullable',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required',
            'berat' => 'nullable|numeric',
            'status_part' => 'required',
        ]);

        $data = $request->all();
        $data['kode_part'] = PartList::generateKodePart($request->permintaan_id);
        
        PartList::create($data);

        return redirect()->route('permintaan.show', $request->permintaan_id)
            ->with('success', 'Part berhasil ditambahkan.');
    }

    public function edit(PartList $partList)
    {
        $designers = User::where('role', 'design')->get();
        return view('part-list.edit', compact('partList', 'designers'));
    }

    public function update(Request $request, PartList $partList)
    {
        $request->validate([
            'nama_part' => 'required',
            'material' => 'nullable',
            'dimensi' => 'nullable',
            'dimensi_belanja' => 'nullable',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required',
            'berat' => 'nullable|numeric',
            'status_part' => 'required',
            'designer_id' => 'nullable|exists:users,user_id',
        ]);

        $partList->update($request->all());

        return redirect()->route('part-list.show', $partList->partlist_id)
            ->with('success', 'Part berhasil diperbarui.');
    }

    public function show(PartList $partList)
    {
        $partList->load(['permintaan', 'designer', 'prosesMfg', 'schedules']);
        return view('part-list.show', compact('partList'));
    }

    public function destroy(PartList $partList)
    {
        $permintaan_id = $partList->permintaan_id;
        $partList->delete();

        return redirect()->route('permintaan.show', $permintaan_id)
            ->with('success', 'Part berhasil dihapus.');
    }

    public function assignDesigner(Request $request, PartList $partList)
    {
        $request->validate([
            'designer_id' => 'required|exists:users,user_id',
        ]);

        $partList->update([
            'designer_id' => $request->designer_id,
            'status_part' => 'draft',
        ]);

        return back()->with('success', 'Designer berhasil ditugaskan.');
    }

    public function updatePartStatus(Request $request, PartList $partList)
    {
        $request->validate([
            'status_part' => 'required|in:draft,belum_dibeli,dibeli,indent,ready',
        ]);

        $partList->update(['status_part' => $request->status_part]);

        return back()->with('success', 'Status part berhasil diperbarui.');
    }
}