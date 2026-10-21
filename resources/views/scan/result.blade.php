<x-app-layout>
    <x-slot name="header"><h2>Absensi</h2></x-slot>

    <div class="card" style="max-width:420px;margin:0 auto;text-align:center;">
        @if($success)
            <div style="width:56px;height:56px;border-radius:50%;background:#E3EBE0;color:var(--success);
                display:flex;align-items:center;justify-content:center;font-size:26px;margin:0 auto 14px;">
                &#10003;
            </div>
            <p style="font-size:16px;font-weight:700;color:var(--primary-dark);margin:0 0 6px;">
                {{ $message }}
            </p>
            <p style="font-size:12.5px;color:var(--muted);margin:0;">
                Lokasi: <strong style="color:var(--primary-dark);">{{ $lokasi }}</strong><br>
                Waktu: <strong style="color:var(--primary-dark);">{{ $waktu }}</strong>
            </p>
        @else
            <div style="width:56px;height:56px;border-radius:50%;background:#F5DEDA;color:var(--danger);
                display:flex;align-items:center;justify-content:center;font-size:26px;margin:0 auto 14px;">
                &#10007;
            </div>
            <p style="font-size:16px;font-weight:700;color:var(--danger);margin:0 0 6px;">
                {{ $message }}
            </p>
        @endif

        <p style="margin-top:18px;">
            <a href="{{ route('siswa.dashboard') }}" style="font-size:12.5px;color:var(--secondary);">
                &larr; Kembali ke Dashboard
            </a>
        </p>
    </div>
</x-app-layout>
