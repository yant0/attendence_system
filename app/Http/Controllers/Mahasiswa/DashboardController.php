<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\Matakuliah;
use App\Models\Presensi;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $mahasiswaProfile = $user->mahasiswaProfile;

        // Get all active matakuliahs
        $matakuliahs = Matakuliah::where('status', 'Aktif')
            ->orderBy('nama_matakuliah')
            ->get();

        // Calculate attendance stats - total across all presensi
        $userPresensis = Presensi::where('mahasiswa_id', $user->id)->get();
        $hadirCount = $userPresensis->where('status', 'Hadir')->count();
        $izinCount = $userPresensis->where('status', 'Izin')->count();
        $alphaCount = $userPresensis->where('status', 'Alpha')->count();
        $totalPresensis = $hadirCount + $izinCount + $alphaCount;
        
        $attendancePercentage = $totalPresensis > 0 
            ? round(($hadirCount / $totalPresensis) * 100) 
            : 0;

        // Get attendance per matakuliah (through QRSession)
        $mkProgress = [];
        foreach ($matakuliahs as $mk) {
            // Get presensis through QRSessions for this matakuliah
            $mkPresensis = Presensi::whereHas('qrSession', function ($query) use ($mk) {
                $query->where('matakuliah_id', $mk->id);
            })
            ->where('mahasiswa_id', $user->id)
            ->get();
            
            $mkHadir = $mkPresensis->where('status', 'Hadir')->count();
            $mkTotal = $mkPresensis->count();
            $mkPercentage = $mkTotal > 0 ? round(($mkHadir / $mkTotal) * 100) : 0;

            if ($mkTotal > 0) {
                $mkProgress[] = [
                    'nama' => $mk->nama_matakuliah,
                    'hadir' => $mkHadir,
                    'total' => $mkTotal,
                    'pct' => $mkPercentage,
                    'color' => $mkPercentage >= 80 ? '#198754' : ($mkPercentage >= 60 ? '#fd7e14' : '#dc3545'),
                ];
            }
        }

        // Get latest izin pengajuan
        $izinData = Izin::where('mahasiswa_id', $user->id)
            ->with('matakuliah')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($i) {
                return [
                    'mk' => $i->matakuliah?->nama_matakuliah ?? $i->kode_matakuliah ?? '-',
                    'tgl' => $i->tanggal?->format('d M Y') ?? '-',
                    'jenis' => $i->jenis,
                    'status' => $i->status,
                    'color' => $i->status === 'Disetujui' ? '#198754' : ($i->status === 'Ditolak' ? '#dc3545' : '#fd7e14'),
                ];
            });

        // Get latest presensi history (through qrSession)
        $riwayat = Presensi::where('mahasiswa_id', $user->id)
            ->with('qrSession.matakuliah')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($p) {
                return [
                    'mk' => $p->qrSession?->matakuliah?->nama_matakuliah ?? '-',
                    'tgl' => $p->qrSession?->tanggal?->format('d M Y') ?? '-',
                    'waktu' => $p->waktu_scan ? substr($p->waktu_scan, 0, 5) : '-',
                    'status' => $p->status,
                    'color' => $p->status === 'Hadir' ? '#198754' : ($p->status === 'Izin' ? '#fd7e14' : '#dc3545'),
                ];
            });

        return view('mahasiswa.dashboard', [
            'attendancePercentage' => $attendancePercentage,
            'hadirCount' => $hadirCount,
            'izinCount' => $izinCount,
            'alphaCount' => $alphaCount,
            'totalPresensis' => $totalPresensis,
            'totalMatakuliah' => $matakuliahs->count(),
            'totalSks' => $matakuliahs->sum('sks'),
            'mkProgress' => $mkProgress,
            'izinData' => $izinData,
            'riwayat' => $riwayat,
            'mahasiswaProfile' => $mahasiswaProfile,
        ]);
    }
}
