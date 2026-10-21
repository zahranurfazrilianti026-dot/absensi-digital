<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi lewat Student::create($data)
    protected $fillable = [
        'user_id',
        'nis',
        'full_name',
        'class_id',
    ];

    // Relasi: satu Student MILIK SATU ClassRoom (banyak siswa - satu kelas)
    // Kebalikan dari hasMany() di model ClassRoom
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    // Relasi: satu Student terhubung ke satu akun User (untuk login)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: satu Student punya BANYAK riwayat Attendance (absensi)
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}