<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Sistem Absensi Digital</title>
    @vite('resources/css/app.css')
</head>
<body class="font-poppins bg-neutral min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-3xl bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row">

        {{-- Panel Kiri: Branding --}}
        <div class="md:w-2/5 bg-gradient-to-br from-slate-800 to-primary p-10 flex flex-col justify-center items-center text-white text-center relative">
            <div class="w-16 h-16 mb-5 bg-white/10 rounded-2xl flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4z" />
                </svg>
            </div>
            <h1 class="text-lg font-semibold mb-1">Sistem Absensi Digital</h1>
            <p class="text-slate-300 text-xs mb-4">Berbasis Web & Mobile</p>
            <p class="text-slate-400 text-xs leading-relaxed">
                Kelola absensi sekolah lebih mudah, aman dan efisien.
            </p>
        </div>

        {{-- Panel Kanan: Form Login --}}
        <div class="md:w-3/5 p-10 flex flex-col justify-center">
            <h2 class="text-xl font-semibold text-slate-800 mb-1">Login Admin</h2>
            <p class="text-slate-500 text-sm mb-6">Masuk untuk mengakses dashboard</p>

            @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-danger/10 text-danger text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <input type="text" name="email" value="{{ old('email') }}" required autofocus
                               placeholder="Username / Email"
                               class="w-full pl-9 pr-4 py-2.5 bg-neutral border border-slate-200 rounded-lg text-sm
                                      focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input type="password" name="password" required
                               placeholder="Password"
                               class="w-full pl-9 pr-4 py-2.5 bg-neutral border border-slate-200 rounded-lg text-sm
                                      focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                </div>

                {{-- Remember + Forgot --}}
                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-primary focus:ring-primary">
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-primary hover:underline">
                            Lupa password?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-primary hover:bg-blue-600 text-white text-sm font-medium py-2.5 rounded-lg
                               transition-colors duration-150 mt-2">
                    Login
                </button>
            </form>
        </div>

    </div>

</body>
</html>