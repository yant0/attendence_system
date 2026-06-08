<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Mahasiswa - Ambasen</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    :root { --maroon:#800020; --maroon-dark:#5a0016; --sidebar-w:260px; --gray-bg:#f4f6f9; }
    body { font-family:'Segoe UI', sans-serif; background:var(--gray-bg); }
    .sidebar { position:fixed; top:0; left:0; width:var(--sidebar-w); height:100vh; background:linear-gradient(180deg,var(--maroon-dark) 0%,var(--maroon) 100%); display:flex; flex-direction:column; z-index:1000; transition:transform .3s; overflow-y:auto; }
    .sidebar-brand { padding:1.5rem 1.2rem 1rem; border-bottom:1px solid rgba(255,255,255,0.12); }
    .sidebar-brand .logo-circle { width:48px; height:48px; background:rgba(255,255,255,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center; border:2px solid rgba(255,255,255,0.3); margin-bottom:.6rem; }
    .sidebar-brand .logo-circle i { color:#fff; font-size:1.4rem; }
    .sidebar-brand h5 { color:#fff; font-weight:700; letter-spacing:1.5px; margin:0; font-size:1.1rem; }
    .sidebar-brand small { color:rgba(255,255,255,0.6); font-size:0.75rem; }
    .sidebar-user { margin:.8rem 1rem; padding:.75rem; background:rgba(255,255,255,0.1); border-radius:10px; display:flex; align-items:center; gap:.75rem; }
    .sidebar-user .avatar { width:40px; height:40px; border-radius:50%; background:#ffd700; display:flex; align-items:center; justify-content:center; font-weight:700; color:var(--maroon-dark); font-size:1rem; }
    .sidebar-user .info .name { color:#fff; font-size:0.88rem; font-weight:600; }
    .sidebar-user .info .role { color:rgba(255,255,255,0.6); font-size:0.75rem; }
    .nav-section-title { color:rgba(255,255,255,0.45); font-size:0.7rem; font-weight:700; letter-spacing:1px; text-transform:uppercase; padding:1rem 1.2rem .3rem; }
    .sidebar-nav a { display:flex; align-items:center; gap:.75rem; padding:.65rem 1.2rem; color:rgba(255,255,255,0.75); text-decoration:none; font-size:0.9rem; border-radius:0 25px 25px 0; margin:.1rem .8rem .1rem 0; transition:all .2s; }
    .sidebar-nav a:hover,.sidebar-nav a.active { background:rgba(255,255,255,0.18); color:#fff; }
    .sidebar-nav a.active { font-weight:600; }
    .sidebar-nav a i { font-size:1rem; width:22px; }
    .sidebar-footer { margin-top:auto; padding:1rem; border-top:1px solid rgba(255,255,255,0.12); }
    .sidebar-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:999; }
    .btn-toggle { display:none; background:none; border:none; font-size:1.4rem; color:#555; }
    .main-content { margin-left:var(--sidebar-w); min-height:100vh; transition:margin .3s; }
    .topbar { background:#fff; padding:.85rem 1.5rem; box-shadow:0 2px 10px rgba(0,0,0,.06); position:sticky; top:0; z-index:900; display:flex; justify-content:space-between; gap:1rem; align-items:center; }
    .page-title { font-weight:700; color:#1a1a2e; }
    .section-card { background:#fff; border-radius:14px; box-shadow:0 2px 12px rgba(0,0,0,.06); }
    .btn-maroon { background:linear-gradient(135deg,var(--maroon-dark),#c0003a); color:#fff; border:0; }
    .btn-maroon:hover { color:#fff; filter:brightness(.95); }
    .table thead th { background:#f4f6f9; font-size:.78rem; text-transform:uppercase; color:#555; }
    .table td { vertical-align:middle; font-size:.88rem; }
    @media (max-width:991px) { .sidebar { transform:translateX(-100%); } .sidebar.show { transform:translateX(0); } .sidebar-overlay.show { display:block; } .main-content { margin-left:0; } .btn-toggle { display:block; } }
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
    <a href="/dosen/list_mahasiswa" class="active"><i class="bi bi-people-fill"></i> Data Mahasiswa</a>
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
      <button type="submit" style="width:100%;background:none;border:none;display:flex;align-items:center;gap:.6rem;color:rgba(255,255,255,0.7);padding:.5rem .8rem;border-radius:8px;">
        <i class="bi bi-box-arrow-left"></i> Keluar
      </button>
    </form>
  </div>
</aside>

<main class="main-content">
  <div class="topbar">
    <div class="d-flex align-items-center gap-3">
      <button class="btn-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
      <div>
        <div class="page-title">Data Mahasiswa</div>
        <small class="text-muted">Data berasal dari tabel users, mahasiswas, dan presensis.</small>
      </div>
    </div>
    <button class="btn btn-maroon rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
      <i class="bi bi-plus-lg me-1"></i>Tambah Mahasiswa
    </button>
  </div>

  <div class="p-3 p-md-4">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="section-card">
      <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
        <div>
          <h6 class="mb-0"><i class="bi bi-people me-2" style="color:var(--maroon);"></i>Daftar Mahasiswa</h6>
          <small class="text-muted">{{ $mahasiswas->count() }} data mahasiswa</small>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead>
          <tr>
            <th>#</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Jurusan</th>
            <th>Angkatan</th>
            <th>Email Login</th>
            <th>Presensi</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
          @forelse($mahasiswas as $mahasiswa)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td><code>{{ $mahasiswa->nim }}</code></td>
              <td>{{ $mahasiswa->nama }}</td>
              <td>{{ $mahasiswa->jurusan }}</td>
              <td>{{ $mahasiswa->angkatan ?? '-' }}</td>
              <td>{{ $mahasiswa->user->email ?? $mahasiswa->email }}</td>
              <td>{{ $mahasiswa->presensis_count }}</td>
              <td>
                <span class="badge {{ $mahasiswa->status === 'Aktif' ? 'text-bg-success' : ($mahasiswa->status === 'Cuti' ? 'text-bg-warning' : 'text-bg-secondary') }}">
                  {{ $mahasiswa->status }}
                </span>
              </td>
              <td class="text-nowrap">
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#edit{{ $mahasiswa->id }}">
                  <i class="bi bi-pencil"></i>
                </button>
                <form method="POST" action="{{ route('dosen.mahasiswa.destroy', $mahasiswa) }}" class="d-inline" onsubmit="return confirm('Hapus mahasiswa ini?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3"></i></button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="text-center text-muted py-4">Belum ada data mahasiswa.</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="{{ route('dosen.mahasiswa.store') }}" class="modal-content">
      @csrf
      <div class="modal-header text-white" style="background:var(--maroon);">
        <h5 class="modal-title">Tambah Mahasiswa</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        @include('dosen.partials.mahasiswa_form', ['mahasiswa' => null])
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-maroon">Simpan</button>
      </div>
    </form>
  </div>
</div>

@foreach($mahasiswas as $mahasiswa)
  <div class="modal fade" id="edit{{ $mahasiswa->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <form method="POST" action="{{ route('dosen.mahasiswa.update', $mahasiswa) }}" class="modal-content">
        @csrf
        @method('PUT')
        <div class="modal-header text-white" style="background:var(--maroon);">
          <h5 class="modal-title">Edit Mahasiswa</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          @include('dosen.partials.mahasiswa_form', ['mahasiswa' => $mahasiswa])
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-maroon">Simpan</button>
        </div>
      </form>
    </div>
  </div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
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
