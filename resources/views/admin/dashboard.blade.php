@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4">
        <h3 class="fw-bold mb-1">Admin Dashboard</h3>
        <p class="text-muted">Gambaran umum pemantauan & pengendalian produksi — {{ now()->translatedFormat('d F Y') }}</p>
    </div>

    {{-- STAT CARDS --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="custom-card card-border-blue">
                <div class="icon-box icon-blue"><i class="bi bi-file-earmark-text"></i></div>
                <p class="text-muted mb-1" style="font-size: 14px;">Total Permintaan</p>
                <h2 class="fw-bold mb-0">{{ $data['total_permintaan'] }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="custom-card card-border-yellow">
                <div class="icon-box icon-yellow"><i class="bi bi-clock"></i></div>
                <p class="text-muted mb-1" style="font-size: 14px;">Dalam Proses</p>
                <h2 class="fw-bold mb-0">{{ $data['permintaan_inprogress'] }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="custom-card card-border-orange">
                <div class="icon-box icon-orange"><i class="bi bi-exclamation-circle"></i></div>
                <p class="text-muted mb-1" style="font-size: 14px;">Mesin Maintenance</p>
                <h2 class="fw-bold mb-0">{{ $data['mesin_maintenance'] }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="custom-card card-border-green">
                <div class="icon-box icon-green"><i class="bi bi-check-circle"></i></div>
                <p class="text-muted mb-1" style="font-size: 14px;">Mesin Aktif</p>
                <h2 class="fw-bold mb-0">{{ $data['mesin_aktif'] }}</h2>
            </div>
        </div>
    </div>

    {{-- CHARTS --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="custom-card border-0">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-0">Tren Produksi</h5>
                        <small class="text-muted">Kinerja produksi dari waktu ke waktu</small>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn chart-toggle-btn active">Bulanan</button>
                        <button type="button" class="btn chart-toggle-btn">Triwulan</button>
                        <button type="button" class="btn chart-toggle-btn">Tahunan</button>
                    </div>
                </div>
                <canvas id="trenProduksiChart" height="100"></canvas>
                <div class="text-center mt-3" style="font-size: 12px;">
                    <span class="me-3"><span class="dot bg-primary"></span> Jumlah Permintaan</span>
                    <span><span class="dot bg-warning"></span> Garis Tren</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="custom-card border-0">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h5 class="fw-bold mb-0">Tren Aktivitas Produksi</h5>
                        <small class="text-muted">Distribusi berdasarkan status</small>
                    </div>
                    <a href="{{ route('admin.permintaan.index') }}" class="text-primary text-decoration-none" style="font-size: 13px;">
                        Detail <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="d-flex align-items-center justify-content-between h-100">
                    <div style="width: 200px;">
                        <canvas id="aktivitasChart"></canvas>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        @php
                            $statusColors = [
                                'draft'       => '#adb5bd',
                                'submitted'   => '#0d6efd',
                                'in_progress' => '#ffc107',
                                'completed'   => '#20c997',
                                'rejected'    => '#dc3545',
                            ];
                        @endphp
                        @forelse($data['permintaan_by_status'] as $status => $jumlah)
                        <div class="legend-item"
                             onclick="window.location.href='{{ route('admin.permintaan.index') }}'"
                             title="Lihat di Request Management">
                            <small class="text-muted">
                                <span class="dot" style="background:{{ $statusColors[$status] ?? '#0d6efd' }}"></span>
                                {{ ucfirst(str_replace('_',' ',$status)) }}
                            </small>
                            <h5 class="fw-bold mb-0 mt-1">{{ $jumlah }}</h5>
                        </div>
                        @empty
                            <p class="text-muted" style="font-size:12px">Belum ada data</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RECENT ACTIVITY --}}
    <div class="row">
        <div class="col-12">
            <div class="custom-card activity-feed border-0">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-0">Recent Activity Feed</h5>
                        <small class="text-muted">Permintaan terbaru masuk ke sistem</small>
                    </div>
                    <a href="{{ route('admin.permintaan.index') }}" class="text-primary fw-bold text-decoration-none" style="font-size: 14px;">
                        View All
                    </a>
                </div>

                @if(isset($data['permintaan_terbaru']) && $data['permintaan_terbaru']->isNotEmpty())
                    <ul class="timeline mb-0">
                        @foreach($data['permintaan_terbaru'] as $p)
                        @php
                            $dotClass = match($p->status) {
                                'submitted'   => 'dot-blue',
                                'in_progress' => 'dot-yellow',
                                'completed'   => 'dot-green',
                                default       => 'dot-grey'
                            };
                        @endphp
                        <li class="timeline-item {{ $dotClass }}"
                            onclick="window.location.href='{{ route('admin.permintaan.index') }}'">
                            <span class="text-dark" style="font-size: 14px;">
                                Request <strong>{{ $p->kode_permintaan ?? 'REQ-'.$p->permintaan_id }}</strong>
                                — {{ $p->nama_permintaan ?? '-' }}
                            </span>
                            <span class="time-text">
                                {{ \Carbon\Carbon::parse($p->tanggal_permintaan)->diffForHumans() }}
                            </span>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted" style="font-size: 13px;">Belum ada permintaan masuk.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const permintaanByMonth  = @json($data['permintaan_by_month']);
    const permintaanByStatus = @json($data['permintaan_by_status']);

    const months  = Object.keys(permintaanByMonth);
    const monthly = Object.values(permintaanByMonth);

    const statusLabels = Object.keys(permintaanByStatus);
    const statusValues = Object.values(permintaanByStatus);
    const colorMap = {
        'draft'      : '#adb5bd',
        'submitted'  : '#0d6efd',
        'in_progress': '#ffc107',
        'completed'  : '#20c997',
        'rejected'   : '#dc3545',
    };
    const bgColors = statusLabels.map(s => colorMap[s] ?? '#0d6efd');

    new Chart(document.getElementById('trenProduksiChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: months.map(m => {
                const d = new Date(m + '-01');
                return d.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
            }),
            datasets: [
                {
                    type: 'line',
                    label: 'Garis Tren',
                    data: monthly,
                    borderColor: '#ffc107',
                    backgroundColor: '#ffc107',
                    borderWidth: 2, tension: 0.4,
                    pointBackgroundColor: '#ffc107',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2, pointRadius: 4
                },
                {
                    type: 'bar',
                    label: 'Jumlah Permintaan',
                    data: monthly,
                    backgroundColor: '#0d6efd',
                    borderRadius: 4, barPercentage: 0.6
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [5,5], color: '#eee' }, border: { display: false } },
                x: { grid: { display: false }, border: { display: false } }
            }
        }
    });

    new Chart(document.getElementById('aktivitasChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusValues.length ? statusValues : [1],
                backgroundColor: statusValues.length ? bgColors : ['#eee'],
                borderWidth: 5, borderColor: '#fff', hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: { legend: { display: false } }
        }
    });
</script>
@endpush