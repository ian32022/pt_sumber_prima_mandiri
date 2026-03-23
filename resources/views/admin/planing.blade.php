<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production Planning - PT Sumber Prima Mandiri</title>
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
            background-color: var(--bg-light);
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

        #main-content { margin-left: var(--sidebar-width); padding: 20px 40px; min-height: 100vh; }
        #top-navbar { margin-bottom: 30px; }
        .search-bar { width: 400px; }
        .user-profile { display: flex; align-items: center; gap: 10px; padding: 5px 15px; border: 1px solid #e0e0e0; border-radius: 50px; background-color: #fff; }
        .user-profile img { width: 35px; height: 35px; border-radius: 50%; }

        /* --- Production Planning Cards --- */
        .machine-card {
            background: #fff; border-radius: 12px; border: 1px solid #e0e0e0; padding: 20px; cursor: pointer; transition: box-shadow 0.2s, transform 0.2s; height: 100%;
        }
        .machine-card:hover { box-shadow: 0 4px 15px rgba(0,0,0,0.05); transform: translateY(-2px); }
        .status-active-badge { background-color: #d1e7dd; color: #0f5132; font-size: 0.7rem; padding: 3px 8px; border-radius: 4px; }
        .activity-badge { background-color: #cfe2f3; color: #084298; font-size: 0.7rem; padding: 3px 8px; border-radius: 4px; }
        .stat-row { display: flex; justify-content: space-between; align-items: center; margin-top: 8px; font-size: 0.85rem; }
        .dot-plan { color: #0d6efd; font-size: 1.2rem; line-height: 0; margin-right: 5px;}
        .dot-act { color: #fd7e14; font-size: 1.2rem; line-height: 0; margin-right: 5px;}
        .dot-done { color: #198754; font-size: 1.2rem; line-height: 0; margin-right: 5px;}
        
        .add-machine-card {
            border: 2px dashed #ccc; background: transparent; display: flex; flex-direction: column; justify-content: center; align-items: center; color: #666; cursor: pointer;
        }
        .add-machine-card:hover { border-color: var(--primary-color); color: var(--primary-color); background-color: rgba(13,110,253,0.02); }
        .add-icon-circle { width: 40px; height: 40px; background-color: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-bottom: 10px; color: var(--primary-color);}

        /* --- Machine Detail View --- */
        .detail-header-card { background: #fff; border-radius: 12px; border: 1px solid #e0e0e0; padding: 20px; margin-bottom: 20px; }
        .doc-item { border: 1px solid #e0e0e0; border-radius: 8px; padding: 15px; display: flex; align-items: center; justify-content: space-between; }
        .doc-icon { width: 40px; height: 40px; background-color: #f8f9fa; border-radius: 8px; display: flex; justify-content: center; align-items: center; color: var(--primary-color); font-size: 1.2rem; margin-right: 15px;}
        
        /* Table Custom */
        .table-custom thead th { font-size: 0.75rem; text-transform: uppercase; color: #888; letter-spacing: 0.5px; border-bottom: 1px solid #ededed; }
        .table-custom tbody td { font-size: 0.9rem; padding: 15px 0; vertical-align: middle; border-bottom: 1px solid #ededed; }
        .text-done { color: #198754; font-weight: 600; }
        .text-act { color: #fd7e14; font-weight: 600; }
        .text-plan { color: #0d6efd; font-weight: 600; }

        /* Action Icons */
        .action-icon { cursor: pointer; transition: transform 0.2s; margin-right: 10px; font-size: 1.1rem;}
        .action-icon:hover { transform: scale(1.1); }
        .icon-edit { color: #0d6efd; }
        .icon-delete { color: #dc3545; }

        /* --- Drag & Drop Upload --- */
        .upload-area { border: 2px dashed #ccc; border-radius: 8px; padding: 30px; text-align: center; background-color: #fafafa; cursor: pointer; transition: 0.3s; }
        .upload-area:hover { border-color: var(--primary-color); background-color: #f0f8ff; }

        /* Hidden containers */
        #machine-detail-container { display: none; }
        #add-activity-card { display: none; }
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
            <div class="sidebar-heading">SUPPORT</div>
            <a class="nav-link" href="#"><i class="bi bi-gear"></i> Settings</a>
            <a class="nav-link" href="#"><i class="bi bi-question-circle"></i> Help Desk</a>
        </nav>
    </div>

    <div id="main-content">
        <div id="top-navbar" class="d-flex justify-content-between align-items-center">
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

        <div id="main-planning-container">
            <div class="mb-4">
                <h3 class="fw-bold mb-1">Production Planning</h3>
                <p class="text-muted">Kelola jadwal activity berdasarkan mesin produksi</p>
            </div>

            <div class="row g-4" id="machine-cards-container">
                <div class="col-md-4">
                    <div class="machine-card" onclick="showMachineDetail('Mesin CNC-01', 'CNC Milling • Area A - Zona Machining')">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-bold mb-0">Mesin CNC-01</h6>
                            <span class="status-active-badge">Active</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <div style="font-size: 0.8rem; color: #666;">CNC Milling</div>
                                <div style="font-size: 0.75rem; color: #999;">Area A - Zona Machining</div>
                            </div>
                            <span class="activity-badge">3 Activity</span>
                        </div>
                        <div class="stat-row"><span class="text-muted"><span class="dot-plan">•</span> Plan:</span> <span class="fw-bold text-primary">1</span></div>
                        <div class="stat-row"><span class="text-muted"><span class="dot-act">•</span> Act:</span> <span class="fw-bold" style="color: #fd7e14;">1</span></div>
                        <div class="stat-row"><span class="text-muted"><span class="dot-done">•</span> Done:</span> <span class="fw-bold text-success">1</span></div>
                    </div>
                </div>

                <div class="col-md-4" id="add-machine-card-wrapper">
                    <div class="machine-card add-machine-card" data-bs-toggle="modal" data-bs-target="#addMachineModal">
                        <div class="add-icon-circle"><i class="bi bi-plus-lg"></i></div>
                        <h6 class="fw-bold text-dark mb-1">Add New Machine</h6>
                        <span style="font-size: 0.75rem;">Configure new production machine</span>
                    </div>
                </div>
            </div>
        </div>

        <div id="machine-detail-container">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div class="d-flex align-items-start gap-3">
                    <button class="btn btn-link text-dark p-0 text-decoration-none mt-1" onclick="hideMachineDetail()"><i class="bi bi-arrow-left fs-5"></i></button>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h3 class="fw-bold mb-0" id="detail-title">Mesin CNC-01</h3>
                            <span class="status-active-badge">Active</span>
                        </div>
                        <p class="text-muted mb-0" id="detail-subtitle">CNC Milling • Area A - Zona Machining</p>
                    </div>
                </div>
                <button class="btn btn-primary" onclick="toggleAddActivity()"><i class="bi bi-plus-lg me-1"></i> Tambah Activity</button>
            </div>

            <div class="detail-header-card" id="doc-card">
                <h6 class="fw-bold mb-3" style="font-size: 0.9rem;">Machine Document</h6>
                <div class="doc-item" id="doc-container">
                    <div class="d-flex align-items-center">
                        <div class="doc-icon"><i class="bi bi-file-earmark-image"></i></div>
                        <div>
                            <div class="fw-bold text-dark" style="font-size: 0.9rem;" id="doc-file-name">Gambar 1.png</div>
                            <div class="text-muted" style="font-size: 0.75rem;" id="doc-file-info">24.9 KB • PNG • Uploaded: 25/1/2026</div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary btn-sm px-3" onclick="viewDocument()"><i class="bi bi-eye me-1"></i> View</button>
                        <button class="btn btn-outline-secondary btn-sm px-3" onclick="document.getElementById('hidden-file-input').click()"><i class="bi bi-upload me-1"></i> Replace</button>
                        <input type="file" id="hidden-file-input" style="display: none;" accept="image/png, image/jpeg, image/jpg" onchange="handleReplaceDocument(event)">
                        <button class="btn btn-outline-danger btn-sm px-3" data-bs-toggle="modal" data-bs-target="#confirmRemoveDocModal"><i class="bi bi-trash me-1"></i> Remove</button>
                    </div>
                </div>
                <div id="empty-doc-message" class="text-center text-muted p-3" style="display: none;">
                    Belum ada dokumen. <a href="#" class="text-decoration-none" onclick="document.getElementById('hidden-file-input').click()">Upload sekarang</a>
                </div>
            </div>

            <div class="detail-header-card border-primary" id="add-activity-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0" style="font-size: 0.95rem;">Tambah Activity Baru</h6>
                    <button type="button" class="btn-close" style="font-size: 0.7rem;" onclick="toggleAddActivity()"></button>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label class="form-label text-muted" style="font-size: 0.8rem;">Nama Activity <span class="text-danger">*</span></label>
                        <input type="text" id="new-act-name" class="form-control form-control-sm" placeholder="Contoh: Machining Part Conveyor">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted" style="font-size: 0.8rem;">PIC (Person In Charge)<span class="text-danger">*</span></label>
                        <input type="text" id="new-act-pic" class="form-control form-control-sm" placeholder="Nama operator">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted" style="font-size: 0.8rem;">Tanggal Plan <span class="text-danger">*</span></label>
                        <input type="date" id="new-act-date" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted" style="font-size: 0.8rem;">Request ID (Optional)</label>
                        <input type="text" id="new-act-reqid" class="form-control form-control-sm" placeholder="REQ-2025-001">
                    </div>
                </div>
                <button class="btn btn-primary btn-sm px-4" onclick="saveNewActivity()">Simpan Activity</button>
                <button class="btn btn-light btn-sm px-4 border" onclick="toggleAddActivity()">Batal</button>
            </div>

            <div class="detail-header-card p-0" style="overflow: hidden;">
                <table class="table table-custom mb-0 mx-4" style="width: calc(100% - 3rem);">
                    <thead>
                        <tr>
                            <th>ID ACTIVITY</th>
                            <th>NAMA ACTIVITY</th>
                            <th>PIC</th>
                            <th>TANGGAL PLAN</th>
                            <th>TANGGAL ACTUAL</th>
                            <th>REQUEST ID</th>
                            <th>STATUS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="activity-table-body">
                        <tr id="act-row-001">
                            <td class="text-primary">ACT-001</td>
                            <td style="max-width: 150px;">Machining Part Conveyor Belt</td>
                            <td>Budi Santoso</td>
                            <td>2025-01-24</td>
                            <td>2025-01-24</td>
                            <td>REQ-2025-001</td>
                            <td class="text-done">Done</td>
                            <td>
                                <i class="bi bi-pencil action-icon icon-edit" onclick="openEditActivity('Machining Part Conveyor Belt', 'Gear Shaft', 'Budi Santoso', '2025-01-24')"></i>
                                <i class="bi bi-trash action-icon icon-delete" onclick="confirmDeleteActivity('act-row-001')"></i>
                            </td>
                        </tr>
                        <tr id="act-row-002">
                            <td class="text-primary">ACT-002</td>
                            <td>Cutting Base Plate</td>
                            <td>Ahmad Yani</td>
                            <td>2025-01-25</td>
                            <td>2025-01-25</td>
                            <td>REQ-2025-002</td>
                            <td class="text-act">Act</td>
                            <td>
                                <i class="bi bi-pencil action-icon icon-edit" onclick="openEditActivity('Cutting Base Plate', 'Base Plate', 'Ahmad Yani', '2025-01-25')"></i>
                                <i class="bi bi-trash action-icon icon-delete" onclick="confirmDeleteActivity('act-row-002')"></i>
                            </td>
                        </tr>
                        <tr id="act-row-003">
                            <td class="text-primary">ACT-003</td>
                            <td>Machining Gear Housing</td>
                            <td>Siti Aminah</td>
                            <td>2025-01-26</td>
                            <td>-</td>
                            <td>-</td>
                            <td class="text-plan">Plan</td>
                            <td>
                                <i class="bi bi-pencil action-icon icon-edit" onclick="openEditActivity('Machining Gear Housing', 'Gear Housing', 'Siti Aminah', '2025-01-26')"></i>
                                <i class="bi bi-trash action-icon icon-delete" onclick="confirmDeleteActivity('act-row-003')"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addMachineModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius: 12px; border:none;">
                <div class="modal-header border-bottom-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold">Add New Machine</h5>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Register a new machine to the production system</p>
                    </div>
                    <button type="button" class="btn-close mb-auto mt-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4">
                    <form>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 0.85rem;">Machine Name <span class="text-danger">*</span></label>
                            <input type="text" id="new-machine-name" class="form-control" placeholder="e.g., CNC Milling A1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 0.85rem;">Machine Code <span class="text-danger">*</span></label>
                            <input type="text" id="new-machine-code" class="form-control" placeholder="e.g., CNC-01">
                            <div class="form-text" style="font-size: 0.75rem;">Unique identifier for this machine</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 0.85rem;">Area / Location <span class="text-danger">*</span></label>
                            <input type="text" id="new-machine-area" class="form-control" placeholder="e.g., Area A - Machining">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 0.85rem;">Machine Type <span class="text-danger">*</span></label>
                            <select id="new-machine-type" class="form-select text-dark">
                                <option value="" selected disabled>Select machine type</option>
                                <option value="CNC Milling">CNC Milling</option>
                                <option value="CNC Lathe">CNC Lathe</option>
                                <option value="Laser Cutting">Laser Cutting</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted mb-0" style="font-size: 0.85rem;">Machine Document Upload</label>
                            <div class="form-text mb-2" style="font-size: 0.75rem;">Upload machine photo, layout, manual, or specification file.</div>
                            <div class="upload-area" onclick="document.getElementById('new-machine-file-input').click()">
                                <i class="bi bi-upload fs-3 text-secondary mb-2 d-block" id="new-upload-icon"></i>
                                <div class="text-dark fw-bold" id="new-upload-text">Drag & drop file here, or click to browse</div>
                                <div class="text-muted mt-1" style="font-size: 0.75rem;" id="new-upload-subtext">Supported: PDF, JPG, PNG (max 10MB)</div>
                            </div>
                            <input type="file" id="new-machine-file-input" style="display: none;" accept="image/png, image/jpeg, application/pdf" onchange="handleNewMachineUpload(event)">
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <button type="button" class="btn btn-light px-4 border" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary px-4" onclick="saveNewMachine()">Save Machine</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewImageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-header border-0 pb-0 justify-content-end">
                    <div class="d-flex gap-2 bg-dark rounded-pill p-1">
                        <button class="btn btn-dark btn-sm rounded-circle" style="width: 35px; height: 35px;"><i class="bi bi-zoom-in"></i></button>
                        <button class="btn btn-dark btn-sm rounded-circle" style="width: 35px; height: 35px;" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></button>
                    </div>
                </div>
                <div class="modal-body text-center p-0 mt-2">
                    <img id="modal-preview-image" src="https://via.placeholder.com/1000x600/ffffff/333333?text=Gambar+Mesin+Bawaan" class="img-fluid rounded shadow-lg" alt="Machine Document">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editActivityModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border:none;">
                <div class="modal-header border-bottom-0 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold">Edit Activity</h5>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Update activity details</p>
                    </div>
                    <button type="button" class="btn-close mb-auto mt-2" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-4">
                    <form>
                        <div class="mb-3"><label class="form-label text-muted" style="font-size: 0.85rem;">Activity Name *</label><input type="text" id="edit-act-name" class="form-control"></div>
                        <div class="mb-3"><label class="form-label text-muted" style="font-size: 0.85rem;">Part Name</label><input type="text" id="edit-part-name" class="form-control"></div>
                        <div class="mb-3"><label class="form-label text-muted" style="font-size: 0.85rem;">PIC *</label><input type="text" id="edit-pic" class="form-control"></div>
                        <div class="mb-4"><label class="form-label text-muted" style="font-size: 0.85rem;">Tanggal Plan *</label><input type="date" id="edit-date" class="form-control"></div>
                        <div class="d-flex justify-content-end gap-2 border-top pt-3">
                            <button type="button" class="btn btn-light px-4 border" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">Update Activity</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmRemoveDocModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0">
                <div class="modal-body text-center p-4">
                    <i class="bi bi-exclamation-circle text-danger fs-1 mb-3"></i>
                    <h5 class="fw-bold">Hapus Dokumen?</h5>
                    <p class="text-muted text-sm mb-4">Dokumen ini akan dihapus dari sistem. Anda yakin?</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger px-3" onclick="removeDocument()" data-bs-dismiss="modal">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmDeleteActivityModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0">
                <div class="modal-body text-center p-4">
                    <i class="bi bi-trash text-danger fs-1 mb-3"></i>
                    <h5 class="fw-bold">Hapus Activity?</h5>
                    <p class="text-muted text-sm mb-4">Data activity yang dihapus tidak dapat dikembalikan.</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger px-3" onclick="executeDeleteActivity()">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // --- VARIABEL GLOBAL ---
        let machineDatabase = {
            "Mesin CNC-01": {
                name: "Gambar 1.png",
                info: "24.9 KB • PNG • Uploaded: 25/1/2026",
                src: "https://via.placeholder.com/1000x600/ffffff/333333?text=Gambar+Mesin+Bawaan"
            }
        };

        let currentDetailMachineTitle = ""; 
        let tempUploadedDoc = null;         
        let activityRowToDelete = null;

        // Counter untuk ID Activity (karena ACT-001 s/d 003 sudah ada, kita mulai dari 4)
        let activityCounter = 4;

        // --- NAVIGASI VIEW ---
        function showMachineDetail(title, subtitle) {
            currentDetailMachineTitle = title; 
            
            document.getElementById('main-planning-container').style.display = 'none';
            document.getElementById('machine-detail-container').style.display = 'block';
            document.getElementById('detail-title').innerText = title;
            document.getElementById('detail-subtitle').innerText = subtitle;

            const docData = machineDatabase[title];
            
            if (docData) {
                document.getElementById('doc-container').style.display = 'flex';
                document.getElementById('empty-doc-message').style.display = 'none';
                document.getElementById('doc-file-name').innerText = docData.name;
                document.getElementById('doc-file-info').innerText = docData.info;
                document.getElementById('modal-preview-image').src = docData.src;
            } else {
                document.getElementById('doc-container').style.display = 'none';
                document.getElementById('empty-doc-message').style.display = 'block';
                document.getElementById('modal-preview-image').src = "https://via.placeholder.com/1000x600/ffffff/333333?text=Tidak+Ada+Dokumen";
            }
        }

        function hideMachineDetail() {
            document.getElementById('machine-detail-container').style.display = 'none';
            document.getElementById('main-planning-container').style.display = 'block';
        }

        function toggleAddActivity() {
            const formCard = document.getElementById('add-activity-card');
            formCard.style.display = (formCard.style.display === 'none' || formCard.style.display === '') ? 'block' : 'none';
        }

        // --- FUNGSI SAVE NEW ACTIVITY (FITUR BARU) ---
        function saveNewActivity() {
            // 1. Ambil data dari form input
            const name = document.getElementById('new-act-name').value;
            const pic = document.getElementById('new-act-pic').value;
            const datePlan = document.getElementById('new-act-date').value;
            let reqId = document.getElementById('new-act-reqid').value;

            // Jika Request ID kosong, ubah jadi strip (-)
            if(reqId.trim() === '') reqId = '-';

            // 2. Validasi input wajib
            if (!name || !pic || !datePlan) {
                alert("Harap isi Nama Activity, PIC, dan Tanggal Plan!");
                return;
            }

            // 3. Buat ID unik dan siapkan format data
            const actId = 'ACT-' + String(activityCounter).padStart(3, '0');
            const rowId = 'act-row-' + String(activityCounter).padStart(3, '0');
            activityCounter++; // Tambah angka untuk activity berikutnya

            const status = 'Plan';
            const statusClass = 'text-plan';

            // 4. Bikin elemen baris tabel baru (<tr>)
            const tbody = document.getElementById('activity-table-body');
            const tr = document.createElement('tr');
            tr.id = rowId;

            // Mencegah error kutip jika nama activity pakai tanda petik
            const safeName = name.replace(/'/g, "\\'");
            const safePic = pic.replace(/'/g, "\\'");

            tr.innerHTML = `
                <td class="text-primary">${actId}</td>
                <td style="max-width: 150px;">${name}</td>
                <td>${pic}</td>
                <td>${datePlan}</td>
                <td>-</td>
                <td>${reqId}</td>
                <td class="${statusClass}">${status}</td>
                <td>
                    <i class="bi bi-pencil action-icon icon-edit" onclick="openEditActivity('${safeName}', '-', '${safePic}', '${datePlan}')"></i>
                    <i class="bi bi-trash action-icon icon-delete" onclick="confirmDeleteActivity('${rowId}')"></i>
                </td>
            `;

            // 5. Tempel baris ke dalam tabel
            tbody.appendChild(tr);

            // 6. Bersihkan form
            document.getElementById('new-act-name').value = '';
            document.getElementById('new-act-pic').value = '';
            document.getElementById('new-act-date').value = '';
            document.getElementById('new-act-reqid').value = '';

            // 7. Tutup kotak form
            toggleAddActivity();
        }

        // --- FUNGSI UPLOAD & SAVE DI ADD NEW MACHINE MODAL ---
        function handleNewMachineUpload(event) {
            const file = event.target.files[0];
            if(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const fileSize = (file.size / 1024).toFixed(1);
                    const fileExt = file.name.split('.').pop().toUpperCase();
                    tempUploadedDoc = {
                        name: file.name,
                        info: `${fileSize} KB • ${fileExt} • Uploaded: Baru saja`,
                        src: e.target.result 
                    };
                    document.getElementById('new-upload-text').innerText = file.name;
                    document.getElementById('new-upload-text').classList.add("text-success");
                    document.getElementById('new-upload-icon').className = 'bi bi-file-earmark-check fs-2 text-success mb-2 d-block';
                    document.getElementById('new-upload-subtext').innerText = `File siap disimpan (${fileSize} KB)`;
                };
                reader.readAsDataURL(file); 
            }
        }

        function saveNewMachine() {
            const name = document.getElementById('new-machine-name').value;
            const code = document.getElementById('new-machine-code').value;
            const area = document.getElementById('new-machine-area').value;
            const type = document.getElementById('new-machine-type').value;

            if (!name || !area || type === "") {
                alert("Harap lengkapi Machine Name, Area, dan Machine Type terlebih dahulu.");
                return;
            }

            if (tempUploadedDoc) {
                machineDatabase[name] = tempUploadedDoc;
            }

            const newCardWrapper = document.createElement('div');
            newCardWrapper.className = 'col-md-4';
            newCardWrapper.innerHTML = `
                <div class="machine-card" onclick="showMachineDetail('${name}', '${type} • ${area}')">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="fw-bold mb-0">${name}</h6>
                        <span class="status-active-badge">Active</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <div style="font-size: 0.8rem; color: #666;">${type}</div>
                            <div style="font-size: 0.75rem; color: #999;">${area}</div>
                        </div>
                        <span class="activity-badge">0 Activity</span>
                    </div>
                    <div class="stat-row"><span class="text-muted"><span class="dot-plan">•</span> Plan:</span> <span class="fw-bold text-primary">0</span></div>
                    <div class="stat-row"><span class="text-muted"><span class="dot-act">•</span> Act:</span> <span class="fw-bold" style="color: #fd7e14;">0</span></div>
                    <div class="stat-row"><span class="text-muted"><span class="dot-done">•</span> Done:</span> <span class="fw-bold text-success">0</span></div>
                </div>
            `;

            const container = document.getElementById('machine-cards-container');
            const addCardButton = document.getElementById('add-machine-card-wrapper');
            container.insertBefore(newCardWrapper, addCardButton);

            bootstrap.Modal.getInstance(document.getElementById('addMachineModal')).hide();

            document.getElementById('new-machine-name').value = '';
            document.getElementById('new-machine-code').value = '';
            document.getElementById('new-machine-area').value = '';
            document.getElementById('new-machine-type').value = '';
            
            tempUploadedDoc = null; 
            document.getElementById('new-upload-text').innerText = 'Drag & drop file here, or click to browse';
            document.getElementById('new-upload-text').classList.remove("text-success");
            document.getElementById('new-upload-icon').className = 'bi bi-upload fs-3 text-secondary mb-2 d-block';
            document.getElementById('new-upload-subtext').innerText = 'Supported: PDF, JPG, PNG (max 10MB)';
            document.getElementById('new-machine-file-input').value = '';
        }

        // --- FUNGSI VIEW, REPLACE, REMOVE DOKUMEN (DI DETAIL VIEW) ---
        function viewDocument() {
            const modal = new bootstrap.Modal(document.getElementById('viewImageModal'));
            modal.show();
        }

        function handleReplaceDocument(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const fileSize = (file.size / 1024).toFixed(1) + " KB";
                    const fileExt = file.name.split('.').pop().toUpperCase();
                    const today = new Date();
                    const dateStr = today.getDate() + '/' + (today.getMonth() + 1) + '/' + today.getFullYear();
                    
                    const newDocData = {
                        name: file.name,
                        info: `${fileSize} • ${fileExt} • Uploaded: ${dateStr}`,
                        src: e.target.result
                    };

                    machineDatabase[currentDetailMachineTitle] = newDocData;

                    document.getElementById('modal-preview-image').src = newDocData.src;
                    document.getElementById('doc-file-name').innerText = newDocData.name;
                    document.getElementById('doc-file-info').innerText = newDocData.info;
                    
                    document.getElementById('doc-container').style.display = 'flex';
                    document.getElementById('empty-doc-message').style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        }

        function removeDocument() {
            delete machineDatabase[currentDetailMachineTitle];
            document.getElementById('doc-container').style.display = 'none';
            document.getElementById('empty-doc-message').style.display = 'block';
            document.getElementById('modal-preview-image').src = "https://via.placeholder.com/1000x600/ffffff/333333?text=Tidak+Ada+Dokumen";
        }

        // --- FUNGSI EDIT DAN DELETE ACTIVITY ---
        function openEditActivity(actName, partName, pic, datePlan) {
            document.getElementById('edit-act-name').value = actName;
            document.getElementById('edit-part-name').value = partName;
            document.getElementById('edit-pic').value = pic;
            document.getElementById('edit-date').value = datePlan;
            const editModal = new bootstrap.Modal(document.getElementById('editActivityModal'));
            editModal.show();
        }

        function confirmDeleteActivity(rowId) {
            activityRowToDelete = rowId;
            const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteActivityModal'));
            deleteModal.show();
        }

        function executeDeleteActivity() {
            if (activityRowToDelete) {
                const row = document.getElementById(activityRowToDelete);
                if (row) row.remove();
            }
            bootstrap.Modal.getInstance(document.getElementById('confirmDeleteActivityModal')).hide();
        }
    </script>
</body>
</html>