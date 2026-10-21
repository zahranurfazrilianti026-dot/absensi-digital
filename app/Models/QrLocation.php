<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrLocation extends Model
{
    use HasFactory;

    // PENTING: sebelumnya properti ini tidak ada, sehingga QrLocation::create()
    // di controller akan melempar MassAssignmentException.
    protected $fillable = [
        'name',
        'code',
        'latitude',
        'longitude',
        'radius',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function tokens()
    {
        return $this->hasMany(QrToken::class, 'qr_location_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
