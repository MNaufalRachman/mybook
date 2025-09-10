<x-app-layout>
    <x-slot name="header">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-wide flex items-center gap-2 animate-fade-in">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2M7 7a4 4 0 118 0 4 4 0 01-8 0z" />
                </svg>
                Dashboard
            </h2>
    </x-slot>


    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8 bg-gradient-to-br from-blue-50 to-white min-h-screen animate-fade-in">
        <!-- Ringkasan Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <a href="{{ route('kriteria.index') }}" class="bg-gradient-to-br from-blue-100 to-blue-50 p-6 rounded-2xl shadow-xl border border-blue-100 flex flex-col items-center hover:shadow-2xl transition group">
                <div class="text-4xl mb-2 group-hover:scale-110 transition">📚</div>
                <div class="text-sm text-gray-500 font-semibold">Total Kriteria</div>
                <div class="text-3xl font-bold text-blue-700 mt-1">{{ $totalKriteria }}</div>
            </a>
            <a href="{{ route('subkriteria.index') }}" class="bg-gradient-to-br from-blue-100 to-blue-50 p-6 rounded-2xl shadow-xl border border-blue-100 flex flex-col items-center hover:shadow-2xl transition group">
                <div class="text-4xl mb-2 group-hover:scale-110 transition">🔍</div>
                <div class="text-sm text-gray-500 font-semibold">Total Sub Kriteria</div>
                <div class="text-3xl font-bold text-blue-700 mt-1">{{ $totalSubkriteria }}</div>
            </a>
            <a href="{{ route('alternatif.index') }}" class="bg-gradient-to-br from-blue-100 to-blue-50 p-6 rounded-2xl shadow-xl border border-blue-100 flex flex-col items-center hover:shadow-2xl transition group">
                <div class="text-4xl mb-2 group-hover:scale-110 transition">📖</div>
                <div class="text-sm text-gray-500 font-semibold">Total Alternatif</div>
                <div class="text-3xl font-bold text-blue-700 mt-1">{{ $totalAlternatif }}</div>
            </a>
            <a href="{{ route('hasil.buku.terminat') }}" class="bg-gradient-to-br from-yellow-100 to-yellow-50 p-6 rounded-2xl shadow-xl border border-yellow-100 flex flex-col items-center hover:shadow-2xl transition group">
                <div class="text-4xl mb-2 group-hover:scale-110 transition">🏆</div>
                <div class="text-sm text-gray-500 font-semibold">Top 1 Buku Terminat {{ $tahunAktif }}</div>
                @if($topBuku)
                <div class="font-bold mt-1 text-yellow-700 text-center">{{ $topBuku->judul }}</div>
                <div class="text-sm text-gray-600">Hasil Vikor: {{ number_format($topBuku->Q, 4) }}</div>
                @else
                <div class="text-sm text-gray-500 mt-1">Belum ada data</div>
                @endif
            </a>
        </div>

        <!-- Informasi Sistem -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <!-- Tahun Penilaian Aktif -->
            <div class="p-6 bg-white rounded-xl shadow-lg border-l-4 border-blue-500 flex items-center space-x-4">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Tahun Penilaian Aktif</div>
                    <div class="text-lg font-bold text-blue-700">{{ $tahunAktif }}</div>
                </div>
            </div>

            <!-- Metode yang Digunakan -->
            <div class="p-6 bg-white rounded-xl shadow-lg border-l-4 border-purple-500 flex items-center space-x-4">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Metode yang Digunakan</div>
                    <div class="text-lg font-bold text-purple-700">VIKOR</div>
                    <div class="text-xs text-purple-600">Compromise Ranking</div>
                </div>
            </div>

            <!-- Terakhir Dihitung -->
            <div class="p-6 bg-white rounded-xl shadow-lg border-l-4 border-green-500 flex items-center space-x-4">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Terakhir Dihitung</div>
                    <div class="text-lg font-bold text-green-700">
                        {{ $terakhirDihitung ? \Carbon\Carbon::parse($terakhirDihitung)->translatedFormat('d M Y') : 'Belum pernah dihitung' }}
                    </div>
                    @if($terakhirDihitung)
                    <div class="text-xs text-green-600">
                        Jam: {{ \Carbon\Carbon::parse($terakhirDihitung)->translatedFormat('H:i') }} WIB
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Notifikasi / Aktivitas Terakhir -->
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-blue-100">
            <h3 class="text-lg font-bold text-blue-700 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 16h6" />
                </svg>
                🆕 Aktivitas Terakhir
            </h3>
            @if($logs->count())
            <ol class="relative border-l border-blue-200 space-y-6">
                @foreach ($logs as $log)
                <li class="ml-4">
                    <div class="absolute w-3 h-3 bg-blue-400 rounded-full -left-1.5 border-2 border-white"></div>
                    <time class="mb-1 text-sm font-medium leading-none text-blue-600">{{ $log->created_at->format('d M Y H:i') }}</time>
                    <p class="text-base text-gray-700">{{ $log->aktivitas }}</p>
                </li>
                @endforeach
            </ol>
            @else
            <div class="text-center text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-sm">Belum ada aktivitas tercatat.</p>
            </div>
            @endif
        </div>

    </div>
    <style>
        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in-up 0.7s ease-out both;
        }
    </style>
</x-app-layout>