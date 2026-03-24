@extends('layouts.app')

@section('styles')
<style>
    .alert-custom-blue { background-color: #f0f7ff; border: 1px solid #cce5ff; color: #004085; border-radius: 8px; padding: 15px; font-size: 0.85rem; display: flex; gap: 12px; align-items: flex-start; }
    .alert-custom-blue i { color: #0d6efd; font-size: 1.1rem; }
    .alert-custom-yellow { background-color: #fffdf0; border: 1px solid #ffeeba; color: #856404; border-radius: 8px; padding: 15px; font-size: 0.85rem; display: flex; gap: 12px; align-items: flex-start; margin-top: 20px; }
    .alert-custom-yellow i { color: #fd7e14; font-size: 1.1rem; }
    .stat-card { background: #fff; border-radius: 12px; border: 1px solid #e0e0e0; padding: 20px; flex: 1; }
    .stat-icon { width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; margin-bottom: 15px; }
    .stat-icon-total { background-color: #eef2ff; color: #4f46e5; }
    .stat-icon-plan  { background-color: #e0f2fe; color: #0284c7; }
    .stat-icon-act   { background-color: #fff7ed; color: #ea580c; }
    .stat-icon-done  { background-color: #f0fdf4; color: #16a34a; }
    .stat-number { font-size: 1.8rem; font-weight: 700; margin-bottom: 0; line-height: 1; color: #333; }
    .stat-label  { font-size: 0.75rem; color: #666; margin-top: 5px; }
    .card-table-wrapper { background: #fff; border-radius: 12px; border: 1px solid #e0e0e0; padding: 20px; margin-top: 20px; }
    .table-custom { width: 100%; margin-bottom: 0; }
    .table-custom thead th { font-size: 0.7rem; text-transform: uppercase; color: #888; border-bottom: 1px solid #ededed; padding-bottom: 15px; font-weight: 600; }
    .table-custom tbody td { font-size: 0.85rem; padding: 15px 0; border-bottom: 1px solid #ededed; vertical-align: middle; color: #444; }
    .table-hover-custom tbody tr { cursor: pointer; transition: background-color 0.2s; }
    .table-hover-custom tbody tr:hover { background-color: #f8f9fa; }
    .badge-code { background-color: #e0f2fe; color: #0284c7; padding: 4px 10px; border-radius: 6px; font-weight: 600; font-size: 0.75rem; display: inline-block; min-width: 40px; text-align: center; }
    .text-act  { color: #ea580c; font-weight: 600; font-size: 0.75rem; }
    .text-plan { color: #0d6efd; font-weight: 600; font-size: 0.75rem; }
    .form-label-custom { font-size: 0.8rem; color: #555; font-weight: 500; margin-bottom: 5px; }
    .form-control-custom, .form-select-custom { font-size: 0.85rem; padding: 10px 15px; border-radius: 8px; border: 1px solid #ddd; }
    #create-activity-container, #detail-activity-container { display: none; }
</style>
@endsection

@section('content')

{{-- ── MAIN SCHEDULE VIEW ── --}}
<div id="master-schedule-main">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="fw-bold mb-1">Master Schedule</h3>
            <p class="text-muted" style="font-size: 0.85rem;">Monitoring & Activity Management - Source: Excel MASTER SCHEDULE</p>
        </div>
        <button class="btn btn-primary btn-sm px-3 py-2" onclick="showCreateActivity()">
            <i class="bi bi-plus-lg me-1"></i> Tambah Activity
        </button>
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

{{-- ── CREATE ACTIVITY VIEW ── --}}
<div id="create-activity-container">
    <button class="btn btn-link text-muted p-0 text-decoration-none mb-3" onclick="showMainSchedule()">
        <i class="bi bi-arrow-left me-1"></i> Back to Master Schedule
    </button>

    <h3 class="fw-bold mb-1">Create Activity</h3>
    <p class="text-muted" style="font-size: 0.85rem;">Admin - Add new activity for setup or correction</p>

    <div class="alert-custom-blue mb-4">
        <i class="bi bi-info-circle"></i>
        <div>
            <div class="fw-bold mb-1" style="font-size: 0.8rem;">Admin Activity Creation</div>
            <div style="font-size: 0.8rem;">Admin creates activities for setup or correction purposes only. The activity will be created with status "Plan" and will appear in both Master Schedule and Schedule MFG.</div>
        </div>
    </div>

    <div class="card-table-wrapper">
        <h6 class="fw-bold mb-1">Activity Information</h6>
        <p class="text-muted border-bottom pb-3 mb-4" style="font-size: 0.8rem;">Fill in the details below</p>

        <form onsubmit="return false;">
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
                    <input type="date" id="new-plan-date" class="form-control form-control-custom" value="{{ date('Y-m-d') }}">
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
                <button type="button" class="btn btn-primary" onclick="saveNewActivity()">
                    <i class="bi bi-plus me-1"></i> Create Activity
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── DETAIL ACTIVITY VIEW ── --}}
<div id="detail-activity-container">
    <button class="btn btn-link text-muted p-0 text-decoration-none mb-3" onclick="showMainSchedule()">
        <i class="bi bi-arrow-left me-1"></i> Back to Master Schedule
    </button>

    <h3 class="fw-bold mb-1">Master Schedule Detail</h3>
    <p class="text-muted" style="font-size: 0.85rem;">
        Activity Code: <span id="dtl-act-code" class="text-dark fw-bold">MC</span>
        &nbsp;•&nbsp;
        Machine: <span id="dtl-machine" class="text-dark fw-bold">CNC Milling 01</span>
        &nbsp;•&nbsp;
        Request ID: <span id="dtl-req" class="text-dark fw-bold">REQ-2025-001</span>
    </p>

    <div class="alert-custom-blue mb-4">
        <i class="bi bi-info-circle"></i>
        <div>
            <div class="fw-bold mb-1" style="font-size: 0.8rem;">View-Only Monitoring</div>
            <div style="font-size: 0.8rem;">Jadwal Utama ini hanya untuk memantau kemajuan produksi. Eksekusi aktivitas terjadi di Jadwal Operator MFG.</div>
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
            <div style="font-size: 0.8rem;">Admin hanya dapat melihat jadwal ini. Semua pembaruan status dilakukan oleh Operator di Schedule MFG.</div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const mainView   = document.getElementById('master-schedule-main');
    const createView = document.getElementById('create-activity-container');
    const detailView = document.getElementById('detail-activity-container');

    function showMainSchedule() {
        mainView.style.display   = 'block';
        createView.style.display = 'none';
        detailView.style.display = 'none';
        window.scrollTo(0, 0);
    }

    function showCreateActivity() {
        mainView.style.display   = 'none';
        createView.style.display = 'block';
        detailView.style.display = 'none';
        window.scrollTo(0, 0);
    }

    function showDetailActivity(code, subAct, reqId, planDateStr = "25/1/2025", statusVal = "Act", pic = "Operator A") {
        mainView.style.display   = 'none';
        createView.style.display = 'none';
        detailView.style.display = 'block';
        window.scrollTo(0, 0);

        document.getElementById('dtl-act-code').innerText = code;
        document.getElementById('dtl-req').innerText      = reqId;
        document.getElementById('info-code').innerText    = code;

        const infoCode = document.getElementById('info-code');
        if (code === 'HT') {
            infoCode.style.backgroundColor = '#e0e7ff';
            infoCode.style.color           = '#4f46e5';
        } else if (code === 'LC') {
            infoCode.style.backgroundColor = '#dcfce7';
            infoCode.style.color           = '#16a34a';
        } else {
            infoCode.style.backgroundColor = '#e0f2fe';
            infoCode.style.color           = '#0284c7';
        }

        document.getElementById('info-sub').innerText       = subAct;
        document.getElementById('dtl-machine').innerText    = subAct.split(' - ')[0];
        document.getElementById('info-plan-date').innerText = planDateStr;
        document.getElementById('info-pic').innerText       = pic;

        const statusSpan = document.getElementById('info-status');
        statusSpan.innerText = statusVal;
        statusSpan.className = statusVal === 'Plan' ? 'text-plan' : statusVal === 'Done' ? 'text-success' : 'text-act';
    }

    function saveNewActivity() {
        const reqIdRaw  = document.getElementById('new-req-id').value;
        const reqId     = reqIdRaw.split(' - ')[0];
        const actCode   = document.getElementById('new-act-code').value;
        const machine   = document.getElementById('new-machine').value;
        const pic       = document.getElementById('new-pic').value;
        const partName  = document.getElementById('new-part-name').value;
        let   planDate  = document.getElementById('new-plan-date').value;
        const status    = document.getElementById('new-act-status').value;

        if (!pic || !planDate) { alert("Harap isi PIC dan Tanggal Plan!"); return; }

        if (planDate) {
            const d = new Date(planDate);
            planDate = `${d.getDate()}/${d.getMonth()+1}/${d.getFullYear()}`;
        }

        const subAktivitas = `${machine} - ${partName}`;

        let badgeStyle = 'background-color: #e0f2fe; color: #0284c7;';
        if (actCode === 'HT') badgeStyle = 'background-color:#e0e7ff; color:#4f46e5;';
        else if (actCode === 'LC') badgeStyle = 'background-color:#dcfce7; color:#16a34a;';

        let statusClass = 'text-plan';
        if (status === 'Act')  statusClass = 'text-act';
        if (status === 'Done') statusClass = 'text-success';

        const tbody = document.getElementById('master-schedule-tbody');
        const tr    = document.createElement('tr');
        tr.setAttribute('onclick', `showDetailActivity('${actCode}', '${subAktivitas}', '${reqId}', '${planDate}', '${status}', '${pic}')`);
        tr.innerHTML = `
            <td><span class="badge-code" style="${badgeStyle}">${actCode}</span></td>
            <td>${subAktivitas}</td>
            <td>${planDate}</td>
            <td>-</td>
            <td><span class="${statusClass}">${status}</span></td>
        `;
        tbody.appendChild(tr);

        const totalElem = document.getElementById('stat-total');
        totalElem.innerText = parseInt(totalElem.innerText) + 1;
        if (status === 'Plan') {
            const planElem = document.getElementById('stat-plan');
            planElem.innerText = parseInt(planElem.innerText) + 1;
        }

        document.getElementById('new-pic').value     = '';
        document.getElementById('new-sub-act').value = '';
        showMainSchedule();
    }
</script>
@endpush