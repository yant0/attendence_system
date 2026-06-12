<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Izin;
use App\Models\Matakuliah;
use Carbon\Carbon;

class IzinController extends Controller
{
    public function index()
    {
        $izins = Izin::with('matakuliah')
            ->where('mahasiswa_id', Auth::id())
            ->latest()
            ->get();

        $matakuliahs = Matakuliah::where('status', 'Aktif')
            ->orderBy('nama_matakuliah')
            ->get();

        $izinJson = $izins->map(function ($i) {
            return [
                'id'       => $i->id,
                'mk'       => $i->matakuliah->nama_matakuliah ?? $i->kode_matakuliah ?? '-',
                'jenis'    => $i->jenis,
                'tgl'      => $i->tanggal ? Carbon::parse($i->tanggal)->format('Y-m-d') : '-',
                'ket'      => $i->keterangan,
                'status'   => $i->status,
                'catatan'  => $i->catatan_dosen ?? '',
                'diajukan' => $i->created_at ? Carbon::parse($i->created_at)->format('Y-m-d') : '-',
            ];
        });

        return view('mahasiswa.izin', compact('izins', 'matakuliahs', 'izinJson'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis'           => 'required|in:Sakit,Izin Keluarga,Kegiatan Kampus,Lainnya',
            'kode_matakuliah' => 'required|string|exists:matakuliah,kode_matakuliah',
            'tanggal'         => 'required|date',
            'keterangan'      => 'required|string|max:1000',
            'lampiran'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('izin_lampiran', 'public');
        }

        Izin::create([
            'mahasiswa_id'    => Auth::id(),
            'kode_matakuliah' => $request->kode_matakuliah,
            'jenis'           => $request->jenis,
            'tanggal'         => $request->tanggal,
            'keterangan'      => $request->keterangan,
            'lampiran'        => $lampiranPath,
            'status'          => 'Menunggu',
        ]);

        return redirect()->route('mahasiswa.izin.index')
            ->with('success', 'Pengajuan izin berhasil dikirim! Menunggu persetujuan dosen.');
    }

    public function destroy(Izin $izin)
    {
        // Hanya boleh batalkan milik sendiri dan masih Menunggu
        if ($izin->mahasiswa_id !== Auth::id()) {
            abort(403);
        }

        if ($izin->status !== 'Menunggu') {
            return redirect()->route('mahasiswa.izin.index')
                ->with('error', 'Hanya pengajuan berstatus Menunggu yang bisa dibatalkan.');
        }

        $izin->delete();

        return redirect()->route('mahasiswa.izin.index')
            ->with('success', 'Pengajuan izin berhasil dibatalkan.');
    }
    public function apiIndex()
    {
        $izins = Izin::with('matakuliah')
            ->where('mahasiswa_id', Auth::id())
            ->latest()
            ->get();

        $matakuliahs = Matakuliah::where('status', 'Aktif')
            ->orderBy('nama_matakuliah')
            ->get();

        return response()->json([
            'success' => true,
            'izins' => $izins->map(function ($i) {
                return [
                    'id' => $i->id,
                    'matakuliah' => $i->matakuliah->nama_matakuliah ?? '-',
                    'jenis' => $i->jenis,
                    'tanggal' => $i->tanggal,
                    'keterangan' => $i->keterangan,
                    'status' => $i->status,
                    'catatan' => $i->catatan_dosen,
                    'diajukan' => $i->created_at?->format('Y-m-d'),
                ];
            }),
            'matakuliah' => $matakuliahs->map(function ($mk) {
                return [
                    'kode' => $mk->kode_matakuliah,
                    'nama' => $mk->nama_matakuliah,
                    'sks' => $mk->sks,
                ];
            }),
        ]);
    }
    public function apiStore(Request $request)
    {
        $request->validate([
            'jenis' => 'required',
            'kode_matakuliah' => 'required',
            'tanggal' => 'required|date',
            'keterangan' => 'required',
        ]);

        $izin = Izin::create([
            'mahasiswa_id' => Auth::id(),
            'kode_matakuliah' => $request->kode_matakuliah,
            'jenis' => $request->jenis,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'status' => 'Menunggu',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan izin berhasil dikirim',
            'data' => $izin,
        ]);
    }
}
