<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mata Kuliah - Ambasen</title>
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
    .btn-maroon { background:linear-gradient(135deg,var(--maroon-dark),#c0003a); color:#fff; border:0; }
    .btn-maroon:hover { color:#fff; filter:brightness(.95); }
    .mk-card { background:#fff; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,.06); border-top:4px solid var(--maroon); height:100%; }
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
    <a href="/dosen/list_mahasiswa"><i class="bi bi-people-fill"></i> Data Mahasiswa</a>
    <a href="/dosen/list_matakuliah" class="active"><i class="bi bi-book-fill"></i> Mata Kuliah</a>
    <a href="/dosen/izin_mahasiswa"><i class="bi bi-file-earmark-check-fill"></i> Izin Mahasiswa</a>
  </nav>
  <div class="nav-section-title">Lainnya</div>
  <nav class="sidebar-nav">
    <a href="/dosen/profile"><i class="bi bi-person-circle"></i> Profil</a>
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
        <div class="page-title">Mata Kuliah</div>
        <small class="text-muted">Data tersimpan di tabel matakuliah dan dipakai saat generate QR.</small>
      </div>
    </div>
    <button class="btn btn-maroon rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
      <i class="bi bi-plus-lg me-1"></i>Tambah Mata Kuliah
    </button>
  </div>

  <div class="p-3 p-md-4">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <div class="row g-3 mb-4">
      <div class="col-6 col-md-3"><div class="bg-white rounded-3 shadow-sm p-3 text-center"><div class="h3 mb-0" style="color:var(--maroon);">{{ $matakuliahs->count() }}</div><small class="text-muted">Total MK</small></div></div>
      <div class="col-6 col-md-3"><div class="bg-white rounded-3 shadow-sm p-3 text-center"><div class="h3 mb-0 text-success">{{ $matakuliahs->where('status', 'Aktif')->count() }}</div><small class="text-muted">Aktif</small></div></div>
      <div class="col-6 col-md-3"><div class="bg-white rounded-3 shadow-sm p-3 text-center"><div class="h3 mb-0 text-primary">{{ $matakuliahs->sum('sks') }}</div><small class="text-muted">Total SKS</small></div></div>
      <div class="col-6 col-md-3"><div class="bg-white rounded-3 shadow-sm p-3 text-center"><div class="h3 mb-0 text-warning">{{ $matakuliahs->sum('qr_sessions_count') }}</div><small class="text-muted">Sesi QR</small></div></div>
    </div>

    <div class="row g-3">
      @forelse($matakuliahs as $matakuliah)
        <div class="col-md-6 col-xl-4">
          <div class="mk-card p-3">
            <div class="d-flex justify-content-between gap-2">
              <div>
                <div class="small fw-bold text-uppercase" style="color:var(--maroon);">{{ $matakuliah->kode_matakuliah }}</div>
                <h6 class="fw-bold mb-1">{{ $matakuliah->nama_matakuliah }}</h6>
                <small class="text-muted">Kelas {{ $matakuliah->kelas ?? '-' }}</small>
              </div>
              <span class="badge h-25 {{ $matakuliah->status === 'Aktif' ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $matakuliah->status }}</span>
            </div>
            <div class="d-flex flex-wrap gap-2 mt-3">
              <span class="badge text-bg-light"><i class="bi bi-award me-1"></i>{{ $matakuliah->sks }} SKS</span>
              <span class="badge text-bg-light"><i class="bi bi-clock me-1"></i>{{ optional($matakuliah->jadwal)->format('H:i') ?? '-' }}</span>
              <span class="badge text-bg-light"><i class="bi bi-geo-alt me-1"></i>{{ $matakuliah->ruang ?? '-' }}</span>
              <span class="badge text-bg-light"><i class="bi bi-qr-code me-1"></i>{{ $matakuliah->qr_sessions_count }} sesi</span>
            </div>
            <div class="d-flex gap-2 mt-3">
              <button class="btn btn-sm btn-outline-primary flex-fill" data-bs-toggle="modal" data-bs-target="#edit{{ $matakuliah->id }}"><i class="bi bi-pencil me-1"></i>Edit</button>
              <a href="/dosen/generate_qr" class="btn btn-sm btn-outline-dark flex-fill"><i class="bi bi-qr-code me-1"></i>QR</a>
              <form method="POST" action="{{ route('dosen.matakuliah.destroy', $matakuliah) }}" onsubmit="return confirm('Hapus mata kuliah ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3"></i></button>
              </form>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="bg-white rounded-3 shadow-sm p-4 text-center text-muted">Belum ada mata kuliah.</div>
        </div>
      @endforelse
    </div>
  </div>
</main>

<div class="modal fade" id="modalTambah" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="{{ route('dosen.matakuliah.store') }}" class="modal-content">
      @csrf
      <div class="modal-header text-white" style="background:var(--maroon);">
        <h5 class="modal-title">Tambah Mata Kuliah</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body row g-3">
        @include('dosen.partials.matakuliah_form', ['matakuliah' => null])
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-maroon">Simpan</button>
      </div>
    </form>
  </div>
</div>

@foreach($matakuliahs as $matakuliah)
  <div class="modal fade" id="edit{{ $matakuliah->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <form method="POST" action="{{ route('dosen.matakuliah.update', $matakuliah) }}" class="modal-content">
        @csrf
        @method('PUT')
        <div class="modal-header text-white" style="background:var(--maroon);">
          <h5 class="modal-title">Edit Mata Kuliah</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          @include('dosen.partials.matakuliah_form', ['matakuliah' => $matakuliah])
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
