<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Absensi Digital') }}</title>

    <!-- Vite / Tailwind tetap dimuat untuk kompatibilitas komponen Breeze (modal, dropdown, dsb) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
      :root{
        --primary:#3B82F6; --primary-dark:#1E293B; --secondary:#6366F1;
        --accent:#93C5FD; --muted:#64748B; --surface:#F1F5F9; --surface-white:#FFFFFF;
        --success:#10B981; --warning:#F59E0B; --danger:#EF4444; --line:#E2E8F0;
      }
      *{box-sizing:border-box;}
      body{margin:0;font-family:-apple-system,Segoe UI,Roboto,Poppins,sans-serif;background:var(--surface);color:var(--primary-dark);}
      a{text-decoration:none;color:inherit;}

      .app{display:flex;min-height:100vh;}
      .sidebar{
        width:230px;background:var(--primary-dark);color:#fff;flex-shrink:0;
        display:flex;flex-direction:column;position:fixed;top:0;bottom:0;left:0;
        transition:transform .25s ease;z-index:40;
      }
      .sidebar .brand{padding:20px 18px;font-weight:700;font-size:14px;color:var(--accent);border-bottom:1px solid rgba(255,255,255,.08);}
      .sidebar .brand small{display:block;font-weight:400;font-size:10.5px;color:#94A3B8;margin-top:2px;}
      .nav{flex:1;padding:12px 10px;overflow-y:auto;font-size:13px;}
      .nav-item{
        display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:9px;
        color:#CBD5E1;cursor:pointer;margin-bottom:2px;
      }
      .nav-item:hover{background:#111827;color:#fff;}
      .nav-item.active{background:var(--primary);color:#fff;font-weight:600;}
      .nav-item .nav-icon{width:18px;height:18px;flex-shrink:0;}
      .sidebar .logout{padding:14px 18px;border-top:1px solid rgba(255,255,255,.08);font-size:12px;color:#94A3B8;cursor:pointer;background:none;border-left:none;border-right:none;border-bottom:none;width:100%;text-align:left;}
      .sidebar .logout:hover{color:#fff;}

      .main{flex:1;margin-left:230px;display:flex;flex-direction:column;transition:margin .25s ease;}
      .topbar{
        background:var(--surface-white);border-bottom:1px solid var(--line);
        padding:14px 24px;display:flex;align-items:center;justify-content:space-between;
        position:sticky;top:0;z-index:20;
      }
      .topbar h1, .topbar h2{margin:0;font-size:17px;font-weight:600;color:var(--primary-dark);}
      .topbar .right{display:flex;align-items:center;gap:12px;}
      .avatar{width:32px;height:32px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;color:#fff;font-size:12px;font-weight:700;}
      .hamburger{display:none;background:none;border:none;font-size:20px;color:var(--primary);cursor:pointer;}

      .content{padding:24px;}

      .card{background:var(--surface-white);border:1px solid var(--line);border-radius:13px;padding:18px;}
      .grid-4{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;}
      .stat b{display:block;font-size:24px;color:var(--primary-dark);}
      .stat span{font-size:12px;color:var(--muted);}
      .toolbar{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:14px;flex-wrap:wrap;}
      .search{background:var(--surface);border:1px solid var(--line);border-radius:8px;padding:8px 12px;font-size:12.5px;color:var(--muted);flex:1;max-width:260px;}
      .btn{border:none;border-radius:8px;padding:9px 14px;font-size:12.5px;font-weight:600;cursor:pointer;}
      .btn-primary{background:var(--primary);color:#fff;}
      .btn-primary:hover{background:#2563EB;}
      .btn-outline{background:#fff;color:var(--primary-dark);border:1px solid var(--line);}

      table{width:100%;border-collapse:collapse;font-size:13px;}
      th{text-align:left;color:var(--muted);font-weight:600;font-size:11.5px;text-transform:uppercase;letter-spacing:.3px;padding:9px 8px;border-bottom:1px solid var(--line);}
      td{padding:9px 8px;border-bottom:1px solid #F1F5F9;}
      tr:last-child td{border-bottom:none;}
      .av{width:24px;height:24px;border-radius:50%;background:var(--accent);display:inline-block;margin-right:8px;vertical-align:middle;}
      .badge{padding:3px 9px;border-radius:20px;font-size:11px;font-weight:600;}
      .badge.ok{background:#D1FAE5;color:var(--success);}
      .badge.warn{background:#FEF3C7;color:var(--warning);}
      .badge.danger{background:#FEE2E2;color:var(--danger);}
      .icon-btn{background:none;border:none;cursor:pointer;color:var(--muted);font-size:13px;padding:3px 5px;}
      .icon-btn:hover{color:var(--primary-dark);}

      .section-title{font-size:14px;font-weight:600;color:var(--primary-dark);margin:0 0 12px;}

      .empty-state{padding:32px 8px;text-align:center;color:var(--muted);font-size:13px;}
      .empty-state a{color:var(--primary);font-weight:600;}

      .field label{display:block;font-size:12.5px;font-weight:600;color:var(--primary-dark);margin:14px 0 6px;}
      .field input, .field select{
        width:100%;padding:9px 11px;border:1px solid var(--line);border-radius:8px;font-size:13px;background:var(--surface-white);
      }
      .field small{display:block;font-size:11px;color:var(--muted);margin-top:4px;}
      .field .error{display:block;font-size:11.5px;color:var(--danger);margin-top:4px;}
      .form-actions{display:flex;gap:8px;margin-top:18px;}

      .flash-success{
        background:#D1FAE5;color:var(--success);border:1px solid #A7F3D0;border-radius:8px;
        padding:10px 14px;font-size:12.5px;font-weight:500;margin-bottom:14px;
      }

      @media print{
        .sidebar, .topbar, .hamburger, .no-print{display:none !important;}
        .main{margin-left:0 !important;}
        body{background:#fff !important;}
        .content{padding:0 !important;}
        .card{border:none !important;}
      }

      @media (max-width: 860px){
        .sidebar{transform:translateX(-100%);}
        .sidebar.open{transform:translateX(0);}
        .main{margin-left:0;}
        .hamburger{display:block;}
        .grid-4{grid-template-columns:repeat(2,1fr);}
      }
    </style>
</head>
<body>

<div class="app">

    <aside class="sidebar" id="sidebar">
        <div class="brand">
            Sistem Absensi Digital
            <small>{{ auth()->user()->role === 'admin' ? 'Web Admin' : 'Portal Siswa' }}</small>
        </div>

        <nav class="nav">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Dashboard
            </a>

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    Dashboard Admin
                </a>
                <a href="{{ route('admin.classes.index') }}" class="nav-item {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                    Data Kelas
                </a>
                <a href="{{ route('admin.students.index') }}" class="nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    Data Siswa
                </a>
                <a href="{{ route('admin.qr-locations.index') }}" class="nav-item {{ request()->routeIs('admin.qr-locations.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                    Lokasi QR
                </a>
            @endif

            @if(auth()->user()->role === 'siswa')
                <a href="{{ route('siswa.dashboard') }}" class="nav-item {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Dashboard Siswa
                </a>
            @endif

            <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Profil Saya
            </a>
        </nav>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout">Keluar</button>
        </form>
    </aside>

    <div class="main">
        <div class="topbar">
            <div style="display:flex;align-items:center;gap:10px;">
                <button class="hamburger" onclick="document.getElementById('sidebar').classList.toggle('open')">&#9776;</button>
                {{ $header ?? '' }}
            </div>
            <div class="right">
                <span style="font-size:12.5px;color:var(--muted);">{{ Auth::user()->name }}</span>
                @if (Auth::user()->profile_photo_url)
                    <img src="{{ Auth::user()->profile_photo_url }}" class="avatar" style="object-fit:cover;" alt="{{ Auth::user()->name }}">
                @else
                    <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                @endif
            </div>
        </div>

        <div class="content">
            {{ $slot }}
        </div>
    </div>
</div>

</body>
</html>