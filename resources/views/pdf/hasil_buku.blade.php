<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hasil Buku Terminat {{ $tahun }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 30px 40px 20px 40px;
            background: #f9f9f9;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .header img {
            height: 60px;
            margin-right: 18px;
        }

        .header-title {
            text-align: left;
        }

        h2 {
            margin-bottom: 2px;
            font-size: 20px;
            letter-spacing: 1px;
        }

        h3, h4 {
            margin: 0;
            font-weight: normal;
        }

        .divider {
            border-bottom: 2px solid #2c3e50;
            margin: 10px 0 18px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background: #fff;
            box-shadow: 0 2px 8px #eee;
        }

        th, td {
            border: 1px solid #333;
            padding: 7px 6px;
            text-align: center;
        }

        th {
            background-color: #e3eafc;
            color: #2c3e50;
            font-size: 13px;
        }

        td.text-left {
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #f6f8fa;
        }

        tbody tr:nth-child(odd) {
            background-color: #fff;
        }

        .footer {
            margin-top: 30px;
            font-size: 11px;
            color: #888;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo-Undika-New-01.png') }}" alt="Logo Undika">
        <div class="header-title">
            <h2>PERPUSTAKAAN UNIVERSITAS DINAMIKA</h2>
            <h3>LAPORAN HASIL PEMERINGKATAN BUKU TERMINAT</h3>
            <h4>UNTUK PENGEMBANGAN KOLEKSI TAHUN {{ $tahun }}</h4>
        </div>
    </div>
    <div class="divider"></div>
    <p style="text-align: center; margin-top: 10px; font-size: 12px;">
        Disusun pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
    </p>
    <p style="margin-top: 20px; font-size: 12px;">
        Laporan ini digunakan sebagai dasar pertimbangan dalam pengembangan koleksi buku perpustakaan 
        berdasarkan analisis minat pemustaka menggunakan metode <strong>VIKOR</strong>.
    </p>
    <table>
        <thead>
            <tr>
                <th>Ranking</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Tahun Terbit</th>
                <th>Kategori</th>
                <th>Harga</th> 
            </tr>
        </thead>
        <tbody>
            @foreach ($ranking as $buku)
                <tr>
                    <td>{{ $buku->rank ?? '-' }}</td>
                    <td class="text-left">{{ $buku->judul }}</td>
                    <td class="text-left">{{ $buku->pengarang }}</td>
                    <td>{{ $buku->tahun_terbit }}</td>
                    <td class="text-left">{{ $buku->kategori }}</td>
                    <td>{{ number_format($buku->harga, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB
    </div>
</body>
</html>
