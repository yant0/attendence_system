<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Generate QR – Ambasen</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <!-- QR code library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
  <style>
    :root {
      --maroon: #800020;
      --maroon-dark: #5a0016;
      --sidebar-w: 260px;
      --gray-bg: #f4f6f9;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: var(--gray-bg);
    }

    /* SIDEBAR (shared) */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: var(--sidebar-w);
      height: 100vh;
      background: linear-gradient(180deg, var(--maroon-dark) 0%, var(--maroon) 100%);
      display: flex;
      flex-direction: column;
      z-index: 1000;
      transition: transform .3s;
      overflow-y: auto;
    }

    .sidebar-brand {
      padding: 1.5rem 1.2rem 1rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    }

    .sidebar-brand .logo-circle {
      width: 48px;
      height: 48px;
      background: rgba(255, 255, 255, 0.15);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 2px solid rgba(255, 255, 255, 0.3);
      margin-bottom: .6rem;
    }

    .sidebar-brand .logo-circle i {
      color: #fff;
      font-size: 1.4rem;
    }

    .sidebar-brand h5 {
      color: #fff;
      font-weight: 700;
      letter-spacing: 1.5px;
      margin: 0;
      font-size: 1.1rem;
    }

    .sidebar-brand small {
      color: rgba(255, 255, 255, 0.6);
      font-size: 0.75rem;
    }

    .sidebar-user {
      margin: .8rem 1rem;
      padding: .75rem;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      display: flex;
      align-items: center;
      gap: .75rem;
    }

    .sidebar-user .avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: #ffd700;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      color: var(--maroon-dark);
      font-size: 1rem;
    }

    .sidebar-user .info .name {
      color: #fff;
      font-size: 0.88rem;
      font-weight: 600;
    }

    .sidebar-user .info .role {
      color: rgba(255, 255, 255, 0.6);
      font-size: 0.75rem;
    }

    .nav-section-title {
      color: rgba(255, 255, 255, 0.45);
      font-size: 0.7rem;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      padding: 1rem 1.2rem .3rem;
    }

    .sidebar-nav a {
      display: flex;
      align-items: center;
      gap: .75rem;
      padding: .65rem 1.2rem;
      color: rgba(255, 255, 255, 0.75);
      text-decoration: none;
      font-size: 0.9rem;
      border-radius: 0 25px 25px 0;
      margin: .1rem .8rem .1rem 0;
      transition: all .2s;
    }

    .sidebar-nav a:hover,
    .sidebar-nav a.active {
      background: rgba(255, 255, 255, 0.18);
      color: #fff;
    }

    .sidebar-nav a.active {
      font-weight: 600;
    }

    .sidebar-nav a i {
      font-size: 1rem;
      width: 22px;
    }

    .sidebar-footer {
      margin-top: auto;
      padding: 1rem;
      border-top: 1px solid rgba(255, 255, 255, 0.12);
    }

    .sidebar-footer a {
      display: flex;
      align-items: center;
      gap: .6rem;
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
      font-size: 0.88rem;
      padding: .5rem .8rem;
      border-radius: 8px;
      transition: background .2s;
    }

    .sidebar-footer a:hover {
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
    }

    .sidebar-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.4);
      z-index: 999;
    }

    .main-content {
      margin-left: var(--sidebar-w);
      min-height: 100vh;
      transition: margin .3s;
    }

    .topbar {
      background: #fff;
      padding: .85rem 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
      position: sticky;
      top: 0;
      z-index: 999;
    }

    .topbar .page-title {
      font-weight: 700;
      font-size: 1.1rem;
      color: #1a1a2e;
    }

    .topbar .breadcrumb {
      font-size: 0.78rem;
      margin: 0;
    }

    .btn-toggle {
      display: none;
      background: none;
      border: none;
      font-size: 1.4rem;
      color: #555;
    }

    /* QR SPECIFIC */
    .form-card,
    .qr-card {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
      padding: 1.8rem;
    }

    .form-card h6,
    .qr-card h6 {
      font-weight: 700;
      font-size: 1rem;
      color: #1a1a2e;
      margin-bottom: 1.2rem;
    }

    .form-label {
      font-weight: 600;
      font-size: 0.85rem;
      color: #555;
    }

    .form-control,
    .form-select {
      border-radius: 10px;
      border: 1.5px solid #e0e0e0;
      font-size: 0.9rem;
      padding: .65rem 1rem;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: var(--maroon);
      box-shadow: 0 0 0 3px rgba(128, 0, 32, 0.12);
    }

    .btn-generate {
      width: 100%;
      background: linear-gradient(135deg, var(--maroon-dark), #c0003a);
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: .8rem;
      font-weight: 600;
      font-size: 1rem;
      transition: transform .15s, box-shadow .15s;
      cursor: pointer;
    }

    .btn-generate:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(128, 0, 32, 0.3);
    }

    /* QR display */
    .qr-display {
      display: none;
      flex-direction: column;
      align-items: center;
    }

    .qr-frame {
      width: 220px;
      height: 220px;
      border: 3px solid var(--maroon);
      border-radius: 16px;
      padding: 12px;
      background: #fff;
      box-shadow: 0 8px 30px rgba(128, 0, 32, 0.15);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .qr-frame::before,
    .qr-frame::after {
      content: '';
      position: absolute;
      width: 20px;
      height: 20px;
      border: 3px solid var(--maroon);
    }

    .qr-frame::before {
      top: 4px;
      left: 4px;
      border-right: none;
      border-bottom: none;
      border-radius: 4px 0 0 0;
    }

    .qr-frame::after {
      bottom: 4px;
      right: 4px;
      border-left: none;
      border-top: none;
      border-radius: 0 0 4px 0;
    }

    .qr-label {
      font-size: 1rem;
      font-weight: 700;
      color: #1a1a2e;
      margin-top: 1rem;
    }

    .qr-sublabel {
      font-size: 0.82rem;
      color: #888;
    }

    .timer-badge {
      background: rgba(128, 0, 32, 0.1);
      color: var(--maroon);
      border-radius: 20px;
      padding: .3rem 1rem;
      font-weight: 700;
      font-size: 0.9rem;
    }

    .pulse-ring {
      position: relative;
      display: inline-block;
    }

    .pulse-ring::after {
      content: '';
      position: absolute;
      inset: -8px;
      border: 2px solid var(--maroon);
      border-radius: 50%;
      animation: pulse 1.5s ease-out infinite;
      opacity: 0;
    }

    @keyframes pulse {
      0% {
        transform: scale(.9);
        opacity: .8
      }

      100% {
        transform: scale(1.5);
        opacity: 0
      }
    }

    .info-item {
      display: flex;
      align-items: center;
      gap: .6rem;
      padding: .5rem .8rem;
      background: var(--gray-bg);
      border-radius: 8px;
      font-size: 0.83rem;
      color: #555;
    }

    .info-item i {
      color: var(--maroon);
      width: 16px;
    }

    @media (max-width: 991px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .sidebar-overlay.show {
        display: block;
      }

      .main-content {
        margin-left: 0;
      }

      .btn-toggle {
        display: block;
      }
    }

    .qr-display .card {
      border: 1px solid #e9ecef;
    }

    .qr-display .table th {
      white-space: nowrap;
      font-size: 0.85rem;
    }

    .qr-display .table td {
      font-size: 0.85rem;
    }
  </style>
</head>

<body>

  <div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

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
      <a href="/dosen/dashboard"><i class="bi bi-grid-fill"></i> Dashboard</a>
      <a href="/dosen/generate_qr" class="active"><i class="bi bi-qr-code-scan"></i> Generate QR</a>
      <a href="/dosen/list_mahasiswa"><i class="bi bi-people-fill"></i> Data Mahasiswa</a>
      <a href="/dosen/list_matakuliah"><i class="bi bi-book-fill"></i> Mata Kuliah</a>
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

  <div class="main-content">
    <div class="topbar">
      <div class="d-flex align-items-center gap-3">
        <button class="btn-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
        <div>
          <div class="page-title">Generate QR Code</div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item"><a href="/dosen/dashboard" style="color:var(--maroon);">Dashboard</a></li>
              <li class="breadcrumb-item active">Generate QR</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>

    <div class="p-3 p-md-4">
      <div class="row g-4">

        <!-- FORM -->
        <div class="col-md-5">
          <div class="form-card">
            <h6><i class="bi bi-sliders me-2" style="color:var(--maroon);"></i>Konfigurasi Sesi Presensi</h6>

            <div class="mb-3">
              <label class="form-label">Mata Kuliah</label>
              <select class="form-select" id="selMk">
                <option value="">-- Pilih Mata Kuliah --</option>
                <option value="MK001">Algoritma &amp; Pemrograman – TI-A</option>
                <option value="MK002">Basis Data – TI-B</option>
                <option value="MK003">Rekayasa Perangkat Lunak – TI-A</option>
                <option value="MK004">Jaringan Komputer – TI-C</option>
                <option value="MK005">Sistem Operasi – TI-B</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Pertemuan Ke‑</label>
              <input type="number" class="form-control" id="pertemuan" min="1" max="16" value="8"
                placeholder="Contoh: 8" />
            </div>

            <div class="row g-2 mb-3">
              <div class="col">
                <label class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tglSesi" />
              </div>
              <div class="col">
                <label class="form-label">Waktu Mulai</label>
                <input type="time" class="form-control" id="waktuMulai" value="07:30" />
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Durasi QR Aktif</label>
              <select class="form-select" id="durasi">
                <option value="300">5 Menit</option>
                <option value="600" selected>10 Menit</option>
                <option value="900">15 Menit</option>
                <option value="1800">30 Menit</option>
              </select>
            </div>

            <div class="mb-4">
              <label class="form-label">Keterangan (Opsional)</label>
              <textarea class="form-control" id="keterangan" rows="2"
                placeholder="Contoh: Kuliah tatap muka, bab 8 – Relasi Antar Tabel"></textarea>
            </div>

            <button class="btn-generate" onclick="generateQR()">
              <i class="bi bi-qr-code me-2"></i>Generate QR Code
            </button>
          </div>

          <!-- Info card -->
          <div class="form-card mt-3">
            <h6 style="font-size:.88rem;"><i class="bi bi-info-circle me-2" style="color:#0d6efd;"></i>Panduan
              Penggunaan</h6>
            <div class="d-flex flex-column gap-2">
              <div class="info-item"><i class="bi bi-1-circle-fill"></i>Pilih mata kuliah &amp; pertemuan yang sesuai
              </div>
              <div class="info-item"><i class="bi bi-2-circle-fill"></i>Tentukan durasi QR Code aktif</div>
              <div class="info-item"><i class="bi bi-3-circle-fill"></i>Klik Generate &amp; tampilkan ke mahasiswa</div>
              <div class="info-item"><i class="bi bi-4-circle-fill"></i>Mahasiswa scan melalui aplikasi mereka</div>
            </div>
          </div>
        </div>

        <!-- QR Display -->
        <div class="col-md-7">
          <div class="qr-card h-100 d-flex flex-column">
            <h6><i class="bi bi-qr-code-scan me-2" style="color:var(--maroon);"></i>QR Code Presensi</h6>

            <!-- Placeholder -->
            <div id="qrPlaceholder" class="flex-grow-1 d-flex flex-column align-items-center justify-content-center"
              style="min-height:320px;">
              <i class="bi bi-qr-code" style="font-size:5rem;color:#ddd;"></i>
              <p class="text-muted mt-3" style="font-size:.9rem;">QR Code akan tampil di sini setelah dikonfigurasi</p>
            </div>

            <!-- QR Result -->
            <div class="qr-display flex-grow-1" id="qrResult">
              <div class="flex-grow-1 d-flex flex-column align-items-center justify-content-center py-3">

                <div class="mb-3 text-center">
                  <span class="badge bg-success px-3 py-2 rounded-pill">
                    <i class="bi bi-wifi me-1"></i> QR Aktif &amp; Menunggu Scan
                  </span>
                </div>

                <div class="qr-frame mb-3">
                  <div id="qrCanvas"></div>
                </div>

                <div class="qr-label" id="qrMkLabel">Mata Kuliah</div>
                <div class="qr-sublabel mb-3" id="qrSubLabel">Pertemuan ke-</div>

                <!-- Timer -->
                <div class="timer-badge mb-3">
                  <i class="bi bi-clock me-1"></i>
                  Tersisa: <span id="timerDisplay">--:--</span>
                </div>

                <!-- Info grid -->
                <div class="row g-2 w-100" style="max-width:360px;">
                  <div class="col-6">
                    <div class="info-item"><i class="bi bi-calendar3"></i><span id="infoDate">-</span></div>
                  </div>
                  <div class="col-6">
                    <div class="info-item"><i class="bi bi-clock"></i><span id="infoTime">-</span></div>
                  </div>
                  <div class="col-6">
                    <div class="info-item"><i class="bi bi-people"></i><span>Hadir: <span id="scanCount">0</span></span>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="info-item"><i class="bi bi-shield-lock"></i>Terenkripsi</div>
                  </div>
                </div>

                <!-- Actions -->
                <div class="d-flex gap-2 mt-4">
                  <button
                    class="btn btn-outline-danger btn-sm rounded-pill px-3"
                    onclick="stopQR()">
                    <i class="bi bi-stop-circle me-1"></i>Hentikan
                  </button>

                  <button
                    class="btn btn-sm rounded-pill px-3"
                    style="background: var(--maroon); color: #fff;"
                    onclick="generateQR()">
                    <i class="bi bi-arrow-clockwise me-1"></i>Regenerate
                  </button>
                </div>

                <!-- Daftar Mahasiswa Scan -->
                <div class="card mt-4 w-100 shadow-sm">
                  <div
                    class="card-header text-white fw-semibold d-flex align-items-center"
                    style="background: var(--maroon);">
                    <i class="bi bi-people-fill me-2"></i>
                    Daftar Mahasiswa Scan
                  </div>

                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table
                        class="table table-bordered table-hover align-middle mb-0 text-center">
                        <thead style="background: var(--maroon); color: #fff;">
                          <tr>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <td>221110001</td>
                            <td class="text-start">Budi Santoso</td>
                            <td>
                              <span class="badge bg-success">Hadir</span>
                            </td>
                            <td>-7.7691</td>
                            <td>110.3777</td>
                          </tr>

                          <tr>
                            <td>221110002</td>
                            <td class="text-start">Siti Aisyah</td>
                            <td>
                              <span class="badge bg-success">Hadir</span>
                            </td>
                            <td>-7.7688</td>
                            <td>110.3780</td>
                          </tr>

                          <tr>
                            <td>221110003</td>
                            <td class="text-start">Ahmad Rizki</td>
                            <td>
                              <span class="badge bg-success">Hadir</span>
                            </td>
                            <td>-7.7695</td>
                            <td>110.3775</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div><!-- end row -->
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Set today date
    document.getElementById('tglSesi').value = new Date().toISOString().split('T')[0];

    let timerInterval = null;
    let scanSimInterval = null;

    const mkNames = {
      MK001: 'Algoritma & Pemrograman',
      MK002: 'Basis Data',
      MK003: 'Rekayasa Perangkat Lunak',
      MK004: 'Jaringan Komputer',
      MK005: 'Sistem Operasi',
    };

    function generateQR() {

      const mk = document.getElementById('selMk').value;

      const prtm = document.getElementById('pertemuan').value;

      const tgl = document.getElementById('tglSesi').value;

      const wkt = document.getElementById('waktuMulai').value;

      const dur = parseInt(
        document.getElementById('durasi').value
      );

      if (!mk) {

        alert(
          'Pilih mata kuliah terlebih dahulu!'
        );

        return;

      }

      if (!prtm) {

        alert(
          'Masukkan nomor pertemuan!'
        );

        return;

      }

      // CLEAR TIMER LAMA
      clearInterval(timerInterval);

      clearInterval(scanSimInterval);

      document.getElementById(
        'qrCanvas'
      ).innerHTML = '';

      // WAJIB AKTIFKAN LOKASI DOSEN
      navigator.geolocation.getCurrentPosition(

        // SUCCESS GPS
        (position) => {

          fetch('/dosen/generate_qr/process', {

              method: 'POST',

              headers: {

                'Content-Type': 'application/json',

                'X-CSRF-TOKEN': document
                  .querySelector(
                    'meta[name="csrf-token"]'
                  )
                  .getAttribute('content')

              },

              body: JSON.stringify({

                kode_matakuliah: mk,

                pertemuan: prtm,

                tanggal: tgl,

                waktu_mulai: wkt,

                durasi: dur,

                keterangan: document.getElementById(
                  'keterangan'
                ).value,

                // GPS DOSEN
                latitude: position.coords.latitude,

                longitude: position.coords.longitude

              })

            })

            .then(res => res.json())

            .then(data => {

              console.log(data);

              if (!data.success) {

                alert(
                  'Gagal generate QR'
                );

                return;

              }

              const qrCanvas =
                document.getElementById(
                  'qrCanvas'
                );

              qrCanvas.innerHTML = '';

              console.log(
                'QR URL:',
                data.url
              );

              // GENERATE QR
              new QRCode(qrCanvas, {

                text: data.url,

                width: 180,

                height: 180

              });

              // UPDATE UI
              document.getElementById(
                  'qrMkLabel'
                ).textContent =
                mkNames[mk] || mk;

              document.getElementById(
                  'qrSubLabel'
                ).textContent =
                'Pertemuan ke-' + prtm;

              document.getElementById(
                'infoDate'
              ).textContent = tgl;

              document.getElementById(
                'infoTime'
              ).textContent = wkt;

              document.getElementById(
                'scanCount'
              ).textContent = '0';

              document.getElementById(
                'qrPlaceholder'
              ).style.display = 'none';

              const res =
                document.getElementById(
                  'qrResult'
                );

              res.style.display = 'flex';

              // COUNTDOWN
              let remaining = dur;

              updateTimer(remaining);

              timerInterval = setInterval(() => {

                remaining--;

                if (remaining <= 0) {

                  clearInterval(
                    timerInterval
                  );

                  stopQR(true);

                  return;

                }

                updateTimer(remaining);

              }, 1000);

              // SIMULASI COUNT
              let cnt = 0;

              scanSimInterval = setInterval(() => {

                if (cnt < 32) {

                  cnt++;

                  document.getElementById(
                    'scanCount'
                  ).textContent = cnt;

                } else {

                  clearInterval(
                    scanSimInterval
                  );

                }

              }, 800);

            })

            .catch(err => {

              console.log(err);

              alert('Fetch Error');

            });

        },

        // GPS GAGAL / DITOLAK
        (error) => {

          alert(
            'Lokasi wajib diaktifkan untuk generate QR!'
          );

          return;

        }

      );

    }



    function updateTimer(sec) {
      const m = String(Math.floor(sec / 60)).padStart(2, '0');
      const s = String(sec % 60).padStart(2, '0');
      document.getElementById('timerDisplay').textContent = m + ':' + s;
      if (sec <= 60) document.getElementById('timerDisplay').style.color = '#dc3545';
      else document.getElementById('timerDisplay').style.color = '';
    }

    function stopQR(expired) {
      clearInterval(timerInterval);
      clearInterval(scanSimInterval);
      document.getElementById('qrResult').style.display = 'none';
      document.getElementById('qrPlaceholder').style.display = 'flex';
      if (expired) alert('Sesi QR Code telah berakhir.');
    }

    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('show');
      document.getElementById('overlay').classList.toggle('show');
    }

    function closeSidebar() {
      document.getElementById('sidebar').classList.remove('show');
      document.getElementById('overlay').classList.remove('show');
    }
  </script>
</body>

</html>