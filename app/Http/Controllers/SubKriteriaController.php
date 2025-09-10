<?php

namespace App\Http\Controllers;

use App\Models\SubKriteria;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::with('subkriterias')->get();
        return view('subkriteria', compact('kriterias'));
    }

    public function store(Request $request)
    {
        $kriteria = Kriteria::findOrFail($request->kriteria_id);

        $rules = [
            'kriteria_id' => 'required|exists:kriterias,id',
            'nilai'       => 'required|integer|min:1|max:10',
            'batas_awal'  => 'required|numeric',
        ];

        // Batas akhir hanya divalidasi jika diisi
        if ($kriteria->nama !== 'Tahun terbit' && $request->filled('batas_akhir')) {
            $rules['batas_akhir'] = 'numeric|gte:batas_awal';
        }

        $request->validate($rules);

        SubKriteria::create([
            'kriteria_id' => $request->kriteria_id,
            'batas_awal'  => $request->batas_awal,
            'batas_akhir' => ($kriteria->nama !== 'Tahun terbit' && 
            $request->filled('batas_akhir')) 
                                ? $request->batas_akhir 
                                : null,
            'nilai'       => $request->nilai,
        ]);

        return redirect()->route('subkriteria.index')->with('success', 
        'Sub Kriteria berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $editingSub = SubKriteria::findOrFail($id);
        $kriterias = Kriteria::with('subkriterias')->get();

        return view('subkriteria', compact('editingSub', 'kriterias'));
    }

    public function update(Request $request, $id)
    {
        $sub = SubKriteria::findOrFail($id);
        $kriteria = Kriteria::findOrFail($request->kriteria_id);

        $rules = [
            'kriteria_id' => 'required|exists:kriterias,id',
            'nilai'       => 'required|integer|min:1|max:10',
            'batas_awal'  => 'required|numeric',
        ];

        if ($kriteria->nama !== 'Tahun terbit' && $request->filled('batas_akhir')) {
            $rules['batas_akhir'] = 'numeric|gte:batas_awal';
        }

        $request->validate($rules);

        $sub->update([
            'kriteria_id' => $request->kriteria_id,
            'batas_awal'  => $request->batas_awal,
            'batas_akhir' => ($kriteria->nama !== 'Tahun terbit' && 
            $request->filled('batas_akhir')) 
                                ? $request->batas_akhir 
                                : null,
            'nilai'       => $request->nilai,
        ]);

        return redirect()->route('subkriteria.index')->with('success', 
        'Sub Kriteria berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sub = SubKriteria::findOrFail($id);
        $sub->delete();

        return redirect()->route('subkriteria.index')->with('success', 
        'Sub Kriteria berhasil dihapus.');
    }
}
