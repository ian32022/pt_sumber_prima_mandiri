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
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; overflow-x: hidden; }

        /* Sidebar */
        #sidebar { width: var(--sidebar-width); height: 100vh; position: fixed; top: 0; left: 0; background-color: #fff; border-right: 1px solid #e0e0e0; z-index: 1000; display: flex; flex-direction: column; padding: 20px; }
        .sidebar-brand { display: flex; align-items: center; margin-bottom: 40px; }
        .sidebar-brand img { width: 40px; height: 40px; margin-right: 10px; border-radius: 50%; }
        .sidebar-brand-text h6 { margin: 0; font-weight: 700; color: #333; }
        .sidebar-brand-text span { font-size: 0.8rem; color: #777; }
        .nav-link { display: flex; align-items: center; color: #555; padding: 10px 15px; border-radius: 8px; margin-bottom: 5px; transition: all 0.3s; text-decoration: none; }
        .nav-link i { margin-right: 12px; font-size: 1.1rem; }
        .nav-link:hover { background-color: rgba(13, 110, 253, 0.05); color: var(--primary-color); }
        .nav-link.active { background-color: var(--primary-color); color: #fff; }
        .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; color: #999; letter-spacing: 1px; margin: 20px 0 10px 15px; }

        /* Main */
        #main-content { margin-left: var(--sidebar-width); padding: 20px 40px; min-height: 100vh; }
        #top-navbar { margin-bottom: 30px; }
        .search-bar { width: 400px; }
        .user-profile { display: flex; align-items: center; gap: 10px; padding: 5px 15px; border: 1px solid #e0e0e0; border-radius: 50px; background-color: #fff; }

        /* Cards & Tables */
        .card-custom { background-color: #fff; border-radius: 12px; border: 1px solid #e0e0e0; padding: 25px; margin-bottom: 25px; }
        .table-custom { width: 100%; margin-top: 15px; }
        .table-custom thead th { font-size: 0.75rem; text-transform: uppercase; color: #888; letter-spacing: 0.5px; padding-bottom: 15px; border-bottom: 1px solid #ededed; }
        .table-custom tbody td { font-size: 0.9rem; padding: 18px 0; border-bottom: 1px solid #ededed; vertical-align: middle; }
        .machine-name { font-weight: 600; color: #333; }
        .machine-desc { font-size: 0.8rem; color: #777; margin-top: 3px; }

        /* Status Badges */
        .status-badge { font-size: 0.8rem; padding: 4px 10px; border-radius: 20px; font-weight: 500; }
        .status-draft       { background-color: #e2e3e5; color: #41464b; }
        .status-submitted   { background-color: #cfe2ff; color: #084298; }
        .status-approved    { background-color: #d1e7dd; color: #0f5132; }
        .status-rejected    { background-color: #f8d7da; color: #842029; }
        .status-in_progress { background-color: #fff3cd; color: #856404; }
        .status-completed   { background-color: #d1e7dd; color: #0f5132; }

        /* Priority Badges */
        .priority-low    { background: #e2e3e5; color: #41464b; font-size: 0.75rem; padding: 2px 8px; border-radius: 12px; }
        .priority-medium { background: #cfe2ff; color: #084298; font-size: 0.75rem; padding: 2px 8px; border-radius: 12px; }
        .priority-high   { background: #fff3cd; color: #856404; font-size: 0.75rem; padding: 2px 8px; border-radius: 12px; }
        .priority-urgent { background: #f8d7da; color: #842029; font-size: 0.75rem; padding: 2px 8px; border-radius: 12px; }

        /* Action Icons */
        .action-icons { display: flex; gap: 12px; font-size: 1.1rem; }
        .action-icon { cursor: pointer; transition: transform 0.2s; }
        .action-icon:hover { transform: scale(1.1); }
        .icon-view   { color: #198754; }
        .icon-edit   { color: #0d6efd; }
        .icon-delete { color: #dc3545; }
        .icon-approve { color: #198754; }
        .icon-reject  { color: #dc3545; }

        /* Modal */
        .modal-content { border-radius: 12px; border: none; padding: 10px; }
        .modal-header { border-bottom: none; padding-bottom: 5px; }
        .modal-footer { border-top: none; padding-top: 5px; }
        .form-label-custom { font-size: 0.85rem; color: #666; margin-bottom: 5px; }
        .form-control-custom { border-radius: 8px; padding: 10px 15px; border: 1px solid #ccc; }
        .required-star { color: #dc3545; margin-left: 3px; }

        /* Part listing */
        #part-listing-container { display: none; }
        .part-detail-item { margin-bottom: 16px; }
        .part-detail-label { font-size: 0.8rem; color: #888; margin-bottom: 2px; }
        .part-detail-value { font-size: 1rem; color: #333; font-weight: 500; }

        /* Progress bar */
        .progress-sm { height: 6px; border-radius: 99px; }
    </style>
</head>
<body>

{{-- ── SIDEBAR ── --}}
<div id="sidebar">
    <div class="sidebar-brand">
        <img src="https://via.placeholder.com/40/0d6efd/ffffff?text=S" alt="Logo">
        <div class="sidebar-brand-text">
            <h6>PT Sumber Prima Mandiri</h6>
            <span>Production System</span>
        </div>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid-1x2"></i> Dashboard</a>
        <a class="nav-link active" href="{{ route('admin.permintaan.index') }}"><i class="bi bi-file-earmark-text"></i> Request Management</a>
        <a class="nav-link" href="{{ route('admin.schedule.index') }}"><i class="bi bi-calendar-event"></i> Production Planning</a>
        <a class="nav-link" href="{{ route('admin.part-list.index') }}"><i class="bi bi-ui-checks"></i> Master Schedule</a>
        <a class="nav-link" href="{{ route('admin.mesin.index') }}"><i class="bi bi-gear"></i> Mesin</a>
        <div class="sidebar-heading">AKUN</div>
        <a class="nav-link" href="{{ route('profile') }}"><i class="bi bi-person"></i> Profil Saya</a>
        <a class="nav-link text-danger" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </nav>
</div>

{{-- ── MAIN CONTENT ── --}}
<div id="main-content">

    {{-- Top Navbar --}}
    <div id="top-navbar" class="d-flex justify-content-between align-items-center">
        <div class="search-bar input-group">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Cari berdasarkan Request ID, jenis produk...">
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="position-relative" style="cursor:pointer;">
                <i class="bi bi-bell fs-5 text-secondary"></i>
            </div>
            <div class="user-profile">
                <div style="width:35px;height:35px;border-radius:50%;background:var(--primary-color);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;">
                    {{ strtoupper(substr(auth()->user()->nama ?? auth()->user()->email, 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight:600;font-size:0.9rem;">{{ auth()->user()->nama ?? auth()->user()->email }}</div>
                    <div style="font-size:0.75rem;color:var(--primary-color);">{{ auth()->user()->role_name }}</div>
                </div>
            </div>
            <a href="{{ route('logout') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
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

    {{-- ── REQUEST LIST ── --}}
    <div id="request-management-container">
        <div class="page-header d-flex justify-content-between align-items-start mb-4">
            <div>
                <h2>Request Management</h2>
                <p class="text-muted">Input & manage incoming production requests</p>
            </div>
            <button class="btn btn-primary d-flex align-items-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#addRequestModal">
                <i class="bi bi-plus-lg"></i> Tambah Permintaan
            </button>
        </div>

        <div class="card-custom">
            {{-- Filter --}}
            <div class="d-flex justify-content-between gap-3 mb-4">
                <div class="input-group" style="max-width:500px;">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="tableSearch" class="form-control border-start-0"
                           placeholder="Cari Request ID, jenis produk...">
                </div>
                <select id="statusFilter" class="form-select" style="max-width:160px;">
                    <option value="">All Status</option>
                    <option value="draft">Draft</option>
                    <option value="submitted">Submitted</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>

            <table class="table-custom" id="requestTable">
                <thead>
                    <tr>
                        <th>REQUEST ID</th>
                        <th>JENIS PRODUK</th>
                        <th>PRIORITY</th>
                        <th>DUE DATE</th>
                        <th>PARTS</th>
                        <th>PROGRESS</th>
                        <th>STATUS</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="request-table-body">
                    @forelse($permintaan as $p)
                    <tr data-status="{{ $p->status }}">
                        <td>{{ $p->nomor_permintaan }}</td>
                        <td>
                            <div class="machine-name">{{ $p->jenis_produk ?? '-' }}</div>
                            <div class="machine-desc">
                                {{ Str::limit($p->deskripsi_kebutuhan, 60) }}
                            </div>
                        </td>
                        <td>
                            <span class="priority-{{ $p->priority }}">
                                {{ ucfirst($p->priority) }}
                            </span>
                        </td>
                        <td>
                            {{ $p->tanggal_selesai ? $p->tanggal_selesai->format('d/m/Y') : '-' }}
                        </td>
                        <td>{{ $p->partLists->count() }} parts</td>
                        <td style="min-width:100px;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="progress progress-sm flex-grow-1">
                                    <div class="progress-bar bg-success" style="width:{{ $p->progress }}%"></div>
                                </div>
                                <small class="text-muted">{{ $p->progress }}%</small>
                            </div>
                        </td>
                        <td>
                            <span class="status-badge status-{{ $p->status }}">
                                {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-icons">
                                {{-- Lihat Part List --}}
                                <i class="bi bi-eye action-icon icon-view"
                                   title="Lihat Part List"
                                   onclick="showPartListing(
                                       '{{ $p->nomor_permintaan }}',
                                       '{{ addslashes($p->jenis_produk) }}',
                                       {{ $p->permintaan_id }}
                                   )">
                                </i>

                                {{-- Approve (hanya jika submitted) --}}
                                @if($p->status === 'submitted')
                                <form action="{{ route('admin.permintaan.approve', $p->permintaan_id) }}"
                                      method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn p-0 border-0 bg-transparent"
                                            title="Approve" onclick="return confirm('Setujui permintaan ini?')">
                                        <i class="bi bi-check-circle action-icon icon-approve"></i>
                                    </button>
                                </form>
                                <button class="btn p-0 border-0 bg-transparent" title="Reject"
                                        data-bs-toggle="modal" data-bs-target="#rejectModal"
                                        onclick="setRejectId({{ $p->permintaan_id }})">
                                    <i class="bi bi-x-circle action-icon icon-reject"></i>
                                </button>
                                @endif

                                {{-- Hapus --}}
                                <form action="{{ route('admin.permintaan.destroy', $p->permintaan_id) }}"
                                      method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn p-0 border-0 bg-transparent"
                                            title="Hapus"
                                            onclick="return confirm('Hapus permintaan {{ $p->nomor_permintaan }}?')">
                                        <i class="bi bi-trash action-icon icon-delete"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Belum ada permintaan masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── PART LISTING ── --}}
    <div id="part-listing-container">
        <div class="page-header mb-4">
            <a href="#" class="text-decoration-none text-muted" onclick="hidePartListing()">
                <i class="bi bi-arrow-left me-2"></i> Back to Request Management
            </a>
            <h2 class="mt-3">Part Listing</h2>
            <p class="text-muted mb-0">Request ID: <span id="detail-req-id" class="fw-bold"></span></p>
            <p class="text-muted">Jenis Produk: <span id="detail-machine-name" class="fw-bold"></span></p>
        </div>

        <div class="card-custom">
            <h5 class="mb-4 fw-bold">Part List</h5>
            <div id="part-list-content">
                <p class="text-muted">Memuat data...</p>
            </div>
        </div>
    </div>

</div>{{-- end main-content --}}


{{-- ── MODAL: TAMBAH PERMINTAAN ── --}}
<div class="modal fade" id="addRequestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between">
                <h5 class="modal-title fw-bold">Create Machine Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.permintaan.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label-custom">
                                Jenis Produk / Mesin<span class="required-star">*</span>
                            </label>
                            <input type="text" name="jenis_produk"
                                   class="form-control form-control-custom"
                                   placeholder="Contoh: Mesin Conveyor Custom"
                                   value="{{ old('jenis_produk') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">
                                Priority<span class="required-star">*</span>
                            </label>
                            <select name="priority" class="form-select form-control-custom" required>
                                <option value="low"    {{ old('priority') == 'low'    ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority','medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high"   {{ old('priority') == 'high'   ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">
                            Deskripsi Kebutuhan<span class="required-star">*</span>
                        </label>
                        <textarea name="deskripsi_kebutuhan" class="form-control form-control-custom"
                                  rows="4" placeholder="Detail kebutuhan dan spesifikasi mesin..."
                                  required>{{ old('deskripsi_kebutuhan') }}</textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label-custom">
                                Tanggal Permintaan<span class="required-star">*</span>
                            </label>
                            <input type="date" name="tanggal_permintaan"
                                   class="form-control form-control-custom"
                                   value="{{ old('tanggal_permintaan', date('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Due Date</label>
                            <input type="date" name="tanggal_selesai"
                                   class="form-control form-control-custom"
                                   value="{{ old('tanggal_selesai') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-custom">Catatan (opsional)</label>
                        <textarea name="catatan" class="form-control form-control-custom"
                                  rows="2" placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-start gap-2">
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    <button type="button" class="btn btn-light px-4 border" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ── MODAL: REJECT ── --}}
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-danger">Tolak Permintaan?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <label class="form-label-custom">Alasan penolakan (opsional)</label>
                    <textarea name="catatan" class="form-control form-control-custom"
                              rows="3" placeholder="Tulis alasan penolakan..."></textarea>
                </div>
                <div class="modal-footer gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger px-4">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ── NAVIGASI TAMPILAN ──
    function showPartListing(reqId, machineName, permintaanId) {
        document.getElementById('request-management-container').style.display = 'none';
        document.getElementById('part-listing-container').style.display = 'block';
        document.getElementById('detail-req-id').innerText = reqId;
        document.getElementById('detail-machine-name').innerText = machineName;
        loadPartList(permintaanId);
    }

    function hidePartListing() {
        document.getElementById('part-listing-container').style.display = 'none';
        document.getElementById('request-management-container').style.display = 'block';
    }

    // ── LOAD PART LIST VIA FETCH ──
    function loadPartList(permintaanId) {
        const container = document.getElementById('part-list-content');
        container.innerHTML = '<p class="text-muted">Memuat data...</p>';

        // Ambil data part list dari controller
        fetch(`/admin/part-list?permintaan_id=${permintaanId}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(parts => {
            if (!parts.length) {
                container.innerHTML = '<p class="text-muted text-center py-4"><i class="bi bi-inbox d-block fs-3 mb-2"></i>Belum ada part list untuk permintaan ini.</p>';
                return;
            }

            const statusBadge = {
                'belum_dibeli' : 'status-waiting',
                'ready'        : 'status-approved',
                'in_progress'  : 'status-in_progress',
                'selesai'      : 'status-completed',
            };

            let rows = parts.map(p => `
                <tr>
                    <td>${p.nama_part ?? '-'}</td>
                    <td>${p.material ?? '-'}</td>
                    <td>${p.dimensi_finish ?? '-'}</td>
                    <td>${p.dimensi_raw ?? '-'}</td>
                    <td>${p.qty ?? '-'}</td>
                    <td>
                        <span class="status-badge ${statusBadge[p.status_part] ?? 'status-draft'}">
                            ${p.status_part ? p.status_part.replace('_', ' ') : '-'}
                        </span>
                    </td>
                </tr>
            `).join('');

            container.innerHTML = `
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>PART NAME</th>
                            <th>MATERIAL</th>
                            <th>DIMENSION FINISH</th>
                            <th>DIMENSION RAW</th>
                            <th>QTY</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>${rows}</tbody>
                </table>
            `;
        })
        .catch(() => {
            container.innerHTML = '<p class="text-danger">Gagal memuat data part list.</p>';
        });
    }

    // ── REJECT MODAL ──
    function setRejectId(permintaanId) {
        document.getElementById('rejectForm').action = `/admin/permintaan/${permintaanId}/reject`;
    }

    // ── FILTER TABEL ──
    document.getElementById('tableSearch').addEventListener('keyup', filterTable);
    document.getElementById('statusFilter').addEventListener('change', filterTable);

    function filterTable() {
        const search = document.getElementById('tableSearch').value.toLowerCase();
        const status = document.getElementById('statusFilter').value;
        document.querySelectorAll('#request-table-body tr').forEach(row => {
            const text      = row.innerText.toLowerCase();
            const rowStatus = row.dataset.status ?? '';
            const matchSearch = text.includes(search);
            const matchStatus = !status || rowStatus === status;
            row.style.display = (matchSearch && matchStatus) ? '' : 'none';
        });
    }
</script>
</body>
</html>