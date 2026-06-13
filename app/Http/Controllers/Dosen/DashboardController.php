<?php

namespace App\Http\Controllers\Dosen;

use Carbon\Carbon;
use App\Models\Izin;
use App\Models\Presensi;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

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

        // 1️⃣  Attendance (Presensi)
        $presensi = Presensi::whereHas('qrSession', function ($q) use ($matakuliahs) {
                $q->whereIn('matakuliah_id', $matakuliahs->pluck('id'));
            })
            ->with(['mahasiswa.mahasiswaProfile', 'qrSession.matakuliah'])
            ->orderByDesc('created_at')
            ->take(6)
            ->get()
            ->map(function ($p) {
                return [
                    'nama'   => $p->mahasiswa?->mahasiswaProfile?->nama ?? $p->mahasiswa?->name ?? '-',
                    'nim'    => $p->mahasiswa?->mahasiswaProfile?->nim ?? '-',
                    'mk'     => $p->qrSession?->matakuliah?->nama_matakuliah ?? '-',
                    'tgl'    => Carbon::parse($p->qrSession?->tanggal)->format('Y-m-d'),
                    'waktu'  => $p->waktu_scan ? (is_string($p->waktu_scan) ? substr($p->waktu_scan,11,5) : $p->waktu_scan->format('H:i')) : '-',
                    'status' => $p->status,               // 'hadir' | 'alpha'
                ];
            });
        // 2️⃣  Permission requests (Izin)
        $izin = Izin::with(['mahasiswa.mahasiswaProfile', 'matakuliah'])
            ->whereIn('kode_matakuliah', $matakuliahs->pluck('kode_matakuliah'))
            ->orderByDesc('created_at')
            ->take(6)
            ->get()
            ->map(function ($i) {
                return [
                    'nama'   => $i->mahasiswa?->mahasiswaProfile?->nama ?? $i->mahasiswa?->name ?? '-',
                    'nim'    => $i->mahasiswa?->mahasiswaProfile?->nim ?? '-',
                    'mk'     => $i->matakuliah?->nama_matakuliah ?? '-',
                    'tgl'    => Carbon::parse($i->tanggal)->format('Y-m-d'),
                    'waktu'  => $i->created_at->format('H:i'),
                    'status' => 'izin',
                ];
            });

        // 3️⃣  Merge, sort by date, keep the newest 6 rows
        $recentPresensis = $presensi->merge($izin)
            ->sortByDesc('waktu')
            ->take(6)
            ->values();   // reset numeric keys

        $totalStudents = Mahasiswa::count();
        $today = Carbon::today();

        $qrCounts = Matakuliah::where('dosen_id', Auth::id())
            ->where('status', 'Aktif')
            ->orderBy('nama_matakuliah')
            ->get()
            ->map(function ($mk) use ($today) {
                return $mk->qrSessions()
                    ->whereDate('tanggal', $today->toDateString())
                    ->count();
            })
            ->sum();

        return view('dosen.dashboard', [
            'qrCounts' => $qrCounts,
            'schedules' => $schedules,
            'mkProgress' => $mkProgress,
            'matakuliahs' => $matakuliahs,
            'totalStudents' => $totalStudents,
            'totalAttendance' => $totalAttendance,
            'recentPresensis' => $recentPresensis,
            'totalMatakuliah' => $matakuliahs->count(),
        ]);
    }

    private function getColorByHash($id)
    {
        $colors = ['#800020', '#0d6efd', '#198754', '#fd7e14', '#dc3545', '#6f42c1'];
        return $colors[$id % count($colors)];
    }
}
