<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Matakuliah;
use App\Models\Presensi;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // Get dosen's matakuliahs
        $matakuliahs = Matakuliah::where('dosen_id', $user->id)
            ->where('status', 'Aktif')
            ->orderBy('nama_matakuliah')
            ->get();

        // Calculate stats
        $totalStudents = 0;
        $totalAttendance = 0;
        foreach ($matakuliahs as $mk) {
            $presensis = Presensi::whereHas('qrSession', function ($query) use ($mk) {
                $query->where('matakuliah_id', $mk->id);
            })->get();
            $totalAttendance += $presensis->where('status', 'hadir')->count();
        }

        // Get schedule for today
        $schedules = $matakuliahs->map(function ($mk) {
            return [
                'time' => substr($mk->jadwal, 0, 5) ?? '08:00',
                'matkul' => $mk->nama_matakuliah,
                'ruang' => $mk->ruang ?? 'Ruang TBD',
                'color' => $this->getColorByHash($mk->id),
                'kode' => $mk->kode_matakuliah,
            ];
        })->sortBy('time')->values();

        // Get matakuliah progress (attendance percentage)
        $mkProgress = $matakuliahs->map(function ($mk) {
            $presensis = Presensi::whereHas('qrSession', function ($query) use ($mk) {
                $query->where('matakuliah_id', $mk->id);
            })->get();
            $hadirCount = $presensis->where('status', 'hadir')->count();
            $totalCount = $presensis->count();
            $percentage = $totalCount > 0 ? round(($hadirCount / $totalCount) * 100) : 0;

            return [
                'mk' => $mk->nama_matakuliah,
                'pct' => $percentage,
                'color' => $percentage >= 80 ? '#198754' : ($percentage >= 60 ? '#fd7e14' : '#dc3545'),
            ];
        });

        // Get recent attendance records
        $recentPresensis = Presensi::whereHas('qrSession', function ($query) use ($matakuliahs) {
            $query->whereIn('matakuliah_id', $matakuliahs->pluck('id'));
        })
            ->with(['mahasiswa.mahasiswaProfile', 'qrSession.matakuliah'])
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($p, $index) {
                $tanggal = $p->qrSession?->tanggal;
                $tanggalFormatted = $tanggal ? Carbon::parse($tanggal)->format('Y-m-d') : '-';
                
                $waktuScan = $p->waktu_scan;
                $waktuFormatted = $waktuScan ? (is_string($waktuScan) ? substr($waktuScan, 11, 5) : $waktuScan->format('H:i')) : '-';
                
                return [
                    'nama' => $p->mahasiswa?->mahasiswaProfile?->nama ?? $p->mahasiswa?->name ?? '-',
                    'nim' => $p->mahasiswa?->mahasiswaProfile?->nim ?? '-',
                    'mk' => $p->qrSession?->matakuliah?->nama_matakuliah ?? '-',
                    'tgl' => $tanggalFormatted,
                    'waktu' => $waktuFormatted,
                    'status' => $p->status,
                    'color' => $p->status === 'hadir' ? '#198754' : ($p->status === 'izin' ? '#fd7e14' : '#dc3545'),
                ];
            });

        return view('dosen.dashboard', [
            'matakuliahs' => $matakuliahs,
            'totalMatakuliah' => $matakuliahs->count(),
            'totalStudents' => $totalStudents,
            'totalAttendance' => $totalAttendance,
            'schedules' => $schedules,
            'mkProgress' => $mkProgress,
            'recentPresensis' => $recentPresensis,
        ]);
    }

    private function getColorByHash($id)
    {
        $colors = ['#800020', '#0d6efd', '#198754', '#fd7e14', '#dc3545', '#6f42c1'];
        return $colors[$id % count($colors)];
    }
}
