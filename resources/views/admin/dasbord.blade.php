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

        /* ==========================================
           --- SIDEBAR STYLES (Sama seperti sebelumnya) ---
           ========================================== */
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

        /* ==========================================
           --- MAIN CONTENT & NAVBAR ---
           ========================================== */
        #main-content {
            margin-left: var(--sidebar-width);
            padding: 20px 40px;
            min-height: 100vh;
        }
        #top-navbar { margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        .search-bar { width: 400px; }
        .user-profile { display: flex; align-items: center; gap: 10px; padding: 5px 15px; border: 1px solid #e0e0e0; border-radius: 50px; background-color: #fff; }
        .user-profile img { width: 35px; height: 35px; border-radius: 50%; }

        /* ==========================================
           --- DASHBOARD SPECIFIC STYLES ---
           ========================================== */
        .custom-card {
            background: #fff; border-radius: 16px; padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            height: 100%;
        }
        
        /* Colored Borders for Top Cards */
        .card-border-blue { border: 2px solid #e0ebff; }
        .card-border-yellow { border: 2px solid #fff3cd; }
        .card-border-orange { border: 2px solid #ffe5d0; }
        .card-border-green { border: 2px solid #d1f2e2; }

        .icon-box {
            width: 40px; height: 40px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; margin-bottom: 15px;
        }
        .icon-blue { background: #eff5ff; color: var(--primary-color); }
        .icon-yellow { background: #fffdf0; color: #ffc107; }
        .icon-orange { background: #fff6f0; color: #fd7e14; }
        .icon-green { background: #f0fdf4; color: #198754; }

        /* Chart Area */
        .chart-toggle-btn {
            border: 1px solid #eee; background: #f8f9fa; color: #6c757d;
            font-size: 13px; padding: 5px 15px;
        }
        .chart-toggle-btn.active { background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.05); font-weight: 600; color: var(--primary-color); border-radius: 6px; }

        /* Custom Legend for Doughnut */
        .legend-item { 
            background: #fff; border: 1px solid #eee; padding: 10px 15px; 
            border-radius: 10px; text-align: center; width: 80px;
            cursor: pointer; transition: 0.2s;
        }
        .legend-item:hover { border-color: var(--primary-color); transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.05);}
        .dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 5px; }

        /* Activity Feed Timeline */
        .activity-feed { background: #fffdfa; }
        .timeline { list-style: none; padding-left: 10px; }
        .timeline-item { 
            position: relative; padding-left: 25px; padding-bottom: 20px; 
            display: flex; justify-content: space-between;
            cursor: pointer; transition: 0.2s; border-radius: 8px;
        }
        .timeline-item:hover { background-color: #f8f9fa; padding-right: 10px; }
        .timeline-item::before {
            content: ''; position: absolute; left: 0; top: 6px;
            width: 8px; height: 8px; border-radius: 50%;
        }
        .timeline-item.dot-blue::before { background-color: var(--primary-color); }
        .timeline-item.dot-green::before { background-color: #20c997; }
        .timeline-item.dot-grey::before { background-color: #adb5bd; }
        .timeline-item.dot-yellow::before { background-color: #ffc107; }
        .time-text { font-size: 12px; color: #adb5bd; }
    </style>
</head>
<body>

    <div id="sidebar">
        <div class="sidebar-brand">
            <img src="https://via.placeholder.com/40/0d6efd/ffffff?text=S" alt="Logo" style="border-radius:50%;">
            <div class="sidebar-brand-text">
                <h6>PT Sumber Prima Mandiri</h6>
                <span>Production System</span>
            </div>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link active" href="{{ route('admin.dasbord') }}"><i class="bi bi-grid-1x2"></i> Dashboard</a>
            <a class="nav-link" href="{{ route('admin.request') }}"><i class="bi bi-file-earmark-text"></i> Request Management</a>
            <a class="nav-link" href="{{ route('admin.planning') }}"><i class="bi bi-calendar-event"></i> Production Planning</a>
            <a class="nav-link" href="{{ route('admin.master') }}"><i class="bi bi-ui-checks"></i> Master Schedule</a>
            <div class="sidebar-heading">SUPPORT</div>
            <a class="nav-link" href="#"><i class="bi bi-gear"></i> Settings</a>
            <a class="nav-link" href="#"><i class="bi bi-question-circle"></i> Help Desk</a>
        </nav>
    </div>

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
                    <img src="https://via.placeholder.com/35/0d6efd/ffffff?text=AG" alt="User">
                    <div class="lh-sm">
                        <div class="fw-bold" style="font-size: 0.85rem;">Andrew Gunawan</div>
                        <div style="font-size: 0.7rem; color: var(--primary-color);">Admin</div>
                    </div>
                </div>
                <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </div>
        </div>

        <div class="container-fluid p-0">
            
            <div class="mb-4">
                <h3 class="fw-bold mb-1">Admin Dashboard</h3>
                <p class="text-muted">Gambaran umum pemantauan & pengendalian produksi</p>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="custom-card card-border-blue">
                        <div class="icon-box icon-blue"><i class="bi bi-file-earmark-text"></i></div>
                        <p class="text-muted mb-1" style="font-size: 14px;">Total Permintaan</p>
                        <h2 class="fw-bold mb-0">3</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="custom-card card-border-yellow">
                        <div class="icon-box icon-yellow"><i class="bi bi-clock"></i></div>
                        <p class="text-muted mb-1" style="font-size: 14px;">Dalam Proses</p>
                        <h2 class="fw-bold mb-0">2</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="custom-card card-border-orange">
                        <div class="icon-box icon-orange"><i class="bi bi-exclamation-circle"></i></div>
                        <p class="text-muted mb-1" style="font-size: 14px;">Menunggu QC</p>
                        <h2 class="fw-bold mb-0">0</h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="custom-card card-border-green">
                        <div class="icon-box icon-green"><i class="bi bi-check-circle"></i></div>
                        <p class="text-muted mb-1" style="font-size: 14px;">Selesai</p>
                        <h2 class="fw-bold mb-0">0</h2>
                    </div>
                </div>
            </div>

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
                            <span class="me-3"><span class="dot bg-primary"></span> Jumlah Keluaran</span>
                            <span><span class="dot bg-warning"></span> Garis Tren</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="custom-card border-0">
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h5 class="fw-bold mb-0">Tren Aktivitas Produksi</h5>
                                <small class="text-muted">Distribusi 7 aktivitas</small>
                            </div>
                            <a href="planing.html" class="text-primary text-decoration-none" style="font-size: 13px;">Detail <i class="bi bi-arrow-right"></i></a>
                        </div>
                        
                        <div class="d-flex align-items-center justify-content-between h-100">
                            <div style="width: 200px;">
                                <canvas id="aktivitasChart"></canvas>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <div class="legend-item" onclick="window.location.href='planing.html'" title="Lihat di Production Planning">
                                    <small class="text-muted"><span class="dot bg-primary"></span> Plan</small>
                                    <h5 class="fw-bold mb-0 mt-1">2</h5>
                                </div>
                                <div class="legend-item" onclick="window.location.href='planing.html'" title="Lihat di Production Planning">
                                    <small class="text-muted"><span class="dot bg-warning"></span> Act</small>
                                    <h5 class="fw-bold mb-0 mt-1">2</h5>
                                </div>
                                <div class="legend-item" onclick="window.location.href='planing.html'" title="Lihat di Production Planning">
                                    <small class="text-muted"><span class="dot" style="background-color: #20c997;"></span> Done</small>
                                    <h5 class="fw-bold mb-0 mt-1">3</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="custom-card activity-feed border-0 border-1 border-warning-subtle">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="fw-bold mb-0">Recent Activity Feed</h5>
                                <small class="text-muted">Latest system updates and changes</small>
                            </div>
                            <a href="request.html" class="text-primary fw-bold text-decoration-none" style="font-size: 14px;">View All</a>
                        </div>
                        
                        <ul class="timeline mb-0">
                            <li class="timeline-item dot-blue" onclick="window.location.href='request.html'">
                                <span class="text-dark" style="font-size: 14px;">Request REQ-2025-001 ditambahkan</span>
                                <span class="time-text">10 menit lalu</span>
                            </li>
                            <li class="timeline-item dot-green" onclick="window.location.href='request.html'">
                                <span class="text-dark" style="font-size: 14px;">Activity MC pada Mesin CNC-01 selesai</span>
                                <span class="time-text">25 menit lalu</span>
                            </li>
                            <li class="timeline-item dot-grey" onclick="window.location.href='request.html'">
                                <span class="text-dark" style="font-size: 14px;">BOM untuk REQ-2025-001 telah dibuat</span>
                                <span class="time-text">1 jam lalu</span>
                            </li>
                            <li class="timeline-item dot-yellow" onclick="window.location.href='request.html'">
                                <span class="text-dark" style="font-size: 14px;">Activity WELD pada Mesin WLD-02 dimulai</span>
                                <span class="time-text">2 jam lalu</span>
                            </li>
                            <li class="timeline-item dot-grey" onclick="window.location.href='request.html'">
                                <span class="text-dark" style="font-size: 14px;">Request REQ-2025-002 approved</span>
                                <span class="time-text">3 jam lalu</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div> 
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // 1. Chart Tren Produksi (Combo: Bar & Line)
        const ctxProduksi = document.getElementById('trenProduksiChart').getContext('2d');
        new Chart(ctxProduksi, {
            type: 'bar',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus'],
                datasets: [
                    {
                        type: 'line',
                        label: 'Garis Tren',
                        data: [42, 48, 50, 55, 58, 62, 68, 70],
                        borderColor: '#ffc107',
                        backgroundColor: '#ffc107',
                        borderWidth: 2,
                        tension: 0.4,
                        pointBackgroundColor: '#ffc107',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    },
                    {
                        type: 'bar',
                        label: 'Jumlah Keluaran',
                        data: [45, 52, 48, 62, 58, 68, 73, 70], 
                        backgroundColor: '#0d6efd', /* Diubah menggunakan warna primary biru yang selaras */
                        borderRadius: 4,
                        barPercentage: 0.6
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } }, 
                scales: {
                    y: { beginAtZero: true, max: 80, grid: { borderDash: [5, 5], color: '#eee' }, border: {display: false} },
                    x: { grid: { display: false }, border: {display: false} }
                }
            }
        });

        // 2. Chart Tren Aktivitas Produksi (Doughnut)
        const ctxAktivitas = document.getElementById('aktivitasChart').getContext('2d');
        new Chart(ctxAktivitas, {
            type: 'doughnut',
            data: {
                labels: ['Plan', 'Act', 'Done'],
                datasets: [{
                    data: [2, 2, 3], // 2 Plan, 2 Act, 3 Done
                    backgroundColor: ['#0d6efd', '#ffc107', '#20c997'], /* Diubah menggunakan primary color */
                    borderWidth: 5,
                    borderColor: '#fff',
                    hoverOffset: 4
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