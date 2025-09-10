<?php

namespace App\Http\Controllers;

use App\Models\HasilBukuTerminat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class HasilBukuTerminatController extends Controller
{
    /**
     * Menampilkan daftar seluruh buku yang dianggap terminat
     * berdasarkan tahun hasil, diurutkan dari tahun terbaru ke lama.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $tahunSekarang = now()->year;
        $jumlah = $request->input('jumlah');
        $tahunSebelumnya = $tahunSekarang - 1;

        // Ranking terbaru
        $rankingTerbaru = HasilBukuTerminat::where(
            'tahun_hasil',
            $tahunSekarang
        )
            ->orderBy('rank')
            ->paginate($jumlah ?? 10); // Default: 10 jika tidak ada input

        // Ranking tahun sebelumnya
        $rankingSebelumnya = HasilBukuTerminat::where(
            'tahun_hasil',
            $tahunSebelumnya
        )
            ->orderBy('rank')
            ->paginate(10);

        return view('hasil_buku_terminat', compact(
            'rankingTerbaru',
            'rankingSebelumnya',
            'tahunSebelumnya',
            'jumlah'
        ));
    }

    public function exportPDF(Request $request)
    {
        $jumlah = $request->input('jumlah');
        $tahun = now()->year;

        $ranking = HasilBukuTerminat::where('tahun_hasil', $tahun)
            ->when($jumlah, fn($q) => $q->limit($jumlah))
            ->get();

        $pdf = Pdf::loadView('pdf.hasil_buku', [
            'ranking' => $ranking,
            'tahun' => $tahun,
        ]);

        return $pdf->download('hasil_buku_terminat_' . $tahun .
            '.pdf');
    }
}
