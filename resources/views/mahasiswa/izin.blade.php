<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Pengajuan Izin – Ambasen</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <style>
    :root {
      --maroon: #800020;
      --maroon-dark: #5a0016;
      --gray-bg: #f4f6f9;
      --nav-h: 65px;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: var(--gray-bg);
      padding-bottom: var(--nav-h);
    }

    /* TOP HEADER */
    .top-header {
      background: linear-gradient(135deg, var(--maroon-dark), var(--maroon));
      padding: 1rem 1.2rem 1.4rem;
      position: relative;
      overflow: hidden;
    }

    .top-header::after {
      content: '';
      position: absolute;
      z-index: -100;
      width: 160px;
      height: 160px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.05);
      bottom: -60px;
      right: -40px;
    }

    .top-header .title {
      color: #fff;
      font-weight: 700;
      font-size: 1.1rem;
    }

    .top-header small {
      color: rgba(255, 255, 255, 0.7);
      font-size: .78rem;
    }

    .back-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.15);
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      text-decoration: none;
    }

    /* STATS STRIP */
    .stats-strip {
      display: flex;
      gap: .8rem;
      background: rgba(255, 255, 255, 0.12);
      border-radius: 12px;
      padding: .8rem 1rem;
      margin-top: .8rem;
    }

    .stat-item {
      text-align: center;
      flex: 1;
    }

    .stat-item .val {
      color: #ffd700;
      font-weight: 700;
      font-size: 1.2rem;
    }

    .stat-item .lbl {
      color: rgba(255, 255, 255, 0.7);
      font-size: .68rem;
    }

    /* SECTION CARD */
    .section-card {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
      overflow: hidden;
    }

    .section-card-header {
      padding: .9rem 1.2rem;
      border-bottom: 1px solid #f0f0f0;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .section-card-header .title-wrap {
      display: flex;
      align-items: center;
      gap: .6rem;
    }

    .section-card-header .icon-wrap {
      width: 34px;
      height: 34px;
      border-radius: 9px;
      background: rgba(128, 0, 32, 0.1);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .section-card-header .icon-wrap i {
      color: var(--maroon);
      font-size: .95rem;
    }

    .section-card-header h6 {
      margin: 0;
      font-weight: 700;
      color: #1a1a2e;
      font-size: .9rem;
    }

    /* IZIN CARD */
    .izin-card {
      display: flex;
      align-items: center;
      gap: .9rem;
      padding: .9rem 1.2rem;
      border-bottom: 1px solid #f5f5f5;
      transition: background .15s;
      cursor: pointer;
    }

    .izin-card:last-child {
      border-bottom: none;
    }

    .izin-card:hover {
      background: #fafafa;
    }

    .izin-icon {
      width: 44px;
      height: 44px;
      border-radius: 11px;
      flex-shrink: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
    }

    .izin-mk {
      font-size: .88rem;
      font-weight: 600;
      color: #1a1a2e;
    }

    .izin-meta {
      font-size: .75rem;
      color: #888;
    }

    /* FILTER TABS */
    .filter-tabs {
      display: flex;
      gap: .4rem;
      padding: .8rem 1.2rem;
      background: #fff;
      border-bottom: 1px solid #f0f0f0;
      overflow-x: auto;
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    .filter-tabs::-webkit-scrollbar {
      display: none;
    }

    .filter-tab {
      flex-shrink: 0;
      padding: .35rem .9rem;
      border-radius: 20px;
      border: 1.5px solid #e0e0e0;
      background: #fff;
      font-size: .78rem;
      font-weight: 600;
      color: #888;
      cursor: pointer;
      transition: all .2s;
    }

    .filter-tab.active {
      background: var(--maroon);
      border-color: var(--maroon);
      color: #fff;
    }

    /* EMPTY STATE */
    .empty-state {
      text-align: center;
      padding: 2.5rem 1rem;
      color: #aaa;
    }

    .empty-state i {
      font-size: 3rem;
      margin-bottom: .8rem;
      display: block;
    }

    .empty-state p {
      font-size: .85rem;
      margin: 0;
    }

    /* BOTTOM NAV */
    .bottom-nav {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      height: var(--nav-h);
      background: #fff;
      border-top: 1px solid #eee;
      display: flex;
      z-index: 1000;
      box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.07);
    }

    .nav-item-btn {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      border: none;
      background: none;
      color: #aaa;
      cursor: pointer;
      font-size: .65rem;
      font-weight: 600;
      gap: .2rem;
      transition: color .2s;
      text-decoration: none;
      padding: 0;
    }

    .nav-item-btn i {
      font-size: 1.3rem;
    }

    .nav-item-btn.active {
      color: var(--maroon);
    }

    .nav-item-btn.active i {
      position: relative;
    }

    .nav-item-btn.active i::after {
      content: '';
      position: absolute;
      bottom: -4px;
      left: 50%;
      transform: translateX(-50%);
      width: 4px;
      height: 4px;
      border-radius: 50%;
      background: var(--maroon);
    }

    .nav-fab {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      border: none;
      background: none;
      cursor: pointer;
      text-decoration: none;
    }

    .nav-fab .fab {
      width: 54px;
      height: 54px;
      background: linear-gradient(135deg, var(--maroon-dark), #c0003a);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 1.5rem;
      box-shadow: 0 4px 16px rgba(128, 0, 32, 0.35);
      margin-top: -20px;
      border: 3px solid #fff;
    }

    /* FAB AJUKAN */
    .fab-ajukan {
      position: fixed;
      bottom: calc(var(--nav-h) + 1rem);
      right: 1.2rem;
      width: 52px;
      height: 52px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--maroon-dark), #c0003a);
      color: #fff;
      border: none;
      font-size: 1.4rem;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 18px rgba(128, 0, 32, 0.4);
      cursor: pointer;
      z-index: 999;
      transition: transform .2s;
    }

    .fab-ajukan:hover {
      transform: scale(1.08);
    }

    /* MODAL */
    .form-label {
      font-weight: 600;
      font-size: .83rem;
      color: #444;
    }

    .form-control,
    .form-select {
      border-radius: 8px;
      border: 1.5px solid #e0e0e0;
      font-size: .9rem;
      padding: .55rem .9rem;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: var(--maroon);
      box-shadow: 0 0 0 3px rgba(128, 0, 32, 0.12);
    }

    /* OFFCANVAS DETAIL */
    .offcanvas {
      border-radius: 20px 20px 0 0 !important;
    }

    .offcanvas-header {
      border-bottom: none;
      padding: 1rem 1.2rem .5rem;
    }

    /* TOAST */
    .toast-container {
      position: fixed;
      bottom: calc(var(--nav-h) + 1rem);
      left: 50%;
      transform: translateX(-50%);
      z-index: 9999;
    }

    #modalAjukan .modal-dialog {
      max-height: 90vh;
    }

    #modalAjukan .modal-content {
      max-height: 120vh;
    }

    #modalAjukan .modal-body {
      overflow-y: auto;
    }
  </style>
