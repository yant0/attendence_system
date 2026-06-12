<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\QRSession;
use App\Models\Presensi;

use Carbon\Carbon;

class ScanQRController extends Controller
{
    public function scan(string $token)
    {
        $session = QRSession::where('token', $token)
            ->where('status', 'aktif')
            ->where('expired_at', '>=', now())
            ->first();

        if (!$session) {
            return view('Presensi.gagal', [
                'message' => 'QR tidak valid atau sudah kadaluarsa.'
            ]);
        }

        return view('mahasiswa.scan_qr', [
            'qrText' => url('/mahasiswa/scan/' . $token),
        ]);
    }
    public function process(Request $request)
    {
    
        $token = $request->token;
       
        if (empty($token) && $request->filled('qr_text')) {
            $parts = explode('/', $request->qr_text);
            $token = end($parts);
        }

        $session = QRSession::where(
            'token',
            $token
        )->first();

        if (!$session) {

            return response()->json([

                'success' => false,

                'message' => 'QR tidak valid'

            ]);
        }

        if (Carbon::now()->gt($session->expired_at)) {

            return response()->json([

                'success' => false,

                'message' => 'QR expired'

            ]);
        }

        $exists = Presensi::where(
            'mahasiswa_id',
            Auth::id()
        )
            ->where(
                'qr_session_id',
                $session->id
            )
            ->exists();

        if ($exists) {

            return response()->json([

                'success' => false,

                'message' => 'Sudah absen'

            ]);
        }
        Presensi::create([

            'mahasiswa_id' => Auth::id(),

            'qr_session_id' => $session->id,

            'waktu_scan' => now(),

            'status' => 'hadir',

            // GPS mahasiswa
            'latitude' => $request->latitude,

            'longitude' => $request->longitude

        ]);

        return response()->json([

            'success' => true

        ]);
    }
}
