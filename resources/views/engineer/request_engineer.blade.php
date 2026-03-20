<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Management - PT Sumber Prima Mandiri</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- Global Styles & Reused from Dashboard --- */
        body { font-family: 'Inter', sans-serif; background-color: #F8F9FB; }
        .sidebar { min-height: 100vh; background-color: #fff; border-right: 1px solid #eaecf0; padding-top: 20px; }
        .logo-area { display: flex; align-items: center; padding: 0 24px 30px 24px; }
        .logo-icon { width: 40px; height: 40px; background-color: #2F6BFF; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 24px; margin-right: 12px; }
        .company-name { font-weight: 700; font-size: 14px; line-height: 1.2; color: #101828; }
        .sidebar-nav .nav-link { color: #475467; font-weight: 500; padding: 12px 24px; margin-bottom: 4px; border-radius: 8px; display: flex; align-items: center; gap: 12px; margin-left: 16px; margin-right: 16px;}
        .sidebar-nav .nav-link:hover { background-color: #f9fafb; color: #101828; }
        .sidebar-nav .nav-link.active { background-color: #2F6BFF; color: white; }
        .top-bar { background-color: #fff; padding: 16px 32px; border-bottom: 1px solid #eaecf0; display: flex; justify-content: space-between; align-items: center; }
        .user-profile { display: flex; align-items: center; gap: 16px; }
        .user-info { text-align: right; }
        .user-name { font-weight: 600; font-size: 14px; color: #101828; }
        .user-role { background-color: #F2F4F7; color: #344054; font-size: 12px; padding: 2px 8px; border-radius: 16px; font-weight: 500; }
        .logout-btn { border: 1px solid #d0d5dd; color: #344054; padding: 8px 16px; border-radius: 8px; background: white; font-weight: 600; font-size: 14px; text-decoration: none; display: flex; align-items: center; gap: 8px; }
        
        /* --- Content Specific Styles --- */
        .main-content-area { padding: 24px 32px; }
        .content-card { background: white; border: 1px solid #eaecf0; border-radius: 12px; padding: 24px; }
        .page-title { font-size: 24px; font-weight: 600; color: #101828; margin-bottom: 8px; }
        .page-subtitle { color: #475467; font-size: 14px; }
        
        /* Tables styling */
        .table thead th { font-size: 12px; color: #475467; font-weight: 600; background-color: #F9FAFB; border-bottom: 1px solid #eaecf0; padding: 12px 16px; text-transform: uppercase; }
        .table tbody td { padding: 16px 16px; color: #101828; font-size: 14px; vertical-align: middle; border-bottom: 1px solid #eaecf0; }
        .status-badge { padding: 4px 12px; border-radius: 16px; font-size: 12px; font-weight: 500; }
        .status-blue { background-color: #eff8ff; color: #2F6BFF; }
        .status-yellow { background-color: #fffaeb; color: #b54708; }
        .btn-add-parts-link { color: #2F6BFF; text-decoration: none; font-weight: 500; cursor: pointer; }
        .btn-add-parts-link:hover { text-decoration: underline; }

        /* Buttons & Forms */
        .btn-primary-custom { background-color: #2F6BFF; border-color: #2F6BFF; color: white; font-weight: 500; }
        .btn-primary-custom:hover { background-color: #1e5afa; }
        .btn-success-custom { background-color: #12B76A; border-color: #12B76A; color: white; font-weight: 500; }
        .btn-success-custom:hover { background-color: #0e9f5d; }
        .btn-outline-custom { border: 1px solid #d0d5dd; color: #344054; background: white; font-weight: 500; }
        .form-label { font-weight: 500; font-size: 14px; color: #344054; }
        .form-control, .form-select { border-radius: 8px; border: 1px solid #d0d5dd; padding: 10px 14px; }
        .required-star { color: #F04438; margin-left: 4px; }
        .back-link { color: #475467; text-decoration: none; font-weight: 500; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 16px; cursor: pointer;}
        .back-link:hover { color: #2F6BFF; }

        /* Action Icons */
        .action-icon-btn { border: none; background: none; padding: 4px 8px; cursor: pointer; transition: color 0.2s; }
        .edit-icon { color: #2F6BFF; }
        .view-icon { color: #12B76A; }
        .delete-icon { color: #F04438; }
        .action-icon-btn:hover { opacity: 0.7; }

        /* Toast/Alert Position */
        .toast-container { z-index: 1060; }
        .custom-toast { border-left: 4px solid #12B76A; }

        /* Utility to hide views */
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
                <li class="nav-item"><a class="nav-link" href="{{ route('design.dasbord') }}"><i class="bi bi-grid-fill"></i> Dashboards</a></li>
                <li class="nav-item"><a class="nav-link active" href="{{ route('design.request') }}"><i class="bi bi-file-text"></i> Request Management</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('design.master') }}"><i class="bi bi-calendar-check"></i> Master Schedule</a></li>
            </ul>
        </nav>

        <main class="col-md-10 ms-sm-auto px-0">
             <header class="top-bar">
                <div class="position-relative" style="width: 400px;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" class="form-control ps-5" placeholder="Search request, machine, activity...">
                </div>
                <div class="user-profile">
                    <div class="position-relative me-3">
                        <i class="bi bi-bell fs-5 text-secondary"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">2</span>
                    </div>
                    <div class="d-flex align-items-center gap-3 bg-white border rounded p-2 pe-4">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="bi bi-person"></i></div>
                        <div class="user-info"><div class="user-name">Vannia Ariawati</div><div class="user-role">Design</div></div>
                    </div>
                    <a href="#" class="logout-btn"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </div>
            </header>

            <div id="view-request-list" class="view-section active main-content-area" style="background-color: #F9FAFB; min-height: 90vh;">
                <div class="mb-4">
                    <h2 class="page-title">Request Management</h2>
                    <p class="page-subtitle">View requests and add part listing</p>
                </div>

                <div class="content-card">
                    <div class="d-flex justify-content-between mb-4">
                        <div class="position-relative" style="width: 300px;">
                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <input type="text" class="form-control ps-5" placeholder="Search by ID or machine name...">
                        </div>
                        <select class="form-select" style="width: 150px;">
                            <option selected>All Status</option>
                            <option>Waiting for Part</option>
                            <option>Completed</option>
                        </select>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Request ID</th>
                                    <th>Machine Name</th>
                                    <th>Quantity</th>
                                    <th>Due Date</th>
                                    <th>Parts</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-medium">REQ-2025-001</td>
                                    <td>
                                        <div class="fw-medium">Custom Gear Box Machine</div>
                                        <small class="text-muted">Mesin gear box untuk packaging line dengan kapasitas 100</small>
                                    </td>
                                    <td>2 unit</td>
                                    <td>15/2/2025</td>
                                    <td>4 parts</td>
                                    <td><span class="status-badge status-blue">Part Listing Completed</span></td>
                                    <td><span class="btn-add-parts-link" onclick="navigate.toPartList('REQ-2025-001')">+ Add Parts</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">REQ-2025-002</td>
                                    <td>
                                        <div class="fw-medium">Conveyor Belt System</div>
                                        <small class="text-muted">System conveyor dengan panjang 10 meter</small>
                                    </td>
                                    <td>1 unit</td>
                                    <td>28/2/2025</td>
                                    <td>0 parts</td>
                                    <td><span class="status-badge status-yellow">Waiting for Part Listing</span></td>
                                    <td><span class="btn-add-parts-link" onclick="navigate.toPartList('REQ-2025-002')">+ Add Parts</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div id="view-part-list" class="view-section main-content-area" style="background-color: #F9FAFB; min-height: 90vh;">
                <div onclick="navigate.toRequestList()" class="back-link"><i class="bi bi-arrow-left"></i> Back to Request Management</div>
                
                <div class="mb-4">
                    <h2 class="page-title">Create Part Listing</h2>
                    <div class="text-muted">Request ID: <span class="fw-medium text-dark" id="pl-request-id">REQ-2025-001</span></div>
                    <div class="text-muted">Machine: <span class="fw-medium text-dark" id="pl-machine-name">Custom Gear Box Machine</span></div>
                    <small class="text-muted">Define what will be produced - parts, materials, and dimensions</small>
                </div>

                <div class="content-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Part List (<span id="part-count">0</span> parts)</h5>
                        <button class="btn btn-primary-custom" onclick="navigate.toAddPartForm()"><i class="bi bi-plus-lg me-2"></i>Add Part</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle" id="parts-table">
                            <thead>
                                <tr>
                                    <th>Part Name</th>
                                    <th>Material</th>
                                    <th>Dimension Finish</th>
                                    <th>Dimension Raw</th>
                                    <th>Qty</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-4">
                        <button class="btn btn-success-custom px-4 py-2" onclick="submitToAdmin()">Submit to Admin</button>
                    </div>
                </div>
            </div>

            <div id="view-add-part" class="view-section main-content-area" style="background-color: #F9FAFB; min-height: 90vh;">
                <div onclick="navigate.toPartList()" class="back-link"><i class="bi bi-arrow-left"></i> Back to Part Listing</div>
                
                <div class="mb-4">
                    <h2 class="page-title">Add New Part</h2>
                    <div class="text-muted small">Request ID: <span class="fw-medium text-dark" id="ap-request-id"></span> • Machine: <span class="fw-medium text-dark" id="ap-machine-name"></span></div>
                </div>

                <div class="alert alert-primary d-flex align-items-center" role="alert" style="background-color: #F5F8FF; border-color: #D0D5DD;">
                    <i class="bi bi-info-circle-fill text-primary me-3 fs-5"></i>
                    <div>
                        <div class="fw-medium" style="color: #1d2939;">Design Team - Part Entry</div>
                        <div class="small" style="color: #475467;">Enter part specifications including material and dimensions. All fields are required for manufacturing preparation.</div>
                    </div>
                </div>

                <div class="content-card">
                    <h5 class="fw-bold mb-4">Part Details</h5>
                    <p class="text-muted small mb-4">Enter part specifications</p>
                    
                    <form id="addPartForm">
                        <div class="mb-3">
                            <label class="form-label">Part Name<span class="required-star">*</span></label>
                            <input type="text" class="form-control" id="add-partName" required placeholder="e.g., Mesin CNC 2">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Material<span class="required-star">*</span></label>
                            <input type="text" class="form-control" id="add-material" required placeholder="e.g., BAJA">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Dimension Finish<span class="required-star">*</span></label>
                                <input type="text" class="form-control" id="add-dimFinish" required placeholder="e.g., 200 x 10">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Dimension Raw<span class="required-star">*</span></label>
                                <input type="text" class="form-control" id="add-dimRaw" required placeholder="e.g., 210 x 290">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantity<span class="required-star">*</span></label>
                            <input type="number" class="form-control" id="add-quantity" required placeholder="e.g., 1">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Notes (Optional)</label>
                            <textarea class="form-control" id="add-notes" rows="3" placeholder="Additional notes..."></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-3">
                            <button type="button" class="btn btn-outline-custom px-4" onclick="navigate.toPartList()">Cancel</button>
                            <button type="submit" class="btn btn-primary-custom px-4">Add Part</button>
                        </div>
                    </form>
                </div>
                <br><br>
                <div class="alert alert-warning small" style="background-color: #FFFAEB; border-color: #FEDF89; color: #B54708;">
                    <strong>Design Workflow:</strong> After adding all parts, submit the complete part listing to Admin for material procurement and production planning.
                </div>
            </div>

        </main>
    </div>
</div>

<div class="modal fade" id="editPartModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-4">Edit Part</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <form id="editPartForm">
                    <input type="hidden" id="edit-partId">
                    <div class="mb-3">
                        <label class="form-label">Part Name<span class="required-star">*</span></label>
                        <input type="text" class="form-control" id="edit-partName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Material<span class="required-star">*</span></label>
                        <input type="text" class="form-control" id="edit-material" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Dimension Finish<span class="required-star">*</span></label>
                            <input type="text" class="form-control" id="edit-dimFinish" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dimension Raw<span class="required-star">*</span></label>
                            <input type="text" class="form-control" id="edit-dimRaw" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity<span class="required-star">*</span></label>
                        <input type="number" class="form-control" id="edit-quantity" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" id="edit-notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary-custom" onclick="saveEditedPart()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewPartModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Part Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-4">
                <div class="row g-4 mb-4">
                    <div class="col-6">
                        <div class="text-muted small">Part Name</div>
                        <div class="fw-medium fs-5" id="view-partName"></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Material</div>
                        <div class="fw-medium fs-5" id="view-material"></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Dimension Finish</div>
                        <div class="fw-medium fs-5" id="view-dimFinish"></div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted small">Dimension Raw</div>
                        <div class="fw-medium fs-5" id="view-dimRaw"></div>
                    </div>
                    <div class="col-12">
                        <div class="text-muted small">Quantity</div>
                        <div class="fw-medium fs-5" id="view-quantity"></div>
                    </div>
                     <div class="col-12">
                        <div class="text-muted small">Part Status</div>
                         <span class="badge bg-warning text-dark rounded-pill fw-normal px-3">Indent</span>
                    </div>
                     <div class="col-12">
                        <div class="text-muted small">Notes</div>
                        <div class="fw-medium" id="view-notes"></div>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="text-muted small">Created By</div>
                        <div class="fw-medium">Design Team</div>
                    </div>
                </div>
            </div>
             <div class="modal-footer border-0 p-0 pb-3 pe-3">
                 <button type="button" class="btn btn-outline-custom px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="toast-container position-fixed top-0 end-0 p-3">
  <div id="successToast" class="toast custom-toast align-items-center bg-white" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
    <div class="d-flex p-2">
      <div class="toast-body d-flex align-items-start gap-3">
        <i class="bi bi-check-circle-fill text-success fs-4"></i>
        <div>
            <h6 class="fw-bold mb-1">Submitted!</h6>
            <p class="mb-0 text-muted small">Part listing submitted to Admin successfully!</p>
        </div>
      </div>
      <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // --- 1. Sample Data Storage ---
    // Data Request utama
    const requestsData = {
        'REQ-2025-001': { machineName: 'Custom Gear Box Machine' },
        'REQ-2025-002': { machineName: 'Conveyor Belt System' }
    };

    // Data Parts yang disimpan per Request ID.
    // Awalnya diisi sampel agar mirip Gambar 3.
    let partsStorage = {
        'REQ-2025-001': [
            { id: 101, name: 'Gear Shaft', material: 'SCM 440', dimFinish: 'Ø50 x 200', dimRaw: 'Ø55 x 210', qty: 2, notes: 'Heat treatment required' },
            { id: 102, name: 'Bearing Housing', material: 'SS 304', dimFinish: '100 x 100 x 50', dimRaw: '110 x 110 x 55', qty: 4, notes: 'Precision machining' },
            { id: 103, name: 'Cover Plate', material: 'Mild Steel', dimFinish: '200 x 150 x 10', dimRaw: '210 x 160 x 12', qty: 2, notes: 'Standard machining' }
        ],
        'REQ-2025-002': [] // Request kedua masih kosong
    };

    // State aplikasi saat ini
    let currentState = {
        requestId: null, // Request mana yang sedang aktif
    };

    // Bootstrap Modal Instances
    const editModal = new bootstrap.Modal(document.getElementById('editPartModal'));
    const viewModal = new bootstrap.Modal(document.getElementById('viewPartModal'));
    const successToast = new bootstrap.Toast(document.getElementById('successToast'));


    // --- 2. Navigation Functions (Pindah Halaman/View) ---
    const navigate = {
        // Tampilkan Halaman Utama (Request List) - Gambar 2
        toRequestList: function() {
            document.querySelectorAll('.view-section').forEach(el => el.classList.remove('active'));
            document.getElementById('view-request-list').classList.add('active');
            currentState.requestId = null;
        },

        // Tampilkan Halaman Daftar Part (Part Listing) - Gambar 3
        toPartList: function(requestId) {
            // Jika requestId tidak diberikan, gunakan yang terakhir aktif
            if(requestId) currentState.requestId = requestId;
            
            const reqInfo = requestsData[currentState.requestId];
            
            // Update Header Halaman Part List
            document.getElementById('pl-request-id').textContent = currentState.requestId;
            document.getElementById('pl-machine-name').textContent = reqInfo.machineName;

            // Render tabel part
            renderPartsTable();

            // Tampilkan view
            document.querySelectorAll('.view-section').forEach(el => el.classList.remove('active'));
            document.getElementById('view-part-list').classList.add('active');
        },

        // Tampilkan Form Tambah Part (Add Part Form) - Gambar 4
        toAddPartForm: function() {
             const reqInfo = requestsData[currentState.requestId];
             // Update Header Halaman Add Form
             document.getElementById('ap-request-id').textContent = currentState.requestId;
             document.getElementById('ap-machine-name').textContent = reqInfo.machineName;
             
             // Reset form
             document.getElementById('addPartForm').reset();

             // Tampilkan view
            document.querySelectorAll('.view-section').forEach(el => el.classList.remove('active'));
            document.getElementById('view-add-part').classList.add('active');
        }
    };


    // --- 3. CRUD Operations & Rendering ---

    // RENDER: Menggambar ulang tabel part di Gambar 3 berdasarkan data
    function renderPartsTable() {
        const tbody = document.querySelector('#parts-table tbody');
        const partCountSpan = document.getElementById('part-count');
        tbody.innerHTML = ''; // Kosongkan tabel
        
        const parts = partsStorage[currentState.requestId] || [];
        partCountSpan.textContent = parts.length; // Update jumlah part di header

        if (parts.length === 0) {
             tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted py-4">No parts added yet.</td></tr>';
             return;
        }

        parts.forEach(part => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="fw-medium">${part.name}</td>
                <td>${part.material}</td>
                <td>${part.dimFinish}</td>
                <td>${part.dimRaw}</td>
                <td>${part.qty}</td>
                <td>${part.notes}</td>
                <td>
                    <button class="action-icon-btn edit-icon" onclick="openEditModal(${part.id})" title="Edit"><i class="bi bi-pencil-fill"></i></button>
                    <button class="action-icon-btn view-icon" onclick="openViewModal(${part.id})" title="View Details"><i class="bi bi-eye-fill"></i></button>
                    <button class="action-icon-btn delete-icon" onclick="deletePart(${part.id})" title="Delete"><i class="bi bi-trash-fill"></i></button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }


    // CREATE: Menangani submit form "Add New Part" (Gambar 4)
    document.getElementById('addPartForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Ambil data dari form
        const newPart = {
            id: Date.now(), // Gunakan timestamp sebagai ID unik sementara
            name: document.getElementById('add-partName').value,
            material: document.getElementById('add-material').value,
            dimFinish: document.getElementById('add-dimFinish').value,
            dimRaw: document.getElementById('add-dimRaw').value,
            qty: document.getElementById('add-quantity').value,
            notes: document.getElementById('add-notes').value
        };

        // Simpan ke array penyimpanan
        partsStorage[currentState.requestId].push(newPart);

        // Kembali ke halaman list
        navigate.toPartList();
    });


    // DELETE: Menghapus part dari list
    function deletePart(partId) {
        if(confirm("Are you sure you want to delete this part?")) {
            // Filter array untuk menghilangkan ID yang dipilih
            partsStorage[currentState.requestId] = partsStorage[currentState.requestId].filter(p => p.id !== partId);
            renderPartsTable(); // Gambar ulang tabel
        }
    }


    // READ (View Details): Membuka Modal View (Gambar 7)
    function openViewModal(partId) {
        const part = partsStorage[currentState.requestId].find(p => p.id === partId);
        if(!part) return;

        // Isi data ke dalam modal view
        document.getElementById('view-partName').textContent = part.name;
        document.getElementById('view-material').textContent = part.material;
        document.getElementById('view-dimFinish').textContent = part.dimFinish;
        document.getElementById('view-dimRaw').textContent = part.dimRaw;
        document.getElementById('view-quantity').textContent = part.qty;
        document.getElementById('view-notes').textContent = part.notes || '-';

        viewModal.show();
    }


    // UPDATE (Prepare Edit): Membuka Modal Edit (Gambar 5)
    function openEditModal(partId) {
        const part = partsStorage[currentState.requestId].find(p => p.id === partId);
        if(!part) return;

        // Isi form edit dengan data yang ada
        document.getElementById('edit-partId').value = part.id;
        document.getElementById('edit-partName').value = part.name;
        document.getElementById('edit-material').value = part.material;
        document.getElementById('edit-dimFinish').value = part.dimFinish;
        document.getElementById('edit-dimRaw').value = part.dimRaw;
        document.getElementById('edit-quantity').value = part.qty;
        document.getElementById('edit-notes').value = part.notes;

        editModal.show();
    }

    // UPDATE (Save Changes): Menyimpan perubahan dari Modal Edit (Gambar 6)
    function saveEditedPart() {
        const form = document.getElementById('editPartForm');
        if (!form.checkValidity()) {
            form.reportValidity(); // Validasi HTML5 standar
            return;
        }

        const partId = parseInt(document.getElementById('edit-partId').value);
        // Cari index part yang sedang diedit
        const partIndex = partsStorage[currentState.requestId].findIndex(p => p.id === partId);

        if (partIndex !== -1) {
            // Update data di array
            partsStorage[currentState.requestId][partIndex] = {
                id: partId,
                name: document.getElementById('edit-partName').value,
                material: document.getElementById('edit-material').value,
                dimFinish: document.getElementById('edit-dimFinish').value,
                dimRaw: document.getElementById('edit-dimRaw').value,
                qty: document.getElementById('edit-quantity').value,
                notes: document.getElementById('edit-notes').value
            };
            
            editModal.hide();
            renderPartsTable(); // Update tampilan tabel
        }
    }


    // --- 4. Submit Action (Gambar 8) ---
    function submitToAdmin() {
        // Logika sebenarnya akan mengirim data ke backend di sini.
        // Untuk prototipe, kita hanya munculkan notifikasi sukses.
        successToast.show();
        // Opsional: Kembali ke halaman utama setelah beberapa detik
        // setTimeout(() => { navigate.toRequestList(); }, 2000);
    }

    document.addEventListener("DOMContentLoaded", function() {
    // 1. Ambil parameter dari URL browser
    const urlParams = new URLSearchParams(window.location.search);
    const requestId = urlParams.get('id'); // Ambil nilai 'id'

    // 2. Cek logika
    if (requestId) {
        // JIKA ADA ID (Diklik dari Dashboard):
        // Langsung loncat ke fungsi toPartList
        navigate.toPartList(requestId);
    } else {
        // JIKA TIDAK ADA ID (Dibuka manual):
        // Tampilkan halaman daftar request biasa
        navigate.toRequestList();
    }
});
</script>

</body>
</html>