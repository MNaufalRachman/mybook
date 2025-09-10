<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class AlternatifController extends Controller
{
    /**
     * Menampilkan daftar alternatif dengan filter dan paginasi.
     */
    public function index(Request $request)
    {
        $alternatifs = Alternatif::query()
            ->when($request->tahun_terbit, fn($q) => $q->where(
                'tahun_terbit',
                $request->tahun_terbit
            ))
            ->when($request->kategori, fn($q) => $q->where('kategori', 
            $request->kategori))
            ->paginate(10);

        $tahunList = Alternatif::select('tahun_terbit')
        ->distinct()->pluck('tahun_terbit');
        $kategoriList = Alternatif::select('kategori')
        ->distinct()->pluck('kategori');

        return view('alternatif', compact('alternatifs', 
        'tahunList', 'kategoriList'));
    }

    /**
     * Menyimpan data alternatif baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string',
            'pengarang' => 'required|string',
            'tahun_terbit' => 'required|integer',
            'kategori' => 'required|string',
            'peminjaman' => 'required|integer',
            'koleksi_meja' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        Alternatif::create($data);

        return redirect()->route('alternatif.index')->with(
            'success',
            'Data alternatif berhasil disimpan.'
        );
    }

    /**
     * Menampilkan form edit dan data alternatif terkait.
     */
    public function edit($id)
    {
        $editing = Alternatif::findOrFail($id);
        $alternatifs = Alternatif::latest()->paginate(10);
        $tahunList = Alternatif::select('tahun_terbit')
        ->distinct()->pluck('tahun_terbit');
        $kategoriList = Alternatif::select('kategori')
        ->distinct()->pluck('kategori');

        return view('alternatif', compact(
            'editing',
            'alternatifs',
            'tahunList',
            'kategoriList'
        ));
    }

    /**
     * Memperbarui data alternatif.
     */
    public function update(Request $request, $id)
    {
        $alt = Alternatif::findOrFail($id);

        $data = $request->validate([
            'judul' => 'required|string',
            'pengarang' => 'required|string',
            'tahun_terbit' => 'required|integer',
            'kategori' => 'required|string',
            'peminjaman' => 'required|integer',
            'koleksi_meja' => 'required|integer',
            'harga' => 'required|numeric',
        ]);

        $alt->update($data);

        return redirect()->route('alternatif.index')->with(
            'success',
            'Data berhasil diperbarui.'
        );
    }

    /**
     * Menghapus satu data alternatif.
     */
    public function destroy($id)
    {
        Alternatif::findOrFail($id)->delete();
        return redirect()->route('alternatif.index')->with(
            'success',
            'Data berhasil dihapus.'
        );
    }

    /**
     * Menghapus seluruh data alternatif.
     */
    public function clear()
    {
        Alternatif::truncate();
        return redirect()->route('alternatif.index')->with(
            'success',
            'Semua data alternatif telah dihapus.'
        );
    }

    /**
     * Upload data alternatif dari file Excel.
     * Seluruh data lama akan dihapus terlebih dahulu.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            // Hapus semua data lama
            Alternatif::truncate();

            $collection = Excel::toCollection(null, $request->file('file'));
            $rows = $collection[0];

            foreach ($rows as $index => $row) {
                if ($index === 0) continue; // Lewati baris header jika ada

                Alternatif::create([
                    'judul'         => $row[0] ?? '-',
                    'pengarang'     => $row[1] ?? '-',
                    'tahun_terbit'  => $row[2] ?? 2020,
                    'kategori'      => $row[3] ?? '-',
                    'peminjaman'    => $row[4] ?? 0,
                    'koleksi_meja'  => $row[5] ?? 0,
                    'harga'         => $row[6] ?? 0,
                ]);
            }

            return redirect()->route('alternatif.index')
                ->with('success', 'Upload data berhasil. 
                Data sebelumnya telah digantikan.');
        } catch (\Exception $e) {
            Log::error('Upload gagal: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Upload gagal. 
            Pastikan format file sesuai.');
        }
    }
}
