<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    // Nama class model "ClassRoom" tidak otomatis cocok dengan nama tabel "classes"
    // (karena Laravel akan menebak tabelnya "class_rooms"), jadi kita set manual
    protected $table = 'classes';

    // Kolom yang boleh diisi lewat mass-assignment, contoh: ClassRoom::create($data)
    // Kalau kolom TIDAK ada di sini, Laravel akan menolak mengisinya demi keamanan
    protected $fillable = [
        'class_name',
        'major',
    ];
    
    // Relasi: satu ClassRoom (kelas) punya BANYAK Student (siswa)
    // 'class_id' adalah foreign key di tabel students yang menunjuk ke tabel classes
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}


