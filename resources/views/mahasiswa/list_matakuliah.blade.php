<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mata Kuliah Saya - Ambasen</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    :root { --maroon:#800020; --maroon-dark:#5a0016; --gray-bg:#f4f6f9; --nav-h:65px; }
    body { font-family:'Segoe UI', sans-serif; background:var(--gray-bg); padding-bottom:var(--nav-h); }
    .top-header { background:linear-gradient(135deg,var(--maroon-dark),var(--maroon)); padding:1rem 1.2rem 1.4rem; color:#fff; }
    .back-btn { width:36px; height:36px; border-radius:50%; background:rgba(255,255,255,.15); color:#fff; display:flex; align-items:center; justify-content:center; text-decoration:none; }
    .stats-strip { display:flex; gap:.8rem; background:rgba(255,255,255,.12); border-radius:12px; padding:.8rem 1rem; margin-top:.8rem; }
    .stat-item { flex:1; text-align:center; }
    .stat-item .val { color:#ffd700; font-weight:700; font-size:1.2rem; }
    .stat-item .lbl { color:rgba(255,255,255,.7); font-size:.68rem; }
    .mk-card { background:#fff; border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,.07); overflow:hidden; }
    .mk-card-header { padding:1.1rem 1.2rem .8rem; border-left:4px solid var(--maroon); }
    .mk-tag { font-size:.72rem; padding:.2rem .55rem; border-radius:20px; background:var(--gray-bg); color:#555; display:inline-flex; align-items:center; gap:.25rem; margin:.15rem; }
    .bottom-nav { position:fixed; bottom:0; left:0; right:0; height:var(--nav-h); background:#fff; border-top:1px solid #eee; display:flex; z-index:1000; box-shadow:0 -4px 16px rgba(0,0,0,.07); }
    .nav-item-btn { flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; border:none; background:none; color:#aaa; cursor:pointer; font-size:.65rem; font-weight:600; gap:.2rem; transition:color .2s; text-decoration:none; padding:0; }
    .nav-item-btn i { font-size:1.3rem; }
    .nav-item-btn.active { color:var(--maroon); }
    .nav-item-btn.active i { position:relative; }
    .nav-item-btn.active i::after { content:''; position:absolute; bottom:-4px; left:50%; transform:translateX(-50%); width:4px; height:4px; border-radius:50%; background:var(--maroon); }
    .nav-fab { flex:1; display:flex; align-items:center; justify-content:center; border:none; background:none; cursor:pointer; text-decoration:none; }
    .fab { width:54px; height:54px; background:linear-gradient(135deg,var(--maroon-dark),#c0003a); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.5rem; box-shadow:0 4px 16px rgba(128,0,32,.35); margin-top:-20px; border:3px solid #fff; }
  </style>
</head>
<body>
@php
  $totalMk = $matakuliahs->count();
  $totalSks = $matakuliahs->sum('sks');
  $totalSesi = $matakuliahs->sum(fn($mk) => $mk->qrSessions->count());
  $totalHadir = $matakuliahs->sum(fn($mk) => $mk->qrSessions->sum(fn($session) => $session->presensis->where('status', 'hadir')->count()));
  $persen = $totalSesi > 0 ? round(($totalHadir / $totalSesi) * 100) : 0;
@endphp

<div class="top-header">
  <div class="d-flex align-items-center justify-content-between mb-2">
    <div class="d-flex align-items-center gap-2">
      <a href="/mahasiswa/dashboard" class="back-btn"><i class="bi bi-arrow-left"></i></a>
      <div>
        <div class="fw-bold">Mata Kuliah Saya</div>
        <small class="text-white-50">{{ auth()->user()->mahasiswaProfile->nim ?? auth()->user()->email }}</small>
      </div>
    </div>
    <span class="badge rounded-pill" style="background:rgba(255,255,255,.15);">{{ $totalMk }} MK</span>
  </div>
  <div class="stats-strip">
    <div class="stat-item"><div class="val">{{ $totalMk }}</div><div class="lbl">Mata Kuliah</div></div>
    <div class="stat-item"><div class="val">{{ $totalSks }}</div><div class="lbl">SKS</div></div>
    <div class="stat-item"><div class="val">{{ $persen }}%</div><div class="lbl">Hadir</div></div>
    <div class="stat-item"><div class="val">{{ $totalSesi }}</div><div class="lbl">Sesi QR</div></div>
  </div>
</div>

<div class="p-3 d-flex flex-column gap-3" style="max-width:640px;margin:auto;">
  @forelse($matakuliahs as $matakuliah)
    @php
      $sessions = $matakuliah->qrSessions;
      $hadir = $sessions->sum(fn($session) => $session->presensis->where('status', 'hadir')->count());
      $total = $sessions->count();
      $pct = $total > 0 ? round(($hadir / $total) * 100) : 0;
      $bar = $pct >= 80 ? '#198754' : ($pct >= 60 ? '#fd7e14' : '#dc3545');
    @endphp
    <div class="mk-card">
      <div class="mk-card-header">
        <div class="small fw-bold text-uppercase" style="color:var(--maroon);">{{ $matakuliah->kode_matakuliah }}</div>
        <div class="fw-bold">{{ $matakuliah->nama_matakuliah }}</div>
        <small class="text-muted"><i class="bi bi-person-fill me-1"></i>{{ $matakuliah->dosen->name ?? 'Dosen' }}</small>
      </div>
      <div class="px-3 pb-2">
        <span class="mk-tag"><i class="bi bi-award"></i>{{ $matakuliah->sks }} SKS</span>
        <span class="mk-tag"><i class="bi bi-people"></i>Kelas {{ $matakuliah->kelas ?? '-' }}</span>
        <span class="mk-tag"><i class="bi bi-clock"></i>{{ optional($matakuliah->jadwal)->format('H:i') ?? '-' }}</span>
        <span class="mk-tag"><i class="bi bi-geo-alt"></i>{{ $matakuliah->ruang ?? '-' }}</span>
      </div>
      <div class="px-3 pb-3">
        <div class="d-flex justify-content-between small mb-1">
          <span class="text-muted">Presensi hadir</span>
          <strong style="color:{{ $bar }}">{{ $hadir }}/{{ $total }} ({{ $pct }}%)</strong>
        </div>
        <div class="progress" style="height:7px;">
          <div class="progress-bar" style="width:{{ $pct }}%;background:{{ $bar }};"></div>
        </div>
      </div>
      <div class="border-top px-3 py-2">
        <button class="btn btn-sm btn-light w-100 text-start" data-bs-toggle="collapse" data-bs-target="#riwayat{{ $matakuliah->id }}">
          <i class="bi bi-clock-history me-1"></i>Riwayat sesi
        </button>
        <div class="collapse mt-2" id="riwayat{{ $matakuliah->id }}">
          @forelse($sessions as $session)
            @php $presensi = $session->presensis->first(); @endphp
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom small">
              <div>
                <div class="fw-semibold">Pertemuan {{ $session->pertemuan }}</div>
                <div class="text-muted">{{ $session->tanggal }} {{ $session->waktu_mulai }}</div>
              </div>
              <span
                  @php
                      $status = $presensi->status ?? '';   // <-- fallback to an empty string
                  @endphp
                  @switch($status)
                      @case('hadir')
                          class="badge text-bg-success"
                      @case('izin')
                          class="badge text-bg-warning"
                      @case('sakit')
                          class="badge text-bg-danger"
                      @case('alpha')
                          class="badge text-bg-danger"
                      @default
                          class="badge text-bg-secondary"
                  @endswitch
                  ">
                {{ $presensi ? ucfirst($presensi->status) : 'Belum scan' }}
              </span>
            </div>
          @empty
            <div class="text-muted small py-2">Belum ada sesi QR untuk mata kuliah ini.</div>
          @endforelse
        </div>
      </div>
    </div>
  @empty
    <div class="bg-white rounded-3 shadow-sm p-4 text-center text-muted">Belum ada mata kuliah aktif.</div>
  @endforelse
</div>

<nav class="bottom-nav">
  <a href="/mahasiswa/dashboard" class="nav-item-btn">
    <i class="bi bi-house-fill"></i><span>Beranda</span>
  </a>
  <a href="/mahasiswa/list_matakuliah" class="nav-item-btn active">
    <i class="bi bi-book"></i><span>Mata Kuliah</span>
  </a>
  <a href="/mahasiswa/scan_qr" class="nav-fab">
    <div class="fab"><i class="bi bi-qr-code-scan"></i></div>
  </a>
  <a href="/mahasiswa/izin" class="nav-item-btn">
    <i class="bi bi-file-earmark-text"></i><span>Izin</span>
  </a>
  <a href="/mahasiswa/profile" class="nav-item-btn">
    <i class="bi bi-person-circle"></i><span>Profil</span>
  </a>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
