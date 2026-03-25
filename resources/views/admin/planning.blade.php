@extends('layouts.app')

@section('title', isset($mesin) ? 'Planning - ' . $mesin->nama_mesin : 'Production Planning')

@section('styles')
<style>
    /* ===== SHARED ===== */
    .status-active-badge {
        background-color: #d1e7dd;
        color: #0f5132;
        font-size: 0.7rem;
        padding: 3px 8px;
        border-radius: 4px;
    }

    /* ===== INDEX: MACHINE CARDS ===== */
    .machine-card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e0e0e0;
        padding: 20px;
        cursor: pointer;
        transition: box-shadow 0.2s, transform 0.2s;
        height: 100%;
        text-decoration: none;
        display: block;
        color: inherit;
    }
    .machine-card:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transform: translateY(-2px);
        color: inherit;
    }
    .activity-badge {
        background-color: #cfe2f3;
        color: #084298;
        font-size: 0.7rem;
        padding: 3px 8px;
        border-radius: 4px;
    }
    .stat-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 8px;
        font-size: 0.85rem;
    }
    .dot-plan { color: #0d6efd; }
    .dot-act  { color: #fd7e14; }
    .dot-done { color: #198754; }
    .add-machine-card {
        border: 2px dashed #ccc;
        background: transparent;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: #666;
        cursor: pointer;
        min-height: 200px;
        border-radius: 12px;
        padding: 20px;
        transition: 0.2s;
        height: 100%;
    }
    .add-machine-card:hover {
        border-color: #2563eb;
        color: #2563eb;
        background-color: rgba(37,99,235,0.02);
    }
    .add-icon-circle {
        width: 44px;
        height: 44px;
        background-color: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        margin-bottom: 10px;
        color: #2563eb;
        transition: 0.2s;
    }
    .add-machine-card:hover .add-icon-circle {
        background-color: #dbeafe;
    }
    .upload-area {
        border: 2px dashed #ccc;
        border-radius: 8px;
        padding: 28px;
        text-align: center;
        background-color: #fafafa;
        cursor: pointer;
        transition: 0.3s;
    }
    .upload-area:hover {
        border-color: #2563eb;
        background-color: #f0f8ff;
    }

    /* ===== SHOW: ACTIVITY TABLE ===== */
    .detail-card { background:#fff; border-radius:12px; border:1px solid #e0e0e0; padding:20px; margin-bottom:20px; }
    .table-custom thead th { font-size:0.75rem; text-transform:uppercase; color:#888; letter-spacing:0.5px; border-bottom:1px solid #ededed; padding-bottom:12px; }
    .table-custom tbody td { font-size:0.9rem; padding:14px 8px; vertical-align:middle; border-bottom:1px solid #f0f0f0; }
    .text-done { color:#198754; font-weight:600; }
    .text-act  { color:#fd7e14; font-weight:600; }
    .text-plan { color:#0d6efd; font-weight:600; }
    .action-icon { cursor:pointer; transition:transform 0.2s; margin-right:8px; font-size:1rem; }
    .action-icon:hover { transform:scale(1.15); }
    .icon-edit   { color:#0d6efd; }
    .icon-delete { color:#dc3545; }
    #add-activity-card { display:none; }
</style>
@endsection

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        ✅ {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        ⚠️ {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- ============================================================
     INDEX VIEW — Daftar semua mesin
     ============================================================ --}}
@if(!isset($mesin))

<div class="mb-4">
    <h3 class="fw-bold mb-1">Production Planning</h3>
    <p class="text-muted">Kelola jadwal activity berdasarkan mesin produksi</p>
</div>

<div class="row g-4">

    @forelse($mesins as $mesin)
    <div class="col-md-4">
        <a href="{{ route('admin.planning.show', $mesin->mesin_id) }}" class="machine-card">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h6 class="fw-bold mb-0">{{ $mesin->nama_mesin }}</h6>
                <span class="status-active-badge">{{ ucfirst($mesin->status) }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <div style="font-size:0.8rem;color:#666;">{{ $mesin->jenis_mesin ?? '-' }}</div>
                    <div style="font-size:0.75rem;color:#999;">{{ $mesin->lokasi ?? '-' }}</div>
                </div>
                <span class="activity-badge">{{ $mesin->total_activity }} Activity</span>
            </div>
            <div class="stat-row">
                <span class="text-muted"><span class="dot-plan">●</span> Plan:</span>
                <span class="fw-bold text-primary">{{ $mesin->plan_count }}</span>
            </div>
            <div class="stat-row">
                <span class="text-muted"><span class="dot-act">●</span> Act:</span>
                <span class="fw-bold" style="color:#fd7e14;">{{ $mesin->act_count }}</span>
            </div>
            <div class="stat-row">
                <span class="text-muted"><span class="dot-done">●</span> Done:</span>
                <span class="fw-bold text-success">{{ $mesin->done_count }}</span>
            </div>
        </a>
    </div>
    @empty
    @endforelse

    {{-- Tombol Add New Machine --}}
    <div class="col-md-4">
        <div class="add-machine-card" data-bs-toggle="modal" data-bs-target="#addMachineModal">
            <div class="add-icon-circle">
                <i class="bi bi-plus-lg"></i>
            </div>
            <h6 class="fw-bold text-dark mb-1">Add New Machine</h6>
            <span style="font-size:0.78rem;">Configure new production machine</span>
        </div>
    </div>

</div>


{{-- ===== MODAL ADD NEW MACHINE ===== --}}
<div class="modal fade" id="addMachineModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius:14px; border:none;">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <div>
                    <h5 class="modal-title fw-bold">Add New Machine</h5>
                    <p class="text-muted mb-0" style="font-size:0.85rem;">
                        Register a new machine to the production system
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-3 pb-4">
                <form action="{{ route('admin.mesin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-muted" style="font-size:0.85rem;">
                            Machine Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_mesin" class="form-control"
                               placeholder="e.g., Mesin CNC-02" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted" style="font-size:0.85rem;">
                            Machine Code <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="kode_mesin" class="form-control"
                               placeholder="e.g., CNC-02" required>
                        <div class="form-text" style="font-size:0.75rem;">
                            Unique identifier for this machine
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted" style="font-size:0.85rem;">
                            Area / Location <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="lokasi" class="form-control"
                               placeholder="e.g., Area A - Machining" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted" style="font-size:0.85rem;">
                            Machine Type <span class="text-danger">*</span>
                        </label>
                        <select name="jenis_mesin" class="form-select" required>
                            <option value="" disabled selected>Select machine type</option>
                            <option value="CNC Milling">CNC Milling</option>
                            <option value="CNC Lathe">CNC Lathe</option>
                            <option value="Laser Cutting">Laser Cutting</option>
                            <option value="Milling Konvensional">Milling Konvensional</option>
                            <option value="Bubut Konvensional">Bubut Konvensional</option>
                            <option value="Grinding">Grinding</option>
                            <option value="Drilling">Drilling</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted mb-1" style="font-size:0.85rem;">
                            Machine Document
                        </label>
                        <div class="form-text mb-2" style="font-size:0.75rem;">
                            Upload foto mesin, layout, atau file spesifikasi (opsional).
                        </div>
                        <div class="upload-area" onclick="document.getElementById('machine-doc-input').click()">
                            <i class="bi bi-upload fs-3 text-secondary mb-2 d-block" id="upload-icon"></i>
                            <div class="fw-bold text-dark" id="upload-text">
                                Drag & drop file here, or click to browse
                            </div>
                            <div class="text-muted mt-1" style="font-size:0.75rem;" id="upload-subtext">
                                Supported: PDF, JPG, PNG (max 10MB)
                            </div>
                        </div>
                        <input type="file" id="machine-doc-input" name="dokumen"
                               style="display:none;" accept=".pdf,.jpg,.jpeg,.png"
                               onchange="handleFileUpload(event)">
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <button type="button" class="btn btn-light px-4 border"
                                data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-1"></i> Save Machine
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


{{-- ============================================================
     SHOW VIEW — Detail mesin & daftar activity
     ============================================================ --}}
@else

{{-- Header --}}
<div class="d-flex justify-content-between align-items-start mb-4">
    <div class="d-flex align-items-start gap-3">
        <a href="{{ route('admin.planning.index') }}" class="btn btn-light border mt-1 px-2 py-1">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h3 class="fw-bold mb-0">{{ $mesin->nama_mesin }}</h3>
                <span class="status-active-badge">{{ ucfirst($mesin->status) }}</span>
            </div>
            <p class="text-muted mb-0">
                {{ $mesin->jenis_mesin ?? '-' }} &bull; {{ $mesin->lokasi ?? '-' }}
            </p>
        </div>
    </div>
    <button class="btn btn-primary" onclick="toggleAddActivity()">
        <i class="bi bi-plus-lg me-1"></i> Tambah Activity
    </button>
</div>

{{-- Form Tambah Activity --}}
<div class="detail-card" style="border-color:#2563eb;" id="add-activity-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Tambah Activity Baru</h6>
        <button type="button" class="btn-close" onclick="toggleAddActivity()"></button>
    </div>
    <form action="{{ route('admin.planning.store') }}" method="POST">
        @csrf
        <input type="hidden" name="mesin_id" value="{{ $mesin->mesin_id }}">
        <div class="row g-3 mb-3">
            <div class="col-12">
                <label class="form-label text-muted" style="font-size:0.85rem;">
                    Nama Activity <span class="text-danger">*</span>
                </label>
                <input type="text" name="nama_activity" class="form-control form-control-sm"
                       placeholder="Contoh: Machining Part Conveyor" required>
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted" style="font-size:0.85rem;">
                    PIC (Person In Charge) <span class="text-danger">*</span>
                </label>
                <input type="text" name="pic" class="form-control form-control-sm"
                       placeholder="Nama operator" required>
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted" style="font-size:0.85rem;">
                    Tanggal Plan <span class="text-danger">*</span>
                </label>
                <input type="date" name="tanggal_plan" class="form-control form-control-sm" required>
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted" style="font-size:0.85rem;">
                    Request ID (Opsional)
                </label>
                <input type="text" name="request_id" class="form-control form-control-sm"
                       placeholder="REQ-2025-001">
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-sm px-4">Simpan Activity</button>
        <button type="button" class="btn btn-light btn-sm px-4 border"
                onclick="toggleAddActivity()">Batal</button>
    </form>
</div>

{{-- Tabel Activity --}}
<div class="detail-card p-0" style="overflow:hidden;">
    <div class="px-4 pt-4 pb-2">
        <h6 class="fw-bold mb-0" style="font-size:0.9rem;">Daftar Activity</h6>
    </div>
    <table class="table table-custom mb-0" style="width:100%;">
        <thead>
            <tr>
                <th class="ps-4">NO</th>
                <th>NAMA ACTIVITY</th>
                <th>PIC</th>
                <th>TANGGAL PLAN</th>
                <th>TANGGAL ACTUAL</th>
                <th>REQUEST ID</th>
                <th>STATUS</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activities as $act)
            <tr>
                <td class="ps-4 text-primary fw-bold">
                    {{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}
                </td>
                <td style="max-width:180px;">{{ $act->nama_proses }}</td>
                <td>{{ $act->pic ?? '-' }}</td>
                <td>{{ $act->tanggal_plan ? \Carbon\Carbon::parse($act->tanggal_plan)->format('d/m/Y') : '-' }}</td>
                <td>{{ $act->tanggal_actual ? \Carbon\Carbon::parse($act->tanggal_actual)->format('d/m/Y') : '-' }}</td>
                <td>{{ $act->request_id ?? '-' }}</td>
                <td>
                    @if($act->status === 'done')
                        <span class="text-done">Done</span>
                    @elseif($act->status === 'running')
                        <span class="text-act">Act</span>
                    @else
                        <span class="text-plan">Plan</span>
                    @endif
                </td>
                <td>
                    <i class="bi bi-pencil action-icon icon-edit" title="Edit"
                       onclick="openEditModal(
                           {{ $act->proses_id }},
                           '{{ addslashes($act->nama_proses) }}',
                           '{{ addslashes($act->pic ?? '') }}',
                           '{{ $act->tanggal_plan }}'
                       )"></i>
                    <i class="bi bi-trash action-icon icon-delete" title="Hapus"
                       onclick="confirmDelete({{ $act->proses_id }})"></i>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted py-5">
                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                    Belum ada activity. Klik <strong>Tambah Activity</strong> untuk memulai.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="editActivityModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px; border:none;">
            <div class="modal-header border-bottom-0">
                <div>
                    <h5 class="modal-title fw-bold">Edit Activity</h5>
                    <p class="text-muted mb-0" style="font-size:0.85rem;">Update detail activity</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-2">
                <form id="editActivityForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label text-muted" style="font-size:0.85rem;">
                            Nama Activity <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_activity" id="edit-act-name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted" style="font-size:0.85rem;">
                            PIC <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="pic" id="edit-pic" class="form-control" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-muted" style="font-size:0.85rem;">
                            Tanggal Plan <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tanggal_plan" id="edit-date" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <button type="button" class="btn btn-light px-4 border" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Hapus --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0" style="border-radius:12px;">
            <div class="modal-body text-center p-4">
                <i class="bi bi-exclamation-triangle text-danger fs-1 mb-3 d-block"></i>
                <h5 class="fw-bold">Hapus Activity?</h5>
                <p class="text-muted mb-4" style="font-size:0.9rem;">
                    Data yang dihapus tidak dapat dikembalikan.
                </p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteActivityForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger px-4">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endif
{{-- ===== END CONDITIONAL VIEW ===== --}}

@endsection

@push('scripts')
<script>
    {{-- ===== INDEX SCRIPTS ===== --}}
    function handleFileUpload(event) {
        const file = event.target.files[0];
        if (!file) return;
        const fileSize = (file.size / 1024).toFixed(1);
        const fileExt  = file.name.split('.').pop().toUpperCase();
        document.getElementById('upload-icon').className = 'bi bi-file-earmark-check fs-3 text-success mb-2 d-block';
        document.getElementById('upload-text').textContent = file.name;
        document.getElementById('upload-text').style.color = '#198754';
        document.getElementById('upload-subtext').textContent = fileSize + ' KB • ' + fileExt + ' — Siap diupload';
    }

    {{-- ===== SHOW SCRIPTS ===== --}}
    function toggleAddActivity() {
        const card = document.getElementById('add-activity-card');
        if (!card) return;
        card.style.display = (card.style.display === 'none' || card.style.display === '') ? 'block' : 'none';
        if (card.style.display === 'block') card.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function openEditModal(id, name, pic, date) {
        document.getElementById('edit-act-name').value = name;
        document.getElementById('edit-pic').value       = pic;
        document.getElementById('edit-date').value      = date;
        document.getElementById('editActivityForm').action = '/admin/planning/' + id;
        new bootstrap.Modal(document.getElementById('editActivityModal')).show();
    }

    function confirmDelete(id) {
        document.getElementById('deleteActivityForm').action = '/admin/planning/' + id;
        new bootstrap.Modal(document.getElementById('confirmDeleteModal')).show();
    }
</script>
@endpush