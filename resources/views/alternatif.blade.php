<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-wide flex items-center gap-2 animate-fade-in">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2M7 7a4 4 0 118 0 4 4 0 01-8 0z" />
            </svg>
            Data Alternatif
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto space-y-8 bg-gradient-to-br from-blue-50 to-white min-h-screen animate-fade-in">

        {{-- === Pesan Berhasil === --}}
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2 animate-fade-in">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- === Form Upload Excel === --}}
        <form x-data="{ loading: false }"
            x-on:submit="loading = true"
            action="{{ route('alternatif.upload') }}"
            method="POST"
            enctype="multipart/form-data"
            class="bg-white p-8 rounded-2xl shadow-xl border border-blue-100 flex flex-col md:flex-row md:items-end gap-4 relative">
            @csrf

            <!-- Loading Spinner -->
            <div x-show="loading"
                class="absolute inset-0 bg-white/70 z-10 flex items-center justify-center rounded-2xl"
                x-transition>
                <div class="flex flex-col items-center gap-2">
                    <svg class="w-8 h-8 text-blue-600 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <p class="text-sm text-blue-600 font-semibold">Sedang mengupload... mohon tunggu</p>
                </div>
            </div>

            <div class="flex-1">
                <label class="block mb-2 text-sm font-semibold text-gray-700">Upload File Excel</label>
                <input type="file" name="file" required
                    class="block w-full border-gray-300 rounded-lg mb-2 focus:ring-blue-400 focus:border-blue-400">
            </div>

            <button type="submit"
                x-bind:disabled="loading"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow transition flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v16h16V4H4zm4 4h8v8H8V8z" />
                </svg>
                Upload
            </button>
        </form>
        {{-- === Filter Tahun & Kategori === --}}
        <form action="{{ route('alternatif.index') }}" method="GET"
            class="flex flex-wrap gap-3 items-center mb-4 bg-white p-6 rounded-2xl shadow border border-blue-100">
            <div>
                <label class="text-sm text-gray-600 font-semibold">Tahun Terbit:</label>
                <select name="tahun_terbit" class="border rounded-lg px-6 py-1 focus:ring-blue-400 focus:border-blue-400">
                    <option value="">Semua</option>
                    @foreach ($tahunList as $tahun)
                    <option value="{{ $tahun }}" {{ request('tahun_terbit') == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-600 font-semibold">Kategori:</label>
                <select name="kategori" class="border rounded-lg px-2 py-1 focus:ring-blue-400 focus:border-blue-400">
                    <option value="">Semua</option>
                    @foreach ($kategoriList as $kat)
                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>
                        {{ $kat }}
                    </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                </svg>
                Filter
            </button>
            <a href="{{ route('alternatif.index') }}" class="text-sm text-blue-700 underline ml-2">Reset</a>
        </form>

        {{-- === Form Tambah / Edit Alternatif === --}}
        <div x-data="{ open: {{ isset($editing) ? 'true' : 'false' }} }" class="bg-white p-8 rounded-2xl shadow-xl border border-blue-100">
            <button @click="open = !open"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg mb-4 shadow flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                {{ isset($editing) ? 'Edit Alternatif' : 'Tambah Alternatif Manual' }}
            </button>

            <div x-show="open" x-transition>
                <form action="{{ isset($editing) ? route('alternatif.update', $editing->id) : route('alternatif.store') }}"
                    method="POST"
                    class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @csrf
                    @if(isset($editing)) @method('PUT') @endif

                    <x-input-group label="Judul" name="judul" :value="old('judul', $editing->judul ?? '')" />
                    <x-input-group label="Pengarang" name="pengarang" :value="old('pengarang', $editing->pengarang ?? '')" />
                    <x-input-group label="Tahun Terbit" name="tahun_terbit" type="number" :value="old('tahun_terbit', $editing->tahun_terbit ?? '')" />
                    <x-input-group label="Kategori" name="kategori" :value="old('kategori', $editing->kategori ?? '')" />
                    <x-input-group label="Peminjaman" name="peminjaman" type="number" :value="old('peminjaman', $editing->peminjaman ?? '')" />
                    <x-input-group label="Koleksi Meja" name="koleksi_meja" type="number" :value="old('koleksi_meja', $editing->koleksi_meja ?? '')" />
                    <x-input-group label="Harga" name="harga" type="number" step="0.01" :value="old('harga', $editing->harga ?? '')" />

                    <div class="md:col-span-4 text-right mt-2">
                        <a href="{{ route('alternatif.index') }}" class="text-gray-500 mr-4 hover:text-blue-600 transition">Batal</a>
                        <button type="submit"
                            class="{{ isset($editing) ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-blue-600 hover:bg-blue-700' }} text-white px-6 py-2 rounded-lg shadow flex items-center gap-2 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ isset($editing) ? 'Update' : 'Simpan Manual' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- === Tabel Alternatif === --}}
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-blue-100">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3 border-b pb-3">
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <h3 class="text-lg font-bold text-blue-700 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 16h6" />
                        </svg>
                        Tabel Data Alternatif
                    </h3>
                    <span class="text-xs text-gray-600">Total Alternatif: <strong class="text-blue-700">{{ $alternatifs->total() }}</strong></span>
                </div>

                <form x-data="{ loading: false }" @submit="loading = true" action="{{ route('vikor.hitung') }}" method="POST" class="relative">
                    @csrf
                    <input type="hidden" name="tahun_terbit" value="{{ request('tahun_terbit') }}">
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">

                    <!-- Loading Spinner -->
                    <div x-show="loading"
                        class="absolute inset-0 bg-white/70 z-10 flex items-center justify-center rounded-lg"
                        x-transition>
                        <div class="flex flex-col items-center gap-2">
                            <svg class="w-6 h-6 text-green-600 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            <p class="text-sm text-green-600 font-semibold">Menghitung... mohon tunggu</p>
                        </div>
                    </div>

                    <button x-bind:disabled="loading"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow flex items-center gap-2 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Hitung Rangking
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full table-auto border border-gray-200 text-sm">
                    <thead class="bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800">
                        <tr>
                            <th class="border px-3 py-2">ID</th>
                            <th class="border px-3 py-2">Judul</th>
                            <th class="border px-3 py-2">Pengarang</th>
                            <th class="border px-3 py-2">Tahun Terbit</th>
                            <th class="border px-3 py-2">Kategori</th>
                            <th class="border px-3 py-2">Peminjaman</th>
                            <th class="border px-3 py-2">Koleksi Meja</th>
                            <th class="border px-3 py-2">Harga</th>
                            <th class="border px-3 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($alternatifs as $alt)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="border px-3 py-2">{{ $alt->id }}</td>
                            <td class="border px-3 py-2 font-semibold text-gray-800">{{ $alt->judul }}</td>
                            <td class="border px-3 py-2">{{ $alt->pengarang }}</td>
                            <td class="border px-3 py-2">{{ $alt->tahun_terbit }}</td>
                            <td class="border px-3 py-2">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">{{ $alt->kategori }}</span>
                            </td>
                            <td class="border px-3 py-2">{{ $alt->peminjaman }}</td>
                            <td class="border px-3 py-2">{{ $alt->koleksi_meja }}</td>
                            <td class="border px-3 py-2">{{ $alt->harga }}</td>
                            <td class="border px-3 py-2 flex gap-2">
                                <a href="{{ route('alternatif.edit', $alt->id) }}"
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg shadow transition flex items-center gap-1 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6 6M3 21h6v-6l9-9a2.828 2.828 0 10-4-4l-9 9z" />
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('alternatif.destroy', $alt->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg shadow transition flex items-center gap-1 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-gray-500">Belum ada data alternatif.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginasi --}}
            <div class="mt-4">
                {{ $alternatifs->withQueryString()->links() }}
            </div>
        </div>
    </div>

    {{-- AlpineJS --}}
    <script src="//unpkg.com/alpinejs" defer></script>
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