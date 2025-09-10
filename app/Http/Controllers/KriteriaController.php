<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KriteriaController extends Controller
{
    // Tampilkan semua kriteria dan form tambah/edit
    public function index()
    {
        $kriterias = Kriteria::all();
        return view('kriteria', compact('kriterias'));
    }

    // Simpan kriteria baru
    public function store(Request $request)
    {
        // Validasi input standar
        $request->validate([
            'nama' => 'required|string',
            'bobot' => 'required|numeric|min:0|max:1',
            'atribut' => 'required|in:benefit,cost'
        ]);

        // Hitung total bobot saat ini
        $totalBobot = \App\Models\Kriteria::sum('bobot');

        // Tambahkan bobot yang akan disimpan
        $totalSetelahTambah = $totalBobot + $request->bobot;

        if ($totalSetelahTambah > 1) {
            return redirect()->back()->withErrors(['bobot' =>
            'Total bobot kriteria tidak boleh lebih dari 1.'])->withInput();
        }

        Kriteria::create($request->all());

        return redirect()->route('kriteria.index')->with(
            'success',
            'Kriteria berhasil ditambahkan.'
        );
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kriterias = Kriteria::all();
        return view('kriteria', compact('kriterias', 'kriteria'));
    }

    // Update kriteria
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'bobot' => 'required|numeric|min:0|max:1',
            'atribut' => 'required|in:benefit,cost'
        ]);

        $kriteria = Kriteria::findOrFail($id);

        $totalBobotLain = Kriteria::where('id', '!=', $id)->sum('bobot');
        $totalSetelahUpdate = $totalBobotLain + $request->bobot;

        if ($totalSetelahUpdate > 1) {
            return redirect()->back()->withErrors(['bobot' =>
            'Total bobot kriteria tidak boleh lebih dari 1.'])->withInput();
        }

        $kriteria->update($request->all());

        return redirect()->route('kriteria.index')->with(
            'success',
            'Kriteria berhasil diperbarui.'
        );
    }

    // Hapus kriteria
    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->delete();

        return redirect()->route('kriteria.index')->with(
            'success',
            'Kriteria berhasil dihapus.'
        );
    }
}
