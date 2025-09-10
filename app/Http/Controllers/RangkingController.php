<?php

namespace App\Http\Controllers;

class RangkingController extends Controller
{
    public function index()
    {
        $hasil = session('hasil_vikor', []);

        if (empty($hasil)) {
            return redirect()->route('alternatif.index')
                ->with('error', 'Data belum dihitung.');
        }

        $kesimpulan = "Alternatif terbaik berdasarkan 
        nilai Q terendah adalah '" . $hasil[0]['judul'] . "'.";

        return view('rangking', compact('hasil', 'kesimpulan'));
    }
}