</head>

<body>

  <!-- TOP HEADER -->
  <div class="top-header">
    <div class="d-flex align-items-center justify-content-between mb-2">
      <div class="d-flex align-items-center gap-2">
        <a href="/mahasiswa/dashboard" class="back-btn">
          <i class="bi bi-arrow-left"></i>
        </a>
        <div>
          <div class="title">Pengajuan Izin</div>
          <small>{{ auth()->user()->name }} · NIM {{ auth()->user()->mahasiswaProfile->nim ?? '-' }}</small>
        </div>
      </div>
      <!-- <button class="btn btn-sm rounded-pill text-white fw-semibold"
      style="background:rgba(255,255,255,0.2);border:1.5px solid rgba(255,255,255,0.4);font-size:.8rem;"
      onclick="openAjukanModal()">
      <i class="bi bi-plus-lg me-1"></i>Ajukan
    </button> -->
    </div>
    <div class="stats-strip">
      <div class="stat-item">
        <div class="val" id="statTotal">{{ $izins->count() }}</div>
        <div class="lbl">Total</div>
      </div>
      <div class="stat-item">
        <div class="val" style="color:#ffd700;" id="statMenunggu">{{ $izins->where('status', 'Menunggu')->count() }}
        </div>
        <div class="lbl">Menunggu</div>
      </div>
      <div class="stat-item">
        <div class="val" style="color:#90ee90;" id="statDisetujui">{{ $izins->where('status', 'Disetujui')->count() }}
        </div>
        <div class="lbl">Disetujui</div>
      </div>
      <div class="stat-item">
        <div class="val" style="color:#ff9999;" id="statDitolak">{{ $izins->where('status', 'Ditolak')->count() }}</div>
        <div class="lbl">Ditolak</div>
      </div>
    </div>
  </div>

  <!-- FILTER TABS -->
  <div class="filter-tabs" id="filterTabs">
    <button class="filter-tab active" onclick="setFilter('semua', this)">Semua</button>
    <button class="filter-tab" onclick="setFilter('Menunggu', this)">Menunggu</button>
    <button class="filter-tab" onclick="setFilter('Disetujui', this)">Disetujui</button>
    <button class="filter-tab" onclick="setFilter('Ditolak', this)">Ditolak</button>
  </div>

  <!-- FLASH MESSAGE -->
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show m-3 mb-0" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show m-3 mb-0" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <!-- CONTENT -->
  <div class="p-3" style="max-width:640px;margin:auto;">
    <div class="section-card">
      <div class="section-card-header">
        <div class="title-wrap">
          <div class="icon-wrap"><i class="bi bi-file-earmark-text-fill"></i></div>
          <h6>Riwayat Pengajuan</h6>
        </div>
        <small class="text-muted" id="jumlahTampil">{{ $izins->count() }} pengajuan</small>
      </div>
      <div id="izinListContainer">
        @forelse($izins as $izin)
          @php
            $statusColor = match ($izin->status) {
              'Disetujui' => '#198754',
              'Ditolak' => '#dc3545',
              default => '#fd7e14',
            };
            $statusIcon = match ($izin->status) {
              'Disetujui' => 'bi-check-circle-fill',
              'Ditolak' => 'bi-x-circle-fill',
              default => 'bi-hourglass-split',
            };
            $jenisIcon = match ($izin->jenis ?? '') {
              'Sakit' => 'bi-thermometer-half',
              'Izin Keluarga' => 'bi-house-heart-fill',
              'Kegiatan Kampus' => 'bi-trophy-fill',
              default => 'bi-three-dots',
            };
            $jenisColor = match ($izin->jenis ?? '') {
              'Sakit' => '#dc3545',
              'Izin Keluarga' => '#6f42c1',
              'Kegiatan Kampus' => '#0d6efd',
              default => '#888',
            };
          @endphp
          <div class="izin-card" data-status="{{ $izin->status }}" onclick="openDetail({{ $izin->id }})">
            <div class="izin-icon" style="background:{{ $jenisColor }}18;color:{{ $jenisColor }};">
              <i class="bi {{ $jenisIcon }}"></i>
            </div>
            <div class="flex-grow-1">
              <div class="izin-mk">{{ $izin->matakuliah->nama_matakuliah ?? $izin->kode_matakuliah ?? '-' }}</div>
              <div class="izin-meta">
                <i class="bi bi-tag me-1"></i>{{ $izin->jenis }}
                &nbsp;·&nbsp;
                <i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($izin->tanggal)->isoFormat('D MMM YYYY') }}
              </div>
            </div>
            <div class="text-end">
              <span class="badge rounded-pill"
                style="background:{{ $statusColor }}18;color:{{ $statusColor }};font-size:.72rem;">
                <i class="bi {{ $statusIcon }} me-1"></i>{{ $izin->status }}
              </span>
            </div>
          </div>
        @empty
          <div class="empty-state">
            <i class="bi bi-file-earmark-x"></i>
            <p>Belum ada pengajuan izin</p>
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <!-- FAB -->
  <button class="fab-ajukan" onclick="openAjukanModal()" title="Ajukan Izin">
    <i class="bi bi-plus-lg"></i>
  </button>

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
    <a href="/mahasiswa/izin" class="nav-item-btn active">
      <i class="bi bi-file-earmark-text"></i><span>Izin</span>
    </a>
    <a href="/mahasiswa/profile" class="nav-item-btn">
      <i class="bi bi-person-circle"></i><span>Profil</span>
    </a>
  </nav>

  <!-- MODAL Ajukan Izin -->
  <div class="modal fade" id="modalAjukan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content border-0 shadow">
        <div class="modal-header"
          style="background:linear-gradient(135deg,var(--maroon-dark),var(--maroon));color:#fff;border:none;">
          <h5 class="modal-title"><i class="bi bi-file-earmark-plus me-2"></i>Ajukan Izin / Sakit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:invert(1);"></button>
        </div>
        <form method="POST" action="{{ route('mahasiswa.izin.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="modal-body p-4">
            <div class="mb-3">
              <label class="form-label">Jenis Izin</label>
              <select class="form-select" name="jenis" required>
                <option value="Sakit">Sakit</option>
                <option value="Izin Keluarga">Izin Keluarga</option>
                <option value="Kegiatan Kampus">Kegiatan Kampus</option>
                <option value="Lainnya">Lainnya</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Mata Kuliah</label>
              <select class="form-select" name="kode_matakuliah" required>
                @foreach($matakuliahs as $mk)
                  <option value="{{ $mk->kode_matakuliah }}">{{ $mk->nama_matakuliah }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Tanggal</label>
              <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Keterangan</label>
              <textarea class="form-control" rows="3" name="keterangan" placeholder="Jelaskan alasan izin Anda..."
                required></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Lampiran <span class="text-muted fw-normal">(opsional)</span></label>
              <input type="file" class="form-control" name="lampiran" accept="image/*,.pdf" />
              <div class="form-text">Surat dokter, surat keterangan, dll.</div>
            </div>
          </div>
          <div class="modal-footer" style="border-top:1px solid #f0f0f0;">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn text-white fw-semibold"
              style="background:var(--maroon);border:none;border-radius:8px;">
              <i class="bi bi-send me-1"></i>Kirim Pengajuan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- OFFCANVAS Detail -->
  <div class="offcanvas offcanvas-bottom" tabindex="-1" id="detailCanvas" style="height:auto;max-height:85vh;">
    <div class="offcanvas-header">
      <div style="width:40px;height:4px;background:#ddd;border-radius:2px;margin:0 auto;"></div>
    </div>
    <div class="offcanvas-body pt-0 pb-4" id="detailBody"></div>
  </div>

  <!-- TOAST -->
  <div class="toast-container">
    <div id="mainToast" class="toast align-items-center border-0" role="alert">
      <div class="d-flex">
        <div class="toast-body" id="toastMsg"></div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>

  <!-- Logout form (hidden) -->
  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // ── DATA dari Blade ──
    const izinData = @json($izinJson);

    // ── CONFIG ──
    const statusCfg = {
      'Menunggu': { color: '#fd7e14', bg: 'rgba(253,126,20,0.1)', icon: 'bi-hourglass-split' },
      'Disetujui': { color: '#198754', bg: 'rgba(25,135,84,0.1)', icon: 'bi-check-circle-fill' },
      'Ditolak': { color: '#dc3545', bg: 'rgba(220,53,69,0.1)', icon: 'bi-x-circle-fill' },
    };
    const jenisCfg = {
      'Sakit': { icon: 'bi-thermometer-half', color: '#dc3545' },
      'Izin Keluarga': { icon: 'bi-house-heart-fill', color: '#6f42c1' },
      'Kegiatan Kampus': { icon: 'bi-trophy-fill', color: '#0d6efd' },
      'Lainnya': { icon: 'bi-three-dots', color: '#888' },
    };

    let activeFilter = 'semua';

    // ── FILTER ──
    function setFilter(f, el) {
      activeFilter = f;
      document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
      el.classList.add('active');

      const cards = document.querySelectorAll('.izin-card');
      let visible = 0;
      cards.forEach(card => {
        const show = f === 'semua' || card.dataset.status === f;
        card.style.display = show ? 'flex' : 'none';
        if (show) visible++;
      });

      // empty state
      const container = document.getElementById('izinListContainer');
      const existing = container.querySelector('.empty-state-js');
      if (visible === 0) {
        if (!existing) {
          const el = document.createElement('div');
          el.className = 'empty-state empty-state-js';
          el.innerHTML = `<i class="bi bi-file-earmark-x"></i><p>Tidak ada pengajuan dengan status ini</p>`;
          container.appendChild(el);
        }
      } else {
        if (existing) existing.remove();
      }

      document.getElementById('jumlahTampil').textContent = visible + ' pengajuan';
    }

    // ── FORMAT TANGGAL ──
    function formatTgl(tgl) {
      if (!tgl || tgl === '-') return '-';
      return new Date(tgl).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
    }

    // ── OPEN DETAIL ──
    function openDetail(id) {
      const iz = izinData.find(i => i.id === id);
      if (!iz) return;
      const sc = statusCfg[iz.status] ?? statusCfg['Menunggu'];
      const jc = jenisCfg[iz.jenis] ?? jenisCfg['Lainnya'];

      document.getElementById('detailBody').innerHTML = `
      <div class="d-flex align-items-center gap-3 mb-3">
        <div style="width:52px;height:52px;border-radius:13px;background:${jc.color}18;color:${jc.color};
          display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;">
          <i class="bi ${jc.icon}"></i>
        </div>
        <div>
          <div style="font-weight:700;font-size:1rem;color:#1a1a2e;">${iz.mk}</div>
          <div style="font-size:.8rem;color:#888;">${iz.jenis} · Diajukan ${formatTgl(iz.diajukan)}</div>
        </div>
      </div>

      <div class="p-3 rounded-3 mb-3"
        style="background:${sc.bg};border:1px solid ${sc.color}30;">
        <div class="d-flex align-items-center gap-2">
          <i class="bi ${sc.icon}" style="color:${sc.color};font-size:1.2rem;"></i>
          <div>
            <div style="font-weight:700;color:${sc.color};">${iz.status}</div>
            ${iz.catatan ? `<div style="font-size:.8rem;color:#555;margin-top:.2rem;">${iz.catatan}</div>` : ''}
          </div>
        </div>
      </div>

      <div class="mb-3">
        <div style="font-size:.75rem;font-weight:700;color:#888;text-transform:uppercase;letter-spacing:.5px;margin-bottom:.5rem;">
          Detail Pengajuan
        </div>
        <div class="d-flex flex-column gap-2">
          <div class="d-flex gap-2 align-items-center p-2 rounded-2" style="background:#f4f6f9;">
            <i class="bi bi-calendar3" style="color:var(--maroon);width:18px;"></i>
            <span style="font-size:.83rem;color:#555;">Tanggal:</span>
            <span style="font-size:.83rem;font-weight:600;">${formatTgl(iz.tgl)}</span>
          </div>
          <div class="d-flex gap-2 align-items-start p-2 rounded-2" style="background:#f4f6f9;">
            <i class="bi bi-chat-left-text" style="color:var(--maroon);width:18px;margin-top:.1rem;"></i>
            <div>
              <span style="font-size:.83rem;color:#555;">Keterangan:</span>
              <div style="font-size:.83rem;font-weight:500;margin-top:.1rem;">${iz.ket}</div>
            </div>
          </div>
        </div>
      </div>

      ${iz.status === 'Menunggu' ? `
        <form method="POST" action="/mahasiswa/izin/${iz.id}/batal">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 w-100"
            onclick="return confirm('Batalkan pengajuan ini?')">
            <i class="bi bi-x-circle me-1"></i>Batalkan Pengajuan
          </button>
        </form>` : ''}
    `;

      new bootstrap.Offcanvas(document.getElementById('detailCanvas')).show();
    }

    // ── MODAL ──
    const modalAjukan = new bootstrap.Modal(document.getElementById('modalAjukan'));
    function openAjukanModal() {
      modalAjukan.show();
    }

    // ── TOAST ──
    function showToast(msg, type) {
      const toast = document.getElementById('mainToast');
      toast.className = `toast align-items-center border-0 text-bg-${type}`;
      document.getElementById('toastMsg').textContent = msg;
      new bootstrap.Toast(toast, { delay: 3500 }).show();
    }

    // Tampilkan flash sebagai toast jika ada
    @if(session('success'))
      showToast('{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
      showToast('{{ session('error') }}', 'danger');
    @endif
  </script>
</body>

</html>
