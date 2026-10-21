<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrToken;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrDisplayController extends Controller
{
    public function show(QrToken $qrToken)
    {
        // Halaman ini TETAP bisa dibuka admin walau token sudah nonaktif/kadaluarsa,
        // supaya admin bisa melihat status dan menekan tombol "Aktifkan Kembali".
        // Validasi ketat (menolak akses) hanya berlaku saat SISWA melakukan scan,
        // bukan saat admin melihat halaman ini.
        $url = route('qr.scan', $qrToken->token);

        // Buat SVG QR sekali di sini, dipakai untuk ditampilkan DAN untuk didownload
        $svg = QrCode::size(260)->generate($url);

        $isExpired = now()->greaterThan($qrToken->valid_until);

        return view('admin.qr.display', [
            'qrToken' => $qrToken,
            'url' => $url,
            'svg' => $svg,
            'svgBase64' => base64_encode($svg),
            'isExpired' => $isExpired,
        ]);
    }
}
