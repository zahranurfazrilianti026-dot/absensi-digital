<x-app-layout>
    <x-slot name="header">
        <h2>QR Code — {{ $qrToken->location->name }}</h2>
    </x-slot>

    <div class="card" style="max-width:460px;margin:0 auto;text-align:center;" id="print-area">
        <p style="font-size:12.5px;color:var(--muted);margin:0 0 4px;">Kode Lokasi</p>
        <p style="font-weight:600;color:var(--primary);margin:0 0 14px;">{{ $qrToken->location->code }}</p>

        <div style="display:inline-block;padding:16px;background:#fff;border:1px solid var(--line);border-radius:12px;">
            {!! $svg !!}
        </div>

        <p style="margin-top:14px;font-size:11px;color:var(--muted);margin-bottom:2px;">Token</p>
        <p style="font-family:monospace;font-size:11px;color:var(--primary-dark);word-break:break-all;
            background:var(--surface);border-radius:6px;padding:8px 10px;margin:0;">
            {{ $qrToken->token }}
        </p>

        <p style="margin-top:14px;">
            @if(!$qrToken->is_active)
                <span class="badge danger">Nonaktif</span>
            @elseif($isExpired)
                <span class="badge warn">Kadaluarsa</span>
            @else
                <span class="badge ok">Aktif</span>
            @endif
        </p>

        <p style="font-size:12.5px;color:var(--muted);">
            Berlaku sampai
            <strong style="color:var(--primary-dark);">{{ $qrToken->valid_until->format('d-m-Y H:i:s') }}</strong>
        </p>

        <div class="form-actions no-print" style="justify-content:center;">
            <a href="data:image/svg+xml;base64,{{ $svgBase64 }}"
                download="qr-{{ $qrToken->location->code }}-{{ substr($qrToken->token, 0, 8) }}.svg"
                class="btn btn-primary">
                Download QR
            </a>

            <button type="button" class="btn btn-outline" onclick="window.print()">
                Print
            </button>

            @if($qrToken->is_active)
                <form method="POST" action="{{ route('admin.qr-tokens.deactivate', $qrToken) }}">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="color:var(--danger);border-color:var(--danger);"
                        onclick="return confirm('Nonaktifkan QR ini sekarang?')">
                        Nonaktifkan
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('admin.qr-tokens.activate', $qrToken) }}">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="color:var(--success);border-color:var(--success);">
                        Aktifkan Kembali
                    </button>
                </form>
            @endif
        </div>

        <p style="margin-top:14px;" class="no-print">
            <a href="{{ route('admin.qr-locations.index') }}" style="font-size:12.5px;color:var(--secondary);">
                &larr; Kembali ke Lokasi QR
            </a>
        </p>
    </div>
</x-app-layout>
