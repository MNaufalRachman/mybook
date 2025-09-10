<nav x-data="{ open: false }" class="bg-gradient-to-r from-blue-50 to-white border-b border-blue-200 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-4">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-blue-700" />
                    </a>
                </div>

                <!-- Navigation Links -->
@if(Auth::check())
    <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <span class="inline-flex items-center gap-1"><svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/></svg> {{ __('Dashboard') }}</span>
        </x-nav-link>
    </div>
    @if(Auth::user()->role === 'admin')
        <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('kriteria.index')" :active="request()->routeIs('kriteria*')">
                <span class="inline-flex items-center gap-1"><svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2"/></svg> {{ __('Kriteria') }}</span>
            </x-nav-link>
        </div>
        <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('subkriteria.index')" :active="request()->routeIs('subkriteria*')">
                <span class="inline-flex items-center gap-1"><svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 16h6"/></svg> {{ __('Sub Kriteria') }}</span>
            </x-nav-link>
        </div>
        <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
            <x-nav-link :href="route('alternatif.index')" :active="request()->routeIs('alternatif*')">
                <span class="inline-flex items-center gap-1"><svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> {{ __('Alternatif') }}</span>
            </x-nav-link>
        </div>
    @endif
    <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
        <x-nav-link :href="route('vikor.rangking')" :active="request()->routeIs('vikor.rangking')">
            <span class="inline-flex items-center gap-1"><svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> {{ __('Rangking') }}</span>
        </x-nav-link>
    </div>
    <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
        <x-nav-link :href="route('hasil.buku.terminat')" :active="request()->routeIs('hasil.buku.terminat')">
            <span class="inline-flex items-center gap-1"><svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z"/></svg> {{ __('Hasil Buku') }}</span>
        </x-nav-link>
    </div>
@endif
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-white hover:text-blue-900 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <div class="font-semibold flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ Auth::user()->name }}
                            </div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <span class="inline-flex items-center gap-1"><svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> {{ __('Profile') }}</span>
                        </x-dropdown-link>
                        @if(Auth::user()->role === 'admin')
                        <div class="border-t border-gray-200 my-2"></div>
                        <div class="px-4 py-1 text-xs text-blue-400 uppercase">Admin Menu</div>
                        <x-dropdown-link :href="route('users.index')">
                            <span class="inline-flex items-center gap-1"><svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2a4 4 0 014 4v2"/></svg> {{ __('Kelola User') }}</span>
                        </x-dropdown-link>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <span class="inline-flex items-center gap-1"><svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7"/></svg> {{ __('Log Out') }}</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-blue-400 hover:text-blue-600 hover:bg-blue-100 focus:outline-none focus:bg-blue-100 focus:text-blue-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <span class="inline-flex items-center gap-1"><svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/></svg> {{ __('Dashboard') }}</span>
            </x-responsive-nav-link>
        </div>
        <div class="pt-4 pb-1 border-t border-blue-200">
            <div class="px-4">
                <div class="font-medium text-base text-blue-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-blue-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <span class="inline-flex items-center gap-1"><svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> {{ __('Profile') }}</span>
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <span class="inline-flex items-center gap-1"><svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7"/></svg> {{ __('Log Out') }}</span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>