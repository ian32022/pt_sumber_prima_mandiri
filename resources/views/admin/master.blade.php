<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Schedule - PT Sumber Prima Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0d6efd;
            --sidebar-width: 260px;
            --bg-light: #f4f6f9;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffff; 
            overflow-x: hidden;
        }

        /* --- Sidebar & Navbar --- */
        #sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; background-color: #fff; border-right: 1px solid #e0e0e0; z-index: 1000; padding: 20px; }
        .sidebar-brand { display: flex; align-items: center; margin-bottom: 40px; }
        .sidebar-brand img { width: 40px; height: 40px; margin-right: 10px; }
        .sidebar-brand-text h6 { margin: 0; font-weight: 700; color: #333; }
        .sidebar-brand-text span { font-size: 0.8rem; color: #777; }
        .nav-link { display: flex; align-items: center; color: #555; padding: 10px 15px; border-radius: 8px; margin-bottom: 5px; transition: all 0.3s; text-decoration: none;}
        .nav-link i { margin-right: 12px; font-size: 1.1rem; }
        .nav-link:hover { background-color: rgba(13, 110, 253, 0.05); color: var(--primary-color); }
        .nav-link.active { background-color: var(--primary-color); color: #fff; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: #999; letter-spacing: 1px; margin: 20px 0 10px 15px; }

        #main-content { margin-left: var(--sidebar-width); padding: 20px 40px; min-height: 100vh; background-color: #fafbfe; }
        #top-navbar { margin-bottom: 30px; background-color: #fff; padding: 10px 0; border-bottom: 1px solid #f0f0f0; }
        .search-bar { width: 400px; }
        .user-profile { display: flex; align-items: center; gap: 10px; padding: 5px 15px; border: 1px solid #e0e0e0; border-radius: 50px; background-color: #fff; }
        .user-profile img { width: 35px; height: 35px; border-radius: 50%; }

        /* --- Custom Alerts --- */
        .alert-custom-blue { background-color: #f0f7ff; border: 1px solid #cce5ff; color: #004085; border-radius: 8px; padding: 15px; font-size: 0.85rem; display: flex; gap: 12px; align-items: flex-start; }
        .alert-custom-blue i { color: var(--primary-color); font-size: 1.1rem; }
        .alert-custom-yellow { background-color: #fffdf0; border: 1px solid #ffeeba; color: #856404; border-radius: 8px; padding: 15px; font-size: 0.85rem; display: flex; gap: 12px; align-items: flex-start; margin-top: 20px; }
        .alert-custom-yellow i { color: #fd7e14; font-size: 1.1rem; }

        /* --- Stats Cards --- */
        .stat-card { background: #fff; border-radius: 12px; border: 1px solid #e0e0e0; padding: 20px; flex: 1; }
        .stat-icon { width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; margin-bottom: 15px; }
        .stat-icon-total { background-color: #eef2ff; color: #4f46e5; }
        .stat-icon-plan { background-color: #e0f2fe; color: #0284c7; }
        .stat-icon-act { background-color: #fff7ed; color: #ea580c; }
        .stat-icon-done { background-color: #f0fdf4; color: #16a34a; }
        .stat-number { font-size: 1.8rem; font-weight: 700; margin-bottom: 0; line-height: 1; color: #333; }
        .stat-label { font-size: 0.75rem; color: #666; margin-top: 5px; }

        /* --- Table Styling --- */
        .card-table-wrapper { background: #fff; border-radius: 12px; border: 1px solid #e0e0e0; padding: 20px; margin-top: 20px; }
        .table-custom { width: 100%; margin-bottom: 0; }
        .table-custom thead th { font-size: 0.7rem; text-transform: uppercase; color: #888; border-bottom: 1px solid #ededed; padding-bottom: 15px; font-weight: 600;}
        .table-custom tbody td { font-size: 0.85rem; padding: 15px 0; border-bottom: 1px solid #ededed; vertical-align: middle; color: #444; }
        .table-hover-custom tbody tr { cursor: pointer; transition: background-color 0.2s; }
        .table-hover-custom tbody tr:hover { background-color: #f8f9fa; }
        .badge-code { background-color: #e0f2fe; color: #0284c7; padding: 4px 10px; border-radius: 6px; font-weight: 600; font-size: 0.75rem; display: inline-block; min-width: 40px; text-align: center;}
        .text-act { color: #ea580c; font-weight: 600; font-size: 0.75rem; }
        .text-plan { color: #0d6efd; font-weight: 600; font-size: 0.75rem; }

        /* --- Form Styling --- */
        .form-label-custom { font-size: 0.8rem; color: #555; font-weight: 500; margin-bottom: 5px; }
        .form-control-custom, .form-select-custom { font-size: 0.85rem; padding: 10px 15px; border-radius: 8px; border: 1px solid #ddd; }
        
        #create-activity-container, #detail-activity-container { display: none; }
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
        <div id="top-navbar" class="d-flex justify-content-between align-items-center mb-4">
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

        <div id="master-schedule-main">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h3 class="fw-bold mb-1">Master Schedule</h3>
                    <p class="text-muted" style="font-size: 0.85rem;">Monitoring & Activity Management - Source: Excel MASTER SCHEDULE</p>
                </div>
                <button class="btn btn-primary btn-sm px-3 py-2" onclick="showCreateActivity()"><i class="bi bi-plus-lg me-1"></i> Tambah Activity</button>
            </div>

            <div class="alert-custom-blue mb-4">
                <i class="bi bi-info-circle"></i>
                <div>
                    <div class="fw-bold mb-1" style="font-size: 0.8rem;">View-Only Monitoring</div>
                    <div style="font-size: 0.8rem;">Jadwal Utama ini hanya untuk memantau kemajuan produksi. Klik baris mana pun untuk melihat detail aktivitas. Eksekusi aktivitas terjadi di Jadwal Operator MFG.</div>
                </div>
            </div>

            <div class="d-flex gap-3 mb-4">
                <div class="stat-card">
                    <div class="stat-icon stat-icon-total"><i class="bi bi-calendar3"></i></div>
                    <h2 class="stat-number" id="stat-total">2</h2>
                    <div class="stat-label">Total Activities</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-icon-plan"><i class="bi bi-clock"></i></div>
                    <h2 class="stat-number text-primary" id="stat-plan">0</h2>
                    <div class="stat-label text-primary">Plan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-icon-act"><i class="bi bi-arrow-repeat"></i></div>
                    <h2 class="stat-number" style="color: #ea580c;">2</h2>
                    <div class="stat-label" style="color: #ea580c;">Act</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-icon-done"><i class="bi bi-check-circle"></i></div>
                    <h2 class="stat-number text-success">0</h2>
                    <div class="stat-label text-success">Done</div>
                </div>
            </div>

            <div class="card-table-wrapper">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h6 class="fw-bold mb-0">Master Schedule - Activity Monitoring</h6>
                        <span class="text-muted" style="font-size: 0.75rem;">Aggregated from Excel schedule - Click row to view details</span>
                    </div>
                    <select class="form-select form-select-sm" style="width: 150px;">
                        <option>All Status</option>
                        <option>Plan</option>
                        <option>Act</option>
                        <option>Done</option>
                    </select>
                </div>

                <table class="table table-custom table-hover-custom">
                    <thead>
                        <tr>
                            <th>AKTIVITAS KODE</th>
                            <th>SUB AKTIVITAS</th>
                            <th>PLAN</th>
                            <th>AKTUAL</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody id="master-schedule-tbody">
                        <tr onclick="showDetailActivity('MC', 'CNC Milling 01 - Gear Shaft', 'REQ-2025-001')">
                            <td><span class="badge-code">MC</span></td>
                            <td>CNC Milling 01 - Gear Shaft</td>
                            <td>25/1/2025</td>
                            <td>25/1/2025</td>
                            <td><span class="text-act">Act</span></td>
                        </tr>
                        <tr onclick="showDetailActivity('HT', 'Heat Treatment Furnace - Gear Shaft', 'REQ-2025-001')">
                            <td><span class="badge-code" style="background-color:#e0e7ff; color:#4f46e5;">HT</span></td>
                            <td>Heat Treatment Furnace - Gear Shaft</td>
                            <td>26/1/2025</td>
                            <td>26/1/2025</td>
                            <td><span class="text-act">Act</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="alert-custom-yellow">
                <i class="bi bi-exclamation-circle"></i>
                <div>
                    <div class="fw-bold mb-1" style="font-size: 0.8rem;">Admin Permissions</div>
                    <div style="font-size: 0.8rem;">Admin hanya dapat melihat jadwal ini. Tidak dapat membuat, mengedit, atau memperbarui status aktivitas. Semua pembaruan status dilakukan oleh Operator di Schedule MFG dan secara otomatis tercermin di sini.</div>
                </div>
            </div>
        </div>

        <div id="create-activity-container">
            <button class="btn btn-link text-muted p-0 text-decoration-none mb-3" onclick="showMainSchedule()"><i class="bi bi-arrow-left me-1"></i> Back to Master Schedule</button>
            
            <h3 class="fw-bold mb-1">Create Activity</h3>
            <p class="text-muted" style="font-size: 0.85rem;">Admin - Add new activity for setup or correction</p>

            <div class="alert-custom-blue mb-4">
                <i class="bi bi-info-circle"></i>
                <div>
                    <div class="fw-bold mb-1" style="font-size: 0.8rem;">Admin Activity Creation</div>
                    <div style="font-size: 0.8rem;">Admin creates activities for setup or correction purposes only. The activity will be created with status "Plan" and will appear in both Master Schedule and Schedule MFG. Activity execution (status updates) must be performed by Operators.</div>
                </div>
            </div>

            <div class="card-table-wrapper">
                <h6 class="fw-bold mb-1">Activity Information</h6>
                <p class="text-muted border-bottom pb-3 mb-4" style="font-size: 0.8rem;">Fill in the details below</p>

                <form>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label-custom">Request ID</label>
                            <select id="new-req-id" class="form-select form-select-custom">
                                <option>REQ-2025-002 - Conveyor Belt System</option>
                                <option>REQ-2025-001 - Custom Gear Box</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Activity Code</label>
                            <select id="new-act-code" class="form-select form-select-custom">
                                <option value="LC">LC</option>
                                <option value="MC">MC</option>
                                <option value="HT">HT</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label-custom">Machine</label>
                            <select id="new-machine" class="form-select form-select-custom">
                                <option value="Laser Cutting">Laser Cutting</option>
                                <option value="CNC Milling 01">CNC Milling 01</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">PIC (Person in Charge)</label>
                            <input type="text" id="new-pic" class="form-control form-control-custom" placeholder="e.g. Operator A">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom mb-0">Part Name</label>
                            <div class="text-muted mb-2" style="font-size:0.7rem;">Select a request first</div>
                            <select id="new-part-name" class="form-select form-select-custom">
                                <option value="Bearing Housing">Bearing Housing</option>
                                <option value="Gear Shaft">Gear Shaft</option>
                                <option value="Base Plate">Base Plate</option>
                            </select>
                        </div>
                        <div class="col-md-6 pt-3">
                            <label class="form-label-custom">Plan Date</label>
                            <input type="date" id="new-plan-date" class="form-control form-control-custom" value="2026-11-21">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-custom mb-0">Sub Activity (Optional)</label>
                            <div class="text-muted mb-2" style="font-size:0.7rem;">Additional description for this activity (optional)</div>
                            <input type="text" id="new-sub-act" class="form-control form-control-custom" placeholder="e.g. Precision grinding, Surface finishing">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom pt-3">Activity Status</label>
                            <select id="new-act-status" class="form-select form-select-custom">
                                <option value="Plan">Plan</option>
                                <option value="Act">Act</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                        <button type="button" class="btn btn-outline-secondary px-4" onclick="showMainSchedule()">Cancel</button>
                        <button type="button" class="btn btn-primary" style="background-color:#81a1ff; border:none; opacity: 0.9;" onclick="saveNewActivity()"><i class="bi bi-plus me-1"></i> Create Activity</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="detail-activity-container">
            <button class="btn btn-link text-muted p-0 text-decoration-none mb-3" onclick="showMainSchedule()"><i class="bi bi-arrow-left me-1"></i> Back to Master Schedule</button>
            
            <h3 class="fw-bold mb-1">Master Schedule Detail</h3>
            <p class="text-muted" style="font-size: 0.85rem;">Activity Code: <span id="dtl-act-code" class="text-dark fw-bold">MC</span> &nbsp;•&nbsp; Machine: <span id="dtl-machine" class="text-dark fw-bold">CNC Milling 01</span> &nbsp;•&nbsp; Request ID: <span id="dtl-req" class="text-dark fw-bold">REQ-2025-001</span></p>

            <div class="alert-custom-blue mb-4">
                <i class="bi bi-info-circle"></i>
                <div>
                    <div class="fw-bold mb-1" style="font-size: 0.8rem;">View-Only Monitoring</div>
                    <div style="font-size: 0.8rem;">Jadwal Utama ini hanya untuk memantau kemajuan produksi. Klik baris mana pun untuk melihat detail aktivitas. Eksekusi aktivitas terjadi di Jadwal Operator MFG.</div>
                </div>
            </div>

            <div class="card-table-wrapper mb-4">
                <h6 class="fw-bold mb-1">Activity Information</h6>
                <p class="text-muted border-bottom pb-3 mb-4" style="font-size: 0.8rem;">Source: Excel MASTER SCHEDULE</p>

                <div class="row g-4 mb-2">
                    <div class="col-md-4">
                        <div class="text-muted" style="font-size:0.7rem; font-weight:600; text-transform:uppercase;">Aktivitas Kode</div>
                        <div class="mt-1"><span class="badge-code" id="info-code">MC</span></div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted" style="font-size:0.7rem; font-weight:600; text-transform:uppercase;">Sub Aktivitas</div>
                        <div class="mt-1" style="font-size:0.85rem; color:#333;" id="info-sub">CNC Milling 01 - Gear Shaft</div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted" style="font-size:0.7rem; font-weight:600; text-transform:uppercase;">PIC</div>
                        <div class="mt-1" style="font-size:0.85rem; color:#333;" id="info-pic">Operator A</div>
                    </div>
                    
                    <div class="col-md-4 mt-4">
                        <div class="text-muted" style="font-size:0.7rem; font-weight:600; text-transform:uppercase;">Plan Date</div>
                        <div class="mt-1" style="font-size:0.85rem; color:#333;" id="info-plan-date">25/1/2025</div>
                    </div>
                    <div class="col-md-4 mt-4">
                        <div class="text-muted" style="font-size:0.7rem; font-weight:600; text-transform:uppercase;">Actual Date</div>
                        <div class="mt-1" style="font-size:0.85rem; color:#333;">-</div>
                    </div>
                    <div class="col-md-4 mt-4">
                        <div class="text-muted" style="font-size:0.7rem; font-weight:600; text-transform:uppercase;">Status</div>
                        <div class="mt-1"><span class="text-plan" id="info-status">Plan</span></div>
                    </div>
                </div>
            </div>

            <div class="alert-custom-yellow">
                <i class="bi bi-exclamation-circle"></i>
                <div>
                    <div class="fw-bold mb-1" style="font-size: 0.8rem;">Admin Permissions</div>
                    <div style="font-size: 0.8rem;">Admin hanya dapat melihat jadwal ini. Tidak dapat membuat, mengedit, atau memperbarui status aktivitas. Semua pembaruan status dilakukan oleh Operator di Schedule MFG dan secara otomatis tercermin di sini.</div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const mainView = document.getElementById('master-schedule-main');
        const createView = document.getElementById('create-activity-container');
        const detailView = document.getElementById('detail-activity-container');

        // Fungsi Navigasi
        function showMainSchedule() {
            mainView.style.display = 'block';
            createView.style.display = 'none';
            detailView.style.display = 'none';
            window.scrollTo(0, 0);
        }

        function showCreateActivity() {
            mainView.style.display = 'none';
            createView.style.display = 'block';
            detailView.style.display = 'none';
            window.scrollTo(0, 0);
        }

        function showDetailActivity(code, subAct, reqId, planDateStr = "25/1/2025", statusVal = "Act", pic = "Operator A") {
            mainView.style.display = 'none';
            createView.style.display = 'none';
            detailView.style.display = 'block';
            window.scrollTo(0, 0);

            document.getElementById('dtl-act-code').innerText = code;
            document.getElementById('dtl-req').innerText = reqId;
            document.getElementById('info-code').innerText = code;
            
            // Ubah warna badge (HT ungu, LC hijau, lainnya biru)
            if(code === 'HT') {
                document.getElementById('info-code').style.backgroundColor = '#e0e7ff';
                document.getElementById('info-code').style.color = '#4f46e5';
            } else if (code === 'LC') {
                document.getElementById('info-code').style.backgroundColor = '#dcfce7';
                document.getElementById('info-code').style.color = '#16a34a';
            } else {
                document.getElementById('info-code').style.backgroundColor = '#e0f2fe';
                document.getElementById('info-code').style.color = '#0284c7';
            }

            document.getElementById('info-sub').innerText = subAct;
            const machineName = subAct.split(' - ')[0];
            document.getElementById('dtl-machine').innerText = machineName;

            // Set detail tambahan yang dilempar oleh fungsi dinamis
            document.getElementById('info-plan-date').innerText = planDateStr;
            document.getElementById('info-pic').innerText = pic;

            const statusSpan = document.getElementById('info-status');
            statusSpan.innerText = statusVal;
            if (statusVal === 'Plan') {
                statusSpan.className = 'text-plan';
            } else if (statusVal === 'Done') {
                statusSpan.className = 'text-success';
            } else {
                statusSpan.className = 'text-act';
            }
        }

        // --- FUNGSI SAVE NEW ACTIVITY (DINAMIS) ---
        function saveNewActivity() {
            // 1. Ambil data dari form
            const reqIdRaw = document.getElementById('new-req-id').value;
            const reqId = reqIdRaw.split(' - ')[0]; // Ekstrak kode REQ-2025-xxx saja
            
            const actCode = document.getElementById('new-act-code').value;
            const machine = document.getElementById('new-machine').value;
            const pic = document.getElementById('new-pic').value;
            const partName = document.getElementById('new-part-name').value;
            let planDate = document.getElementById('new-plan-date').value;
            let status = document.getElementById('new-act-status').value;

            // Validasi wajib isi
            if (!pic || !planDate) {
                alert("Harap isi PIC dan Tanggal Plan!");
                return;
            }

            // Ubah format tanggal (YYYY-MM-DD -> DD/MM/YYYY)
            if (planDate) {
                const d = new Date(planDate);
                planDate = `${d.getDate()}/${d.getMonth()+1}/${d.getFullYear()}`;
            }

            // Gabungkan menjadi teks Sub Aktivitas
            const subAktivitas = `${machine} - ${partName}`;

            // Tentukan style badge kode aktivitas
            let badgeStyle = 'background-color: #e0f2fe; color: #0284c7;'; // default biru (MC)
            if (actCode === 'HT') {
                badgeStyle = 'background-color:#e0e7ff; color:#4f46e5;'; // ungu
            } else if (actCode === 'LC') {
                badgeStyle = 'background-color:#dcfce7; color:#16a34a;'; // hijau
            }

            // Tentukan class warna teks status
            let statusClass = 'text-plan';
            if (status === 'Act') statusClass = 'text-act';
            if (status === 'Done') statusClass = 'text-success';

            // 2. Buat elemen baris tabel baru (<tr>)
            const tbody = document.getElementById('master-schedule-tbody');
            const tr = document.createElement('tr');
            
            // Tambahkan fungsi onClick agar baris baru ini juga bisa di-klik untuk melihat detail
            tr.setAttribute('onclick', `showDetailActivity('${actCode}', '${subAktivitas}', '${reqId}', '${planDate}', '${status}', '${pic}')`);

            // Masukkan struktur HTML kolom-kolomnya
            tr.innerHTML = `
                <td><span class="badge-code" style="${badgeStyle}">${actCode}</span></td>
                <td>${subAktivitas}</td>
                <td>${planDate}</td>
                <td>-</td>
                <td><span class="${statusClass}">${status}</span></td>
            `;

            // 3. Masukkan baris baru ke dalam tabel di halaman utama
            tbody.appendChild(tr);

            // 4. Update angka pada Dashboard Card di atas tabel
            const totalElem = document.getElementById('stat-total');
            totalElem.innerText = parseInt(totalElem.innerText) + 1;
            
            if (status === 'Plan') {
                const planElem = document.getElementById('stat-plan');
                planElem.innerText = parseInt(planElem.innerText) + 1;
            }

            // Bersihkan form text input
            document.getElementById('new-pic').value = '';
            document.getElementById('new-sub-act').value = '';

            // Kembali ke layar utama
            showMainSchedule();
        }
    </script>
</body>
</html>