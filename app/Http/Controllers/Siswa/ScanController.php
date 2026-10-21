<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\QrToken;
use App\Models\Student;

class ScanController extends Controller
{
    public function scan(string $token)
    {
        // 1) Cari token di database
        $qrToken = QrToken::where('token', $token)->first();

        // 2) Token tidak ditemukan, nonaktif, atau lokasinya nonaktif -> tolak
        if (!$qrToken || !$qrToken->is_active || !$qrToken->location->is_active) {
            return view('scan.result', [
                'success' => false,
                'message' => 'QR sudah kadaluarsa.',
            ]);
        }

        // 3) Token bukan untuk hari ini, atau sudah lewat jam berlakunya -> tolak
        $isToday = $qrToken->date->toDateString() === today()->toDateString();
        // between() dengan $equal = true (default) berarti batas awal/akhir ikut dihitung valid
        $isWithinWindow = now()->between($qrToken->valid_from, $qrToken->valid_until);

        if (!$isToday || !$isWithinWindow) {
            return view('scan.result', [
                'success' => false,
                'message' => 'QR sudah kadaluarsa.',
            ]);
        }

        // 4) Pastikan akun yang login terhubung ke data siswa
        $student = Student::where('user_id', auth()->id())->first();

        if (!$student) {
            return view('scan.result', [
                'success' => false,
                'message' => 'Akun kamu belum terhubung dengan data siswa. Hubungi admin.',
            ]);
        }

        // 5) Cegah absen dua kali di hari yang sama
        $sudahAbsen = Attendance::where('student_id', $student->id)
            ->whereDate('attendance_date', today())
            ->exists();

        if ($sudahAbsen) {
            return view('scan.result', [
                'success' => false,
                'message' => 'Kamu sudah absen hari ini.',
            ]);
        }

        // 6) Semua valid -> catat absensi
        Attendance::create([
            'student_id' => $student->id,
            'qr_location_id' => $qrToken->qr_location_id,
            'qr_token_id' => $qrToken->id,
            'attendance_date' => today(),
            'attendance_time' => now()->format('H:i:s'),
            'status' => 'hadir',
        ]);

        return view('scan.result', [
            'success' => true,
            'message' => 'Kamu berhasil absen!',
            'lokasi' => $qrToken->location->name,
            'waktu' => now()->format('H:i:s'),
        ]);
    }
}
