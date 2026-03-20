<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - PT Sumber Prima Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --sidebar-width: 260px;
            --bg-light: #f4f6f9;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
            color: #333;
            overflow-x: hidden;
        }
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            background-color: #fff;
            border-right: 1px solid #e0e0e0;
            z-index: 1000;
            padding: 20px;
        }
        .sidebar-brand { display: flex; align-items: center; margin-bottom: 40px; }
        .sidebar-brand img { width: 40px; height: 40px; margin-right: 10px; }
        .sidebar-brand-text h6 { margin: 0; font-weight: 700; color: #333; }
        .sidebar-brand-text span { font-size: 0.8rem; color: #777; }
        .nav-link {
            display: flex; align-items: center; color: #555; padding: 10px 15px;
            border-radius: 8px; margin-bottom: 5px; transition: all 0.3s; text-decoration: none;
        }
        .nav-link i { margin-right: 12px; font-size: 1.1rem; }
        .nav-link:hover { background-color: rgba(13, 110, 253, 0.05); color: var(--primary-color); }
        .nav-link.active { background-color: var(--primary-color); color: #fff; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: #999; letter-spacing: 1px; margin: 20px 0 10px 15px; }
        #main-content { margin-left: var(--sidebar-width); padding: 20px 40px; min-height: 100vh; }
        #top-navbar { margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        .search-bar { width: 400px; }
        .user-profile { display: flex; align-items: center; gap: 10px; padding: 5px 15px; border: 1px solid #e0e0e0; border-radius: 50px; background-color: #fff; }
        .custom-card { background: #fff; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); height: 100%; }
        .card-border-blue   { border: 2px solid #e0ebff; }
        .card-border-yellow { border: 2px solid #fff3cd; }
        .card-border-orange { border: 2px solid #ffe5d0; }
        .card-border-green  { border: 2px solid #d1f2e2; }
        .icon-box { width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-bottom: 15px; }
        .icon-blue   { background: #eff5ff; color: var(--primary-color); }
        .icon-yellow { background: #fffdf0; color: #ffc107; }
        .icon-orange { background: #fff6f0; color: #fd7e14; }
        .icon-green  { background: #f0fdf4; color: #198754; }
        .chart-toggle-btn { border: 1px solid #eee; background: #f8f9fa; color: #6c757d; font-size: 13px; padding: 5px 15px; }
        .chart-toggle-btn.active { background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.05); font-weight: 600; color: var(--primary-color); border-radius: 6px; }
        .legend-item { background: #fff; border: 1px solid #eee; padding: 10px 15px; border-radius: 10px; text-align: center; width: 80px; cursor: pointer; transition: 0.2s; }
        .legend-item:hover { border-color: var(--primary-color); transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
        .dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 5px; }
        .activity-feed { background: #fffdfa; }
        .timeline { list-style: none; padding-left: 10px; }
        .timeline-item { position: relative; padding-left: 25px; padding-bottom: 20px; display: flex; justify-content: space-between; cursor: pointer; transition: 0.2s; border-radius: 8px; }
        .timeline-item:hover { background-color: #f8f9fa; padding-right: 10px; }
        .timeline-item::before { content: ''; position: absolute; left: 0; top: 6px; width: 8px; height: 8px; border-radius: 50%; }
        .timeline-item.dot-blue::before   { background-color: var(--primary-color); }
        .timeline-item.dot-green::before  { background-color: #20c997; }
        .timeline-item.dot-grey::before   { background-color: #adb5bd; }
        .timeline-item.dot-yellow::before { background-color: #ffc107; }
        .time-text { font-size: 12px; color: #adb5bd; }
    </style>
</head>
<body>

{{-- ── SIDEBAR ── --}}
<div id="sidebar">
    <div class="sidebar-brand">
        <img src="https://via.placeholder.com/40/0d6efd/ffffff?text=S" alt="Logo" style="border-radius:50%;">
        <div class="sidebar-brand-text">
            <h6>PT Sumber Prima Mandiri</h6>
            <span>Production System</span>
        </div>
    </div>
    <nav class="nav flex-column">
        {{-- Sesuai file: dasbord.blade.php --}}
        <a class="nav-link active" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-grid-1x2"></i> Dashboard
        </a>
        {{-- Sesuai file: request.blade.php --}}
        <a class="nav-link" href="{{ route('admin.permintaan.index') }}">
            <i class="bi bi-file-earmark-text"></i> Request Management
        </a>
        {{-- Sesuai file: planing.blade.php --}}
        <a class="nav-link" href="{{ route('admin.schedule.index') }}">
            <i class="bi bi-calendar-event"></i> Production Planning
        </a>
        {{-- Sesuai file: master.blade.php --}}
        <a class="nav-link" href="{{ route('admin.part-list.index') }}">
            <i class="bi bi-ui-checks"></i> Master Schedule
        </a>
        <div class="sidebar-heading">AKUN</div>
        <a class="nav-link" href="{{ route('profile') }}">
            <i class="bi bi-person"></i> Profil Saya
        </a>
        <a class="nav-link text-danger" href="{{ route('logout') }}">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </nav>
</div>

{{-- ── MAIN CONTENT ── --}}
<div id="main-content">
    <div id="top-navbar">
        <div class="search-bar input-group">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" class="form-control border-start-0" placeholder="Search request, machine, activity...">
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="position-relative" style="cursor: pointer;">
                <i class="bi bi-bell fs-5 text-secondary"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">2</span>
            </div>
            <div class="user-profile">
                <div style="width:35px;height:35px;border-radius:50%;background:var(--primary-color);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:14px;">
                    {{ strtoupper(substr($user->nama ?? $user->email, 0, 1)) }}
                </div>
                <div class="lh-sm">
                    <div class="fw-bold" style="font-size: 0.85rem;">{{ $user->nama ?? $user->email }}</div>
                    <div style="font-size: 0.7rem; color: var(--primary-color);">{{ $user->role_name }}</div>
                </div>
            </div>
            <a href="{{ route('logout') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="container-fluid p-0">
        <div class="mb-4">
            <h3 class="fw-bold mb-1">Admin Dashboard</h3>
            <p class="text-muted">Gambaran umum pemantauan & pengendalian produksi — {{ now()->translatedFormat('d F Y') }}</p>
        </div>

        {{-- STAT CARDS --}}
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="custom-card card-border-blue">
                    <div class="icon-box icon-blue"><i class="bi bi-file-earmark-text"></i></div>
                    <p class="text-muted mb-1" style="font-size: 14px;">Total Permintaan</p>
                    <h2 class="fw-bold mb-0">{{ $data['total_permintaan'] }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="custom-card card-border-yellow">
                    <div class="icon-box icon-yellow"><i class="bi bi-clock"></i></div>
                    <p class="text-muted mb-1" style="font-size: 14px;">Dalam Proses</p>
                    <h2 class="fw-bold mb-0">{{ $data['permintaan_inprogress'] }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="custom-card card-border-orange">
                    <div class="icon-box icon-orange"><i class="bi bi-exclamation-circle"></i></div>
                    <p class="text-muted mb-1" style="font-size: 14px;">Mesin Maintenance</p>
                    <h2 class="fw-bold mb-0">{{ $data['mesin_maintenance'] }}</h2>
                </div>
            </div>
            <div class="col-md-3">
                <div class="custom-card card-border-green">
                    <div class="icon-box icon-green"><i class="bi bi-check-circle"></i></div>
                    <p class="text-muted mb-1" style="font-size: 14px;">Mesin Aktif</p>
                    <h2 class="fw-bold mb-0">{{ $data['mesin_aktif'] }}</h2>
                </div>
            </div>
        </div>

        {{-- CHARTS --}}
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="custom-card border-0">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-bold mb-0">Tren Produksi</h5>
                            <small class="text-muted">Kinerja produksi dari waktu ke waktu</small>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn chart-toggle-btn active">Bulanan</button>
                            <button type="button" class="btn chart-toggle-btn">Triwulan</button>
                            <button type="button" class="btn chart-toggle-btn">Tahunan</button>
                        </div>
                    </div>
                    <canvas id="trenProduksiChart" height="100"></canvas>
                    <div class="text-center mt-3" style="font-size: 12px;">
                        <span class="me-3"><span class="dot bg-primary"></span> Jumlah Permintaan</span>
                        <span><span class="dot bg-warning"></span> Garis Tren</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="custom-card border-0">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h5 class="fw-bold mb-0">Tren Aktivitas Produksi</h5>
                            <small class="text-muted">Distribusi berdasarkan status</small>
                        </div>
                        <a href="{{ route('admin.permintaan.index') }}" class="text-primary text-decoration-none" style="font-size: 13px;">
                            Detail <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between h-100">
                        <div style="width: 200px;">
                            <canvas id="aktivitasChart"></canvas>
                        </div>
                        <div class="d-flex flex-column gap-2">
                            @php
                                $statusColors = [
                                    'draft'       => '#adb5bd',
                                    'submitted'   => '#0d6efd',
                                    'in_progress' => '#ffc107',
                                    'completed'   => '#20c997',
                                    'rejected'    => '#dc3545',
                                ];
                            @endphp
                            @forelse($data['permintaan_by_status'] as $status => $jumlah)
                            <div class="legend-item"
                                 onclick="window.location.href='{{ route('admin.permintaan.index') }}'"
                                 title="Lihat di Request Management">
                                <small class="text-muted">
                                    <span class="dot" style="background:{{ $statusColors[$status] ?? '#0d6efd' }}"></span>
                                    {{ ucfirst(str_replace('_',' ',$status)) }}
                                </small>
                                <h5 class="fw-bold mb-0 mt-1">{{ $jumlah }}</h5>
                            </div>
                            @empty
                                <p class="text-muted" style="font-size:12px">Belum ada data</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RECENT ACTIVITY --}}
        <div class="row">
            <div class="col-12">
                <div class="custom-card activity-feed border-0 border-1 border-warning-subtle">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-bold mb-0">Recent Activity Feed</h5>
                            <small class="text-muted">Permintaan terbaru masuk ke sistem</small>
                        </div>
                        <a href="{{ route('admin.permintaan.index') }}" class="text-primary fw-bold text-decoration-none" style="font-size: 14px;">
                            View All
                        </a>
                    </div>

                    @if(isset($data['permintaan_terbaru']) && $data['permintaan_terbaru']->isNotEmpty())
                        <ul class="timeline mb-0">
                            @foreach($data['permintaan_terbaru'] as $p)
                            @php
                                $dotClass = match($p->status) {
                                    'submitted'   => 'dot-blue',
                                    'in_progress' => 'dot-yellow',
                                    'completed'   => 'dot-green',
                                    default       => 'dot-grey'
                                };
                            @endphp
                            <li class="timeline-item {{ $dotClass }}"
                                onclick="window.location.href='{{ route('admin.permintaan.index') }}'">
                                <span class="text-dark" style="font-size: 14px;">
                                    Request <strong>{{ $p->kode_permintaan ?? 'REQ-'.$p->permintaan_id }}</strong>
                                    — {{ $p->nama_permintaan ?? '-' }}
                                </span>
                                <span class="time-text">
                                    {{ \Carbon\Carbon::parse($p->tanggal_permintaan)->diffForHumans() }}
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted" style="font-size: 13px;">Belum ada permintaan masuk.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const permintaanByMonth  = @json($data['permintaan_by_month']);
    const permintaanByStatus = @json($data['permintaan_by_status']);

    const months  = Object.keys(permintaanByMonth);
    const monthly = Object.values(permintaanByMonth);

    const statusLabels = Object.keys(permintaanByStatus);
    const statusValues = Object.values(permintaanByStatus);
    const colorMap = {
        'draft'      : '#adb5bd',
        'submitted'  : '#0d6efd',
        'in_progress': '#ffc107',
        'completed'  : '#20c997',
        'rejected'   : '#dc3545',
    };
    const bgColors = statusLabels.map(s => colorMap[s] ?? '#0d6efd');

    // Chart Tren Produksi
    new Chart(document.getElementById('trenProduksiChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: months.map(m => {
                const d = new Date(m + '-01');
                return d.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
            }),
            datasets: [
                {
                    type: 'line',
                    label: 'Garis Tren',
                    data: monthly,
                    borderColor: '#ffc107',
                    backgroundColor: '#ffc107',
                    borderWidth: 2, tension: 0.4,
                    pointBackgroundColor: '#ffc107',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2, pointRadius: 4
                },
                {
                    type: 'bar',
                    label: 'Jumlah Permintaan',
                    data: monthly,
                    backgroundColor: '#0d6efd',
                    borderRadius: 4, barPercentage: 0.6
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5,5], color: '#eee' }, border: { display: false } },
                x: { grid: { display: false }, border: { display: false } }
            }
        }
    });

    // Chart Status Permintaan (Doughnut)
    new Chart(document.getElementById('aktivitasChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusValues.length ? statusValues : [1],
                backgroundColor: statusValues.length ? bgColors : ['#eee'],
                borderWidth: 5, borderColor: '#fff', hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: { legend: { display: false } }
        }
    });
</script>
</body>
</html>