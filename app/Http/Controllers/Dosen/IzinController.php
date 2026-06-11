<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IzinController extends Controller
{
    public function index()
    {
        $matakuliahs = Matakuliah::where('dosen_id', Auth::id())
            ->orderBy('nama_matakuliah')
            ->get();

        $kodeMatakuliah = $matakuliahs->pluck('kode_matakuliah');

        $izins = Izin::with(['mahasiswa.mahasiswaProfile', 'matakuliah'])
            ->whereIn('kode_matakuliah', $kodeMatakuliah)
            ->latest()
            ->get()
            ->map(fn($i) => $this->formatIzin($i));

        $izinJson = $izins;

        return view('dosen.izin_mahasiswa', [
            'izins' => $izins,
            'izinJson' => $izinJson,
            'matakuliahs' => $matakuliahs,
        ]);
    }

    public function approve(Request $request, Izin $izin)
    {
        $izin->update([
            'status' => 'Disetujui',
            'catatan_dosen' => $request->catatan,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Izin mahasiswa disetujui');
    }

    public function reject(Request $request, Izin $izin)
    {
        $izin->update([
            'status' => 'Ditolak',
            'catatan_dosen' => $request->catatan,
            'reviewed_at' => now(),
        ]);

        return back()->with('error', 'Izin mahasiswa ditolak');
    }

    private function formatIzin(Izin $izin): array
    {
        $profile = $izin->mahasiswa?->mahasiswaProfile;

        return [
            'id'       => $izin->id,
            'nim'      => $profile?->nim ?? '-',
            'nama'     => $profile?->nama ?? $izin->mahasiswa?->name ?? '-',
            'mk'       => $izin->matakuliah?->nama_matakuliah ?? $izin->kode_matakuliah,
            'jenis'    => $izin->jenis,
            'tgl'      => $izin->tanggal ? Carbon::parse($izin->tanggal)->format('Y-m-d') : '-',
            'ket'      => $izin->keterangan,
            'status'   => $izin->status,
            'catatan'  => $izin->catatan_dosen ?? '',
            'diajukan' => $izin->created_at ? Carbon::parse($izin->created_at)->format('Y-m-d') : '-',
            'lampiran' => $izin->lampiran ? asset('storage/' . $izin->lampiran) : null,
        ];
    }
}
