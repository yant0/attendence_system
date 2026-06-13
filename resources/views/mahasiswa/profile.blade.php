<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profil – Ambasen</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
  <style>
    :root { --maroon: #800020; --maroon-dark: #5a0016; --gray-bg: #f4f6f9; --nav-h: 65px; }
    body { font-family: 'Segoe UI', sans-serif; background: var(--gray-bg); padding-bottom: var(--nav-h); }

    /* TOP HEADER */
    .top-header {
      background: linear-gradient(135deg, var(--maroon-dark) 0%, var(--maroon) 70%, #c0003a 100%);
      padding: 1.4rem 1.2rem 1.2rem;
      position: relative; overflow: hidden;
    }
    .top-header::before {
      content: ''; position: absolute; width: 200px; height: 200px; border-radius: 50%;
      background: rgba(255,255,255,0.06); top: -80px; right: -60px;
      z-index: -100;
    }
    .top-header::after {
      content: ''; position: absolute; width: 120px; height: 120px; border-radius: 50%;
      background: rgba(255,255,255,0.04); bottom: -50px; left: -30px;
      z-index: -100;
    }
    .top-header .avatar {
      width: 70px; height: 70px; border-radius: 50%;
      background: #ffd700; display: flex; align-items: center; justify-content: center;
      font-weight: 700; color: var(--maroon-dark); font-size: 1.5rem;
      border: 3px solid rgba(255,255,255,0.4);
      box-shadow: 0 4px 16px rgba(0,0,0,0.2);
      flex-shrink: 0;
    }
    .top-header .prof-name  { color: #fff; font-weight: 700; font-size: 1.15rem; line-height: 1.2; }
    .top-header .prof-nim   { color: rgba(255,255,255,0.75); font-size: .78rem; margin-top: .15rem; }
    .top-header .prof-prodi { color: rgba(255,255,255,0.7); font-size: .78rem; }
    .edit-icon-btn {
      width: 38px; height: 38px; border-radius: 50%;
      background: rgba(255,255,255,0.15); border: 1.5px solid rgba(255,255,255,0.35);
      display: flex; align-items: center; justify-content: center;
      color: #fff; font-size: 1rem; cursor: pointer; transition: background .2s;
      flex-shrink: 0;
    }
    .edit-icon-btn:hover { background: rgba(255,255,255,0.28); }

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
    .section-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); overflow: hidden; }
    .section-card-header {
      padding: .9rem 1.2rem; border-bottom: 1px solid #f0f0f0;
      display: flex; align-items: center; gap: .6rem;
    }
    .section-card-header .icon-wrap {
      width: 34px; height: 34px; border-radius: 9px;
      background: rgba(128,0,32,0.1); display: flex; align-items: center; justify-content: center;
    }
    .section-card-header .icon-wrap i { color: var(--maroon); font-size: .95rem; }
    .section-card-header h6 { margin: 0; font-weight: 700; color: #1a1a2e; font-size: .9rem; }
    .section-card-body { padding: 1rem 1.2rem; }

    /* INFO ROWS */
    .info-row {
      display: flex; align-items: flex-start; gap: .75rem;
      padding: .6rem 0; border-bottom: 1px solid #f8f8f8;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row .info-label {
      font-size: .76rem; color: #888; font-weight: 600; min-width: 130px; flex-shrink: 0;
    }
    .info-row .info-value { font-size: .86rem; color: #1a1a2e; font-weight: 500; }

    /* CIRCULAR PROGRESS */
    .circle-wrap { position: relative; width: 110px; height: 110px; flex-shrink: 0; }
    .circle-wrap svg { transform: rotate(-90deg); }
    .circle-wrap .pct-label {
      position: absolute; inset: 0; display: flex; flex-direction: column;
      align-items: center; justify-content: center;
    }
    .circle-wrap .pct-label .num { font-size: 1.4rem; font-weight: 700; color: var(--maroon); line-height: 1; }
    .circle-wrap .pct-label .sub { font-size: .65rem; color: #888; }

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

    /* MODAL */
    .modal-header { background: linear-gradient(135deg, var(--maroon-dark), var(--maroon)); color: #fff; border: none; }
    .modal-header .btn-close { filter: invert(1); }
    .form-label { font-weight: 600; font-size: 0.83rem; color: #444; }
    .form-control {
      border-radius: 8px; border: 1.5px solid #e0e0e0; font-size: 0.9rem; padding: .55rem .9rem;
    }
    .form-control:focus { border-color: var(--maroon); box-shadow: 0 0 0 3px rgba(128,0,32,0.12); }
    .btn-save { background: linear-gradient(135deg, var(--maroon-dark), #c0003a); color: #fff; border: none; border-radius: 8px; padding: .55rem 1.5rem; font-weight: 600; }
    .btn-save:hover { opacity: .9; color: #fff; }

    /* TOAST */
    .toast-container { position: fixed; bottom: calc(var(--nav-h) + 1rem); right: 1rem; z-index: 9999; }
  </style>
</head>
<body>

<!-- TOP HEADER -->
<div class="top-header">
  <div class="d-flex align-items-center gap-3">
    <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
    <div class="flex-grow-1">
      <div class="prof-name">{{ auth()->user()->name }}</div>
      <div class="prof-nim"><i class="bi bi-id-card me-1"></i>{{ $mahasiswa->nim ?? 'N/A' }}</div>
      <div class="prof-prodi"><i class="bi bi-building me-1"></i>{{ $mahasiswa->jurusan ?? 'N/A' }}</div>
    </div>
    <button class="edit-icon-btn" onclick="openEditModal()" aria-label="Edit Profil">
      <i class="bi bi-pencil-square"></i>
    </button>
  </div>
</div>

<!-- SUMMARY STRIP -->
<div class="summary-strip">
  <div class="sum-pill">
    <div class="val" style="color:var(--maroon);">{{ round($persentaseKehadiran) }}%</div>
    <div class="lbl">Kehadiran</div>
  </div>
  <div class="sum-pill">
    <div class="val" style="color:#198754;">{{ $totalHadir }}</div>
    <div class="lbl">Hadir</div>
  </div>
  <div class="sum-pill">
    <div class="val" style="color:#fd7e14;">{{ $totalIzin }}</div>
    <div class="lbl">Izin</div>
  </div>
  <div class="sum-pill">
    <div class="val" style="color:#dc3545;">{{ $totalAlpha }}</div>
    <div class="lbl">Alpha</div>
  </div>
  <div class="sum-pill">
    <div class="val" style="color:#0d6efd;">{{ $mahasiswa->semester ?? '0' }}</div>
    <div class="lbl">Semester</div>
  </div>
</div>

<!-- CONTENT -->
<div class="p-3" style="max-width:640px;margin:auto;">

  <!-- Informasi Pribadi -->
  <div class="section-card mb-3">
    <div class="section-card-header">
      <div class="icon-wrap"><i class="bi bi-person-fill"></i></div>
      <h6>Informasi Pribadi</h6>
    </div>
    <div class="section-card-body">
      <div class="info-row">
        <span class="info-label">Nama Lengkap</span>
        <span class="info-value">{{ $mahasiswa->nama ?? auth()->user()->name }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">NIM</span>
        <span class="info-value">{{ $mahasiswa->nim ?? 'N/A' }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Email</span>
        <span class="info-value">{{ $mahasiswa->email ?? auth()->user()->email }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">No. HP</span>
        <span class="info-value">{{ $mahasiswa->no_hp ?? 'N/A' }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Tanggal Lahir</span>
        <span class="info-value">{{ $mahasiswa->tanggal_lahir ?? 'N/A' }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Jenis Kelamin</span>
        <span class="info-value">{{ $mahasiswa->jenis_kelamin ?? 'N/A' }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Angkatan</span>
        <span class="info-value">{{ $mahasiswa->angkatan ?? 'N/A' }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Alamat</span>
        <span class="info-value">{{ $mahasiswa->alamat ?? 'N/A' }}</span>
      </div>
    </div>
  </div>

  <!-- Informasi Akademik -->
  <div class="section-card mb-3">
    <div class="section-card-header">
      <div class="icon-wrap"><i class="bi bi-mortarboard-fill"></i></div>
      <h6>Informasi Akademik</h6>
    </div>
    <div class="section-card-body">
      <div class="info-row">
        <span class="info-label">Program Studi</span>
        <span class="info-value">{{ $mahasiswa->jurusan ?? 'N/A' }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Semester</span>
        <span class="info-value">{{ $mahasiswa->semester ?? 'N/A' }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Status Mahasiswa</span>
        <span class="info-value">
          <span class="badge text-bg-{{ $mahasiswa->status === 'Aktif' ? 'success' : 'warning' }} rounded-pill px-3">{{ $mahasiswa->status ?? 'N/A' }}</span>
        </span>
      </div>
      <div class="info-row">
        <span class="info-label">IPK</span>
        <span class="info-value" style="font-weight:700;color:var(--maroon);">{{ $mahasiswa->ipk ?? 'N/A' }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Total SKS Tempuh</span>
        <span class="info-value">{{ $mahasiswa->total_sks ?? '0' }} SKS</span>
      </div>
    </div>
  </div>

  <!-- Kehadiran Semester Ini -->
  <div class="section-card mb-3">
    <div class="section-card-header">
      <div class="icon-wrap"><i class="bi bi-bar-chart-fill"></i></div>
      <h6>Kehadiran Semester Ini</h6>
    </div>
    <div class="section-card-body">
      <!-- Circular progress + summary -->
      <div class="d-flex align-items-center gap-3 mb-3 pb-3" style="border-bottom:1px solid #f0f0f0;">
        <div class="circle-wrap">
          <svg width="110" height="110">
            <circle cx="55" cy="55" r="48" fill="none" stroke="#f0f0f0" stroke-width="8"/>
            <circle cx="55" cy="55" r="48" fill="none" stroke="var(--maroon)" stroke-width="8"
              stroke-dasharray="301.6" stroke-dashoffset="{{ 301.6 * (1 - $persentaseKehadiran / 100) }}" stroke-linecap="round"/>
          </svg>
          <div class="pct-label">
            <div class="num">{{ round($persentaseKehadiran) }}%</div>
            <div class="sub">Hadir</div>
          </div>
        </div>
        <div>
          <div style="font-size:.82rem;color:#555;margin-bottom:.4rem;">Total Kehadiran</div>
          <div style="font-size:1.5rem;font-weight:700;color:#1a1a2e;line-height:1;">{{ round($persentaseKehadiran) }}%</div>
          <div style="font-size:.75rem;color:#888;margin-top:.2rem;">{{ $totalHadir }} / {{ $totalPertemuan > $totalitas ? $totalPertemuan : $totalitas }} pertemuan hadir</div>
          <div class="d-flex gap-2 mt-2 flex-wrap">
            <span style="font-size:.72rem;background:rgba(25,135,84,0.1);color:#198754;padding:.2rem .6rem;border-radius:20px;">Hadir: {{ $totalHadir }}</span>
            <span style="font-size:.72rem;background:rgba(253,126,20,0.1);color:#fd7e14;padding:.2rem .6rem;border-radius:20px;">Izin: {{ $totalIzin }}</span>
            <span style="font-size:.72rem;background:rgba(220,53,69,0.1);color:#dc3545;padding:.2rem .6rem;border-radius:20px;">Alpha: {{ $totalAlpha }}</span>
          </div>
        </div>
      </div>

      <!-- Per MK breakdown -->
      <div id="mkBreakdown"></div>
    </div>
  </div>

  <!-- Keamanan Akun -->
  <div class="section-card mb-3">
    <div class="section-card-header">
      <div class="icon-wrap"><i class="bi bi-shield-lock-fill"></i></div>
      <h6>Keamanan Akun</h6>
    </div>
    <div class="section-card-body">
      <p style="font-size:.82rem;color:#888;margin-bottom:.8rem;">Kelola keamanan dan kata sandi akun Anda.</p>
      <button class="btn btn-outline-secondary btn-sm rounded-pill px-3" onclick="openPasswordModal()">
        <i class="bi bi-key-fill me-1"></i>Ganti Password
      </button>
    </div>
  </div>

  <!-- Logout -->
  <div class="section-card mb-3">
    <div class="section-card-header">
      <div class="icon-wrap" style="background:rgba(220,53,69,0.1);">
        <i class="bi bi-box-arrow-right" style="color:#dc3545;"></i>
      </div>
      <h6 style="color:#dc3545;">Keluar Akun</h6>
    </div>
    <div class="section-card-body">
      <p style="font-size:.82rem;color:#888;margin-bottom:.8rem;">Anda akan keluar dari sesi ini dan diarahkan ke halaman login.</p>
      <button class="btn btn-danger btn-sm rounded-pill px-3" onclick="doLogout()">
        <i class="bi bi-box-arrow-right me-1"></i>Logout
      </button>
    </div>
  </div>

</div><!-- end content -->

<!-- BOTTOM NAV -->
<nav class="bottom-nav">
  <a href="/mahasiswa/dashboard" class="nav-item-btn">
    <i class="bi bi-house-fill"></i><span>Beranda</span>
  </a>
  <a href="/mahasiswa/list_matakuliah" class="nav-item-btn">
    <i class="bi bi-book"></i><span>Mata Kuliah</span>
  </a>
  <a href="/mahasiswa/scan_qr" class="nav-fab">
    <div class="fab"><i class="bi bi-qr-code-scan"></i></div>
  </a>
  <a href="/mahasiswa/izin" class="nav-item-btn">
    <i class="bi bi-file-earmark-text"></i><span>Izin</span>
  </a>
  <a href="/mahasiswa/profile" class="nav-item-btn active">
    <i class="bi bi-person-circle"></i><span>Profil</span>
  </a>
</nav>

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
          <input type="email" class="form-control" id="editEmail" value="{{ $mahasiswa->email ?? auth()->user()->email }}"/>
        </div>
        <div class="mb-3">
          <label class="form-label">No. HP</label>
          <input type="number" class="form-control" id="editHp" value="{{ $mahasiswa->no_hp ?? '' }}"/>
        </div>
        <div class="mb-3">
          <label class="form-label">Alamat</label>
          <textarea class="form-control" id="editAlamat" rows="3">{{ $mahasiswa->alamat ?? '' }}</textarea>
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
  // Render per-MK attendance breakdown
  const mkData = @json($courseBreakdown ?? []);
  const breakdown = document.getElementById('mkBreakdown');
  if (mkData.length > 0) {
    mkData.forEach(m => {
      breakdown.innerHTML += `
        <div class="mb-3">
          <div class="d-flex justify-content-between mb-1">
            <small style="font-size:.82rem;font-weight:600;color:#333;">${m.nama}</small>
            <small style="color:${m.color};font-weight:700;">${m.pct}%</small>
          </div>
          <div class="progress" style="height:7px;border-radius:10px;">
            <div class="progress-bar" style="width:${m.pct}%;background:${m.color};border-radius:10px;"></div>
          </div>
        </div>`;
    });
  } else {
    breakdown.innerHTML = '<p style="font-size:.82rem;color:#888;text-align:center;">Belum ada data kehadiran per mata kuliah</p>';
  }

  // Modals
  const modalEditProfil = new bootstrap.Modal(document.getElementById('modalEditProfil'));
  const modalPassword   = new bootstrap.Modal(document.getElementById('modalPassword'));

  function openEditModal()     { modalEditProfil.show(); }
  function openPasswordModal() { modalPassword.show(); }

  function doLogout() {
    showToast('Logout...', 'secondary');

    setTimeout(() => {
        document.getElementById('logout-form').submit();
    }, 500);
}

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
</script>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

</body>
</html>
