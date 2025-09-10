<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 leading-tight tracking-wide flex items-center gap-2">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2M7 7a4 4 0 118 0 4 4 0 01-8 0z"/></svg>
            Manajemen Pengguna
        </h2>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto space-y-8 bg-gradient-to-br from-blue-50 to-white min-h-screen">

        {{-- === Pesan Berhasil === --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2 animate-fade-in">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- === Form Tambah/Edit User === --}}
        <div x-data="{ open: {{ isset($editing) ? 'true' : 'false' }} }" class="bg-white p-8 rounded-2xl shadow-xl border border-blue-100">
            <button @click="open = !open"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg mb-4 shadow flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                {{ isset($editing) ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}
            </button>

            <div x-show="open" x-transition>
                <form action="{{ isset($editing) ? route('users.update', $editing->id) : route('users.store') }}"
                      method="POST"
                      class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    @csrf
                    @if(isset($editing)) @method('PUT') @endif

                    <x-input-group label="Nama" name="name" :value="old('name', $editing->name ?? '')" />
                    <x-input-group label="Email" name="email" type="email" :value="old('email', $editing->email ?? '')" />
                    <x-input-group label="Password" name="password" type="password" />

                    <div class="col-span-1">
                        <label class="block text-sm font-semibold mb-1 text-gray-700">Role</label>
                        <select name="role" class="w-full border p-2 rounded-lg focus:ring-blue-400 focus:border-blue-400">
                            <option value="user" {{ old('role', $editing->role ?? '') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $editing->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div class="md:col-span-4 text-right mt-2">
                        <a href="{{ route('users.index') }}" class="text-gray-500 mr-4 hover:text-blue-600 transition">Batal</a>
                        <button type="submit"
                                class="{{ isset($editing) ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-blue-600 hover:bg-blue-700' }} text-white px-6 py-2 rounded-lg shadow flex items-center gap-2 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            {{ isset($editing) ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- === Tabel User === --}}
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-blue-100">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3 border-b pb-3">
                <h3 class="text-lg font-bold text-blue-700 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 16h6"/></svg>
                    Daftar Pengguna
                </h3>
                <span class="text-xs text-gray-600">Total: <strong class="text-blue-700">{{ $users->total() }} Akun</strong></span>
            </div>

            <div class="overflow-x-auto rounded-lg">
            <table class="min-w-full table-auto border border-gray-200 text-sm">
                <thead class="bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800">
                    <tr>
                        <th class="border px-3 py-2">No</th>
                        <th class="border px-3 py-2">Nama</th>
                        <th class="border px-3 py-2">Email</th>
                        <th class="border px-3 py-2">Role</th>
                        <th class="border px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="border px-3 py-2">{{ $users->firstItem() + $i }}</td>
                            <td class="border px-3 py-2 font-semibold text-gray-800">{{ $user->name }}</td>
                            <td class="border px-3 py-2">{{ $user->email }}</td>
                            <td class="border px-3 py-2 text-center">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $user->role == 'admin' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="border px-3 py-2 flex gap-2">
                                <a href="{{ route('users.edit', $user->id) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-lg shadow transition flex items-center gap-1 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M9 11l6 6M3 21h6v-6l9-9a2.828 2.828 0 10-4-4l-9 9z"/></svg>
                                    Edit
                                </a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg shadow transition flex items-center gap-1 text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>

            {{-- Paginasi --}}
            <div class="mt-4">
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>

    {{-- AlpineJS --}}
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        @keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
        .animate-fade-in { animation: fade-in 0.7s; }
    </style>
</x-app-layout>
