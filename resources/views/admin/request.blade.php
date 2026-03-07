<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Management - PT Sumber Prima Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0d6efd;
            --sidebar-width: 260px;
            --bg-light: #f8f9fa;
        }

        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; overflow-x: hidden; }

        /* --- Sidebar Styles --- */
        #sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; top: 0; left: 0; background-color: #fff; border-right: 1px solid #e0e0e0; z-index: 1000; display: flex; flex-direction: column; padding: 20px; }
        .sidebar-brand { display: flex; align-items: center; margin-bottom: 40px; }
        .sidebar-brand img { width: 40px; height: 40px; margin-right: 10px; }
        .sidebar-brand-text h6 { margin: 0; font-weight: 700; color: #333; }
        .sidebar-brand-text span { font-size: 0.8rem; color: #777; }
        .nav-link { display: flex; align-items: center; color: #555; padding: 10px 15px; border-radius: 8px; margin-bottom: 5px; transition: all 0.3s; text-decoration: none;}
        .nav-link i { margin-right: 12px; font-size: 1.1rem; }
        .nav-link:hover { background-color: rgba(13, 110, 253, 0.05); color: var(--primary-color); }
        .nav-link.active { background-color: var(--primary-color); color: #fff; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: #999; letter-spacing: 1px; margin: 20px 0 10px 15px; }

        /* --- Main Content Styles --- */
        #main-content { margin-left: var(--sidebar-width); width: calc(100% - var(--sidebar-width)); padding: 20px 40px; min-height: 100vh; }
        #top-navbar { background-color: transparent; margin-bottom: 30px; }
        #top-navbar .search-bar { width: 400px; }
        #top-navbar .nav-icons { display: flex; align-items: center; gap: 20px; }
        #top-navbar .notification-icon { font-size: 1.3rem; color: #555; position: relative; cursor: pointer;}
        #top-navbar .notification-badge { position: absolute; top: -5px; right: -8px; background-color: #dc3545; color: #fff; font-size: 0.7rem; padding: 2px 6px; border-radius: 50%; }
        #top-navbar .user-profile { display: flex; align-items: center; gap: 10px; padding: 5px 15px; border: 1px solid #e0e0e0; border-radius: 50px; background-color: #fff; }
        #top-navbar .user-profile img { width: 35px; height: 35px; border-radius: 50%; }

        .page-header { margin-bottom: 30px; }
        .btn-tambah { display: flex; align-items: center; gap: 8px; }

        /* --- Cards & Tables --- */
        .card-custom { background-color: #fff; border-radius: 12px; border: 1px solid #e0e0e0; padding: 25px; margin-bottom: 25px; }
        .table-custom { width: 100%; margin-top: 15px; }
        .table-custom thead th { font-size: 0.75rem; text-transform: uppercase; color: #888; letter-spacing: 0.5px; padding-bottom: 15px; border-bottom: 1px solid #ededed; }
        .table-custom tbody td { font-size: 0.9rem; padding: 18px 0; border-bottom: 1px solid #ededed; vertical-align: middle; }
        .table-custom .machine-name { font-weight: 600; color: #333; }
        .table-custom .machine-desc { font-size: 0.8rem; color: #777; margin-top: 3px; }

        /* --- Status Badges --- */
        .status-badge { font-size: 0.8rem; padding: 4px 10px; border-radius: 20px; font-weight: 500; }
        .status-completed { background-color: #d1e7dd; color: #0f5132; }
        .status-waiting { background-color: #fff3cd; color: #856404; }
        .status-purchased { background-color: #d1e7dd; color: #0f5132; }
        .status-available { background-color: #cfe2f3; color: #084298; }
        .status-indent { background-color: #fff3cd; color: #856404; }

        /* --- Action Icons --- */
        .action-icons { display: flex; gap: 12px; font-size: 1.1rem; }
        .action-icon { cursor: pointer; transition: transform 0.2s; }
        .action-icon:hover { transform: scale(1.1); }
        .icon-view { color: #198754; }
        .icon-edit { color: #0d6efd; }
        .icon-delete { color: #dc3545; }

        /* --- Modal Customizations --- */
        .modal-content { border-radius: 12px; border: none; padding: 10px; }
        .modal-header { border-bottom: none; padding-bottom: 5px; }
        .modal-body { padding-top: 10px; }
        .modal-footer { border-top: none; padding-top: 5px; }
        .form-label-custom { font-size: 0.85rem; color: #666; margin-bottom: 5px; }
        .form-control-custom { border-radius: 8px; padding: 10px 15px; border: 1px solid #ccc; }
        .form-control-custom:focus { border-color: var(--primary-color); box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15); }
        .required-star { color: #dc3545; margin-left: 3px; }

        /* --- Custom UI for "Part Details" --- */
        .part-detail-item { margin-bottom: 20px; }
        .part-detail-label { font-size: 0.8rem; color: #888; margin-bottom: 2px; }
        .part-detail-value { font-size: 1rem; color: #333; font-weight: 500; }
        .part-detail-indent { color: #856404; font-weight: 600; }

        #part-listing-container { display: none; }
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

        <div id="top-navbar" class="d-flex justify-content-between align-items-center">
            <div class="search-bar input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Cari berdasarkan Request ID, perusahaan, atau...">
            </div>

            <div class="nav-icons">
                <div class="notification-icon">
                    <i class="bi bi-bell"></i>
                    <span class="notification-badge">2</span>
                </div>
                <div class="user-profile">
                    <img src="https://via.placeholder.com/35/0d6efd/ffffff?text=AG" alt="User">
                    <div>
                        <div style="font-weight: 600; font-size: 0.9rem;">Andrew Gunawan</div>
                        <div style="font-size: 0.75rem; color: #0d6efd;">Admin</div>
                    </div>
                </div>
                <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-box-arrow-right me-1"></i> Logout</button>
            </div>
        </div>

        <div id="request-management-container">
            <div class="page-header d-flex justify-content-between align-items-start">
                <div>
                    <h2>Request Management</h2>
                    <p class="text-muted">Input & manage incoming production requests</p>
                </div>
                <button class="btn btn-primary btn-tambah" data-bs-toggle="modal" data-bs-target="#addRequestModal">
                    <i class="bi bi-plus-lg"></i> Tambah Permintaan
                </button>
            </div>

            <div class="card-custom">
                <div class="d-flex justify-content-between gap-3 mb-4">
                    <div class="input-group" style="max-width: 600px;">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" class="form-control border-start-0" placeholder="Cari berdasarkan Request ID, perusahaan, atau jenis mesin...">
                    </div>
                    <select class="form-select" style="max-width: 150px;">
                        <option selected>All Status</option>
                        <option>Completed</option>
                        <option>Waiting</option>
                    </select>
                </div>

                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>REQUEST ID</th>
                            <th>MACHINE NAME</th>
                            <th>QUANTITY</th>
                            <th>DUE DATE</th>
                            <th>PARTS</th>
                            <th>STATUS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody id="request-table-body">
                        <tr id="req-row-001">
                            <td>REQ-2025-001</td>
                            <td>
                                <div class="machine-name">Custom Gear Box Machine</div>
                                <div class="machine-desc">Mesin gear box untuk packaging line dengan kapasitas 100...</div>
                            </td>
                            <td>2 unit</td>
                            <td>15/2/2025</td>
                            <td>3 parts</td>
                            <td><span class="status-badge status-completed">Part Listing Completed</span></td>
                            <td>
                                <div class="action-icons">
                                    <i class="bi bi-eye action-icon icon-view" title="Lihat Detail Bagian" onclick="showPartListing('REQ-2025-001', 'Custom Gear Box Machine')"></i>
                                    <i class="bi bi-trash action-icon icon-delete" title="Hapus Permintaan" onclick="confirmDeleteRequest('REQ-2025-001')"></i>
                                </div>
                            </td>
                        </tr>
                        <tr id="req-row-002">
                            <td>REQ-2025-002</td>
                            <td>
                                <div class="machine-name">Conveyor Belt System</div>
                                <div class="machine-desc">System conveyor dengan panjang 10 meter</div>
                            </td>
                            <td>1 unit</td>
                            <td>28/2/2025</td>
                            <td>0 parts</td>
                            <td><span class="status-badge status-waiting">Waiting for Part Listing</span></td>
                            <td>
                                <div class="action-icons">
                                    <i class="bi bi-eye action-icon icon-view" title="Lihat Detail Bagian" onclick="showPartListing('REQ-2025-002', 'Conveyor Belt System')"></i>
                                    <i class="bi bi-trash action-icon icon-delete" title="Hapus Permintaan" onclick="confirmDeleteRequest('REQ-2025-002')"></i>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="part-listing-container">
            <div class="page-header">
                <a href="#" class="text-decoration-none text-muted" onclick="hidePartListing()"><i class="bi bi-arrow-left me-2"></i> Back to Request Management</a>
                <h2 class="mt-3">Part Listing</h2>
                <p class="text-muted mb-0">Request ID: <span id="detail-req-id" class="fw-bold">REQ-2025-001</span></p>
                <p class="text-muted">Machine: <span id="detail-machine-name" class="fw-bold">Custom Gear Box Machine</span></p>
            </div>

            <div class="card-custom">
                <h5 class="mb-4 fw-bold">Part List</h5>

                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>PART NAME</th>
                            <th>MATERIAL</th>
                            <th>DIMENSION FINISH</th>
                            <th>DIMENSION RAW</th>
                            <th>QTY</th>
                            <th>PART STATUS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="part-row-1">
                            <td>Gear Shaft</td>
                            <td>SCM 440</td>
                            <td>Ø50 x 200</td>
                            <td>Ø55 x 210</td>
                            <td>2</td>
                            <td><span class="status-badge status-purchased">Purchased</span></td>
                            <td>
                                <div class="action-icons">
                                    <i class="bi bi-pencil action-icon icon-edit" title="Edit Status" data-bs-toggle="modal" data-bs-target="#editPartStatusModal" onclick="populateEditModal('part-row-1', 'Gear Shaft', 'Purchased')"></i>
                                    <i class="bi bi-eye action-icon icon-view" title="Lihat Detail Bagian" data-bs-toggle="modal" data-bs-target="#partDetailsModal"></i>
                                    <i class="bi bi-trash action-icon icon-delete" title="Hapus Bagian" onclick="confirmDeletePart('part-row-1', 'Gear Shaft')"></i>
                                </div>
                            </td>
                        </tr>
                        <tr id="part-row-2">
                            <td>Bearing Housing</td>
                            <td>SS 304</td>
                            <td>100 x 100 x 50</td>
                            <td>110 x 110 x 55</td>
                            <td>4</td>
                            <td><span class="status-badge status-available">Available</span></td>
                            <td>
                                <div class="action-icons">
                                    <i class="bi bi-pencil action-icon icon-edit" title="Edit Status" data-bs-toggle="modal" data-bs-target="#editPartStatusModal" onclick="populateEditModal('part-row-2', 'Bearing Housing', 'Available')"></i>
                                    <i class="bi bi-eye action-icon icon-view" title="Lihat Detail Bagian" data-bs-toggle="modal" data-bs-target="#partDetailsModal"></i>
                                    <i class="bi bi-trash action-icon icon-delete" title="Hapus Bagian" onclick="confirmDeletePart('part-row-2', 'Bearing Housing')"></i>
                                </div>
                            </td>
                        </tr>
                        <tr id="part-row-3">
                            <td>Cover Plate</td>
                            <td>Mild Steel</td>
                            <td>200 x 150 x 10</td>
                            <td>210 x 160 x 12</td>
                            <td>2</td>
                            <td><span class="status-badge status-indent">Indent</span></td>
                            <td>
                                <div class="action-icons">
                                    <i class="bi bi-pencil action-icon icon-edit" title="Edit Status" data-bs-toggle="modal" data-bs-target="#editPartStatusModal" onclick="populateEditModal('part-row-3', 'Cover Plate', 'Indent')"></i>
                                    <i class="bi bi-eye action-icon icon-view" title="Lihat Detail Bagian" data-bs-toggle="modal" data-bs-target="#partDetailsModal"></i>
                                    <i class="bi bi-trash action-icon icon-delete" title="Hapus Bagian" onclick="confirmDeletePart('part-row-3', 'Cover Plate')"></i>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="modal fade" id="addRequestModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title fw-bold">Create Machine Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-custom">Jenis Mesin / Produk<span class="required-star">*</span></label>
                                <input type="text" id="new-req-jenis" class="form-control form-control-custom" placeholder="Contoh: Mesin Conveyor Custom">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Quantity Mesin<span class="required-star">*</span></label>
                                <input type="number" id="new-req-qty" class="form-control form-control-custom" placeholder="Contoh: 1">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Deskripsi Permintaan<span class="required-star">*</span></label>
                            <textarea id="new-req-desc" class="form-control form-control-custom" rows="4" placeholder="Detail kebutuhan dan spesifikasi mesin..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-custom">Due Date<span class="required-star">*</span></label>
                            <input type="date" id="new-req-date" class="form-control form-control-custom">
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-start gap-2">
                    <button type="button" class="btn btn-primary px-4" onclick="saveNewRequest()">Simpan</button>
                    <button type="button" class="btn btn-light px-4 border" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="partDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center pb-2">
                    <h5 class="modal-title fw-bold">Part Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="part-detail-item"><div class="part-detail-label">Part Name</div><div class="part-detail-value">Gear Shaft</div></div>
                            <div class="part-detail-item"><div class="part-detail-label">Dimension Finish</div><div class="part-detail-value">Ø50 x 200</div></div>
                            <div class="part-detail-item"><div class="part-detail-label">Quantity</div><div class="part-detail-value">2</div></div>
                        </div>
                        <div class="col-md-6">
                            <div class="part-detail-item"><div class="part-detail-label">Material</div><div class="part-detail-value">SCM 440</div></div>
                            <div class="part-detail-item"><div class="part-detail-label">Dimension Raw</div><div class="part-detail-value">Ø55 x 210</div></div>
                            <div class="part-detail-item"><div class="part-detail-label">Created By</div><div class="part-detail-value">Design Team</div></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end">
                    <button type="button" class="btn btn-outline-secondary px-4 border" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPartStatusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h5 class="modal-title fw-bold">Edit Part Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label-custom text-muted">Part Name</label>
                        <div id="edit-modal-part-name" class="fw-bold fs-5 text-dark">Gear Shaft</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label-custom text-dark">Procurement Status</label>
                        <select id="edit-modal-status-select" class="form-select form-control-custom">
                            <option value="Purchased">Purchased</option>
                            <option value="Available">Available</option>
                            <option value="Indent">Indent</option>
                        </select>
                    </div>
                    <div class="text-muted mt-3" style="font-size: 0.8rem; line-height: 1.4;">
                        Only parts with "Purchased" or "Available" status can be scheduled for production.
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light px-4 border" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary px-4" onclick="savePartStatus()">Save Status</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmDeleteRequestModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-danger">Hapus Permintaan?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus permintaan <strong id="delete-req-id-text"></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" onclick="deleteRequest()">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmDeletePartModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-danger">Hapus Bagian?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Hapus <strong id="delete-part-name-text"></strong> dari daftar?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" onclick="deletePart()">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // --- NAVIGASI TAMPILAN ---
        function showPartListing(reqId, machineName) {
            document.getElementById('request-management-container').style.display = 'none';
            document.getElementById('part-listing-container').style.display = 'block';
            document.getElementById('detail-req-id').innerText = reqId;
            document.getElementById('detail-machine-name').innerText = machineName;
        }

        function hidePartListing() {
            document.getElementById('part-listing-container').style.display = 'none';
            document.getElementById('request-management-container').style.display = 'block';
        }

        // ====================================================
        // FUNGSI 1: SIMPAN PERMINTAAN BARU SECARA DINAMIS
        // ====================================================
        let requestCounter = 3; // Mulai dari 3 karena 1 dan 2 sudah ada

        function saveNewRequest() {
            // 1. Ambil data dari form
            const jenis = document.getElementById('new-req-jenis').value;
            const qty = document.getElementById('new-req-qty').value;
            const desc = document.getElementById('new-req-desc').value;
            let date = document.getElementById('new-req-date').value;

            // Validasi Input Wajib
            if (!jenis || !qty || !date) {
                alert("Harap lengkapi Jenis Mesin, Quantity, dan Due Date!");
                return;
            }

            // Ubah format tanggal (YYYY-MM-DD -> DD/MM/YYYY)
            if (date) {
                const d = new Date(date);
                date = `${d.getDate()}/${d.getMonth()+1}/${d.getFullYear()}`;
            }

            // Buat ID unik
            const reqId = 'REQ-2025-' + String(requestCounter).padStart(3, '0');
            const rowId = 'req-row-' + String(requestCounter).padStart(3, '0');
            requestCounter++;

            // Potong deskripsi jika terlalu panjang
            const shortDesc = desc.length > 50 ? desc.substring(0, 50) + '...' : desc;

            // 2. Buat elemen baris <tr> baru
            const tbody = document.getElementById('request-table-body');
            const tr = document.createElement('tr');
            tr.id = rowId;

            // Amankan teks yang diketik agar tidak error jika ada kutip
            const safeJenis = jenis.replace(/'/g, "\\'");

            tr.innerHTML = `
                <td>${reqId}</td>
                <td>
                    <div class="machine-name">${jenis}</div>
                    <div class="machine-desc">${shortDesc}</div>
                </td>
                <td>${qty} unit</td>
                <td>${date}</td>
                <td>0 parts</td>
                <td><span class="status-badge status-waiting">Waiting for Part Listing</span></td>
                <td>
                    <div class="action-icons">
                        <i class="bi bi-eye action-icon icon-view" title="Lihat Detail Bagian" onclick="showPartListing('${reqId}', '${safeJenis}')"></i>
                        <i class="bi bi-trash action-icon icon-delete" title="Hapus Permintaan" onclick="confirmDeleteRequest('${reqId}')"></i>
                    </div>
                </td>
            `;

            // 3. Masukkan ke tabel
            tbody.appendChild(tr);

            // 4. Bersihkan form & Tutup Modal
            document.getElementById('new-req-jenis').value = '';
            document.getElementById('new-req-qty').value = '';
            document.getElementById('new-req-desc').value = '';
            document.getElementById('new-req-date').value = '';

            bootstrap.Modal.getInstance(document.getElementById('addRequestModal')).hide();
        }


        // ====================================================
        // FUNGSI 2: EDIT PART STATUS SECARA DINAMIS
        // ====================================================
        let currentEditPartRowId = ''; // Menyimpan ID baris yang sedang di-edit

        function populateEditModal(rowId, partName, currentStatus) {
            // Ingat ID barisnya saat kita mengklik ikon pensil
            currentEditPartRowId = rowId;
            
            // Isi teks di dalam modal
            document.getElementById('edit-modal-part-name').innerText = partName;
            document.getElementById('edit-modal-status-select').value = currentStatus;
        }

        function savePartStatus() {
            // 1. Ambil status yang baru dipilih
            const newStatus = document.getElementById('edit-modal-status-select').value;
            
            if(!currentEditPartRowId) return;

            // 2. Temukan baris tabel berdasarkan ID
            const row = document.getElementById(currentEditPartRowId);
            if(row) {
                // Kolom Status Part ada di index ke-5 (Kolom ke-6)
                const statusCell = row.cells[5];
                
                // Tentukan warna (class) badge sesuai status
                let badgeClass = 'status-available'; // Default Biru
                if(newStatus === 'Purchased') badgeClass = 'status-purchased'; // Hijau
                if(newStatus === 'Indent') badgeClass = 'status-indent'; // Kuning

                // 3. Ganti HTML di dalam kolom tersebut
                statusCell.innerHTML = `<span class="status-badge ${badgeClass}">${newStatus}</span>`;
                
                // 4. Update Event Listener ikon pensil agar saat di-klik lagi statusnya sudah yang terbaru
                const editIcon = row.querySelector('.icon-edit');
                const partName = row.cells[0].innerText; // Ambil nama part dari kolom pertama
                
                // Ganti fungsi onclick pada pensil
                editIcon.setAttribute('onclick', `populateEditModal('${currentEditPartRowId}', '${partName}', '${newStatus}')`);
            }

            // Tutup Modal
            bootstrap.Modal.getInstance(document.getElementById('editPartStatusModal')).hide();
        }

        // --- FUNGSI HAPUS (Tetap Sama) ---
        let requestIdToDelete = '';
        let partRowIdToDelete = '';

        function confirmDeleteRequest(reqId) {
            requestIdToDelete = reqId;
            document.getElementById('delete-req-id-text').innerText = reqId;
            const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteRequestModal'));
            deleteModal.show();
        }

        function deleteRequest() {
            // Cari baris berdasarkan reqId (menggunakan selector attribute ID)
            const rows = document.querySelectorAll('#request-table-body tr');
            rows.forEach(row => {
                if (row.cells[0].innerText === requestIdToDelete) {
                    row.remove();
                }
            });
            bootstrap.Modal.getInstance(document.getElementById('confirmDeleteRequestModal')).hide();
        }

        function confirmDeletePart(rowId, partName) {
            partRowIdToDelete = rowId;
            document.getElementById('delete-part-name-text').innerText = partName;
            const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeletePartModal'));
            deleteModal.show();
        }

        function deletePart() {
            const row = document.getElementById(partRowIdToDelete);
            if (row) row.remove();
            bootstrap.Modal.getInstance(document.getElementById('confirmDeletePartModal')).hide();
        }

    </script>
</body>
</html>