<!DOCTYPE html>
<html>
<head>
    <title>Production System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f4f6f9;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: white;
            position: fixed;
            border-right: 1px solid #e5e7eb;
            top: 0;
            left: 0;
            overflow-y: auto;
        }

        /* HEADER */
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
        }

        /* LOGO */
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-logo img {
            width: 40px;
            height: 40px;
            object-fit: contain;
            transform: rotate(-95deg);
        }

        /* TITLE */
        .sidebar-title {
            font-size: 14px;
            font-weight: 600;
        }

        .sidebar-sub {
            font-size: 12px;
            color: #777;
        }

        /* MENU */
        .menu {
            padding: 20px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            text-decoration: none;
            color: #333;
            border-radius: 8px;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .menu a:hover  { background: #f3f4f6; }
        .menu a.active { background: #2563eb; color: white; }
        .menu hr { border: none; border-top: 1px solid #eee; margin: 10px 0; }

        /* MAIN */
        .main    { margin-left: 250px; }
        .content { padding: 30px; }

        /* TOPBAR */
        .topbar {
            height: 70px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            border-bottom: 1px solid #e5e7eb;
        }

        /* SEARCH */
        .search-box { position: relative; }
        .search-box input {
            width: 420px;
            height: 40px;
            padding-left: 38px;
            border-radius: 10px;
            border: 1px solid #ddd;
            outline: none;
            font-size: 14px;
        }
        .search-icon {
            position: absolute;
            left: 12px;
            top: 10px;
            color: #888;
        }

        /* RIGHT */
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification { font-size: 20px; color: black; cursor: pointer; }

        /* USER */
        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            padding: 6px 12px;
            border-radius: 10px;
        }

        .avatar {
            width: 32px;
            height: 32px;
            background: #2563eb;
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }

        .user-name { font-size: 14px; font-weight: 600; }
        .user-role { font-size: 12px; color: #7c3aed; }

        /* LOGOUT */
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            background: white;
            padding: 8px 14px;
            border-radius: 10px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #333;
            font-size: 14px;
        }

        .logout-btn:hover { background: #f9fafb; }

        /* Flash Messages */
        .flash-success {
            background: #d1fae5;
            border: 1px solid #6ee7b7;
            color: #065f46;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .flash-error {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        /* ── Dashboard Cards (dipakai di dashboard.blade.php) ── */
        .custom-card        { background: #fff; border-radius: 16px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); height: 100%; }
        .card-border-blue   { border: 2px solid #e0ebff; }
        .card-border-yellow { border: 2px solid #fff3cd; }
        .card-border-orange { border: 2px solid #ffe5d0; }
        .card-border-green  { border: 2px solid #d1f2e2; }
        .icon-box    { width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; margin-bottom: 15px; }
        .icon-blue   { background: #eff5ff; color: #0d6efd; }
        .icon-yellow { background: #fffdf0; color: #ffc107; }
        .icon-orange { background: #fff6f0; color: #fd7e14; }
        .icon-green  { background: #f0fdf4; color: #198754; }
        .chart-toggle-btn        { border: 1px solid #eee; background: #f8f9fa; color: #6c757d; font-size: 13px; padding: 5px 15px; }
        .chart-toggle-btn.active { background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.05); font-weight: 600; color: #0d6efd; border-radius: 6px; }
        .legend-item       { background: #fff; border: 1px solid #eee; padding: 10px 15px; border-radius: 10px; text-align: center; width: 80px; cursor: pointer; transition: 0.2s; }
        .legend-item:hover { border-color: #0d6efd; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
        .dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 5px; }
        .activity-feed { background: #fffdfa; }
        .timeline      { list-style: none; padding-left: 10px; }
        .timeline-item { position: relative; padding-left: 25px; padding-bottom: 20px; display: flex; justify-content: space-between; cursor: pointer; transition: 0.2s; border-radius: 8px; }
        .timeline-item:hover              { background-color: #f8f9fa; padding-right: 10px; }
        .timeline-item::before            { content: ''; position: absolute; left: 0; top: 6px; width: 8px; height: 8px; border-radius: 50%; }
        .timeline-item.dot-blue::before   { background-color: #0d6efd; }
        .timeline-item.dot-green::before  { background-color: #20c997; }
        .timeline-item.dot-grey::before   { background-color: #adb5bd; }
        .timeline-item.dot-yellow::before { background-color: #ffc107; }
        .time-text { font-size: 12px; color: #adb5bd; }
    </style>

    {{-- ✅ TAMBAHAN 1: CSS khusus dari masing-masing halaman --}}
    @yield('styles')
</head>
<body>

{{-- SIDEBAR --}}
@include('layouts.sidebar')

<div class="main">

    {{-- TOPBAR --}}
    @include('layouts.topbar')

    <div class="content">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="flash-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash-error">⚠️ {{ session('error') }}</div>
        @endif

        {{-- Konten dari masing-masing halaman --}}
        @yield('content')

    </div>
</div>

{{-- ✅ TAMBAHAN 2: Bootstrap JS (wajib untuk modal, dropdown, alert) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- ✅ TAMBAHAN 3: Script khusus dari masing-masing halaman --}}
@stack('scripts')

</body>
</html>