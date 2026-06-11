<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Presensi;
use App\Models\QRSession;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Dosen
        $dosen = User::updateOrCreate(
            ['email' => 'dosen@example.com'],
            [
                'name' => 'Dr. Bambang Irawanto',
                'password' => Hash::make('password'),
                'role' => 'dosen',
            ]
        );

        // Create multiple Mahasiswa
        $mahasiswaData = [
            [
                'email' => 'mahasiswa@example.com',
                'name' => 'Andi Pratama',
                'nim' => 'M001',
                'jurusan' => 'Teknik Informatika',
                'angkatan' => 2022,
                'no_hp' => '081234567890',
            ],
            [
                'email' => 'budi@student.ac.id',
                'name' => 'Budi Santoso',
                'nim' => 'M002',
                'jurusan' => 'Teknik Informatika',
                'angkatan' => 2022,
                'no_hp' => '081345678901',
            ],
            [
                'email' => 'citra@student.ac.id',
                'name' => 'Citra Dewi',
                'nim' => 'M003',
                'jurusan' => 'Teknik Informatika',
                'angkatan' => 2022,
                'no_hp' => '081456789012',
            ],
            [
                'email' => 'dian@student.ac.id',
                'name' => 'Dian Kusuma',
                'nim' => 'M004',
                'jurusan' => 'Teknik Informatika',
                'angkatan' => 2023,
                'no_hp' => '081567890123',
            ],
            [
                'email' => 'eko@student.ac.id',
                'name' => 'Eko Wijaya',
                'nim' => 'M005',
                'jurusan' => 'Teknik Informatika',
                'angkatan' => 2023,
                'no_hp' => '081678901234',
            ],
            [
                'email' => 'fira@student.ac.id',
                'name' => 'Fira Ayunda',
                'nim' => 'M006',
                'jurusan' => 'Teknik Informatika',
                'angkatan' => 2023,
                'no_hp' => '081789012345',
            ],
        ];

        $mahasiswaUsers = [];
        foreach ($mahasiswaData as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'mahasiswa',
                ]
            );

            Mahasiswa::updateOrCreate(
                ['nim' => $data['nim']],
                [
                    'user_id' => $user->id,
                    'nama' => $data['name'],
                    'jurusan' => $data['jurusan'],
                    'angkatan' => $data['angkatan'],
                    'email' => $data['email'],
                    'no_hp' => $data['no_hp'],
                    'status' => 'Aktif',
                ]
            );

            $mahasiswaUsers[$data['nim']] = $user->id;
        }

        // Create Mata Kuliah
        $matakuliahs = [
            [
                'kode_matakuliah' => 'MK001',
                'nama_matakuliah' => 'Algoritma dan Pemrograman',
                'kelas' => 'TI-A',
                'sks' => 3,
                'jadwal' => '07:30',
                'ruang' => 'Lab K.301',
            ],
            [
                'kode_matakuliah' => 'MK002',
                'nama_matakuliah' => 'Basis Data',
                'kelas' => 'TI-B',
                'sks' => 3,
                'jadwal' => '09:30',
                'ruang' => 'R. B.202',
            ],
            [
                'kode_matakuliah' => 'MK003',
                'nama_matakuliah' => 'Rekayasa Perangkat Lunak',
                'kelas' => 'TI-A',
                'sks' => 3,
                'jadwal' => '13:00',
                'ruang' => 'R. C.101',
            ],
            [
                'kode_matakuliah' => 'MK004',
                'nama_matakuliah' => 'Jaringan Komputer',
                'kelas' => 'TI-B',
                'sks' => 3,
                'jadwal' => '15:00',
                'ruang' => 'R. D.202',
            ],
        ];

        $matakuliahModels = [];
        foreach ($matakuliahs as $matakuliah) {
            $mk = Matakuliah::updateOrCreate(
                ['kode_matakuliah' => $matakuliah['kode_matakuliah']],
                $matakuliah + [
                    'dosen_id' => $dosen->id,
                    'nilai' => 0,
                    'status' => 'Aktif',
                ]
            );
            $matakuliahModels[$matakuliah['kode_matakuliah']] = $mk->id;
        }

        // Create QR Sessions and Attendance Records
        $startDate = Carbon::now()->subWeeks(8);

        foreach ($matakuliahs as $mkData) {
            for ($pertemuan = 1; $pertemuan <= 14; $pertemuan++) {
                $tanggal = $startDate->copy()->addWeeks($pertemuan - 1);

                $qrSession = QRSession::updateOrCreate(
                    [
                        'matakuliah_id' => $matakuliahModels[$mkData['kode_matakuliah']],
                        'pertemuan' => $pertemuan,
                    ],
                    [
                        'dosen_id' => $dosen->id,
                        'kode_matakuliah' => $mkData['kode_matakuliah'],
                        'tanggal' => $tanggal->toDateString(),
                        'waktu_mulai' => Carbon::createFromTimeString($mkData['jadwal']),
                        'token' => Str::uuid(),
                        'durasi' => 3600,
                        'expired_at' => $tanggal->copy()->addHours(2),
                        'status' => 'selesai',
                        'latitude' => -6.9271 + (rand(-100, 100) / 10000),
                        'longitude' => 107.6411 + (rand(-100, 100) / 10000),
                    ]
                );

                // Create attendance records for each mahasiswa
                foreach ($mahasiswaUsers as $nim => $userId) {
                    // 80% hadir, 10% izin, 10% absen
                    $rand = rand(1, 100);
                    if ($rand <= 80) {
                        $status = 'hadir';
                    } elseif ($rand <= 90) {
                        $status = 'izin';
                    } else {
                        $status = 'absen';
                    }

                    Presensi::updateOrCreate(
                        [
                            'mahasiswa_id' => $userId,
                            'qr_session_id' => $qrSession->id,
                        ],
                        [
                            'waktu_scan' => $tanggal->copy()->addHours(rand(0, 2))->addMinutes(rand(0, 59)),
                            'status' => $status,
                            'latitude' => -6.9271 + (rand(-100, 100) / 10000),
                            'longitude' => 107.6411 + (rand(-100, 100) / 10000),
                            'distance' => rand(0, 500),
                        ]
                    );
                }
            }
        }
    }
}
