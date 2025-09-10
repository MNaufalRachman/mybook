<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-wide flex items-center gap-2 animate-fade-in">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2M7 7a4 4 0 118 0 4 4 0 01-8 0z" />
            </svg>
            Hasil Buku Terminat
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10 bg-gradient-to-br from-blue-50 to-white min-h-screen animate-fade-in">

        <!-- Form Filter Jumlah Tampilkan -->
        <form method="GET" action="{{ route('hasil.buku.terminat') }}" class="mb-6 flex items-center gap-3 flex-wrap bg-white p-6 rounded-2xl shadow border border-blue-100">
            <label for="jumlah" class="font-semibold text-sm text-gray-700">Tampilkan Top Buku:</label>
            <input list="jumlah-options" name="jumlah" id="jumlah"
                placeholder="Semua" value="{{ request('jumlah') }}"
                class="border rounded-lg px-2 py-1 w-32 focus:ring-blue-400 focus:border-blue-400" />
            <datalist id="jumlah-options">
                <option value="5">
                <option value="10">
                <option value="15">
                <option value="20">
            </datalist>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow flex items-center gap-1 transition transition duration-300 transform hover:scale-105">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                </svg>
                Tampilkan
            </button>
        </form>

        <!-- Tabel Ranking Tahun Terbaru -->
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-blue-100">
            <div class="flex justify-between items-center mb-6 border-b pb-3">
                <h3 class="text-lg font-bold text-blue-700 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 16h6" />
                    </svg>
                    Ranking Buku Terminat Tahun {{ now()->year }}
                </h3>
                <a href="{{ route('hasil_buku.export_pdf', ['jumlah' => request('jumlah')]) }}"
                    class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg shadow transition transition duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Export PDF
                </a>
            </div>

            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full table-auto border border-gray-200 text-sm">
                    <thead class="bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800">
                        <tr>
                            <th class="border px-3 py-2">Ranking</th>
                            <th class="border px-3 py-2">Judul</th>
                            <th class="border px-3 py-2">Pengarang</th>
                            <th class="border px-3 py-2">Tahun Terbit</th>
                            <th class="border px-3 py-2">Kategori</th>
                            <th class="border px-3 py-2">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rankingTerbaru as $buku)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="border px-3 py-2 text-center">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">{{ $buku->rank ?? '-' }}</span>
                            </td>
                            <td class="border px-3 py-2 font-semibold text-gray-800">{{ $buku->judul }}</td>
                            <td class="border px-3 py-2">{{ $buku->pengarang }}</td>
                            <td class="border px-3 py-2 text-center">{{ $buku->tahun_terbit }}</td>
                            <td class="border px-3 py-2">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">{{ $buku->kategori }}</span>
                            </td>
                            <td class="border px-3 py-2 text-center">{{ $buku->harga }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-2 text-gray-500">Tidak ada data untuk tahun ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $rankingTerbaru->appends(request()->except('page'))->links() }}
            </div>
        </div>

        <!-- Tabel Ranking Tahun Sebelumnya -->
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-blue-100">
            <h3 class="text-lg font-bold text-blue-700 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 16h6" />
                </svg>
                Ranking Tahun {{ $tahunSebelumnya }}
            </h3>
            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full table-auto border border-gray-200 text-sm">
                    <thead class="bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800">
                        <tr>
                            <th class="border px-3 py-2">Ranking</th>
                            <th class="border px-3 py-2">Judul</th>
                            <th class="border px-3 py-2">Pengarang</th>
                            <th class="border px-3 py-2">Tahun Terbit</th>
                            <th class="border px-3 py-2">Kategori</th>
                            <th class="border px-3 py-2">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rankingSebelumnya as $buku)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="border px-3 py-2 text-center">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">{{ $buku->rank ?? '-' }}</span>
                            </td>
                            <td class="border px-3 py-2 font-semibold text-gray-800">{{ $buku->judul }}</td>
                            <td class="border px-3 py-2">{{ $buku->pengarang }}</td>
                            <td class="border px-3 py-2 text-center">{{ $buku->tahun_terbit }}</td>
                            <td class="border px-3 py-2">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">{{ $buku->kategori }}</span>
                            </td>
                            <td class="border px-3 py-2 text-center">{{ $buku->harga }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500 italic animate-fade-in">
                                📭 Tidak ada data tahun sebelumnya.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $rankingSebelumnya->appends(request()->except('page'))->links() }}
            </div>
        </div>

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