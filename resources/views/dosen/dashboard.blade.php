  <!DOCTYPE html>
  <html lang="id">
  <head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Dashboard Dosen – Ambasen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
    <style>
      :root {
        --maroon: #800020;
        --maroon-dark: #5a0016;
        --sidebar-w: 260px;
        --gray-bg: #f4f6f9;
      }

      body { font-family: 'Segoe UI', sans-serif; background: var(--gray-bg); }

      /* ── SIDEBAR ── */
      .sidebar {
        position: fixed; top: 0; left: 0;
        width: var(--sidebar-w); height: 100vh;
        background: linear-gradient(180deg, var(--maroon-dark) 0%, var(--maroon) 100%);
        display: flex; flex-direction: column;
        z-index: 1000; transition: transform .3s;
        overflow-y: auto;
      }
      .sidebar-brand {
        padding: 1.5rem 1.2rem 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.12);
      }
      .sidebar-brand .logo-circle {
        width: 48px; height: 48px;
        background: rgba(255,255,255,0.15);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        border: 2px solid rgba(255,255,255,0.3);
        margin-bottom: .6rem;
      }
      .sidebar-brand .logo-circle i { color: #fff; font-size: 1.4rem; }
      .sidebar-brand h5 { color: #fff; font-weight: 700; letter-spacing: 1.5px; margin: 0; font-size: 1.1rem; }
      .sidebar-brand small { color: rgba(255,255,255,0.6); font-size: 0.75rem; }

      .sidebar-user {
        margin: .8rem 1rem;
        padding: .75rem;
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        display: flex; align-items: center; gap: .75rem;
      }
      .sidebar-user .avatar {
        width: 40px; height: 40px; border-radius: 50%;
        background: #ffd700;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; color: var(--maroon-dark); font-size: 1rem;
      }
      .sidebar-user .info .name { color: #fff; font-size: 0.88rem; font-weight: 600; }
      .sidebar-user .info .role { color: rgba(255,255,255,0.6); font-size: 0.75rem; }

      .nav-section-title {
        color: rgba(255,255,255,0.45);
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 1rem 1.2rem .3rem;
      }

      .sidebar-nav a {
        display: flex; align-items: center; gap: .75rem;
        padding: .65rem 1.2rem;
        color: rgba(255,255,255,0.75);
        text-decoration: none;
        font-size: 0.9rem;
        border-radius: 0 25px 25px 0;
        margin: .1rem .8rem .1rem 0;
        transition: all .2s;
      }
      .sidebar-nav a:hover,
      .sidebar-nav a.active {
        background: rgba(255,255,255,0.18);
        color: #fff;
      }
      .sidebar-nav a.active { font-weight: 600; }
      .sidebar-nav a i { font-size: 1rem; width: 22px; }

      .sidebar-footer {
        margin-top: auto;
        padding: 1rem;
        border-top: 1px solid rgba(255,255,255,0.12);
      }
      .sidebar-footer a {
        display: flex; align-items: center; gap: .6rem;
        color: rgba(255,255,255,0.7);
        text-decoration: none; font-size: 0.88rem;
        padding: .5rem .8rem;
        border-radius: 8px;
        transition: background .2s;
      }
      .sidebar-footer a:hover { background: rgba(255,255,255,0.1); color: #fff; }

      /* ── MAIN ── */
      .main-content {
        margin-left: var(--sidebar-w);
        min-height: 100vh;
        transition: margin .3s;
      }

      /* ── TOPBAR ── */
      .topbar {
        background: #fff;
        padding: .85rem 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        position: sticky; top: 0; z-index: 999;
      }
      .topbar .page-title { font-weight: 700; font-size: 1.1rem; color: #1a1a2e; }
      .topbar .breadcrumb { font-size: 0.78rem; margin: 0; }
      .btn-toggle { display: none; background: none; border: none; font-size: 1.4rem; color: #555; }

      /* ── STATS CARDS ── */
      .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 1.4rem 1.2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        display: flex; align-items: center; gap: 1rem;
        border-left: 4px solid transparent;
        transition: transform .2s, box-shadow .2s;
      }
      .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
      .stat-card .icon-box {
        width: 54px; height: 54px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; flex-shrink: 0;
      }
      .stat-card .val { font-size: 1.7rem; font-weight: 700; line-height: 1; }
      .stat-card .lbl { font-size: 0.8rem; color: #888; margin-top: .15rem; }
      .stat-card .trend { font-size: 0.75rem; margin-top: .3rem; }

      .card-maroon  { border-left-color: var(--maroon); }
      .card-maroon  .icon-box { background: rgba(128,0,32,0.1); color: var(--maroon); }

      .card-blue    { border-left-color: #0d6efd; }
      .card-blue    .icon-box { background: rgba(13,110,253,0.1); color: #0d6efd; }

      .card-green   { border-left-color: #198754; }
      .card-green   .icon-box { background: rgba(25,135,84,0.1); color: #198754; }

      .card-orange  { border-left-color: #fd7e14; }
      .card-orange  .icon-box { background: rgba(253,126,20,0.1); color: #fd7e14; }

      /* ── SECTION CARD ── */
      .section-card {
        background: #fff;
        border-radius: 14px;
        padding: 1.5rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
      }
      .section-card h6 {
        font-weight: 700; color: #1a1a2e;
        font-size: 0.95rem; margin-bottom: 1rem;
        display: flex; align-items: center; gap: .5rem;
      }
      .section-card h6 i { color: var(--maroon); }

      /* ── TABLE ── */
      .table thead th {
        background: var(--gray-bg);
        font-size: 0.8rem;
        font-weight: 700;
        color: #555;
        text-transform: uppercase;
        letter-spacing: .5px;
        border: none;
      }
      .table tbody td { font-size: 0.88rem; vertical-align: middle; border-color: #f0f0f0; }
      .table tbody tr:hover { background: #fafafa; }

      .badge-hadir    { background: rgba(25,135,84,0.12); color: #198754; }
      .badge-izin     { background: rgba(253,126,20,0.12); color: #fd7e14; }
      .badge-alpha    { background: rgba(220,53,69,0.12);  color: #dc3545; }

      /* ── SCHEDULE ── */
      .schedule-item {
        display: flex; align-items: center; gap: .9rem;
        padding: .75rem 0;
        border-bottom: 1px solid #f0f0f0;
      }
      .schedule-item:last-child { border-bottom: none; }
      .schedule-time {
        width: 52px; text-align: center; flex-shrink: 0;
        font-size: 0.78rem; color: var(--maroon); font-weight: 700;
        line-height: 1.2;
      }
      .schedule-dot {
        width: 10px; height: 10px; border-radius: 50%;
        flex-shrink: 0;
      }
      .schedule-info .mk { font-size: 0.88rem; font-weight: 600; color: #1a1a2e; }
      .schedule-info .rm { font-size: 0.78rem; color: #888; }

      /* ── OVERLAY ── */
      .sidebar-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 999;
      }

      @media (max-width: 991px) {
        .sidebar { transform: translateX(-100%); }
        .sidebar.show { transform: translateX(0); }
        .sidebar-overlay.show { display: block; }
        .main-content { margin-left: 0; }
        .btn-toggle { display: block; }
      }
    </style>
  </head>
  <body>

  <!-- Overlay -->
  <div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <div class="logo-circle"><i class="bi bi-mortarboard-fill"></i></div>
      <h5>AMBASEN</h5>
      <small>Sistem Presensi Akademik</small>
    </div>

    <div class="sidebar-user">
      <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
      <div class="info">
        <div class="name">{{ auth()->user()->name }}</div>
        <div class="role">{{ ucfirst(auth()->user()->role) }} / {{ auth()->user()->email }}</div>
      </div>
    </div>

    <div class="nav-section-title">Menu Utama</div>
    <nav class="sidebar-nav">
      <a href="/dosen/dashboard" class="active"><i class="bi bi-grid-fill"></i> Dashboard</a>
      <a href="/dosen/generate_qr"><i class="bi bi-qr-code-scan"></i> Generate QR</a>
      <a href="/dosen/list_mahasiswa"><i class="bi bi-people-fill"></i> Data Mahasiswa</a>
      <a href="/dosen/list_matakuliah"><i class="bi bi-book-fill"></i> Mata Kuliah</a>
      <a href="/dosen/izin_mahasiswa"><i class="bi bi-file-earmark-check-fill"></i> Izin Mahasiswa</a>
    </nav>

    <div class="nav-section-title">Lainnya</div>
    <nav class="sidebar-nav">
      <a href="/dosen/profile"><i class="bi bi-person-circle"></i> Profil</a>
      <a href="#"><i class="bi bi-gear-fill"></i> Pengaturan</a>
    </nav>

  <div class="sidebar-footer">

    <form method="POST" action="{{ route('logout') }}">

        @csrf

        <button type="submit"
            style="
                width:100%;
                background:none;
                border:none;
                display:flex;
                align-items:center;
                gap:.6rem;
                color:rgba(255,255,255,0.7);
                padding:.5rem .8rem;
                border-radius:8px;
            ">

            <i class="bi bi-box-arrow-left"></i>
            Keluar

        </button>

    </form>

</div>
  </aside>

  <!-- MAIN -->
  <div class="main-content">

    <!-- TOPBAR -->
    <div class="topbar">
      <div class="d-flex align-items-center gap-3">
        <button class="btn-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
        <div>
          <div class="page-title">Dashboard</div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="#" style="color:var(--maroon);">Dosen</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </nav>
        </div>
      </div>
      <div class="d-flex align-items-center gap-2">
        <span class="badge rounded-pill text-bg-danger d-none d-sm-inline">
          <i class="bi bi-circle-fill me-1" style="font-size:.5rem;"></i> Live
        </span>
        <button class="btn btn-sm" style="background:var(--gray-bg);border:none;" title="Notifikasi">
          <i class="bi bi-bell" style="font-size:1.1rem;color:#555;"></i>
        </button>
      </div>
    </div>

    <!-- CONTENT -->
    <div class="p-3 p-md-4">

      <!-- Greeting -->
      <div class="mb-4">
        <h4 class="fw-700 mb-0" style="color:#1a1a2e;">Selamat Datang, {{ explode(' ', auth()->user()->name)[0] }}👋</h4>
        <small class="text-muted" id="dateNow"></small>
      </div>

      <!-- STAT CARDS -->
      <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
          <div class="stat-card card-maroon">
            <div class="icon-box"><i class="bi bi-people-fill"></i></div>
            <div>
              <div class="val">{{ $totalStudents }}</div>
              <div class="lbl">Total Mahasiswa</div>
              <div class="trend text-success"><i class="bi bi-arrow-up-short"></i>4 baru</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card card-blue">
            <div class="icon-box"><i class="bi bi-book-fill"></i></div>
            <div>
              <div class="val">{{ $totalMatakuliah }}</div>
              <div class="lbl">Mata Kuliah Diampu</div>
              <div class="trend text-muted">Semester ini</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card card-green">
            <div class="icon-box"><i class="bi bi-check-circle-fill"></i></div>
            <div>
              <div class="val">{{ $totalAttendance }}</div>
              <div class="lbl">Rata‑rata Kehadiran</div>
              <div class="trend text-success"><i class="bi bi-arrow-up-short"></i>+2% bulan ini</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="stat-card card-orange">
            <div class="icon-box"><i class="bi bi-hourglass-split"></i></div>
            <div>
              <div class="val">3</div>
              <div class="lbl">QR Aktif Hari Ini</div>
              <div class="trend text-muted">Sesi berlangsung</div>
            </div>
          </div>
        </div>
      </div>

      <!-- ROW: Jadwal + Presensi Terbaru -->
      <div class="row g-3 mb-4">

        <!-- Jadwal Hari Ini -->
        <div class="col-md-5">
          <div class="section-card h-100">
            <h6><i class="bi bi-calendar3"></i> Jadwal Hari Ini</h6>
            <div id="scheduleList">
              @forelse ($schedules as $schedule)
                <div class="schedule-item">
                  <div class="schedule-time">{{ $schedule['time'] }}</div>
                  <div class="schedule-dot" style="background:{{ $schedule['color'] }};"></div>
                  <div class="schedule-info">
                    <div class="mk">{{ $schedule['matkul'] }}</div>
                    <div class="rm"><i class="bi bi-geo-alt"></i> {{ $schedule['ruang'] }}</div>
                  </div>
                </div>
              @empty
                <p class="text-muted text-center py-3">Tidak ada jadwal untuk hari ini</p>
              @endforelse
            </div>
          </div>
        </div>

        <!-- Presensi Per Mata Kuliah -->
        <div class="col-md-7">
          <div class="section-card h-100">
            <h6><i class="bi bi-bar-chart-fill"></i> Kehadiran per Mata Kuliah</h6>
            <div id="progressList">
              @forelse ($mkProgress as $progress)
                <div class="mb-3">
                  <div class="d-flex justify-content-between mb-1">
                    <small class="fw-600" style="color:#333;">{{ $progress['mk'] }}</small>
                    <small style="color:{{ $progress['color'] }};font-weight:700;">{{ $progress['pct'] }}%</small>
                  </div>
                  <div class="progress" style="height:7px;border-radius:10px;">
                    <div class="progress-bar" style="width:{{ $progress['pct'] }}%;background:{{ $progress['color'] }};border-radius:10px;"></div>
                  </div>
                </div>
              @empty
                <p class="text-muted text-center py-3">Tidak ada data kehadiran</p>
              @endforelse
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Presensi Table -->
      <div class="section-card">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h6 class="mb-0"><i class="bi bi-clock-history"></i> Riwayat Presensi Terbaru</h6>
          <span class="badge rounded-pill" style="background:rgba(128,0,32,0.1);color:var(--maroon);">Hari Ini</span>
        </div>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>#</th>
                <th>Mahasiswa</th>
                <th>Mata Kuliah</th>
                <th>Waktu</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="recentTable">
              @forelse ($recentPresensis as $index => $presence)
                <tr>
                  <td class="text-muted">{{ $index + 1 }}</td>
                  <td>
                    <div class="fw-600">{{ $presence['nama'] }}</div>
                    <small class="text-muted">{{ $presence['nim'] }}</small>
                  </td>
                  <td>{{ $presence['mk'] }}</td>
                  <td><i class="bi bi-clock me-1 text-muted"></i>{{ $presence['waktu'] }}</td>
                  <td>
                    @switch($presence['status'])
                      @case('hadir')
                        <span class="badge badge-hadir px-3 py-1 rounded-pill">Hadir</span>
                        @break
                      @case('izin')
                        <span class="badge badge-izin px-3 py-1 rounded-pill">Izin</span>
                        @break
                      @case('alpha')
                        <span class="badge badge-alpha px-3 py-1 rounded-pill">Alpha</span>
                        @break
                      @default
                        <span class="badge badge-secondary px-3 py-1 rounded-pill">{{ ucfirst($presence['status']) }}</span>
                    @endswitch
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-muted text-center py-3">Tidak ada data presensi</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

    </div><!-- end .p-4 -->
  </div><!-- end .main-content -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Date
    const d = new Date();
    document.getElementById('dateNow').textContent =
      d.toLocaleDateString('id-ID', { weekday:'long', year:'numeric', month:'long', day:'numeric' });

    // Sidebar toggle
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('show');
      document.getElementById('overlay').classList.toggle('show');
    }
    function closeSidebar() {
      document.getElementById('sidebar').classList.remove('show');
      document.getElementById('overlay').classList.remove('show');
    }
  </script>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
