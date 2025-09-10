<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-wide flex items-center gap-2 animate-fade-in">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2M7 7a4 4 0 118 0 4 4 0 01-8 0z" />
            </svg>
            Kelola Sub Kriteria
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto space-y-10 sm:px-6 lg:px-8 bg-gradient-to-br from-blue-50 to-white min-h-screen animate-fade-in">

        @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-2 flex items-center gap-2 animate-fade-in">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
        @endif

        @foreach ($kriterias as $kriteria)
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-blue-100 space-y-6 transition-all duration-300 hover:shadow-2xl">
            <div class="flex justify-between items-center mb-2 border-b pb-2">
                <h3 class="text-xl font-bold text-blue-700 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 16h6" />
                    </svg>
                    {{ $kriteria->nama }}
                </h3>
                <span class="text-xs text-gray-600">Total Subkriteria: <span class="font-semibold text-blue-700">{{ $kriteria->subkriterias->count() }}</span></span>
            </div>

            {{-- Tabel Subkriteria --}}
            <div class="overflow-x-auto rounded-lg">
                <table class="min-w-full table-auto border border-gray-200 text-sm">
                    <thead class="bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800">
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Rentang</th>
                            <th class="border px-4 py-2">Nilai</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kriteria->subkriterias as $item)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2">
                                @if (is_null($item->batas_akhir))
                                ≥ {{ $item->batas_awal }}
                                @else
                                {{ $item->batas_awal }} - {{ $item->batas_akhir }}
                                @endif
                            </td>
                            <td class="border px-4 py-2">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                    {{ $item->nilai }}
                                </span>
                            </td>
                            <td class="border px-4 py-2 flex gap-2">
                                <a href="{{ route('subkriteria.edit', $item->id) }}"
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg shadow transition flex items-center gap-1 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6 6M3 21h6v-6l9-9a2.828 2.828 0 10-4-4l-9 9z" />
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('subkriteria.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded-lg shadow transition flex items-center gap-1 text-sm">
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
                            <td colspan="4" class="text-center py-3 text-gray-500">Belum ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Form Tambah / Edit --}}
            @php
            $isEditing = isset($editingSub) && $editingSub->kriteria_id == $kriteria->id;
            @endphp

            <form action="{{ $isEditing ? route('subkriteria.update', $editingSub->id) : route('subkriteria.store') }}"
                method="POST"
                class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
                @csrf
                @if ($isEditing)
                @method('PUT')
                @endif

                <input type="hidden" name="kriteria_id" value="{{ $kriteria->id }}">

                {{-- Batas Awal --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Batas Awal</label>
                    <input type="number" step="any" name="batas_awal"
                        value="{{ old('batas_awal', $isEditing ? $editingSub->batas_awal : '') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-400 focus:border-blue-400" required>
                </div>

                {{-- Batas Akhir --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Batas Akhir (Opsional)</label>
                    <input type="number" step="any" name="batas_akhir"
                        value="{{ old('batas_akhir', $isEditing ? $editingSub->batas_akhir : '') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-400 focus:border-blue-400">
                    <p class="text-xs text-gray-500">Kosongkan untuk ≥ batas awal</p>
                </div>

                {{-- Nilai --}}
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nilai</label>
                    <input type="number" name="nilai" min="1" max="10"
                        value="{{ old('nilai', $isEditing ? $editingSub->nilai : '') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-400 focus:border-blue-400" required>
                </div>

                {{-- Tombol --}}
                <div class="flex items-end">
                    <div class="flex gap-2">
                        @if ($isEditing)
                        <a href="{{ route('subkriteria.index') }}"
                            class="text-gray-600 hover:text-blue-600 px-3 py-2 transition">Batal</a>
                        @endif
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition flex items-center gap-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ $isEditing ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @endforeach
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