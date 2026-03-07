<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Design Dashboard - PT Sumber Prima Mandiri</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8F9FB; /* Warna background abu-abu muda */
        }

        /* --- Sidebar Styling --- */
        .sidebar {
            min-height: 100vh;
            background-color: #fff;
            border-right: 1px solid #eaecf0;
            padding-top: 20px;
        }

        .logo-area {
            display: flex;
            align-items: center;
            padding: 0 24px 30px 24px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background-color: #2F6BFF; /* Biru logo */
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 24px;
            margin-right: 12px;
        }

        .company-name {
            font-weight: 700;
            font-size: 14px;
            line-height: 1.2;
            color: #101828;
        }

        .sidebar-nav .nav-link {
            color: #475467;
            font-weight: 500;
            padding: 12px 24px;
            margin-bottom: 4px;
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-nav .nav-link:hover {
            background-color: #f9fafb;
            color: #101828;
        }

        .sidebar-nav .nav-link.active {
            background-color: #2F6BFF;
            color: white;
            border-radius: 0 8px 8px 0; /* Rounded hanya di kanan jika mau persis, atau full rounded */
            margin-right: 16px;
            border-radius: 8px; /* Mengikuti gaya modern gambar */
            margin-left: 16px;
        }

        /* --- Main Content Styling --- */
        .top-bar {
            background-color: #fff;
            padding: 16px 32px;
            border-bottom: 1px solid #eaecf0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-input {
            background-color: #fff;
            border: 1px solid #d0d5dd;
            border-radius: 8px;
            padding: 10px 14px;
            width: 400px;
            max-width: 100%;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-info {
            text-align: right;
        }
        .user-name { font-weight: 600; font-size: 14px; color: #101828; }
        .user-role { 
            background-color: #F2F4F7; 
            color: #344054; 
            font-size: 12px; 
            padding: 2px 8px; 
            border-radius: 16px; 
            font-weight: 500;
        }

        .logout-btn {
            border: 1px solid #d0d5dd;
            color: #344054;
            padding: 8px 16px;
            border-radius: 8px;
            background: white;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* --- Dashboard Widgets --- */
        .page-header {
            margin-bottom: 24px;
        }
        .page-title { font-size: 24px; font-weight: 600; color: #101828; }
        .page-subtitle { color: #475467; font-size: 14px; }

        .stat-card {
            background: white;
            border: 1px solid #eaecf0;
            border-radius: 12px;
            padding: 24px;
            height: 100%;
            display: flex;
            justify-content: space-between;
            align-items: start;
        }

        .stat-title { font-size: 14px; color: #475467; font-weight: 500; margin-bottom: 8px; }
        .stat-value { font-size: 30px; font-weight: 600; color: #101828; }

        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .icon-blue { background-color: #eff8ff; color: #2F6BFF; }
        .icon-yellow { background-color: #fffaeb; color: #b54708; }
        .icon-green { background-color: #ecfdf3; color: #027a48; }

        /* --- Table Section --- */
        .content-card {
            background: white;
            border: 1px solid #eaecf0;
            border-radius: 12px;
            padding: 24px;
            margin-top: 24px;
        }
        
        .table thead th {
            font-size: 12px;
            color: #475467;
            font-weight: 600;
            background-color: #F9FAFB;
            border-bottom: 1px solid #eaecf0;
            padding: 12px 24px;
            text-transform: uppercase;
        }
        
        .table tbody td {
            padding: 16px 24px;
            color: #101828;
            font-size: 14px;
            vertical-align: middle;
            border-bottom: 1px solid #eaecf0;
        }

        .request-id { color: #2F6BFF; font-weight: 500; text-decoration: none; }
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 16px;
            font-size: 12px;
            font-weight: 500;
            background-color: #F2F4F7;
            color: #344054;
        }

        .action-link {
            color: #2F6BFF;
            text-decoration: none;
            font-weight: 500;
        }
        .action-link:hover { text-decoration: underline; }

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
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('design.dasbord') }}">
                        <i class="bi bi-grid-fill"></i> Dashboards
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('design.request') }}">
                        <i class="bi bi-file-text"></i> Request Management
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('design.master') }}">
                        <i class="bi bi-calendar-check"></i> Master Schedule
                    </a>
                </li>
            </ul>
        </nav>

        <main class="col-md-10 ms-sm-auto px-0">
            <header class="top-bar">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" id="searchInput" class="search-input ps-5" placeholder="Search request, machine, activity...">
                </div>

                <div class="user-profile">
                    <div class="position-relative me-3">
                        <i class="bi bi-bell fs-5 text-secondary"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                            2
                        </span>
                    </div>

                    <div class="d-flex align-items-center gap-3 bg-white border rounded p-2 pe-4">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="user-info">
                            <div class="user-name">Vannia Ariawati</div>
                            <div class="user-role">Design</div>
                        </div>
                    </div>

                    <a href="#" class="logout-btn" onclick="logoutAlert()">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </header>

            <div class="p-4" style="background-color: #F9FAFB; min-height: 90vh;">
                
                <div class="page-header">
                    <h2 class="page-title">Design Dashboard</h2>
                    <p class="page-subtitle">Engineering & BOM Management</p>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div>
                                <div class="stat-title">Permintaan Baru</div>
                                <div class="stat-value">0</div>
                            </div>
                            <div class="icon-box icon-blue">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div>
                                <div class="stat-title">BOM Dalam Proses</div>
                                <div class="stat-value">0</div>
                            </div>
                            <div class="icon-box icon-yellow">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div>
                                <div class="stat-title">BOM Selesai</div>
                                <div class="stat-value">0</div>
                            </div>
                            <div class="icon-box icon-green">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-card">
                    <div class="mb-4">
                        <h5 class="fw-bold mb-1">Request List</h5>
                        <p class="text-muted small">All production requests assigned to Design</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover" id="requestTable">
                            <thead>
                                <tr>
                                    <th>Request ID</th>
                                    <th>Company</th>
                                    <th>Machine Type</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="#" class="request-id">REQ-2025-001</a></td>
                                    <td>PT. Sinar Matahari</td>
                                    <td>Custom Gear Box Machine</td>
                                    <td>Standard machining</td>
                                    <td><span class="status-badge">parts completed</span></td>
                                    <td><a href="request.html?id=REQ-2025-001" class="action-link">Create BOM</a></td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="request-id">REQ-2025-002</a></td>
                                    <td>PT. Sinar Bulan</td>
                                    <td>Conveyor Belt System</td>
                                    <td>Berkualitas</td>
                                    <td><span class="status-badge">waiting-parts</span></td>
                                    <td><a href="#" class="action-link">Create BOM</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // 1. Fungsi Pencarian Sederhana
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let input = this.value.toLowerCase();
        let rows = document.querySelectorAll('#requestTable tbody tr');

        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            if(text.includes(input)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // 2. Fungsi Tombol Logout (Simulasi)
    function logoutAlert() {
        if(confirm("Apakah Anda yakin ingin keluar dari sistem?")) {
            alert("Anda telah logout.");
            // Di sistem nyata: window.location.href = 'login.html';
        }
    }
</script>

</body>
</html>