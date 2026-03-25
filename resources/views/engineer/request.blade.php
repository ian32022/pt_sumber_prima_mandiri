@extends('layouts.app')

@section('title', 'Request Management')

@push('styles')
<style>
    .page-title { font-size: 24px; font-weight: 600; color: #101828; margin-bottom: 8px; }
    .page-subtitle { color: #475467; font-size: 14px; }
    .content-card { background: white; border: 1px solid #eaecf0; border-radius: 12px; padding: 24px; }
    .table thead th { font-size: 12px; color: #475467; font-weight: 600; background-color: #F9FAFB; border-bottom: 1px solid #eaecf0; padding: 12px 16px; text-transform: uppercase; }
    .table tbody td { padding: 16px 16px; color: #101828; font-size: 14px; vertical-align: middle; border-bottom: 1px solid #eaecf0; }
    .status-badge { padding: 4px 12px; border-radius: 16px; font-size: 12px; font-weight: 500; }
    .status-blue   { background-color: #eff8ff; color: #2F6BFF; }
    .status-yellow { background-color: #fffaeb; color: #b54708; }
    .btn-add-parts-link { color: #2F6BFF; text-decoration: none; font-weight: 500; cursor: pointer; }
    .btn-add-parts-link:hover { text-decoration: underline; }
    .btn-primary-custom { background-color: #2F6BFF; border-color: #2F6BFF; color: white; font-weight: 500; }
    .btn-primary-custom:hover { background-color: #1e5afa; }
    .btn-success-custom { background-color: #12B76A; border-color: #12B76A; color: white; font-weight: 500; }
    .btn-outline-custom { border: 1px solid #d0d5dd; color: #344054; background: white; font-weight: 500; }
    .form-label { font-weight: 500; font-size: 14px; color: #344054; }
    .form-control, .form-select { border-radius: 8px; border: 1px solid #d0d5dd; padding: 10px 14px; }
    .required-star { color: #F04438; margin-left: 4px; }
    .back-link { color: #475467; text-decoration: none; font-weight: 500; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 16px; cursor: pointer; }
    .back-link:hover { color: #2F6BFF; }
    .action-icon-btn { border: none; background: none; padding: 4px 8px; cursor: pointer; transition: color 0.2s; }
    .edit-icon { color: #2F6BFF; }
    .view-icon { color: #12B76A; }
    .delete-icon { color: #F04438; }
    .action-icon-btn:hover { opacity: 0.7; }
    .custom-toast { border-left: 4px solid #12B76A; }
    .view-section { display: none; }
    .view-section.active { display: block; }
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════
     VIEW 1: REQUEST LIST
══════════════════════════════════════ --}}
<div id="view-request-list" class="view-section active">
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
                    @forelse($permintaan as $p)
                    <tr>
                        <td class="fw-medium">{{ $p->kode_permintaan ?? 'REQ-'.$p->permintaan_id }}</td>
                        <td>
                            <div class="fw-medium">{{ $p->nama_permintaan ?? '-' }}</div>
                            <small class="text-muted">{{ $p->deskripsi ?? '' }}</small>
                        </td>
                        <td>{{ $p->qty ?? '-' }}</td>
                        <td>{{ $p->tanggal_permintaan ? \Carbon\Carbon::parse($p->tanggal_permintaan)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $p->partLists->count() ?? 0 }} parts</td>
                        <td>
                            <span class="status-badge {{ $p->status === 'submitted' ? 'status-yellow' : 'status-blue' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td>
                            <span class="btn-add-parts-link"
                                  onclick="navigate.toPartList('{{ $p->kode_permintaan ?? 'REQ-'.$p->permintaan_id }}')">
                                + Add Parts
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Tidak ada permintaan saat ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     VIEW 2: PART LIST
══════════════════════════════════════ --}}
<div id="view-part-list" class="view-section">
    <div onclick="navigate.toRequestList()" class="back-link">
        <i class="bi bi-arrow-left"></i> Back to Request Management
    </div>
    <div class="mb-4">
        <h2 class="page-title">Create Part Listing</h2>
        <div class="text-muted">Request ID: <span class="fw-medium text-dark" id="pl-request-id"></span></div>
        <div class="text-muted">Machine: <span class="fw-medium text-dark" id="pl-machine-name"></span></div>
        <small class="text-muted">Define what will be produced - parts, materials, and dimensions</small>
    </div>
    <div class="content-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Part List (<span id="part-count">0</span> parts)</h5>
            <button class="btn btn-primary-custom" onclick="navigate.toAddPartForm()">
                <i class="bi bi-plus-lg me-2"></i>Add Part
            </button>
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

{{-- ══════════════════════════════════════
     VIEW 3: ADD PART FORM
══════════════════════════════════════ --}}
<div id="view-add-part" class="view-section">
    <div onclick="navigate.toPartList()" class="back-link">
        <i class="bi bi-arrow-left"></i> Back to Part Listing
    </div>
    <div class="mb-4">
        <h2 class="page-title">Add New Part</h2>
        <div class="text-muted small">
            Request ID: <span class="fw-medium text-dark" id="ap-request-id"></span> •
            Machine: <span class="fw-medium text-dark" id="ap-machine-name"></span>
        </div>
    </div>
    <div class="alert alert-primary d-flex align-items-center"
         style="background-color: #F5F8FF; border-color: #D0D5DD;">
        <i class="bi bi-info-circle-fill text-primary me-3 fs-5"></i>
        <div>
            <div class="fw-medium" style="color: #1d2939;">Design Team - Part Entry</div>
            <div class="small" style="color: #475467;">Enter part specifications including material and dimensions.</div>
        </div>
    </div>
    <div class="content-card">
        <h5 class="fw-bold mb-4">Part Details</h5>
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
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editPartModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold fs-4">Edit Part</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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

{{-- View Modal --}}
<div class="modal fade" id="viewPartModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Part Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-4">
                <div class="row g-4 mb-4">
                    <div class="col-6"><div class="text-muted small">Part Name</div><div class="fw-medium fs-5" id="view-partName"></div></div>
                    <div class="col-6"><div class="text-muted small">Material</div><div class="fw-medium fs-5" id="view-material"></div></div>
                    <div class="col-6"><div class="text-muted small">Dimension Finish</div><div class="fw-medium fs-5" id="view-dimFinish"></div></div>
                    <div class="col-6"><div class="text-muted small">Dimension Raw</div><div class="fw-medium fs-5" id="view-dimRaw"></div></div>
                    <div class="col-12"><div class="text-muted small">Quantity</div><div class="fw-medium fs-5" id="view-quantity"></div></div>
                    <div class="col-12"><div class="text-muted small">Notes</div><div class="fw-medium" id="view-notes"></div></div>
                </div>
            </div>
            <div class="modal-footer border-0 p-0 pb-3 pe-3">
                <button type="button" class="btn btn-outline-custom px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Toast --}}
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="successToast" class="toast custom-toast align-items-center bg-white" role="alert" data-bs-delay="5000">
        <div class="d-flex p-2">
            <div class="toast-body d-flex align-items-start gap-3">
                <i class="bi bi-check-circle-fill text-success fs-4"></i>
                <div>
                    <h6 class="fw-bold mb-1">Submitted!</h6>
                    <p class="mb-0 text-muted small">Part listing submitted to Admin successfully!</p>
                </div>
            </div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const requestsData = {
        @foreach($permintaan as $p)
        '{{ $p->kode_permintaan ?? 'REQ-'.$p->permintaan_id }}': {
            machineName: '{{ addslashes($p->nama_permintaan ?? '-') }}'
        },
        @endforeach
    };

    let partsStorage = {};
    let currentState = { requestId: null };

    const editModal    = new bootstrap.Modal(document.getElementById('editPartModal'));
    const viewModal    = new bootstrap.Modal(document.getElementById('viewPartModal'));
    const successToast = new bootstrap.Toast(document.getElementById('successToast'));

    const navigate = {
        toRequestList: function() {
            document.querySelectorAll('.view-section').forEach(el => el.classList.remove('active'));
            document.getElementById('view-request-list').classList.add('active');
            currentState.requestId = null;
        },
        toPartList: function(requestId) {
            if (requestId) currentState.requestId = requestId;
            const reqInfo = requestsData[currentState.requestId] || { machineName: '-' };
            document.getElementById('pl-request-id').textContent   = currentState.requestId;
            document.getElementById('pl-machine-name').textContent = reqInfo.machineName;
            if (!partsStorage[currentState.requestId]) partsStorage[currentState.requestId] = [];
            renderPartsTable();
            document.querySelectorAll('.view-section').forEach(el => el.classList.remove('active'));
            document.getElementById('view-part-list').classList.add('active');
        },
        toAddPartForm: function() {
            const reqInfo = requestsData[currentState.requestId] || { machineName: '-' };
            document.getElementById('ap-request-id').textContent   = currentState.requestId;
            document.getElementById('ap-machine-name').textContent = reqInfo.machineName;
            document.getElementById('addPartForm').reset();
            document.querySelectorAll('.view-section').forEach(el => el.classList.remove('active'));
            document.getElementById('view-add-part').classList.add('active');
        }
    };

    function renderPartsTable() {
        const tbody = document.querySelector('#parts-table tbody');
        const parts = partsStorage[currentState.requestId] || [];
        document.getElementById('part-count').textContent = parts.length;
        if (parts.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted py-4">No parts added yet.</td></tr>';
            return;
        }
        tbody.innerHTML = '';
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
                    <button class="action-icon-btn view-icon" onclick="openViewModal(${part.id})" title="View"><i class="bi bi-eye-fill"></i></button>
                    <button class="action-icon-btn delete-icon" onclick="deletePart(${part.id})" title="Delete"><i class="bi bi-trash-fill"></i></button>
                </td>`;
            tbody.appendChild(tr);
        });
    }

    document.getElementById('addPartForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const newPart = {
            id: Date.now(),
            name: document.getElementById('add-partName').value,
            material: document.getElementById('add-material').value,
            dimFinish: document.getElementById('add-dimFinish').value,
            dimRaw: document.getElementById('add-dimRaw').value,
            qty: document.getElementById('add-quantity').value,
            notes: document.getElementById('add-notes').value
        };
        if (!partsStorage[currentState.requestId]) partsStorage[currentState.requestId] = [];
        partsStorage[currentState.requestId].push(newPart);
        navigate.toPartList();
    });

    function deletePart(partId) {
        if (confirm('Are you sure you want to delete this part?')) {
            partsStorage[currentState.requestId] = partsStorage[currentState.requestId].filter(p => p.id !== partId);
            renderPartsTable();
        }
    }

    function openViewModal(partId) {
        const part = (partsStorage[currentState.requestId] || []).find(p => p.id === partId);
        if (!part) return;
        document.getElementById('view-partName').textContent  = part.name;
        document.getElementById('view-material').textContent  = part.material;
        document.getElementById('view-dimFinish').textContent = part.dimFinish;
        document.getElementById('view-dimRaw').textContent    = part.dimRaw;
        document.getElementById('view-quantity').textContent  = part.qty;
        document.getElementById('view-notes').textContent     = part.notes || '-';
        viewModal.show();
    }

    function openEditModal(partId) {
        const part = (partsStorage[currentState.requestId] || []).find(p => p.id === partId);
        if (!part) return;
        document.getElementById('edit-partId').value    = part.id;
        document.getElementById('edit-partName').value  = part.name;
        document.getElementById('edit-material').value  = part.material;
        document.getElementById('edit-dimFinish').value = part.dimFinish;
        document.getElementById('edit-dimRaw').value    = part.dimRaw;
        document.getElementById('edit-quantity').value  = part.qty;
        document.getElementById('edit-notes').value     = part.notes;
        editModal.show();
    }

    function saveEditedPart() {
        const form = document.getElementById('editPartForm');
        if (!form.checkValidity()) { form.reportValidity(); return; }
        const partId = parseInt(document.getElementById('edit-partId').value);
        const idx = partsStorage[currentState.requestId].findIndex(p => p.id === partId);
        if (idx !== -1) {
            partsStorage[currentState.requestId][idx] = {
                id: partId,
                name: document.getElementById('edit-partName').value,
                material: document.getElementById('edit-material').value,
                dimFinish: document.getElementById('edit-dimFinish').value,
                dimRaw: document.getElementById('edit-dimRaw').value,
                qty: document.getElementById('edit-quantity').value,
                notes: document.getElementById('edit-notes').value
            };
            editModal.hide();
            renderPartsTable();
        }
    }

    function submitToAdmin() {
        successToast.show();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const requestId = urlParams.get('id');
        if (requestId) {
            navigate.toPartList(requestId);
        } else {
            navigate.toRequestList();
        }
    });
</script>
@endpush