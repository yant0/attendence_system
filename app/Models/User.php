<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function mahasiswaProfile(): HasOne
    {
        return $this->hasOne(Mahasiswa::class, 'user_id');
    }

    public function presensis(): HasMany
    {
        return $this->hasMany(Presensi::class, 'mahasiswa_id');
    }

    public function izinsAsMahasiswa(): HasMany
    {
        return $this->hasMany(Izin::class, 'mahasiswa_id');
    }

    public function izinsAsDosen(): HasMany
    {
        return $this->hasMany(Izin::class, 'dosen_id');
    }

    public function matakuliahs(): HasMany
    {
        return $this->hasMany(Matakuliah::class, 'dosen_id');
    }

    public function getNimAttribute(): ?string
    {
        return $this->mahasiswaProfile?->nim;
    }

    public function getNamaAttribute(): string
    {
        return $this->mahasiswaProfile?->nama ?? $this->name;
    }
}
