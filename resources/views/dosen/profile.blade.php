<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profil – Ambasen</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <style>
    :root { --maroon: #800020; --maroon-dark: #5a0016; --sidebar-w: 260px; --gray-bg: #f4f6f9; }
    body { font-family: 'Segoe UI', sans-serif; background: var(--gray-bg); }

    /* SIDEBAR */
    .sidebar {
      position: fixed; top: 0; left: 0; width: var(--sidebar-w); height: 100vh;
      background: linear-gradient(180deg, var(--maroon-dark) 0%, var(--maroon) 100%);
      display: flex; flex-direction: column; z-index: 1000; transition: transform .3s; overflow-y: auto;
    }
    .sidebar-brand { padding: 1.5rem 1.2rem 1rem; border-bottom: 1px solid rgba(255,255,255,0.12); }
    .sidebar-brand .logo-circle {
      width: 48px; height: 48px; background: rgba(255,255,255,0.15); border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      border: 2px solid rgba(255,255,255,0.3); margin-bottom: .6rem;
    }
    .sidebar-brand .logo-circle i { color: #fff; font-size: 1.4rem; }
    .sidebar-brand h5 { color: #fff; font-weight: 700; letter-spacing: 1.5px; margin: 0; font-size: 1.1rem; }
    .sidebar-brand small { color: rgba(255,255,255,0.6); font-size: 0.75rem; }
    .sidebar-user {
      margin: .8rem 1rem; padding: .75rem; background: rgba(255,255,255,0.1); border-radius: 10px;
      display: flex; align-items: center; gap: .75rem;
    }
    .sidebar-user .avatar {
      width: 40px; height: 40px; border-radius: 50%; background: #ffd700;
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; color: var(--maroon-dark); font-size: 1rem;
    }
    .sidebar-user .info .name { color: #fff; font-size: 0.88rem; font-weight: 600; }
    .sidebar-user .info .role { color: rgba(255,255,255,0.6); font-size: 0.75rem; }
    .nav-section-title {
      color: rgba(255,255,255,0.45); font-size: 0.7rem; font-weight: 700;
      letter-spacing: 1px; text-transform: uppercase; padding: 1rem 1.2rem .3rem;
    }
    .sidebar-nav a {
      display: flex; align-items: center; gap: .75rem; padding: .65rem 1.2rem;
      color: rgba(255,255,255,0.75); text-decoration: none; font-size: 0.9rem;
      border-radius: 0 25px 25px 0; margin: .1rem .8rem .1rem 0; transition: all .2s;
    }
    .sidebar-nav a:hover, .sidebar-nav a.active { background: rgba(255,255,255,0.18); color: #fff; }
    .sidebar-nav a.active { font-weight: 600; }
    .sidebar-nav a i { font-size: 1rem; width: 22px; }
    .sidebar-footer { margin-top: auto; padding: 1rem; border-top: 1px solid rgba(255,255,255,0.12); }
    .sidebar-footer a {
      display: flex; align-items: center; gap: .6rem; color: rgba(255,255,255,0.7);
      text-decoration: none; font-size: 0.88rem; padding: .5rem .8rem; border-radius: 8px; transition: background .2s;
    }
    .sidebar-footer a:hover { background: rgba(255,255,255,0.1); color: #fff; }
    .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 999; }
    .main-content { margin-left: var(--sidebar-w); min-height: 100vh; transition: margin .3s; }

    /* TOPBAR */
    .topbar {
      background: #fff; padding: .85rem 1.5rem;
      display: flex; align-items: center; justify-content: space-between;
      box-shadow: 0 2px 10px rgba(0,0,0,0.06); position: sticky; top: 0; z-index: 999;
    }
    .topbar .page-title { font-weight: 700; font-size: 1.1rem; color: #1a1a2e; }
    .topbar .breadcrumb { font-size: 0.78rem; margin: 0; }
    .btn-toggle { display: none; background: none; border: none; font-size: 1.4rem; color: #555; }

    /* PROFILE HEADER CARD */
    .profile-header-card {
      background: linear-gradient(135deg, var(--maroon-dark) 0%, var(--maroon) 60%, #c0003a 100%);
      border-radius: 16px; padding: 2rem 2rem 1.8rem;
      position: relative; overflow: hidden;
      box-shadow: 0 8px 32px rgba(128,0,32,0.25);
    }
    .profile-header-card::before {
      content: ''; position: absolute; width: 250px; height: 250px; border-radius: 50%;
      background: rgba(255,255,255,0.05); top: -100px; right: -80px;
    }
    .profile-header-card::after {
      content: ''; position: absolute; width: 150px; height: 150px; border-radius: 50%;
      background: rgba(255,255,255,0.04); bottom: -60px; left: -40px;
    }
    .profile-avatar-lg {
      width: 80px; height: 80px; border-radius: 50%; background: #ffd700;
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; color: var(--maroon-dark); font-size: 1.8rem;
      border: 3px solid rgba(255,255,255,0.4);
      box-shadow: 0 4px 16px rgba(0,0,0,0.2);
      flex-shrink: 0;
    }
    .profile-header-card .prof-name { color: #fff; font-weight: 700; font-size: 1.3rem; margin-bottom: .2rem; }
    .profile-header-card .prof-nip  { color: rgba(255,255,255,0.75); font-size: .82rem; }
    .profile-header-card .prof-dept { color: rgba(255,255,255,0.8); font-size: .85rem; margin-top: .3rem; }
    .badge-role {
      background: rgba(255,255,255,0.2); color: #fff;
      border: 1px solid rgba(255,255,255,0.35);
      font-size: .75rem; padding: .25rem .75rem; border-radius: 20px; font-weight: 600;
    }
    .btn-edit-profile {
      background: rgba(255,255,255,0.15); color: #fff;
      border: 1.5px solid rgba(255,255,255,0.4); border-radius: 25px;
      padding: .45rem 1.2rem; font-size: .85rem; font-weight: 600;
      cursor: pointer; transition: all .2s; display: flex; align-items: center; gap: .4rem;
    }
    .btn-edit-profile:hover { background: rgba(255,255,255,0.28); }

    /* INFO CARDS */
    .info-card {
      background: #fff; border-radius: 14px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.07); overflow: hidden;
    }
    .info-card-header {
      padding: 1rem 1.4rem; border-bottom: 1px solid #f0f0f0;
      display: flex; align-items: center; gap: .6rem;
    }
    .info-card-header .icon-wrap {
      width: 36px; height: 36px; border-radius: 10px;
      background: rgba(128,0,32,0.1); display: flex; align-items: center; justify-content: center;
    }
    .info-card-header .icon-wrap i { color: var(--maroon); font-size: 1rem; }
    .info-card-header h6 { margin: 0; font-weight: 700; color: #1a1a2e; font-size: .95rem; }
    .info-card-body { padding: 1.2rem 1.4rem; }
    .info-row {
      display: flex; align-items: flex-start; gap: .75rem;
      padding: .65rem 0; border-bottom: 1px solid #f8f8f8;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row .info-label {
      font-size: .78rem; color: #888; font-weight: 600; min-width: 140px; flex-shrink: 0;
    }
    .info-row .info-value { font-size: .88rem; color: #1a1a2e; font-weight: 500; }

    /* STAT MINI */
    .stat-mini {
      background: var(--gray-bg); border-radius: 10px; padding: .8rem 1rem;
      text-align: center;
    }
    .stat-mini .stat-val { font-size: 1.4rem; font-weight: 700; color: var(--maroon); line-height: 1; }
    .stat-mini .stat-lbl { font-size: .72rem; color: #888; margin-top: .2rem; }

    /* SECURITY CARD */
    .security-card {
      background: #fff; border-radius: 14px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.07); padding: 1.4rem;
    }

    /* MODAL */
    .modal-header { background: linear-gradient(135deg, var(--maroon-dark), var(--maroon)); color: #fff; border: none; }
    .modal-header .btn-close { filter: invert(1); }
    .form-label { font-weight: 600; font-size: 0.83rem; color: #444; }
    .form-control, .form-select {
      border-radius: 8px; border: 1.5px solid #e0e0e0; font-size: 0.9rem; padding: .55rem .9rem;
    }
    .form-control:focus, .form-select:focus { border-color: var(--maroon); box-shadow: 0 0 0 3px rgba(128,0,32,0.12); }
    .btn-save { background: linear-gradient(135deg, var(--maroon-dark), #c0003a); color: #fff; border: none; border-radius: 8px; padding: .55rem 1.5rem; font-weight: 600; }
    .btn-save:hover { opacity: .9; color: #fff; }

    /* TOAST */
    .toast-container { position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 9999; }

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
    <a href="/dosen/generate_qr"><i class="bi bi-qr-code-scan"></i> Generate QR</a>
    <a href="/dosen/list_mahasiswa"><i class="bi bi-people-fill"></i> Data Mahasiswa</a>
    <a href="/dosen/list_matakuliah"><i class="bi bi-book-fill"></i> Mata Kuliah</a>
    <a href="/dosen/izin_mahasiswa"><i class="bi bi-file-earmark-check-fill"></i> Izin Mahasiswa</a>
  </nav>
  <div class="nav-section-title">Lainnya</div>
  <nav class="sidebar-nav">
    <a href="/dosen/profile" class="active"><i class="bi bi-person-circle"></i> Profil</a>
    <a href="#"><i class="bi bi-gear-fill"></i> Pengaturan</a>
  </nav>
  <div class="sidebar-footer">
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" ><i class="bi bi-box-arrow-left"></i> Keluar</a>
  </div>
</aside>

<div class="main-content">
  <!-- TOPBAR -->
  <div class="topbar">
    <div class="d-flex align-items-center gap-3">
      <button class="btn-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
      <div>
        <div class="page-title">Profil Saya</div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="/dosen/dashboard" style="color:var(--maroon);">Dashboard</a></li>
            <li class="breadcrumb-item active">Profil</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>

  <div class="p-3 p-md-4">

    <!-- PROFILE HEADER CARD -->
    <div class="profile-header-card mb-4">
      <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-3">
        <div class="profile-avatar-lg">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
        <div class="flex-grow-1">
          <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
            <div class="prof-name">{{ auth()->user()->name }}</div>
            <span class="badge-role">Dosen</span>
          </div>
          <div class="prof-nip"><i class="bi bi-envelope me-1"></i>{{ auth()->user()->email }}</div>
          <div class="prof-dept"><i class="bi bi-building me-1"></i>Teknik Informatika</div>
        </div>
        <button class="btn-edit-profile" onclick="openEditModal()">
          <i class="bi bi-pencil-square"></i> Edit Profil
        </button>
      </div>
    </div>

    <!-- INFO CARDS ROW -->
    <div class="row g-4 mb-4">

      <!-- LEFT: Informasi Pribadi -->
      <div class="col-lg-6">
        <div class="info-card h-100">
          <div class="info-card-header">
            <div class="icon-wrap"><i class="bi bi-person-fill"></i></div>
            <h6>Informasi Pribadi</h6>
          </div>
          <div class="info-card-body">
            <div class="info-row">
              <span class="info-label">Nama Lengkap</span>
              <span class="info-value">{{ auth()->user()->name }}</span>
            </div>
            <div class="info-row">
              <span class="info-label">NIP</span>
              <span class="info-value">198501012015</span>
            </div>
            <div class="info-row">
              <span class="info-label">Email</span>
              <span class="info-value">{{ auth()->user()->email }}</span>
            </div>
            <div class="info-row">
              <span class="info-label">No. HP</span>
              <span class="info-value">08123456789</span>
            </div>
            <div class="info-row">
              <span class="info-label">Tanggal Lahir</span>
              <span class="info-value">01 Januari 1985</span>
            </div>
            <div class="info-row">
              <span class="info-label">Jenis Kelamin</span>
              <span class="info-value">Laki-laki</span>
            </div>
            <div class="info-row">
              <span class="info-label">Alamat</span>
              <span class="info-value">Jl. Merdeka No. 12, Kota Bandung</span>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT: Informasi Akademik -->
      <div class="col-lg-6">
        <div class="info-card h-100">
          <div class="info-card-header">
            <div class="icon-wrap"><i class="bi bi-mortarboard-fill"></i></div>
            <h6>Informasi Akademik</h6>
          </div>
          <div class="info-card-body">
            <div class="info-row">
              <span class="info-label">Program Studi</span>
              <span class="info-value">Teknik Informatika</span>
            </div>
            <div class="info-row">
              <span class="info-label">Jabatan Fungsional</span>
              <span class="info-value">Lektor Kepala</span>
            </div>
            <div class="info-row">
              <span class="info-label">Pendidikan Terakhir</span>
              <span class="info-value">S2 – Teknik Informatika</span>
            </div>
            <div class="info-row">
              <span class="info-label">Tahun Bergabung</span>
              <span class="info-value">2015</span>
            </div>
            <div class="info-row">
              <span class="info-label">Status</span>
              <span class="info-value">
                <span class="badge text-bg-success rounded-pill px-3">Aktif</span>
              </span>
            </div>

            <!-- Statistik Mengajar -->
            <div class="mt-3 pt-2" style="border-top: 1px solid #f0f0f0;">
              <div style="font-size:.8rem;font-weight:700;color:#555;margin-bottom:.75rem;">
                <i class="bi bi-bar-chart-fill me-1" style="color:var(--maroon);"></i>Statistik Mengajar
              </div>
              <div class="row g-2">
                <div class="col-4">
                  <div class="stat-mini">
                    <div class="stat-val">5</div>
                    <div class="stat-lbl">Mata Kuliah Diampu</div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="stat-mini">
                    <div class="stat-val" style="color:#0d6efd;">181</div>
                    <div class="stat-lbl">Total Mahasiswa</div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="stat-mini">
                    <div class="stat-val" style="color:#198754;">87%</div>
                    <div class="stat-lbl">Rata-rata Kehadiran</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- KEAMANAN AKUN -->
    <div class="security-card">
      <div class="d-flex align-items-center gap-3 mb-3">
        <div style="width:40px;height:40px;border-radius:10px;background:rgba(128,0,32,0.1);display:flex;align-items:center;justify-content:center;">
          <i class="bi bi-shield-lock-fill" style="color:var(--maroon);font-size:1.1rem;"></i>
        </div>
        <div>
          <div style="font-weight:700;color:#1a1a2e;font-size:.95rem;">Keamanan Akun</div>
          <div style="font-size:.78rem;color:#888;">Kelola keamanan dan kata sandi akun Anda</div>
        </div>
      </div>
      <div class="d-flex flex-wrap gap-2">
        <button class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="openPasswordModal()">
          <i class="bi bi-key-fill me-1"></i>Ganti Password
        </button>
      </div>
    </div>

  </div><!-- end p-3 p-md-4 -->
</div><!-- end main-content -->

<!-- MODAL Edit Profil -->
<div class="modal fade" id="modalEditProfil" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Profil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="mb-3">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" class="form-control" id="editNama" value="{{ auth()->user()->name }}"/>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" id="editEmail" value="{{ auth()->user()->email }}"/>
        </div>
        <div class="mb-3">
          <label class="form-label">No. HP</label>
          <input type="text" class="form-control" id="editHp" value="08123456789"/>
        </div>
        <div class="mb-3">
          <label class="form-label">Alamat</label>
          <textarea class="form-control" id="editAlamat" rows="3">Jl. Merdeka No. 12, Kota Bandung</textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-save" onclick="saveProfile()"><i class="bi bi-save me-1"></i>Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL Ganti Password -->
<div class="modal fade" id="modalPassword" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header">
        <h5 class="modal-title"><i class="bi bi-key-fill me-2"></i>Ganti Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="mb-3">
          <label class="form-label">Password Lama</label>
          <input type="password" class="form-control" id="passLama" placeholder="Masukkan password lama"/>
        </div>
        <div class="mb-3">
          <label class="form-label">Password Baru</label>
          <input type="password" class="form-control" id="passBaru" placeholder="Masukkan password baru"/>
        </div>
        <div class="mb-3">
          <label class="form-label">Konfirmasi Password</label>
          <input type="password" class="form-control" id="passKonfirmasi" placeholder="Ulangi password baru"/>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-save" onclick="savePassword()"><i class="bi bi-shield-check me-1"></i>Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- TOAST -->
<div class="toast-container">
  <div id="mainToast" class="toast align-items-center border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body" id="toastMsg">Berhasil!</div>
      <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const modalEditProfil = new bootstrap.Modal(document.getElementById('modalEditProfil'));
  const modalPassword   = new bootstrap.Modal(document.getElementById('modalPassword'));

  function openEditModal()     { modalEditProfil.show(); }
  function openPasswordModal() { modalPassword.show(); }

  function saveProfile() {
    modalEditProfil.hide();
    showToast('Profil berhasil diperbarui!', 'success');
  }

  function savePassword() {
    const baru = document.getElementById('passBaru').value;
    const konfirmasi = document.getElementById('passKonfirmasi').value;
    if (!baru || !konfirmasi) { showToast('Semua field wajib diisi!', 'danger'); return; }
    if (baru !== konfirmasi)  { showToast('Konfirmasi password tidak cocok!', 'danger'); return; }
    modalPassword.hide();
    document.getElementById('passLama').value = '';
    document.getElementById('passBaru').value = '';
    document.getElementById('passKonfirmasi').value = '';
    showToast('Password berhasil diubah!', 'success');
  }

  function showToast(msg, type) {
    const toast = document.getElementById('mainToast');
    toast.className = `toast align-items-center border-0 text-bg-${type}`;
    document.getElementById('toastMsg').textContent = msg;
    new bootstrap.Toast(toast, { delay: 3000 }).show();
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
