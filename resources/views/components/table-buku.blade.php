@if ($data->count())
<div class="overflow-x-auto">
    <table class="min-w-full border border-gray-300 text-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Tahun</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Q</th>
                <th>Ranking</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $buku)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $buku->judul }}</td>
                <td>{{ $buku->pengarang }}</td>
                <td>{{ $buku->tahun_terbit }}</td>
                <td>{{ $buku->kategori }}</td>
                <td>{{ $buku->jumlah }}</td>
                <td>{{ number_format($buku->Q, 4) }}</td>
                <td>{{ $buku->rank }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<p class="text-gray-500">Tidak ada data ditemukan.</p>
@endif