<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-[#0D1F17] leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Background utama menggunakan warna paling terang dari palet --}}
    <div class="py-12 bg-[#E3E3DE] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Kartu Welcome (Menggunakan Hijau Hutan / Forest Green) --}}
            <div class="bg-[#264132] overflow-hidden shadow-lg sm:rounded-2xl mb-8">
                <div class="p-8 sm:p-10">
                    <h3 class="text-3xl font-bold text-[#E3E3DE] mb-2">
                        Selamat Datang kembali!
                    </h3>
                    <p class="text-[#8B9A86] text-lg">
                        {{ __("You're logged in and ready to go.") }}
                    </p>
                </div>
            </div>

            {{-- Grid 3 Kolom untuk Statistik/Info --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Kartu 1: Hijau Sage --}}
                <div class="bg-[#8B9A86] p-6 rounded-2xl shadow-md flex flex-col justify-center">
                    <span class="text-[#0D1F17] text-sm font-bold uppercase tracking-wider mb-2">
                        Total Siswa
                    </span>
                    <span class="text-[#0D1F17] text-4xl font-extrabold">
                        1,245
                    </span>
                </div>

                {{-- Kartu 2: Hijau Zaitun (Olive) --}}
                <div class="bg-[#5F6B53] p-6 rounded-2xl shadow-md flex flex-col justify-center">
                    <span class="text-[#E3E3DE] text-sm font-medium uppercase tracking-wider mb-2">
                        Hadir Hari Ini
                    </span>
                    <span class="text-white text-4xl font-extrabold">
                        98%
                    </span>
                </div>

                {{-- Kartu 3: Hijau Paling Gelap --}}
                <div class="bg-[#0D1F17] p-6 rounded-2xl shadow-md flex flex-col justify-center border border-[#264132]">
                    <span class="text-[#8B9A86] text-sm font-medium uppercase tracking-wider mb-2">
                        Status Sistem
                    </span>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-[#8B9A86] animate-pulse"></div>
                        <span class="text-[#E3E3DE] text-3xl font-bold">
                            Online
                        </span>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</x-app-layout>