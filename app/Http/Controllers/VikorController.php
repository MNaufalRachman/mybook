<?php

namespace App\Http\Controllers;

use App\Models\Alternatif;
use App\Models\Kriteria;
use App\Models\HasilVikor;
use App\Models\HasilBukuTerminat;
use App\Models\LogAktivitas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VikorController extends Controller
{
    /**
     * Proses perhitungan VIKOR dan simpan hasil ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function hitung(Request $request)
    {
        ini_set('max_execution_time', 300); // 5 menit
        ini_set('memory_limit', '1024M');

        $kriterias = Kriteria::with('subkriterias')->get();

        $alternatifs = Alternatif::query()
            ->when($request->tahun_terbit, fn($q) => $q->where('tahun_terbit', 
            $request->tahun_terbit))
            ->when($request->kategori, fn($q) => $q->where('kategori', 
            $request->kategori))
            ->get();

        $matrix = [];

        foreach ($alternatifs as $alt) {
            $row = ['id' => $alt->id, 'judul' => $alt->judul];

            foreach ($kriterias as $kriteria) {
                $kolom = match ($kriteria->nama) {
                    'Frekuensi Peminjaman' => 'peminjaman',
                    'Frekuensi Dibaca' => 'koleksi_meja',
                    'Tahun terbit' => 'tahun_terbit',
                    'Harga' => 'harga',
                    default => strtolower(str_replace(' ', '_', $kriteria->nama)),
                };

                $value = $alt[$kolom] ?? 0;

                $sub = $kriteria->subkriterias
                    ->filter(function ($s) use ($value, $kriteria) {
                        if ($kriteria->nama === 'Tahun terbit') {
                            return $value >= $s->batas_awal;
                        } elseif (is_null($s->batas_akhir)) {
                            return $value >= $s->batas_awal;
                        } else {
                            return $value >= $s->batas_awal && $value <= 
                            $s->batas_akhir;
                        }
                    })
                    ->sortByDesc('batas_awal')
                    ->first();

                $row[$kriteria->nama . '_asli'] = $value;
                $row[$kriteria->nama . '_konversi'] = $sub ? $sub->nilai : 0;
                $row[$kriteria->nama] = $sub ? $sub->nilai : 0;
            }

            $matrix[] = $row;
        }

        
        $normalized = $this->normalisasi($matrix, $kriterias);
        $normalizedBobot = $this->normalisasiBobot($normalized, $kriterias);
        $vikor = $this->prosesVikor($normalizedBobot, $kriterias);

        HasilVikor::truncate();
        HasilBukuTerminat::where('tahun_hasil', Carbon::now()->year)->delete();

        $hasilVikorData = collect($vikor)->map(function ($res) {
            return [
                'alternatif_id' => $res['id'],
                'judul'         => $res['judul'],
                'S'             => $res['S'],
                'R'             => $res['R'],
                'Q'             => $res['Q'],
                'rank'          => $res['rank'],
                'created_at'    => now(),
                'updated_at'    => now(),
            ];
        })->toArray();

        HasilVikor::insert($hasilVikorData);

        $detailAlternatif = Alternatif::whereIn('id', collect($vikor)
        ->pluck('id'))->get()->keyBy('id');
        $tahunHasil = now()->year;

        $dataTerminat = [];

        foreach ($vikor as $item) {
            $detail = $detailAlternatif[$item['id']] ?? null;

            if ($detail) {  
                $dataTerminat[] = [
                    'alternatif_id' => $detail->id,
                    'judul'         => $detail->judul,
                    'pengarang'     => $detail->pengarang,
                    'tahun_terbit'  => $detail->tahun_terbit,
                    'kategori'      => $detail->kategori,
                    'jumlah'        => $detail->peminjaman,
                    'harga'         => $detail->harga,
                    'Q'             => $item['Q'],
                    'rank'          => $item['rank'],
                    'tahun_hasil'   => $tahunHasil,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }
        }

        HasilBukuTerminat::insert($dataTerminat);

        // Simpan ke log aktivitas
        LogAktivitas::create([
            'aktivitas' => 'Perhitungan VIKOR dilakukan pada ' . now()
            ->format('d M Y H:i'),
        ]);

        return redirect()->route('vikor.rangking');
    }

    /**
     * Normalisasi data matriks berdasarkan kriteria.
     *
     * @param  array $data
     * @param  \Illuminate\Support\Collection $kriterias
     * @return array
     */
    private function normalisasi($data, $kriterias)
    {
        foreach ($kriterias as $kriteria) {
            $nama = $kriteria->nama;
            $col = array_column($data, $nama);
            $max = max($col);
            $min = min($col);

            foreach ($data as &$row) {
                $value = $row[$nama];

                if ($max == $min) {
                    $row[$nama] = 0;
                } else {
                    $row[$nama] = ($max - $value) / ($max - $min);
                }
            }
        }

        return $data;
    }

    /**
     * Mengalikan hasil normalisasi dengan bobot kriteria.
     *
     * @param  array $normalized
     * @param  \Illuminate\Support\Collection $kriterias
     * @return array
     */
    private function normalisasiBobot($normalized, $kriterias)
    {
        $bobot = $kriterias->pluck('bobot', 'nama');

        foreach ($normalized as &$row) {
            foreach ($kriterias as $kriteria) {
                $nama = $kriteria->nama;
                $row[$nama] *= $bobot[$nama];
            }
        }

        return $normalized;
    }

    /**
     * Proses perhitungan VIKOR (S, R, Q, dan ranking).
     *
     * @param  array $data
     * @param  \Illuminate\Support\Collection $kriterias
     * @return array
     */
    private function prosesVikor($data, $kriterias)
    {
        $results = [];
        $namaKriteria = $kriterias->pluck('nama');

        $Smax = -INF;
        $Smin = INF;
        $Rmax = -INF;
        $Rmin = INF;

        foreach ($data as $row) {
            $S = 0;
            $R = 0;

            foreach ($namaKriteria as $nama) {
                $value = $row[$nama];
                $S += $value;
                $R = max($R, $value);
            }

            $results[] = [
                'id'    => $row['id'],
                'judul' => $row['judul'],
                'S'     => $S,
                'R'     => $R,
            ];

            $Smax = max($Smax, $S);
            $Smin = min($Smin, $S);
            $Rmax = max($Rmax, $R);
            $Rmin = min($Rmin, $R);
        }

        foreach ($results as &$res) {
            $v = 0.5;
            $res['Q'] = $v * (($res['S'] - $Smin) / ($Smax - $Smin ?: 1)) +
                (1 - $v) * (($res['R'] - $Rmin) / ($Rmax - $Rmin ?: 1));
        }

        usort($results, fn($a, $b) => $a['Q'] <=> $b['Q']);

        foreach ($results as $i => &$res) {
            $res['rank'] = $i + 1;
        }

        return $results;
    }

    /**
     * Menampilkan hasil ranking VIKOR.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function rangking(Request $request)
    {
        $items = HasilVikor::orderBy('rank')->paginate(10);

        $kriterias = Kriteria::with('subkriterias')->get();
        $alternatifs = Alternatif::all();

        // Buat tabel konversi
        $konversi = [];
        foreach ($alternatifs as $alt) {
            $row = [
                'id' => $alt->id,
                'judul' => $alt->judul,
            ];
            foreach ($kriterias as $kriteria) {
                $kolom = match ($kriteria->nama) {
                    'Frekuensi Peminjaman' => 'peminjaman',
                    'Frekuensi Dibaca' => 'koleksi_meja',
                    'Tahun terbit' => 'tahun_terbit',
                    'Harga' => 'harga',
                    default => strtolower(str_replace(' ', '_', $kriteria->nama)),
                };
                $value = $alt[$kolom] ?? 0;
                $sub = $kriteria->subkriterias
                    ->filter(function ($s) use ($value, $kriteria) {
                        if ($kriteria->nama === 'Tahun terbit') {
                            return $value >= $s->batas_awal;
                        } elseif (is_null($s->batas_akhir)) {
                            return $value >= $s->batas_awal;
                        } else {
                            return $value >= $s->batas_awal && $value <= 
                            $s->batas_akhir;
                        }
                    })
                    ->sortByDesc('batas_awal')
                    ->first();
                $row[$kriteria->nama . '_asli'] = $value;
                $row[$kriteria->nama . '_konversi'] = $sub ? $sub->nilai : 0;
                $row[$kriteria->nama] = $sub ? $sub->nilai : 0;
            }
            $konversi[] = $row;
        }

        // Normalisasi dan normalisasi bobot
        $normalisasi = $this->normalisasi($konversi, $kriterias);
        $normalisasi_bobot = $this->normalisasiBobot($normalisasi, $kriterias);

        return view('rangking', compact('items', 'konversi', 'kriterias', 
        'normalisasi', 'normalisasi_bobot'));
    }
}
