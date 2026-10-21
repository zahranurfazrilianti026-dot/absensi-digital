<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrLocation;
use App\Models\QrToken;
use Illuminate\Support\Str;

class QrTokenController extends Controller
{
    // Membuat token baru untuk HARI INI, untuk semua lokasi yang aktif.
    // Kalau lokasi tertentu sudah punya token hari ini, dilewati (tidak dobel).
    public function generate()
    {
        $locations = QrLocation::where('is_active', true)->get();

        $dibuat = 0;

        foreach ($locations as $location) {
            $existing = QrToken::where('qr_location_id', $location->id)
                ->whereDate('date', today())
                ->first();

            if ($existing) {
                continue;
            }

            QrToken::create([
                'qr_location_id' => $location->id,
                'token' => Str::random(64),
                'date' => today(),
                'valid_from' => now()->startOfDay(),
                'valid_until' => now()->endOfDay(),
                'is_active' => true,
            ]);

            $dibuat++;
        }

        if ($dibuat === 0) {
            return back()->with('success', 'Semua lokasi aktif sudah punya token untuk hari ini.');
        }

        return back()->with('success', "Token QR berhasil dibuat untuk {$dibuat} lokasi.");
    }

    // Menonaktifkan token tertentu secara manual
    public function deactivate(QrToken $qrToken)
    {
        $qrToken->update(['is_active' => false]);

        return back()->with('success', 'Token QR berhasil dinonaktifkan.');
    }

    // Mengaktifkan kembali token yang sebelumnya dinonaktifkan.
    // Catatan: ini TIDAK memperpanjang valid_until — kalau masa berlakunya
    // sudah lewat, token akan tetap ditolak saat discan meski is_active = true.
    public function activate(QrToken $qrToken)
    {
        $qrToken->update(['is_active' => true]);

        return back()->with('success', 'Token QR berhasil diaktifkan kembali.');
    }
}
