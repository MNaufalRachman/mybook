<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-wide flex items-center gap-2 animate-fade-in">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2M7 7a4 4 0 118 0 4 4 0 01-8 0z" />
            </svg>
            Perangkingan
        </h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto space-y-10 sm:px-6 lg:px-8 bg-gradient-to-br from-blue-50 to-white min-h-screen animate-fade-in">
<!--         
        {{-- Tabel Konversi Nilai --}}
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-blue-100 mt-10">
            <h3 class="text-lg font-bold text-blue-700 mb-4">Tabel Konversi Nilai Alternatif</h3>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full text-sm text-gray-800 table-auto">
                    <thead class="bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800 font-semibold text-sm uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-3 border">ID</th>
                            <th class="px-4 py-3 border">Judul</th>
                            @foreach ($kriterias as $kriteria)
                            <th class="px-4 py-3 border">{{ $kriteria->nama }} (Asli)</th>
                            <th class="px-4 py-3 border">{{ $kriteria->nama }} (Konversi)</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($konversi as $row)
                        <tr>
                            <td class="border px-4 py-2 text-center">{{ $row['id'] }}</td>
                            <td class="border px-4 py-2">{{ $row['judul'] }}</td>
                            @foreach ($kriterias as $kriteria)
                            <td class="border px-4 py-2 text-right">{{ $row[$kriteria->nama . '_asli'] }}</td>
                            <td class="border px-4 py-2 text-right">{{ $row[$kriteria->nama . '_konversi'] }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tabel Normalisasi --}}
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-blue-100 mt-10">
            <h3 class="text-lg font-bold text-blue-700 mb-4">Tabel Normalisasi</h3>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full text-sm text-gray-800 table-auto">
                    <thead class="bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800 font-semibold text-sm uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-3 border">ID</th>
                            <th class="px-4 py-3 border">Judul</th>
                            @foreach ($kriterias as $kriteria)
                                <th class="px-4 py-3 border">{{ $kriteria->nama }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($normalisasi as $row)
                        <tr>
                            <td class="border px-4 py-2 text-center">{{ $row['id'] }}</td>
                            <td class="border px-4 py-2">{{ $row['judul'] }}</td>
                            @foreach ($kriterias as $kriteria)
                                <td class="border px-4 py-2 text-right">{{ number_format($row[$kriteria->nama], 4) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Tabel Normalisasi Bobot --}}
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-blue-100 mt-10">
            <h3 class="text-lg font-bold text-blue-700 mb-4">Tabel Normalisasi Bobot</h3>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full text-sm text-gray-800 table-auto">
                    <thead class="bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800 font-semibold text-sm uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-3 border">ID</th>
                            <th class="px-4 py-3 border">Judul</th>
                            @foreach ($kriterias as $kriteria)
                                <th class="px-4 py-3 border">{{ $kriteria->nama }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($normalisasi_bobot as $row)
                        <tr>
                            <td class="border px-4 py-2 text-center">{{ $row['id'] }}</td>
                            <td class="border px-4 py-2">{{ $row['judul'] }}</td>
                            @foreach ($kriterias as $kriteria)
                                <td class="border px-4 py-2 text-right">{{ number_format($row[$kriteria->nama], 4) }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> -->

        {{-- Tabel Hasil Perangkingan --}}

        <div class="bg-white p-8 rounded-2xl shadow-xl border border-blue-100 transition-all duration-300 hover:shadow-2xl">
            <h3 class="text-xl font-bold text-blue-700 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 16h6" />
                </svg>
                Hasil Perangkingan Alternatif – Metode VIKOR
            </h3>

            @if ($items->count())
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full text-sm text-gray-800 table-auto">
                    <thead class="bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800 font-semibold text-sm uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-3 border">ID</th>
                            <th class="px-4 py-3 border text-left">Judul</th>
                            <th class="px-4 py-3 border text-right">S</th>
                            <th class="px-4 py-3 border text-right">R</th>
                            <th class="px-4 py-3 border text-right">Q</th>
                            <th class="px-4 py-3 border text-center">Ranking</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($items as $item)
                        <tr class="hover:bg-blue-50 transition duration-200">
                            <td class="border px-4 py-2 text-center">{{ $item->alternatif_id }}</td>
                            <td class="border px-4 py-2 font-medium text-gray-900">{{ $item->judul }}</td>
                            <td class="border px-4 py-2 text-right text-gray-700">{{ number_format($item->S, 4) }}</td>
                            <td class="border px-4 py-2 text-right text-gray-700">{{ number_format($item->R, 4) }}</td>
                            <td class="border px-4 py-2 text-right text-blue-700 font-semibold">{{ number_format($item->Q, 4) }}</td>
                            <td class="border px-4 py-2 text-center">
                                <span class="inline-block bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                    #{{ $item->rank }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginasi --}}
            <div class="mt-6">
                {{ $items->links() }}
            </div>
            @else
            <div class="text-center text-gray-500 text-sm">
                Belum ada hasil perangkingan disimpan.
            </div>
            @endif
        </div>

        {{-- Tombol kembali --}}
        @php
        $userRole = Auth::user()->role;
        @endphp

        @if ($userRole === 'admin')
        <div class="text-center">
            <a href="{{ route('alternatif.index') }}"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow transition duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Data Alternatif
            </a>
        </div>
        @endif


    </div>

    <style>
        @keyframes fade-in {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out both;
        }
    </style>
</x-app-layout>