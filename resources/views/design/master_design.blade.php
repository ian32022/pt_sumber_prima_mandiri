<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Schedule - PT Sumber Prima Mandiri</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- Global Styles --- */
        body { font-family: 'Inter', sans-serif; background-color: #F8F9FB; color: #101828; }
        
        /* Sidebar (Sama seperti modul sebelumnya) */
        .sidebar { min-height: 100vh; background-color: #fff; border-right: 1px solid #eaecf0; padding-top: 20px; }
        .logo-area { display: flex; align-items: center; padding: 0 24px 30px 24px; }
        .logo-icon { width: 40px; height: 40px; background-color: #2F6BFF; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 24px; margin-right: 12px; }
        .company-name { font-weight: 700; font-size: 14px; line-height: 1.2; }
        .sidebar-nav .nav-link { color: #475467; font-weight: 500; padding: 12px 24px; margin: 0 16px 4px 16px; border-radius: 8px; display: flex; align-items: center; gap: 12px; }
        .sidebar-nav .nav-link:hover { background-color: #f9fafb; color: #101828; }
        .sidebar-nav .nav-link.active { background-color: #2F6BFF; color: white; }
        
        /* Top Bar */
        .top-bar { background-color: #fff; padding: 16px 32px; border-bottom: 1px solid #eaecf0; display: flex; justify-content: space-between; align-items: center; }
        .user-profile { display: flex; align-items: center; gap: 16px; }
        .user-role { background-color: #F2F4F7; color: #344054; font-size: 12px; padding: 2px 8px; border-radius: 16px; font-weight: 500; }
        .logout-btn { border: 1px solid #d0d5dd; color: #344054; padding: 8px 16px; border-radius: 8px; background: white; font-weight: 600; font-size: 14px; text-decoration: none; display: flex; align-items: center; gap: 8px; }

        /* --- Page Specific Styles --- */
        .page-title { font-size: 24px; font-weight: 600; margin-bottom: 4px; }
        .page-subtitle { color: #475467; font-size: 14px; margin-bottom: 24px; }

        /* Custom Alerts */
        .alert-info-custom { background-color: #EFF8FF; border: 1px solid #B2DDFF; color: #175CD3; border-radius: 12px; font-size: 14px; }
        .alert-warning-custom { background-color: #FFFAEB; border: 1px solid #FEDF89; color: #B54708; border-radius: 12px; font-size: 14px; }

        /* Stat Cards */
        .stat-card { background: white; border: 1px solid #eaecf0; border-radius: 12px; padding: 24px; height: 100%; }
        .stat-icon { width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 20px; }
        .bg-icon-blue { background-color: #EFF8FF; color: #2F6BFF; }
        .bg-icon-orange { background-color: #FFFAEB; color: #B54708; }
        .bg-icon-green { background-color: #ECFDF3; color: #027A48; }
        .stat-value { font-size: 30px; font-weight: 600; color: #101828; margin-bottom: 4px; }
        .stat-label { font-size: 14px; color: #475467; }

        /* Tables & Content */
        .content-card { background: white; border: 1px solid #eaecf0; border-radius: 12px; padding: 24px; margin-top: 24px; }
        .table thead th { font-size: 12px; color: #475467; font-weight: 600; background-color: #F9FAFB; border-bottom: 1px solid #eaecf0; padding: 12px 16px; text-transform: uppercase; }
        .table tbody td { padding: 16px 16px; color: #101828; font-size: 14px; vertical-align: middle; border-bottom: 1px solid #eaecf0; }
        
        /* Interactive Rows */
        .clickable-row { cursor: pointer; transition: background-color 0.2s; }
        .clickable-row:hover { background-color: #F9FAFB; }

        /* Badges */
        .badge-code { 
            background-color: #EFF8FF; 
            color: #2F6BFF; 
            padding: 4px 8px; 
            border-radius: 6px; 
            font-weight: 600; 
            font-size: 12px; 
            display: inline-block;
        }
        .status-pill {
            padding: 4px 12px;
            border-radius: 16px;
            font-size: 12px;
            font-weight: 500;
        }
        .status-act { background-color: #FFFAEB; color: #B54708; } /* Orange */
        .status-done { background-color: #ECFDF3; color: #027A48; } /* Green */

        /* Back Link */
        .back-link { color: #475467; text-decoration: none; font-weight: 500; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 16px; cursor: pointer; }
        .back-link:hover { color: #2F6BFF; }

        /* Detail View Specifics */
        .detail-label { font-size: 12px; font-weight: 600; color: #475467; text-transform: uppercase; margin-bottom: 8px; }
        .detail-value { font-size: 14px; color: #101828; font-weight: 400; }
        
        /* View Switching Logic */
        .view-section { display: none; }
        .view-section.active { display: block; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="logo-area">
                <div class="logo-icon">S</div>
                <div class="company-name">PT Sumber<br>Prima Mandiri<br><small class="text-muted fw-normal">Design System</small></div>
            </div>
            <ul class="nav flex-column sidebar-nav">
                <li class="nav-item"><a class="nav-link" href="dasboard.html"><i class="bi bi-grid-fill"></i> Dashboards</a></li>
                <li class="nav-item"><a class="nav-link" href="request.html"><i class="bi bi-file-text"></i> Request Management</a></li>
                <li class="nav-item"><a class="nav-link active" href="master.html"><i class="bi bi-calendar-check"></i> Master Schedule</a></li>
            </ul>
        </nav>

        <main class="col-md-10 ms-sm-auto px-0">
            <header class="top-bar">
                <div class="position-relative" style="width: 400px;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" class="form-control ps-5" placeholder="Search request, machine, activity...">
                </div>
                <div class="user-profile">
                    <div class="position-relative me-3"><i class="bi bi-bell fs-5 text-secondary"></i><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">2</span></div>
                    <div class="d-flex align-items-center gap-3 bg-white border rounded p-2 pe-4">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="bi bi-person"></i></div>
                        <div><div style="font-weight: 600; font-size: 14px;">Vannia Ariawati</div><div class="user-role">Design</div></div>
                    </div>
                    <a href="#" class="logout-btn"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </div>
            </header>

            <div class="p-4" style="background-color: #F8F9FB; min-height: 90vh;">
                
                <div id="view-schedule-list" class="view-section active">
                    <div class="mb-4">
                        <h2 class="page-title">Master Schedule</h2>
                        <p class="page-subtitle">View-Only Monitoring Table - Source: Excel MASTER SCHEDULE</p>
                    </div>

                    <div class="alert alert-info-custom d-flex align-items-start gap-3 mb-4">
                        <i class="bi bi-info-circle fs-5"></i>
                        <div>
                            <div class="fw-semibold mb-1">View-Only Monitoring</div>
                            <div>Jadwal Utama ini hanya untuk memantau kemajuan produksi. Klik baris mana pun untuk melihat detail aktivitas. Eksekusi aktivitas terjadi di Jadwal Operator MFG.</div>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-3">
                            <div class="stat-card">
                                <div class="stat-icon bg-icon-blue"><i class="bi bi-calendar-event"></i></div>
                                <div class="stat-value">2</div>
                                <div class="stat-label">Total Activities</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <div class="stat-icon bg-icon-blue"><i class="bi bi-clock"></i></div>
                                <div class="stat-value">0</div>
                                <div class="stat-label">Plan</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <div class="stat-icon bg-icon-orange"><i class="bi bi-arrow-repeat"></i></div>
                                <div class="stat-value" style="color: #B54708;">2</div>
                                <div class="stat-label">Act</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card">
                                <div class="stat-icon bg-icon-green"><i class="bi bi-check-circle"></i></div>
                                <div class="stat-value" style="color: #027A48;">0</div>
                                <div class="stat-label">Done</div>
                            </div>
                        </div>
                    </div>

                    <div class="content-card mt-0">
                        <div class="mb-3">
                            <h5 class="fw-bold fs-6">Master Schedule - Activity Monitoring</h5>
                            <p class="text-muted small">Aggregated from Excel schedule (6) - Click row to view details</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Aktivitas Kode</th>
                                        <th>Sub Aktivitas</th>
                                        <th>Plan</th>
                                        <th>Aktual</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="clickable-row" onclick="showDetail('MC')">
                                        <td><span class="badge-code">MC</span></td>
                                        <td class="fw-medium">CNC Milling 01 - Gear Shaft</td>
                                        <td>25/1/2025</td>
                                        <td>25/1/2025</td>
                                        <td><span class="status-pill status-act">Act</span></td>
                                    </tr>
                                    <tr class="clickable-row" onclick="showDetail('HT')">
                                        <td><span class="badge-code">HT</span></td>
                                        <td class="fw-medium">Heat Treatment Furnace - Gear Shaft</td>
                                        <td>26/1/2025</td>
                                        <td>26/1/2025</td>
                                        <td><span class="status-pill status-act">Act</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="alert alert-warning-custom d-flex align-items-start gap-3 mt-4">
                        <i class="bi bi-exclamation-circle fs-5"></i>
                        <div>
                            <div class="fw-semibold mb-1">Admin Permissions</div>
                            <div>Admin hanya dapat melihat jadwal ini. Tidak dapat membuat, mengedit, atau memperbarui status aktivitas. Semua pembaruan status dilakukan oleh Operator di Schedule MFG dan secara otomatis tercermin di sini.</div>
                        </div>
                    </div>
                </div>

                <div id="view-schedule-detail" class="view-section">
                    <div class="back-link" onclick="showList()">
                        <i class="bi bi-arrow-left"></i> Back to Master Schedule
                    </div>

                    <div class="mb-4">
                        <h2 class="page-title">Master Schedule Detail</h2>
                        <div class="d-flex gap-3 text-muted small align-items-center">
                            <span>Activity Code: <span class="fw-bold text-dark" id="detail-code">MC</span></span>
                            <span>•</span>
                            <span>Machine: <span class="fw-bold text-dark" id="detail-machine">CNC Milling 01</span></span>
                            <span>•</span>
                            <span>Request ID: <span class="fw-bold text-dark">REQ-2025-001</span></span>
                        </div>
                    </div>

                    <div class="alert alert-info-custom d-flex align-items-start gap-3 mb-4">
                        <i class="bi bi-info-circle fs-5"></i>
                        <div>
                            <div class="fw-semibold mb-1">View-Only Monitoring</div>
                            <div>Jadwal Utama ini hanya untuk memantau kemajuan produksi. Klik baris mana pun untuk melihat detail aktivitas. Eksekusi aktivitas terjadi di Jadwal Operator MFG.</div>
                        </div>
                    </div>

                    <div class="content-card mt-0 mb-4">
                        <div class="mb-4 border-bottom pb-3">
                            <h5 class="fw-bold fs-6 mb-1">Activity Information</h5>
                            <p class="text-muted small mb-0">Source: Excel MASTER SCHEDULE</p>
                        </div>
                        
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="detail-label">Aktivitas Kode</div>
                                <div><span class="badge-code" id="info-code">MC</span></div>
                            </div>
                            <div class="col-md-4">
                                <div class="detail-label">Sub Aktivitas</div>
                                <div class="detail-value fw-medium" id="info-activity">CNC Milling 01 - Gear Shaft</div>
                            </div>
                            <div class="col-md-4">
                                <div class="detail-label">PIC</div>
                                <div class="detail-value">Operator A</div>
                            </div>
                            <div class="col-md-4">
                                <div class="detail-label">Plan Date</div>
                                <div class="detail-value">25/1/2025</div>
                            </div>
                            <div class="col-md-4">
                                <div class="detail-label">Actual Date</div>
                                <div class="detail-value">25/1/2025</div>
                            </div>
                            <div class="col-md-4">
                                <div class="detail-label">Status</div>
                                <div><span class="status-pill status-act">Act</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="content-card mt-0">
                        <div class="mb-3">
                            <h5 class="fw-bold fs-6">Related Activities</h5>
                            <p class="text-muted small">All activities for this machine and request</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Aktivitas Kode</th>
                                        <th>Sub Aktivitas</th>
                                        <th>Plan</th>
                                        <th>Aktual</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="badge-code">MC</span></td>
                                        <td class="fw-medium">CNC Milling 01 - Gear Shaft</td>
                                        <td>25/1/2025</td>
                                        <td>25/1/2025</td>
                                        <td><span class="status-pill status-act">Act</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="badge-code">HT</span></td>
                                        <td class="fw-medium">Heat Treatment Furnace - Gear Shaft</td>
                                        <td>26/1/2025</td>
                                        <td>26/1/2025</td>
                                        <td><span class="status-pill status-act">Act</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="alert alert-warning-custom d-flex align-items-start gap-3 mt-4">
                        <i class="bi bi-exclamation-circle fs-5"></i>
                        <div>
                            <div class="fw-semibold mb-1">Admin Permissions</div>
                            <div>Admin hanya dapat melihat jadwal ini. Tidak dapat membuat, mengedit, atau memperbarui status aktivitas. Semua pembaruan status dilakukan oleh Operator di Schedule MFG dan secara otomatis tercermin di sini.</div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Data dummy untuk simulasi
    const activities = {
        'MC': {
            code: 'MC',
            machine: 'CNC Milling 01',
            activity: 'CNC Milling 01 - Gear Shaft',
            pic: 'Operator A',
            plan: '25/1/2025',
            actual: '25/1/2025'
        },
        'HT': {
            code: 'HT',
            machine: 'Heat Treatment',
            activity: 'Heat Treatment Furnace - Gear Shaft',
            pic: 'Operator B',
            plan: '26/1/2025',
            actual: '26/1/2025'
        }
    };

    function showDetail(code) {
        const data = activities[code];
        
        // Populate data ke view detail
        document.getElementById('detail-code').textContent = data.code;
        document.getElementById('detail-machine').textContent = data.machine;
        
        document.getElementById('info-code').textContent = data.code;
        document.getElementById('info-activity').textContent = data.activity;
        
        // Tampilkan view detail, sembunyikan list
        document.getElementById('view-schedule-list').classList.remove('active');
        document.getElementById('view-schedule-detail').classList.add('active');
        
        // Scroll ke atas
        window.scrollTo(0, 0);
    }

    function showList() {
        // Tampilkan view list, sembunyikan detail
        document.getElementById('view-schedule-detail').classList.remove('active');
        document.getElementById('view-schedule-list').classList.add('active');
    }
</script>

</body>
</html>