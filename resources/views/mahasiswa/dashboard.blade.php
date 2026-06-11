<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Mahasiswa – Ambasen</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <style>
    :root { --maroon: #800020; --maroon-dark: #5a0016; --gray-bg: #f4f6f9; --nav-h: 65px; }
    body { font-family: 'Segoe UI', sans-serif; background: var(--gray-bg); padding-bottom: var(--nav-h); }

    /* TOP HEADER */
    .top-header {
      background: linear-gradient(135deg, var(--maroon-dark) 0%, var(--maroon) 70%, #c0003a 100%);
      padding: 1.2rem 1.2rem .8rem;
      position: relative; overflow: hidden;
    }
    .top-header::before {
      content: ''; position: absolute; width: 200px; height: 200px; border-radius: 50%;
      background: rgba(255,255,255,0.06); top: -80px; right: -60px;
      z-index: -100;
    }
    .top-header .avatar {
      width: 50px; height: 50px; border-radius: 50%;
      background: #ffd700; display: flex; align-items: center; justify-content: center;
      font-weight: 700; color: var(--maroon-dark); font-size: 1.2rem; border: 2px solid rgba(255,255,255,0.4);
    }
    .top-header .greeting { color: rgba(255,255,255,0.8); font-size: .8rem; }
    .top-header .name     { color: #fff; font-weight: 700; font-size: 1.1rem; }
    .top-header .nim      { color: rgba(255,255,255,0.7); font-size: .75rem; }
    .notif-btn {
      width: 40px; height: 40px; border-radius: 50%;
      background: rgba(255,255,255,0.15); border: none;
      display: flex; align-items: center; justify-content: center;
      color: #fff; font-size: 1.1rem; cursor: pointer;
    }

    /* SUMMARY STRIP */
    .summary-strip {
      display: flex; gap: .7rem;
      padding: .8rem 1rem;
      background: #fff; border-bottom: 1px solid #f0f0f0;
      overflow-x: auto; -ms-overflow-style: none; scrollbar-width: none;
    }
    .summary-strip::-webkit-scrollbar { display: none; }
    .sum-pill {
      flex-shrink: 0; text-align: center;
      padding: .55rem 1rem; border-radius: 20px;
      background: var(--gray-bg);
    }
    .sum-pill .val { font-size: 1.1rem; font-weight: 700; }
    .sum-pill .lbl { font-size: .68rem; color: #888; white-space: nowrap; }

    /* SECTION CARD */
    .section-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }

    /* CIRCULAR PROGRESS */
    .circle-wrap { position: relative; width: 110px; height: 110px; }
    .circle-wrap svg { transform: rotate(-90deg); }
    .circle-wrap .pct-label {
      position: absolute; inset: 0; display: flex; flex-direction: column;
      align-items: center; justify-content: center;
    }
    .circle-wrap .pct-label .num { font-size: 1.4rem; font-weight: 700; color: #1a1a2e; line-height: 1; }
    .circle-wrap .pct-label .sub { font-size: .65rem; color: #888; }

    /* RECENT TABLE */
    .rec-item {
      display: flex; align-items: center; gap: .75rem;
      padding: .7rem 0; border-bottom: 1px solid #f5f5f5;
    }
    .rec-item:last-child { border-bottom: none; }
    .rec-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
    .rec-mk  { font-size: .88rem; font-weight: 600; color: #1a1a2e; }
    .rec-date{ font-size: .75rem; color: #888; }
    .badge-hadir { background: rgba(25,135,84,0.12); color: #198754; }
    .badge-izin  { background: rgba(253,126,20,0.12); color: #fd7e14; }
    .badge-alpha { background: rgba(220,53,69,0.12);  color: #dc3545; }

    /* IZIN CARD */
    .izin-card {
      border-radius: 12px; padding: 1rem 1.2rem;
      display: flex; align-items: center; gap: .8rem; margin-bottom: .6rem;
      box-shadow: 0 1px 6px rgba(0,0,0,0.05);
    }
    .izin-icon {
      width: 40px; height: 40px; border-radius: 10px;
      display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;
    }
    .izin-mk   { font-size: .88rem; font-weight: 600; }
    .izin-date { font-size: .75rem; color: #888; }

    /* BOTTOM NAV */
    .bottom-nav {
      position: fixed; bottom: 0; left: 0; right: 0; height: var(--nav-h);
      background: #fff; border-top: 1px solid #eee;
      display: flex; z-index: 1000;
      box-shadow: 0 -4px 16px rgba(0,0,0,0.07);
    }
    .nav-item-btn {
      flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center;
      border: none; background: none; color: #aaa; cursor: pointer;
      font-size: .65rem; font-weight: 600; gap: .2rem; transition: color .2s;
      text-decoration: none; padding: 0;
    }
    .nav-item-btn i { font-size: 1.3rem; }
    .nav-item-btn.active { color: var(--maroon); }
    .nav-item-btn.active i { position: relative; }
    .nav-item-btn.active i::after {
      content: ''; position: absolute; bottom: -4px; left: 50%; transform: translateX(-50%);
      width: 4px; height: 4px; border-radius: 50%; background: var(--maroon);
    }

    /* QR FAB button in center */
    .nav-fab {
      flex: 1; display: flex; align-items: center; justify-content: center;
      border: none; background: none; cursor: pointer; text-decoration: none;
    }
    .nav-fab .fab {
      width: 54px; height: 54px; background: linear-gradient(135deg, var(--maroon-dark), #c0003a);
      border-radius: 50%; display: flex; align-items: center; justify-content: center;
      color: #fff; font-size: 1.5rem; box-shadow: 0 4px 16px rgba(128,0,32,0.35);
      margin-top: -20px; border: 3px solid #fff;
    }

    .quick-btn {
      border: 1.5px solid #e0e0e0; background: #fff; border-radius: 12px;
      padding: .7rem .5rem; display: flex; flex-direction: column; align-items: center;
      gap: .4rem; cursor: pointer; transition: all .2s; text-decoration: none; color: #333;
    }
    .quick-btn:hover { border-color: var(--maroon); background: rgba(128,0,32,0.04); }
    .quick-btn i { font-size: 1.3rem; color: var(--maroon); }
    .quick-btn span { font-size: .72rem; font-weight: 600; text-align: center; }
  </style>
</head>
<body>

<!-- TOP HEADER -->
<div class="top-header">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <div class="d-flex align-items-center gap-2">
      <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
      <div>
        <div class="greeting">Selamat Datang,</div>
        <div class="name">{{ auth()->user()->name }}</div>
        <div class="nim">NIM: {{ $mahasiswaProfile->nim ?? 'M001' }} · {{ $mahasiswaProfile->jurusan ?? 'Teknik Informatika' }}</div>
      </div>
    </div>
    <button class="notif-btn" id="dateBtn">
      <i class="bi bi-bell"></i>
    </button>
  </div>

  <!-- Attendance circle -->
  <div class="d-flex align-items-center gap-3 pb-2">
    <div class="circle-wrap">
      <svg width="110" height="110">
        <circle cx="55" cy="55" r="48" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="8"/>
        <circle cx="55" cy="55" r="48" fill="none" stroke="#ffd700" stroke-width="8"
          stroke-dasharray="301.6" stroke-dashoffset="{{ 301.6 - (301.6 * $attendancePercentage / 100) }}" stroke-linecap="round"/>
      </svg>
      <div class="pct-label">
        <div class="num" style="color:#fff;">{{ $attendancePercentage }}%</div>
        <div class="sub" style="color:rgba(255,255,255,0.7);">Hadir</div>
      </div>
    </div>
    <div>
      <div style="color:rgba(255,255,255,0.8);font-size:.8rem;">Kehadiran Semester Ini</div>
      <div style="color:#fff;font-weight:700;font-size:1.6rem;line-height:1;">{{ $attendancePercentage }}%</div>
      <div style="color:rgba(255,255,255,0.7);font-size:.75rem;">{{ $hadirCount }} / {{ $hadirCount + $izinCount + $absenCount }} pertemuan hadir</div>
    </div>
  </div>
</div>

<!-- SUMMARY STRIP -->
<div class="summary-strip">
  <div class="sum-pill">
    <div class="val" style="color:var(--maroon);">{{ $totalMatakuliah }}</div>
    <div class="lbl">Mata Kuliah</div>
  </div>
  <div class="sum-pill">
    <div class="val" style="color:#198754;">{{ $hadirCount }}</div>
    <div class="lbl">Hadir</div>
  </div>
  <div class="sum-pill">
    <div class="val" style="color:#fd7e14;">{{ $izinCount }}</div>
    <div class="lbl">Izin</div>
  </div>
  <div class="sum-pill">
    <div class="val" style="color:#dc3545;">{{ $absenCount }}</div>
    <div class="lbl">Absen</div>
  </div>
  <div class="sum-pill">
    <div class="val" style="color:#0d6efd;">{{ $totalSks }}</div>
    <div class="lbl">SKS Total</div>
  </div>
</div>

<!-- CONTENT -->
<div class="p-3" style="max-width:640px;margin:auto;">

  <!-- Quick Actions -->
  <!-- <div class="mb-3">
    <div style="font-size:.85rem;font-weight:700;color:#1a1a2e;margin-bottom:.7rem;">Aksi Cepat</div>
    <div class="row g-2">
      <div class="col-3">
        <a href="/mahasiswa/scan_qr" class="quick-btn">
          <i class="bi bi-qr-code-scan"></i>
          <span>Scan QR</span>
        </a>
      </div>
      <div class="col-3">
        <a href="#" class="quick-btn" onclick="openIzinModal()">
          <i class="bi bi-file-earmark-text"></i>
          <span>Ajukan Izin</span>
        </a>
      </div>
      <div class="col-3">
        <a href="/mahasiswa/list_matakuliah" class="quick-btn">
          <i class="bi bi-book-fill"></i>
          <span>Mata Kuliah</span>
        </a>
      </div>
      <div class="col-3">
        <a href="#" class="quick-btn">
          <i class="bi bi-graph-up-arrow"></i>
          <span>Rekap</span>
        </a>
      </div>
    </div>
  </div> -->

  <!-- Kehadiran per MK -->
  <div class="section-card p-3 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div style="font-size:.9rem;font-weight:700;color:#1a1a2e;"><i class="bi bi-bar-chart-fill me-1" style="color:var(--maroon);"></i> Kehadiran per Mata Kuliah</div>
    </div>
    <div id="mkProgressList">
      @forelse($mkProgress as $mk)
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-1">
            <small class="fw-600" style="color:#333;font-size:.83rem;">{{ $mk['nama'] }}</small>
            <small style="color:{{ $mk['color'] }};font-weight:700;">{{ $mk['hadir'] }}/{{ $mk['total'] }} ({{ $mk['pct'] }}%)</small>
          </div>
          <div class="progress" style="height:7px;border-radius:10px;">
            <div class="progress-bar" style="width:{{ $mk['pct'] }}%;background:{{ $mk['color'] }};border-radius:10px;"></div>
          </div>
        </div>
      @empty
        <div style="text-align:center;color:#888;font-size:.9rem;padding:1rem;">Belum ada data kehadiran.</div>
      @endforelse
    </div>
  </div>

  <!-- Pengajuan Izin Terbaru -->
  <div class="section-card p-3 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div style="font-size:.9rem;font-weight:700;color:#1a1a2e;"><i class="bi bi-file-earmark-check me-1" style="color:var(--maroon);"></i> Status Pengajuan Izin</div>
    </div>
    <div id="izinList">
      @forelse($izinData as $iz)
        @php
          $bg = $iz['status'] === 'Disetujui' ? 'rgba(25,135,84,0.06)' : 'rgba(253,126,20,0.06)';
        @endphp
        <div class="izin-card" style="background:{{ $bg }};border:1px solid {{ $iz['color'] }}30;">
          <div class="izin-icon" style="background:{{ $iz['color'] }}18;color:{{ $iz['color'] }};">
            <i class="bi bi-file-earmark-text"></i>
          </div>
          <div class="flex-grow-1">
            <div class="izin-mk">{{ $iz['mk'] }}</div>
            <div class="izin-date">{{ $iz['jenis'] }} · {{ $iz['tgl'] }}</div>
          </div>
          <span class="badge rounded-pill" style="background:{{ $iz['color'] }}18;color:{{ $iz['color'] }};">{{ $iz['status'] }}</span>
        </div>
      @empty
        <div style="text-align:center;color:#888;font-size:.9rem;padding:1rem;">Belum ada pengajuan izin.</div>
      @endforelse
    </div>
  </div>

  <!-- Riwayat Terbaru -->
  <div class="section-card p-3 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div style="font-size:.9rem;font-weight:700;color:#1a1a2e;"><i class="bi bi-clock-history me-1" style="color:var(--maroon);"></i> Riwayat Presensi Terbaru</div>
    </div>
    <div id="riwayatList">
      @forelse($riwayat as $r)
        @php
          $statusBadges = [
            'hadir' => '<span class="badge badge-hadir px-2 rounded-pill">Hadir</span>',
            'izin'  => '<span class="badge badge-izin px-2 rounded-pill">Izin</span>',
            'alpha' => '<span class="badge badge-alpha px-2 rounded-pill">Absen</span>',
          ];
        @endphp
        <div class="rec-item">
          <div class="rec-dot" style="background:{{ $r['color'] }};"></div>
          <div class="flex-grow-1">
            <div class="rec-mk">{{ $r['mk'] }}</div>
            <div class="rec-date"><i class="bi bi-calendar3 me-1"></i>{{ $r['tgl'] }}  <i class="bi bi-clock ms-2 me-1"></i>{{ $r['waktu'] }}</div>
          </div>
          {!! $statusBadges[$r['status']] !!}
        </div>
      @empty
        <div style="text-align:center;color:#888;font-size:.9rem;padding:1rem;">Belum ada riwayat presensi.</div>
      @endforelse
    </div>
  </div>

</div><!-- end content -->

<!-- BOTTOM NAV -->
<nav class="bottom-nav">
  <a href="/mahasiswa/dashboard" class="nav-item-btn active">
    <i class="bi bi-house-fill"></i>
    <span>Beranda</span>
  </a>
  <a href="/mahasiswa/list_matakuliah" class="nav-item-btn">
    <i class="bi bi-book"></i>
    <span>Mata Kuliah</span>
  </a>
  <a href="/mahasiswa/scan_qr" class="nav-fab">
    <div class="fab"><i class="bi bi-qr-code-scan"></i></div>
  </a>
  <a href="/mahasiswa/izin" class="nav-item-btn">
    <i class="bi bi-file-earmark-text"></i>
    <span>Izin</span>
  </a>
  <a href="/mahasiswa/profile" class="nav-item-btn">
    <i class="bi bi-person-circle"></i>
    <span>Profil</span>
  </a>
</nav>

<!-- MODAL Izin -->
<div class="modal fade" id="modalIzin" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 shadow">
      <div class="modal-header" style="background:linear-gradient(135deg,var(--maroon-dark),var(--maroon));color:#fff;border:none;">
        <h5 class="modal-title"><i class="bi bi-file-earmark-plus me-2"></i>Ajukan Izin / Sakit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1);"></button>
      </div>
      <div class="modal-body p-4">
        <div class="mb-3">
          <label class="form-label fw-600" style="font-size:.83rem;color:#444;">Jenis Izin</label>
          <select class="form-select" id="izinJenis" style="border-radius:8px;border:1.5px solid #e0e0e0;">
            <option>Sakit</option><option>Izin Keluarga</option><option>Kegiatan Kampus</option><option>Lainnya</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label fw-600" style="font-size:.83rem;color:#444;">Mata Kuliah</label>
          <select class="form-select" id="izinMk" style="border-radius:8px;border:1.5px solid #e0e0e0;">
            <option>Algoritma &amp; Pemrograman</option>
            <option>Basis Data</option>
            <option>Rekayasa Perangkat Lunak</option>
            <option>Jaringan Komputer</option>
            <option>Sistem Operasi</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label fw-600" style="font-size:.83rem;color:#444;">Tanggal</label>
          <input type="date" class="form-control" id="izinTgl" style="border-radius:8px;border:1.5px solid #e0e0e0;"/>
        </div>
        <div class="mb-3">
          <label class="form-label fw-600" style="font-size:.83rem;color:#444;">Keterangan</label>
          <textarea class="form-control" rows="3" id="izinKet" placeholder="Jelaskan alasan izin Anda..." style="border-radius:8px;border:1.5px solid #e0e0e0;"></textarea>
        </div>
      </div>
      <div class="modal-footer" style="border-top:1px solid #f0f0f0;">
        <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button class="btn text-white fw-600" style="background:var(--maroon);border:none;border-radius:8px;" onclick="submitIzin()">
          <i class="bi bi-send me-1"></i>Kirim Pengajuan
        </button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Modal
  document.getElementById('izinTgl').value = new Date().toISOString().split('T')[0];
  const modalIzin = new bootstrap.Modal(document.getElementById('modalIzin'));
  function openIzinModal() { modalIzin.show(); }
  function submitIzin() {
    modalIzin.hide();
    alert('Pengajuan izin berhasil dikirim! Menunggu persetujuan dosen.');
  }
</script>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

</body>
</html>
