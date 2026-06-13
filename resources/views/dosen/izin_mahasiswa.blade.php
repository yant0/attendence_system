<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izin Mahasiswa - Ambasen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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

        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 999;
        }

        .btn-toggle { display: none; background: none; border: none; font-size: 1.4rem; color: #555; }

        .main-content {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            transition: margin .3s;
        }

        .topbar {
            background: #fff;
            padding: .85rem 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
            position: sticky;
            top: 0;
            z-index: 900;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            align-items: center;
        }

        .page-title {
            font-weight: 700;
            color: #1a1a2e;
        }

        .section-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
        }

        .btn-maroon {
            background: linear-gradient(135deg, var(--maroon-dark), #c0003a);
            color: #fff;
            border: 0;
        }

        .btn-maroon:hover {
            color: #fff;
            filter: brightness(.95);
        }

        .table thead th {
            background: #f4f6f9;
            font-size: .78rem;
            text-transform: uppercase;
            color: #555;
        }

        .table td {
            vertical-align: middle;
            font-size: .88rem;
        }

        /* Stat Cards */
        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 1.2rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            display: flex;
            align-items: center;
            gap: .9rem;
            border-left: 4px solid transparent;
        }

        .stat-card .icon-box {
            width: 46px;
            height: 46px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .stat-card .val {
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1;
        }

        .stat-card .lbl {
            font-size: .78rem;
            color: #888;
            margin-top: .1rem;
        }

        /* Avatar */
        .avatar-sm {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: .8rem;
            flex-shrink: 0;
        }

        /* Badge status */
        .badge-menunggu {
            background: rgba(253, 126, 20, 0.12);
            color: #fd7e14;
        }

        .badge-disetujui {
            background: rgba(25, 135, 84, 0.12);
            color: #198754;
        }

        .badge-ditolak {
            background: rgba(220, 53, 69, 0.12);
            color: #dc3545;
        }

        /* Filter tabs */
        .filter-tabs {
            display: flex;
            gap: .4rem;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: .3rem .85rem;
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

        /* Action buttons */
        .btn-acc {
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
            border: none;
            border-radius: 7px;
            padding: .3rem .65rem;
            font-size: .8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
            display: inline-flex;
            align-items: center;
            gap: .3rem;
        }

        .btn-acc:hover {
            background: #198754;
            color: #fff;
        }

        .btn-tolak {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: none;
            border-radius: 7px;
            padding: .3rem .65rem;
            font-size: .8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
            display: inline-flex;
            align-items: center;
            gap: .3rem;
        }

        .btn-tolak:hover {
            background: #dc3545;
            color: #fff;
        }

        .btn-detail {
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            border: none;
            border-radius: 7px;
            padding: .3rem .65rem;
            font-size: .8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .15s;
            display: inline-flex;
            align-items: center;
            gap: .3rem;
        }

        .btn-detail:hover {
            background: #0d6efd;
            color: #fff;
        }

        /* Modal */
        .btn-save-green {
            background: linear-gradient(135deg, #157347, #198754);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: .5rem 1.4rem;
            font-weight: 600;
        }

        .btn-save-green:hover {
            opacity: .9;
            color: #fff;
        }

        .btn-save-red {
            background: linear-gradient(135deg, #b02a37, #dc3545);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: .5rem 1.4rem;
            font-weight: 600;
        }

        .btn-save-red:hover {
            opacity: .9;
            color: #fff;
        }

        .search-box {
            position: relative;
            min-width: 200px;
        }

        .search-box input {
            border-radius: 25px;
            border: 1.5px solid #e0e0e0;
            padding: .4rem 1rem .4rem 2.1rem;
            font-size: .84rem;
            width: 100%;
        }

        .search-box input:focus {
            border-color: var(--maroon);
            box-shadow: 0 0 0 3px rgba(128, 0, 32, .1);
            outline: none;
        }

        .search-box .bi-search {
            position: absolute;
            left: .7rem;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: .85rem;
        }

        .pagination-area {
            padding: .85rem 1.4rem;
            border-top: 1px solid #f0f0f0;
        }

        .table-toolbar {
            padding: 1.1rem 1.4rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: .75rem;
        }

        .table-toolbar h6 {
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
            font-size: .95rem;
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
            <a href="/dosen/dashboard"><i class="bi bi-grid-fill"></i> Dashboard</a>
            <a href="/dosen/generate_qr"><i class="bi bi-qr-code-scan"></i> Generate QR</a>
            <a href="/dosen/list_mahasiswa"><i class="bi bi-people-fill"></i> Data Mahasiswa</a>
            <a href="/dosen/list_matakuliah"><i class="bi bi-book-fill"></i> Mata Kuliah</a>
            <a href="/dosen/izin_mahasiswa" class="active"><i class="bi bi-file-earmark-check-fill"></i> Izin Mahasiswa</a>
        </nav>

        <div class="nav-section-title">Lainnya</div>
        <nav class="sidebar-nav">
            <a href="/dosen/profile"><i class="bi bi-person-circle"></i> Profil</a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="
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

    <main class="main-content">
        <!-- TOPBAR -->
        <div class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
                <div>
                    <div class="page-title">Izin Mahasiswa</div>
                    <small class="text-muted">Kelola pengajuan izin dari mahasiswa.</small>
                </div>
            </div>
            <span class="badge rounded-pill text-bg-warning" id="badgePending" style="font-size:.78rem;display:none;"></span>
        </div>

        <div class="p-3 p-md-4">

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- STAT CARDS -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="stat-card" style="border-left-color:#fd7e14;">
                        <div class="icon-box" style="background:rgba(253,126,20,0.1);color:#fd7e14;"><i class="bi bi-hourglass-split"></i></div>
                        <div>
                            <div class="val" id="scMenunggu">0</div>
                            <div class="lbl">Menunggu</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card" style="border-left-color:#198754;">
                        <div class="icon-box" style="background:rgba(25,135,84,0.1);color:#198754;"><i class="bi bi-check-circle-fill"></i></div>
                        <div>
                            <div class="val" id="scDisetujui">0</div>
                            <div class="lbl">Disetujui</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card" style="border-left-color:#dc3545;">
                        <div class="icon-box" style="background:rgba(220,53,69,0.1);color:#dc3545;"><i class="bi bi-x-circle-fill"></i></div>
                        <div>
                            <div class="val" id="scDitolak">0</div>
                            <div class="lbl">Ditolak</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card" style="border-left-color:var(--maroon);">
                        <div class="icon-box" style="background:rgba(128,0,32,0.1);color:var(--maroon);"><i class="bi bi-file-earmark-text-fill"></i></div>
                        <div>
                            <div class="val" id="scTotal">0</div>
                            <div class="lbl">Total</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLE CARD -->
            <div class="section-card">
                <div class="table-toolbar">
                    <div>
                        <h6><i class="bi bi-file-earmark-check me-2" style="color:var(--maroon);"></i>Daftar Pengajuan Izin</h6>
                        <div class="filter-tabs mt-2">
                            <button class="filter-tab active" onclick="setFilter('semua', this)">Semua</button>
                            <button class="filter-tab" onclick="setFilter('Menunggu', this)">Menunggu</button>
                            <button class="filter-tab" onclick="setFilter('Disetujui', this)">Disetujui</button>
                            <button class="filter-tab" onclick="setFilter('Ditolak', this)">Ditolak</button>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-sm-row gap-2 align-items-start align-items-sm-center">
                        <select class="form-select form-select-sm" style="width:auto;border-radius:20px;font-size:.82rem;" id="filterMk" onchange="renderTable()">
                            <option value="">Semua MK</option>
                            @foreach($matakuliahs as $mk)
                            <option value="{{ $mk->nama_matakuliah }}">{{ $mk->nama_matakuliah }}</option>
                            @endforeach
                        </select>
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" id="searchInput" placeholder="Cari nama / NIM..." oninput="renderTable()" />
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mahasiswa</th>
                                <th>Mata Kuliah</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Diajukan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="izinTable"></tbody>
                    </table>
                </div>

                <div class="pagination-area d-flex align-items-center justify-content-between">
                    <small class="text-muted" id="pageInfo"></small>
                    <div class="d-flex gap-1" id="paginationBtns"></div>
                </div>
            </div>

        </div>
    </main>

    <!-- MODAL: Detail Pengajuan Izin -->
    <div class="modal fade" id="modalDetail" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header text-white" style="background:var(--maroon);">
                    <h5 class="modal-title"><i class="bi bi-file-earmark-text me-2"></i>Detail Pengajuan Izin</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" id="detailModalBody"></div>
                <div class="modal-footer" id="detailModalFooter"></div>
            </div>
        </div>
    </div>

    <!-- MODAL: Konfirmasi Setujui -->
    <div class="modal fade" id="modalAcc" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header text-white" style="background:linear-gradient(135deg,#157347,#198754);">
                    <h5 class="modal-title"><i class="bi bi-check-circle-fill me-2"></i>Setujui Izin</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted" style="font-size:.9rem;" id="accDesc"></p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.83rem;">Catatan untuk Mahasiswa <span class="text-muted fw-normal">(opsional)</span></label>
                        <textarea class="form-control" rows="3" id="accCatatan" placeholder="Contoh: Semoga lekas sembuh, jangan lupa kumpulkan tugas..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-save-green" onclick="confirmAcc()"><i class="bi bi-check-lg me-1"></i>Setujui</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: Konfirmasi Tolak -->
    <div class="modal fade" id="modalTolak" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header text-white" style="background:linear-gradient(135deg,#b02a37,#dc3545);">
                    <h5 class="modal-title"><i class="bi bi-x-circle-fill me-2"></i>Tolak Izin</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted" style="font-size:.9rem;" id="tolakDesc"></p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.83rem;">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" id="tolakAlasan" placeholder="Jelaskan alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-save-red" onclick="confirmTolak()"><i class="bi bi-x-lg me-1"></i>Tolak</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden forms untuk approve/reject -->
    <form id="formApprove" method="POST" style="display:none;">
        @csrf
        @method('PATCH')
        <input type="hidden" name="catatan_dosen" id="formApproveCatatan">
    </form>
    <form id="formReject" method="POST" style="display:none;">
        @csrf
        @method('PATCH')
        <input type="hidden" name="catatan_dosen" id="formRejectCatatan">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let izinData = @json($izinJson);
        const approveUrlTemplate = @json(route('dosen.izin.approve', ['izin' => '__ID__']));
        const rejectUrlTemplate = @json(route('dosen.izin.reject', ['izin' => '__ID__']));

        const ROWS = 8;
        let currentPage = 1;
        let activeFilter = 'semua';
        let actionId = null;

        const jenisCfg = {
            'Sakit': {
                icon: 'bi-thermometer-half',
                color: '#dc3545'
            },
            'Izin Keluarga': {
                icon: 'bi-house-heart-fill',
                color: '#6f42c1'
            },
            'Kegiatan Kampus': {
                icon: 'bi-trophy-fill',
                color: '#0d6efd'
            },
            'Lainnya': {
                icon: 'bi-three-dots',
                color: '#888'
            },
        };
        const avatarColors = ['#800020', '#0d6efd', '#198754', '#fd7e14', '#6f42c1', '#0dcaf0', '#d63384', '#20c997'];

        function initials(n) {
            return n.split(' ').slice(0, 2).map(w => w[0]).join('').toUpperCase();
        }

        function fmtTgl(t) {
            return new Date(t).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });
        }

        function setFilter(f, el) {
            activeFilter = f;
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            currentPage = 1;
            renderTable();
        }

        function getFiltered() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            const mk = document.getElementById('filterMk').value;
            return izinData.filter(i =>
                (activeFilter === 'semua' || i.status === activeFilter) &&
                (mk ? i.mk === mk : true) &&
                (i.nama.toLowerCase().includes(q) || i.nim.toLowerCase().includes(q) || i.mk.toLowerCase().includes(q))
            );
        }

        function updateStats() {
            const m = izinData.filter(i => i.status === 'Menunggu').length;
            document.getElementById('scMenunggu').textContent = m;
            document.getElementById('scDisetujui').textContent = izinData.filter(i => i.status === 'Disetujui').length;
            document.getElementById('scDitolak').textContent = izinData.filter(i => i.status === 'Ditolak').length;
            document.getElementById('scTotal').textContent = izinData.length;
            const badge = document.getElementById('badgePending');
            if (m > 0) {
                badge.textContent = m + ' menunggu';
                badge.style.display = '';
            } else badge.style.display = 'none';
        }

        function renderTable() {
            updateStats();
            const filtered = getFiltered();
            const pages = Math.ceil(filtered.length / ROWS) || 1;
            if (currentPage > pages) currentPage = 1;
            const start = (currentPage - 1) * ROWS;
            const slice = filtered.slice(start, start + ROWS);

            document.getElementById('pageInfo').textContent = `Halaman ${currentPage} dari ${pages} · ${filtered.length} data`;

            const tb = document.getElementById('izinTable');
            tb.innerHTML = '';
            if (!slice.length) {
                tb.innerHTML = '<tr><td colspan="8" class="text-center text-muted py-5"><i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>Tidak ada data</td></tr>';
            }

            slice.forEach((iz, i) => {
                const idx = izinData.indexOf(iz);
                const color = avatarColors[idx % avatarColors.length];
                const jc = jenisCfg[iz.jenis] || jenisCfg['Lainnya'];

                let statusBadge, aksiHtml;
                if (iz.status === 'Menunggu') {
                    statusBadge = `<span class="badge badge-menunggu rounded-pill px-2"><i class="bi bi-hourglass-split me-1"></i>Menunggu</span>`;
                    aksiHtml = `<button class="btn-detail me-1" onclick="openDetail(${iz.id})"><i class="bi bi-eye"></i></button>
                       <button class="btn-acc me-1" onclick="openAcc(${iz.id})"><i class="bi bi-check-lg"></i> ACC</button>
                       <button class="btn-tolak" onclick="openTolak(${iz.id})"><i class="bi bi-x-lg"></i> Tolak</button>`;
                } else if (iz.status === 'Disetujui') {
                    statusBadge = `<span class="badge badge-disetujui rounded-pill px-2"><i class="bi bi-check-circle-fill me-1"></i>Disetujui</span>`;
                    aksiHtml = `<button class="btn-detail" onclick="openDetail(${iz.id})"><i class="bi bi-eye me-1"></i>Detail</button>`;
                } else {
                    statusBadge = `<span class="badge badge-ditolak rounded-pill px-2"><i class="bi bi-x-circle-fill me-1"></i>Ditolak</span>`;
                    aksiHtml = `<button class="btn-detail" onclick="openDetail(${iz.id})"><i class="bi bi-eye me-1"></i>Detail</button>`;
                }

                tb.innerHTML += `
        <tr>
          <td class="text-muted">${start+i+1}</td>
          <td>
            <div class="d-flex align-items-center gap-2">
              <div class="avatar-sm" style="background:${color}20;color:${color};">${initials(iz.nama)}</div>
              <div>
                <div class="fw-semibold" style="font-size:.87rem;">${iz.nama}</div>
                <small class="text-muted">${iz.nim}</small>
              </div>
            </div>
          </td>
          <td style="font-size:.84rem;">${iz.mk}</td>
          <td>
            <span style="font-size:.8rem;background:${jc.color}15;color:${jc.color};padding:.2rem .55rem;border-radius:20px;font-weight:600;">
              <i class="bi ${jc.icon} me-1"></i>${iz.jenis}
            </span>
          </td>
          <td style="font-size:.84rem;">${fmtTgl(iz.tgl)}</td>
          <td style="font-size:.82rem;color:#888;">${fmtTgl(iz.diajukan)}</td>
          <td>${statusBadge}</td>
          <td><div class="d-flex gap-1 flex-wrap">${aksiHtml}</div></td>
        </tr>`;
            });

            const pb = document.getElementById('paginationBtns');
            pb.innerHTML = '';
            for (let p = 1; p <= pages; p++) {
                const active = p === currentPage;
                pb.innerHTML += `<button class="btn btn-sm ${active ? 'text-white' : 'btn-light'}"
        style="${active ? 'background:var(--maroon);border-color:var(--maroon);' : ''}"
        onclick="goPage(${p})">${p}</button>`;
            }
        }

        function goPage(p) {
            currentPage = p;
            renderTable();
        }

        const mDetail = new bootstrap.Modal(document.getElementById('modalDetail'));
        const mAcc = new bootstrap.Modal(document.getElementById('modalAcc'));
        const mTolak = new bootstrap.Modal(document.getElementById('modalTolak'));

        function openDetail(id) {
            const iz = izinData.find(i => i.id === id);
            const jc = jenisCfg[iz.jenis] || jenisCfg['Lainnya'];
            const statusColor = iz.status === 'Disetujui' ? '#198754' : iz.status === 'Ditolak' ? '#dc3545' : '#fd7e14';
            const statusIcon = iz.status === 'Disetujui' ? 'bi-check-circle-fill' : iz.status === 'Ditolak' ? 'bi-x-circle-fill' : 'bi-hourglass-split';

            document.getElementById('detailModalBody').innerHTML = `
      <div class="d-flex align-items-center gap-3 mb-3 pb-3" style="border-bottom:1px solid #f0f0f0;">
        <div style="width:50px;height:50px;border-radius:12px;background:${jc.color}18;color:${jc.color};display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;">
          <i class="bi ${jc.icon}"></i>
        </div>
        <div>
          <div style="font-weight:700;font-size:.95rem;">${iz.nama} <span style="font-size:.78rem;color:#888;font-weight:400;">(${iz.nim})</span></div>
          <div style="font-size:.8rem;color:#888;">${iz.mk}</div>
        </div>
      </div>
      <div class="row g-2 mb-3">
        <div class="col-6"><div style="background:#f8f9fa;border-radius:8px;padding:.6rem .8rem;">
          <div style="font-size:.7rem;color:#888;font-weight:700;text-transform:uppercase;">Jenis</div>
          <div style="font-size:.85rem;font-weight:600;">${iz.jenis}</div>
        </div></div>
        <div class="col-6"><div style="background:#f8f9fa;border-radius:8px;padding:.6rem .8rem;">
          <div style="font-size:.7rem;color:#888;font-weight:700;text-transform:uppercase;">Tanggal Izin</div>
          <div style="font-size:.85rem;font-weight:600;">${fmtTgl(iz.tgl)}</div>
        </div></div>
        <div class="col-6"><div style="background:#f8f9fa;border-radius:8px;padding:.6rem .8rem;">
          <div style="font-size:.7rem;color:#888;font-weight:700;text-transform:uppercase;">Diajukan</div>
          <div style="font-size:.85rem;font-weight:600;">${fmtTgl(iz.diajukan)}</div>
        </div></div>
        <div class="col-6"><div style="background:#f8f9fa;border-radius:8px;padding:.6rem .8rem;">
          <div style="font-size:.7rem;color:#888;font-weight:700;text-transform:uppercase;">Status</div>
          <div style="font-size:.85rem;font-weight:700;color:${statusColor};"><i class="bi ${statusIcon} me-1"></i>${iz.status}</div>
        </div></div>
      </div>
      <div style="background:#f8f9fa;border-radius:8px;padding:.75rem .9rem;margin-bottom:${iz.catatan ? '.75rem' : '0'};">
        <div style="font-size:.7rem;color:#888;font-weight:700;text-transform:uppercase;margin-bottom:.3rem;">Keterangan Mahasiswa</div>
        <div style="font-size:.87rem;color:#333;">${iz.ket}</div>
      </div>
      ${iz.catatan ? `<div style="background:${statusColor}10;border:1px solid ${statusColor}30;border-radius:8px;padding:.75rem .9rem;">
        <div style="font-size:.7rem;color:${statusColor};font-weight:700;text-transform:uppercase;margin-bottom:.3rem;">Catatan Dosen</div>
        <div style="font-size:.87rem;color:#333;">${iz.catatan}</div>
      </div>` : ''}`;

            const footer = document.getElementById('detailModalFooter');
            if (iz.status === 'Menunggu') {
                footer.innerHTML = `
        <button class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
        <button class="btn btn-save-red" onclick="mDetail.hide();openTolak(${iz.id})"><i class="bi bi-x-lg me-1"></i>Tolak</button>
        <button class="btn btn-save-green" onclick="mDetail.hide();openAcc(${iz.id})"><i class="bi bi-check-lg me-1"></i>Setujui</button>`;
            } else {
                footer.innerHTML = `<button class="btn btn-light" data-bs-dismiss="modal">Tutup</button>`;
            }
            mDetail.show();
        }

        function openAcc(id) {
            actionId = id;
            const iz = izinData.find(i => i.id === id);
            document.getElementById('accDesc').textContent = `Setujui izin "${iz.jenis}" dari ${iz.nama} (${iz.nim}) untuk mata kuliah ${iz.mk} pada ${fmtTgl(iz.tgl)}?`;
            document.getElementById('accCatatan').value = '';
            mAcc.show();
        }

        function confirmAcc() {
            const iz = izinData.find(i => i.id === actionId);
            const catatan = document.getElementById('accCatatan').value.trim();
            const form = document.getElementById('formApprove');
            form.action = approveUrlTemplate.replace('__ID__', actionId);
            document.getElementById('formApproveCatatan').value = catatan || 'Izin disetujui.';
            mAcc.hide();
            form.submit();
        }

        function openTolak(id) {
            actionId = id;
            const iz = izinData.find(i => i.id === id);
            document.getElementById('tolakDesc').textContent = `Tolak izin "${iz.jenis}" dari ${iz.nama} (${iz.nim}) untuk mata kuliah ${iz.mk} pada ${fmtTgl(iz.tgl)}?`;
            document.getElementById('tolakAlasan').value = '';
            mTolak.show();
        }

        function confirmTolak() {
            const alasan = document.getElementById('tolakAlasan').value.trim();
            if (!alasan) {
                showToast('Alasan penolakan wajib diisi!', 'danger');
                return;
            }
            const form = document.getElementById('formReject');
            form.action = rejectUrlTemplate.replace('__ID__', actionId);
            document.getElementById('formRejectCatatan').value = alasan;
            mTolak.hide();
            form.submit();
        }

        function showToast(msg, type) {
            // Gunakan bootstrap alert sederhana jika tidak ada toast container
            const toastEl = document.getElementById('mainToast');
            if (toastEl) {
                toastEl.className = `toast align-items-center border-0 text-bg-${type}`;
                document.getElementById('toastMsg').textContent = msg;
                new bootstrap.Toast(toastEl, {
                    delay: 3000
                }).show();
            } else {
                alert(msg);
            }
        }

        renderTable();

        // Sidebar toggle for mobile
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('overlay').classList.toggle('show');
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('show');
            document.getElementById('overlay').classList.remove('show');
        }
    </script>

    <!-- Toast (opsional, jika ingin notifikasi halus) -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index:9999;">
        <div id="mainToast" class="toast align-items-center border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body" id="toastMsg">Berhasil!</div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

</body>

</html>
