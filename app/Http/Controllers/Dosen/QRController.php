<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Matakuliah;
use App\Models\Presensi;
use App\Models\QRSession;

class QRController extends Controller
{
    public function index()
    {
        $activeSession = $this->activeSessionQuery()
            ->with('matakuliah')
            ->first();

        $presensis = $activeSession
            ? $this->activePresensiQuery($activeSession->id)->get()
            : collect();

        $matakuliahs = Matakuliah::where('status', 'Aktif')
            ->where(function ($query) {
                $query->where('dosen_id', Auth::id())
                    ->orWhereNull('dosen_id');
            })
            ->orderBy('nama_matakuliah')
            ->get();

        return view('dosen.generate_qr', compact(
            'activeSession',
            'presensis',
            'matakuliahs'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_matakuliah' => 'required|string',
            'pertemuan' => 'required|integer|min:1|max:16',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'durasi' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
    
        $matakuliah = Matakuliah::where('kode_matakuliah', $request->kode_matakuliah)
            ->where('status', 'Aktif')
            ->where(function ($query) {
                $query->where('dosen_id', Auth::id())
                    ->orWhereNull('dosen_id');
            })
            ->firstOrFail();

        QRSession::where('dosen_id', Auth::id())
            ->where('status', 'aktif')
            ->update(['status' => 'selesai']);

        $token = Str::uuid();

        $session = QRSession::create([
            'dosen_id' => Auth::id(),
            'matakuliah_id' => $matakuliah->id,
            'kode_matakuliah' => $matakuliah->kode_matakuliah,
            'pertemuan' => $request->pertemuan,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'token' => $token,
            'durasi' => $request->durasi,
            'keterangan' => $request->keterangan,
            'expired_at' => now()->addSeconds((int) $request->durasi),
            'status' => 'aktif',
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json([
            'success' => true,
            'qr_session_id' => $session->id,
            'url' => url('/mahasiswa/scan/' . $token),
            'presensis_url' => url('/dosen/generate_qr/presensis'),
        ]);
    }

    public function presensis()
    {
        $activeSession = $this->activeSessionQuery()->first();

        $presensis = $activeSession
            ? $this->activePresensiQuery($activeSession->id)->get()
            : collect();

        return response()->json([
            'success' => true,
            'scan_count' => $presensis->count(),
            'presensis' => $presensis->map(function (Presensi $presensi) {
                return [
                    'nim' => $presensi->mahasiswa?->nim ?? '-',
                    'nama' => $presensi->mahasiswa?->nama ?? $presensi->mahasiswa?->name ?? '-',
                    'status' => ucfirst($presensi->status),
                    'latitude' => $presensi->latitude,
                    'longitude' => $presensi->longitude,
                ];
            })->values(),
        ]);
    }

    private function activeSessionQuery()
    {
        return QRSession::query()
            ->where('dosen_id', Auth::id())
            ->where('status', 'aktif')
            ->where('expired_at', '>=', now())
            ->latest();
    }

    private function activePresensiQuery(int $qrSessionId)
    {
        return Presensi::with([
                'mahasiswa.mahasiswaProfile',
                'qrSession.matakuliah',
            ])
            ->where('qr_session_id', $qrSessionId)
            ->latest('waktu_scan');
    }
}
