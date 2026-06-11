<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinController extends Controller
{
    public function index()
    {
        $kodeMatakuliah = Matakuliah::where('dosen_id', Auth::id())
            ->pluck('kode_matakuliah');

        $izins = Izin::with(['mahasiswa.mahasiswaProfile', 'matakuliah'])
            ->whereIn('kode_matakuliah', $kodeMatakuliah)
            ->latest()
            ->get();

        $matakuliahs = Matakuliah::where('dosen_id', Auth::id())
            ->where('status', 'Aktif')
            ->orderBy('nama_matakuliah')
            ->get();

        $izinJson = $izins->map(fn ($i) => $this->formatIzin($i));

        return view('dosen.izin_mahasiswa', compact('izins', 'matakuliahs', 'izinJson'));
    }

    public function approve(Request $request, Izin $izin)
    {
        $this->authorizeDosenIzin($izin);

        if ($izin->status !== 'Menunggu') {
            return back()->with('error', 'Hanya pengajuan berstatus Menunggu yang bisa diproses.');
        }

        $request->validate([
            'catatan_dosen' => 'nullable|string|max:1000',
        ]);

        $izin->update([
            'status'        => 'Disetujui',
            'dosen_id'      => Auth::id(),
            'catatan_dosen' => $request->input('catatan_dosen') ?: 'Izin disetujui.',
            'reviewed_at'   => now(),
        ]);

        return redirect()->route('dosen.izin.index')
            ->with('success', 'Pengajuan izin berhasil disetujui.');
    }

    public function reject(Request $request, Izin $izin)
    {
        $this->authorizeDosenIzin($izin);

        if ($izin->status !== 'Menunggu') {
            return back()->with('error', 'Hanya pengajuan berstatus Menunggu yang bisa diproses.');
        }

        $request->validate([
            'catatan_dosen' => 'required|string|max:1000',
        ], [
            'catatan_dosen.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $izin->update([
            'status'        => 'Ditolak',
            'dosen_id'      => Auth::id(),
            'catatan_dosen' => $request->catatan_dosen,
            'reviewed_at'   => now(),
        ]);

        return redirect()->route('dosen.izin.index')
            ->with('success', 'Pengajuan izin berhasil ditolak.');
    }

    private function authorizeDosenIzin(Izin $izin): void
    {
        $ownsMatakuliah = Matakuliah::where('dosen_id', Auth::id())
            ->where('kode_matakuliah', $izin->kode_matakuliah)
            ->exists();

        if (! $ownsMatakuliah) {
            abort(403, 'Anda tidak berhak memproses izin untuk mata kuliah ini.');
        }
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
            'tgl'      => $izin->tanggal?->format('Y-m-d') ?? '-',
            'ket'      => $izin->keterangan,
            'status'   => $izin->status,
            'catatan'  => $izin->catatan_dosen ?? '',
            'diajukan' => $izin->created_at?->format('Y-m-d') ?? '-',
            'lampiran' => $izin->lampiran ? asset('storage/' . $izin->lampiran) : null,
        ];
    }
}
