@extends('layouts.app')

@section('title', 'Master Schedule')

@push('styles')
<style>
    .page-title { font-size: 24px; font-weight: 600; margin-bottom: 4px; }
    .page-subtitle { color: #475467; font-size: 14px; margin-bottom: 24px; }
    .alert-info-custom { background-color: #EFF8FF; border: 1px solid #B2DDFF; color: #175CD3; border-radius: 12px; font-size: 14px; }
    .alert-warning-custom { background-color: #FFFAEB; border: 1px solid #FEDF89; color: #B54708; border-radius: 12px; font-size: 14px; }
    .stat-card { background: white; border: 1px solid #eaecf0; border-radius: 12px; padding: 24px; height: 100%; }
    .stat-icon { width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 20px; }
    .bg-icon-blue   { background-color: #EFF8FF; color: #2F6BFF; }
    .bg-icon-orange { background-color: #FFFAEB; color: #B54708; }
    .bg-icon-green  { background-color: #ECFDF3; color: #027A48; }
    .stat-value { font-size: 30px; font-weight: 600; color: #101828; margin-bottom: 4px; }
    .stat-label { font-size: 14px; color: #475467; }
    .content-card { background: white; border: 1px solid #eaecf0; border-radius: 12px; padding: 24px; margin-top: 24px; }
    .table thead th { font-size: 12px; color: #475467; font-weight: 600; background-color: #F9FAFB; border-bottom: 1px solid #eaecf0; padding: 12px 16px; text-transform: uppercase; }
    .table tbody td { padding: 16px 16px; color: #101828; font-size: 14px; vertical-align: middle; border-bottom: 1px solid #eaecf0; }
    .clickable-row { cursor: pointer; transition: background-color 0.2s; }
    .clickable-row:hover { background-color: #F9FAFB; }
    .badge-code { background-color: #EFF8FF; color: #2F6BFF; padding: 4px 8px; border-radius: 6px; font-weight: 600; font-size: 12px; display: inline-block; }
    .status-pill { padding: 4px 12px; border-radius: 16px; font-size: 12px; font-weight: 500; }
    .status-act  { background-color: #FFFAEB; color: #B54708; }
    .status-done { background-color: #ECFDF3; color: #027A48; }
    .back-link { color: #475467; text-decoration: none; font-weight: 500; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 16px; cursor: pointer; }
    .back-link:hover { color: #2F6BFF; }
    .detail-label { font-size: 12px; font-weight: 600; color: #475467; text-transform: uppercase; margin-bottom: 8px; }
    .detail-value { font-size: 14px; color: #101828; font-weight: 400; }
    .view-section { display: none; }
    .view-section.active { display: block; }
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════
     VIEW 1: SCHEDULE LIST
══════════════════════════════════════ --}}
<div id="view-schedule-list" class="view-section active">
    <div class="mb-4">
        <h2 class="page-title">Master Schedule</h2>
        <p class="page-subtitle">View-Only Monitoring Table - Source: Excel MASTER SCHEDULE</p>
    </div>

    <div class="alert alert-info-custom d-flex align-items-start gap-3 mb-4">
        <i class="bi bi-info-circle fs-5"></i>
        <div>
            <div class="fw-semibold mb-1">View-Only Monitoring</div>
            <div>Jadwal Utama ini hanya untuk memantau kemajuan produksi. Klik baris mana pun untuk melihat detail aktivitas.</div>
        </div>
    </div>

    {{-- STAT CARDS --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-icon-blue"><i class="bi bi-calendar-event"></i></div>
                <div class="stat-value">{{ $schedules->count() }}</div>
                <div class="stat-label">Total Activities</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-icon-blue"><i class="bi bi-clock"></i></div>
                <div class="stat-value">{{ $schedules->where('status', 'planned')->count() }}</div>
                <div class="stat-label">Plan</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-icon-orange"><i class="bi bi-arrow-repeat"></i></div>
                <div class="stat-value" style="color: #B54708;">{{ $schedules->where('status', 'in_progress')->count() }}</div>
                <div class="stat-label">Act</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-icon-green"><i class="bi bi-check-circle"></i></div>
                <div class="stat-value" style="color: #027A48;">{{ $schedules->where('status', 'completed')->count() }}</div>
                <div class="stat-label">Done</div>
            </div>
        </div>
    </div>

    <div class="content-card mt-0">
        <div class="mb-3">
            <h5 class="fw-bold fs-6">Master Schedule - Activity Monitoring</h5>
            <p class="text-muted small">Click row to view details</p>
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
                    @forelse($schedules as $schedule)
                    <tr class="clickable-row" onclick="showDetail({{ $schedule->schedule_id }})">
                        <td><span class="badge-code">{{ $schedule->kode_aktivitas ?? 'ACT' }}</span></td>
                        <td class="fw-medium">{{ $schedule->nama_aktivitas ?? ($schedule->mesin->nama_mesin ?? '-') }}</td>
                        <td>{{ $schedule->tanggal_plan ? \Carbon\Carbon::parse($schedule->tanggal_plan)->format('d/m/Y') : '-' }}</td>
                        <td>{{ $schedule->tanggal_aktual ? \Carbon\Carbon::parse($schedule->tanggal_aktual)->format('d/m/Y') : '-' }}</td>
                        <td>
                            <span class="status-pill {{ $schedule->status === 'completed' ? 'status-done' : 'status-act' }}">
                                {{ ucfirst($schedule->status ?? 'act') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Tidak ada jadwal saat ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="alert alert-warning-custom d-flex align-items-start gap-3 mt-4">
        <i class="bi bi-exclamation-circle fs-5"></i>
        <div>
            <div class="fw-semibold mb-1">View-Only</div>
            <div>Semua pembaruan status dilakukan oleh Operator di Schedule MFG dan secara otomatis tercermin di sini.</div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     VIEW 2: SCHEDULE DETAIL
══════════════════════════════════════ --}}
<div id="view-schedule-detail" class="view-section">
    <div class="back-link" onclick="showList()">
        <i class="bi bi-arrow-left"></i> Back to Master Schedule
    </div>

    <div class="mb-4">
        <h2 class="page-title">Master Schedule Detail</h2>
        <div class="d-flex gap-3 text-muted small align-items-center">
            <span>Activity Code: <span class="fw-bold text-dark" id="detail-code">-</span></span>
            <span>•</span>
            <span>Machine: <span class="fw-bold text-dark" id="detail-machine">-</span></span>
        </div>
    </div>

    <div class="alert alert-info-custom d-flex align-items-start gap-3 mb-4">
        <i class="bi bi-info-circle fs-5"></i>
        <div>
            <div class="fw-semibold mb-1">View-Only Monitoring</div>
            <div>Eksekusi aktivitas terjadi di Jadwal Operator MFG.</div>
        </div>
    </div>

    <div class="content-card mt-0 mb-4">
        <div class="mb-4 border-bottom pb-3">
            <h5 class="fw-bold fs-6 mb-1">Activity Information</h5>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="detail-label">Aktivitas Kode</div>
                <div><span class="badge-code" id="info-code">-</span></div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Sub Aktivitas</div>
                <div class="detail-value fw-medium" id="info-activity">-</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">PIC</div>
                <div class="detail-value" id="info-pic">-</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Plan Date</div>
                <div class="detail-value" id="info-plan">-</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Actual Date</div>
                <div class="detail-value" id="info-actual">-</div>
            </div>
            <div class="col-md-4">
                <div class="detail-label">Status</div>
                <div><span class="status-pill status-act" id="info-status">-</span></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    {{-- Data dari controller --}}
    const schedulesData = {
        @foreach($schedules as $schedule)
        {{ $schedule->schedule_id }}: {
            code:     '{{ $schedule->kode_aktivitas ?? 'ACT' }}',
            machine:  '{{ addslashes($schedule->mesin->nama_mesin ?? '-') }}',
            activity: '{{ addslashes($schedule->nama_aktivitas ?? ($schedule->mesin->nama_mesin ?? '-')) }}',
            pic:      '{{ addslashes($schedule->pic ?? '-') }}',
            plan:     '{{ $schedule->tanggal_plan ? \Carbon\Carbon::parse($schedule->tanggal_plan)->format('d/m/Y') : '-' }}',
            actual:   '{{ $schedule->tanggal_aktual ? \Carbon\Carbon::parse($schedule->tanggal_aktual)->format('d/m/Y') : '-' }}',
            status:   '{{ ucfirst($schedule->status ?? 'act') }}',
            statusClass: '{{ $schedule->status === "completed" ? "status-done" : "status-act" }}'
        },
        @endforeach
    };

    function showDetail(id) {
        const data = schedulesData[id];
        if (!data) return;

        document.getElementById('detail-code').textContent    = data.code;
        document.getElementById('detail-machine').textContent = data.machine;
        document.getElementById('info-code').textContent      = data.code;
        document.getElementById('info-activity').textContent  = data.activity;
        document.getElementById('info-pic').textContent       = data.pic;
        document.getElementById('info-plan').textContent      = data.plan;
        document.getElementById('info-actual').textContent    = data.actual;

        const statusEl = document.getElementById('info-status');
        statusEl.textContent = data.status;
        statusEl.className   = 'status-pill ' + data.statusClass;

        document.getElementById('view-schedule-list').classList.remove('active');
        document.getElementById('view-schedule-detail').classList.add('active');
        window.scrollTo(0, 0);
    }

    function showList() {
        document.getElementById('view-schedule-detail').classList.remove('active');
        document.getElementById('view-schedule-list').classList.add('active');
    }
</script>
@endpush