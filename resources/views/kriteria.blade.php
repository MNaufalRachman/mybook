<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight tracking-wide flex items-center gap-2 animate-fade-in">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2M7 7a4 4 0 118 0 4 4 0 01-8 0z" />
            </svg>
            {{ __('Kelola Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gradient-to-br from-blue-50 to-white min-h-screen animate-fade-in">
        <div class="max-w-7xl mx-auto space-y-8 sm:px-6 lg:px-8">

            {{-- Form Tambah/Edit Kriteria --}}
            <div
                x-data="{ 
                    total: {{ $kriterias->sum('bobot') }}, 
                    inputBobot: '{{ old('bobot', $kriteria->bobot ?? 0) }}', 
                    isOverLimit() { 
                        return (parseFloat(this.total) + parseFloat(this.inputBobot || 0)) > 1; 
                    } 
                }"
                class="bg-white shadow-xl border border-blue-100 sm:rounded-2xl p-8 transition-all duration-300 hover:shadow-2xl">
                <div class="flex justify-between items-center mb-6 border-b pb-3">
                    <h3 class="text-xl font-bold text-blue-700 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        {{ isset($kriteria) ? 'Edit Kriteria' : 'Tambah Kriteria' }}
                    </h3>
                    <div class="text-right">
                        <span class="text-xs font-medium text-gray-600">Total Bobot Sementara:</span>
                        <span :class="isOverLimit() ? 'text-red-600 font-bold' : 'text-green-700 font-semibold'" class="ml-2"
                            x-text="(parseFloat(total) + parseFloat(inputBobot || 0)).toFixed(2) + ' / 1.00'">
                        </span>
                        <template x-if="isOverLimit()">
                            <p class="text-red-600 text-xs mt-1 animate-pulse">Total bobot tidak boleh melebihi 1.00</p>
                        </template>
                    </div>
                </div>

                @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-3 text-red-700 animate-fade-in">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ isset($kriteria) ? route('kriteria.update', $kriteria->id) : route('kriteria.store') }}" method="POST" class="space-y-4">
                    @csrf
                    @if (isset($kriteria))
                    @method('PUT')
                    <input type="hidden" x-init="total -= {{ $kriteria->bobot }}" />
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Nama --}}
                        <div>
                            <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1">Nama Kriteria</label>
                            <input type="text" name="nama" id="nama"
                                value="{{ old('nama', $kriteria->nama ?? '') }}"
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-400 focus:border-blue-400" required>
                        </div>

                        {{-- Bobot --}}
                        <div>
                            <label for="bobot" class="block text-sm font-semibold text-gray-700 mb-1">Bobot (0 - 1)</label>
                            <input type="number" step="0.01" name="bobot" id="bobot"
                                x-model="inputBobot"
                                value="{{ old('bobot', $kriteria->bobot ?? '') }}"
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-400 focus:border-blue-400" required>
                        </div>

                        {{-- Atribut --}}
                        <div>
                            <label for="atribut" class="block text-sm font-semibold text-gray-700 mb-1">Atribut</label>
                            <select name="atribut" id="atribut"
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-400 focus:border-blue-400" required>
                                <option value="">-- Pilih Atribut --</option>
                                <option value="benefit" {{ old('atribut', $kriteria->atribut ?? '') == 'benefit' ? 'selected' : '' }}>Benefit</option>
                                <option value="cost" {{ old('atribut', $kriteria->atribut ?? '') == 'cost' ? 'selected' : '' }}>Cost</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-2">
                        @if(isset($kriteria))
                        <a href="{{ route('kriteria.index') }}" class="mr-2 text-gray-500 hover:underline hover:text-blue-600 transition">Batal</a>
                        @endif
                        <button type="submit"
                            :disabled="isOverLimit()"
                            class="flex items-center gap-2 px-5 py-2 rounded-lg text-white bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 shadow-md transition disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ isset($kriteria) ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tabel Kriteria --}}
            <div class="bg-white shadow-xl border border-blue-100 sm:rounded-2xl p-8 transition-all duration-300 hover:shadow-2xl">
                <div class="flex justify-between items-center mb-6 border-b pb-3">
                    <h3 class="text-lg font-bold text-blue-700 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 16h6" />
                        </svg>
                        Daftar Kriteria
                    </h3>
                    <span class="text-xs text-gray-600">Total Kriteria: <span class="font-semibold text-blue-700">{{ $kriterias->count() }}</span></span>
                </div>

                @if (session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 rounded-lg p-3 text-green-700 animate-fade-in">
                    <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
                @endif

                <div class="overflow-x-auto rounded-lg">
                    <table class="min-w-full table-auto border border-gray-200 text-sm">
                        <thead>
                            <tr class="bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800">
                                <th class="border px-4 py-2 text-left">No</th>
                                <th class="border px-4 py-2 text-left">Nama</th>
                                <th class="border px-4 py-2 text-left">Bobot</th>
                                <th class="border px-4 py-2 text-left">Atribut</th>
                                <th class="border px-4 py-2 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kriterias as $index => $item)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2 font-semibold text-gray-800">{{ $item->nama }}</td>
                                <td class="border px-4 py-2 text-blue-700 font-bold">{{ $item->bobot }}</td>
                                <td class="border px-4 py-2">
                                    <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $item->atribut == 'benefit' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ ucfirst($item->atribut) }}
                                    </span>
                                </td>
                                <td class="border px-4 py-2 flex gap-2">
                                    <a href="{{ route('kriteria.edit', $item->id) }}"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg shadow transition flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6 6M3 21h6v-6l9-9a2.828 2.828 0 10-4-4l-9 9z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('kriteria.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded-lg shadow transition flex items-center gap-1">
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
                                <td colspan="5" class="text-center py-4 text-gray-500">Belum ada kriteria.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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