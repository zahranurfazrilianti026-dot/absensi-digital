<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QrToken;
use App\Helpers\GeoHelper;

class AttendanceController extends Controller
{
    public function scan(Request $request)
    {
        // 1. Validasi input request (QR Token + Koordinat GPS)
        $request->validate([
            'qr_token'  => ['required', 'string'],
            'latitude'  => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $user = $request->user();
        $student = $user->student;

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Akun belum terhubung dengan data siswa.'
            ], 422);
        }

        // 2. Cari QR Token yang aktif dan sesuai tanggal/jam hari ini
        $qrToken = QrToken::with('location')
            ->where('token', $request->qr_token)
            ->where('is_active', true)
            ->whereDate('date', today())
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->first();

        if (!$qrToken) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid atau sudah kedaluwarsa.'
            ], 422);
        }

        $location = $qrToken->location;

        if (!$location || !$location->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi QR tidak aktif.'
            ], 422);
        }

        // 3. Hitung jarak siswa dengan lokasi QR menggunakan GeoHelper (Haversine)
        $distance = GeoHelper::distance(
            (float) $request->latitude,
            (float) $request->longitude,
            (float) $location->latitude,
            (float) $location->longitude
        );

        // 4. Validasi apakah jarak siswa masih dalam Radius lokasi QR
        if ($distance > $location->radius) {
            return response()->json([
                'success' => false,
                'message' => 'Anda berada di luar radius lokasi absensi.',
                'data'    => [
                    'distance' => round($distance, 2),
                    'radius'   => $location->radius,
                    'location' => $location->name,
                ]
            ], 422);
        }

        // 5. Jika QR valid & GPS siswa masuk dalam radius
        return response()->json([
            'success' => true,
            'message' => 'QR dan lokasi valid.',
            'data'    => [
                'student' => [
                    'id'   => $student->id,
                    'nis'  => $student->nis,
                    'name' => $student->full_name,
                ],
                'location' => [
                    'name'      => $location->name,
                    'latitude'  => $location->latitude,
                    'longitude' => $location->longitude,
                    'radius'    => $location->radius,
                    'gps'       => [
                        'latitude'  => $request->latitude,
                        'longitude' => $request->longitude,
                        'distance'  => round($distance, 2),
                    ]
                ]
            ]
        ]);
    }
}