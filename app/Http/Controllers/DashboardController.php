<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Subkriteria;
use App\Models\Alternatif;
use App\Models\HasilVikor;
use App\Models\HasilBukuTerminat;
use App\Models\LogAktivitas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard utama.
     */
    public function index()
{
    $totalKriteria    = Kriteria::count();
    $totalSubkriteria = Subkriteria::count();
    $totalAlternatif  = Alternatif::count();
    $tahunAktif       = Carbon::now()->year;

    $topBuku = HasilBukuTerminat::where('tahun_hasil', $tahunAktif)
        ->orderBy('rank')
        ->first();

    $terakhirDihitung = HasilBukuTerminat::where('tahun_hasil', $tahunAktif)
        ->orderByDesc('created_at')
        ->first()?->created_at;

    $logs = LogAktivitas::latest()->take(5)->get();

    return view('dashboard', compact(
        'totalKriteria',
        'totalSubkriteria',
        'totalAlternatif',
        'topBuku',
        'tahunAktif',
        'terakhirDihitung',
        'logs'
    ));
}
}
