{{--
    resources/views/layouts/navigation.blade.php

    Ini SATU-SATUNYA navbar/navigasi aplikasi (bentuk sidebar).
    File ini di-include otomatis oleh components/app-layout.blade.php,
    jadi kamu TIDAK perlu memanggil atau menulis ulang ini di
    dashboard.blade.php, data-kelas.blade.php, dsb.
--}}
<div x-data="{ mobileOpen: false }">

    {{-- Tombol buka sidebar khusus mobile --}}
    <button
        @click="mobileOpen = !mobileOpen"
        class="md:hidden fixed top-4 left-4 z-50 bg-[#0D1F17] text-white p-2 rounded-lg shadow-lg"
    >
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    {{-- Overlay gelap saat sidebar dibuka di mobile --}}
    <div
        x-show="mobileOpen"
        x-transition.opacity
        @click="mobileOpen = false"
        style="display: none;"
        class="fixed inset-0 bg-black/40 z-30 md:hidden"
    ></div>

    <aside
        class="w-72 bg-[#0D1F17] min-h-screen flex flex-col justify-between px-5 py-6 shrink-0
               fixed md:static top-0 left-0 z-40 transition-transform duration-200"
        :class="mobileOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
    >
        <div>
            {{-- Brand --}}
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 mb-10 px-2">
                <div class="w-11 h-11 rounded-xl bg-[#264132] flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#8B9A86]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0121 12.5c0 2.21-1.79 4-4 4s-4-1.79-4-4c0-.462.079-.906.223-1.32M12 14v7m0-7L5.84 10.578A12.083 12.083 0 003 12.5c0 2.21 1.79 4 4 4s4-1.79 4-4" />
                    </svg>
                </div>
                <div>
                    <p class="text-white font-bold leading-tight">AbsensiKu</p>
                    <p class="text-[#8B9A86] text-xs">SMK Negeri 1 Maja</p>
                </div>
            </a>

            {{-- Menu --}}
            <nav class="flex flex-col gap-1">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition
                        {{ request()->routeIs('dashboard')
                            ? 'bg-[#264132] text-white'
                            : 'text-[#8B9A86] hover:bg-[#1a2e22] hover:text-white' }}">
                    <span class="w-5 h-5 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="12" cy="12" r="9" stroke-width="1.5" />
                        </svg>
                    </span>
                    Dashboard
                </a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.classes.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition
                            {{ request()->routeIs('admin.classes.*')
                                ? 'bg-[#264132] text-white'
                                : 'text-[#8B9A86] hover:bg-[#1a2e22] hover:text-white' }}">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle cx="12" cy="12" r="9" stroke-width="1.5" />
                            </svg>
                        </span>
                        Data Kelas
                    </a>

                    <a href="{{ route('admin.students.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition
                            {{ request()->routeIs('admin.students.*')
                                ? 'bg-[#264132] text-white'
                                : 'text-[#8B9A86] hover:bg-[#1a2e22] hover:text-white' }}">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle cx="12" cy="12" r="9" stroke-width="1.5" />
                            </svg>
                        </span>
                        Data Siswa
                    </a>

                    <a href="{{ route('admin.qr-locations.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition
                            {{ request()->routeIs('admin.qr-locations.*')
                                ? 'bg-[#264132] text-white'
                                : 'text-[#8B9A86] hover:bg-[#1a2e22] hover:text-white' }}">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle cx="12" cy="12" r="9" stroke-width="1.5" />
                            </svg>
                        </span>
                        Lokasi QR
                    </a>
                @endif
            </nav>
        </div>

        {{-- User info + logout --}}
        <div class="px-2">
            <div class="flex items-center gap-3 mb-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=264132&color=E3E3DE"
                     class="w-9 h-9 rounded-full" alt="{{ Auth::user()->name }}">
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                    <a href="{{ route('profile.edit') }}" class="text-xs text-[#8B9A86] hover:text-white">Profil</a>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left text-xs font-medium text-[#8B9A86] hover:text-white px-2">
                    Keluar
                </button>
            </form>
            <p class="text-[#5F6B53] text-xs leading-relaxed mt-4">
                Absensi Digital<br>Untuk Masa Depan Yang Lebih Baik
            </p>
        </div>
    </aside>
</div>