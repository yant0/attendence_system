<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $mahasiswa = $user->mahasiswaProfile;

        // Get attendance data for current semester
        $presensis = $user->presensis()->get();

        // Calculate attendance statistics
        $totalPertemuan = 16; // This should ideally come from the semester/course data
        $totalHadir = $presensis->where('status', 'Hadir')->count();
        $totalIzin = $presensis->where('status', 'Izin')->count();
        $totalAlpha = $presensis->where('status', 'Alpha')->count();
        $persentaseKehadiran = $totalPertemuan > 0 
            ? round(($totalHadir / $totalPertemuan) * 100, 2)
            : 0;

        // Group presences by course (if available in your data structure)
        // For now, we'll prepare empty course breakdown
        $courseBreakdown = [];

        return view('mahasiswa.profile', compact(
            'mahasiswa',
            'totalHadir',
            'totalIzin',
            'totalAlpha',
            'totalPertemuan',
            'persentaseKehadiran',
            'courseBreakdown'
        ));
    }
}
