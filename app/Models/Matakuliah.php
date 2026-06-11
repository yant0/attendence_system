<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matakuliah extends Model
{
    protected $table = 'matakuliah';

    protected $fillable = [
        'dosen_id',
        'kode_matakuliah',
        'nama_matakuliah',
        'kelas',
        'sks',
        'nilai',
        'jadwal',
        'ruang',
        'status',
    ];

    protected $casts = [
        'jadwal' => 'datetime:H:i',
    ];

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function qrSessions(): HasMany
    {
        return $this->hasMany(QRSession::class, 'matakuliah_id');
    }

    public function izins(): HasMany
    {
        return $this->hasMany(Izin::class, 'kode_matakuliah', 'kode_matakuliah');
    }
}
