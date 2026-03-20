<div class="sidebar">

    <div class="sidebar-header">
        <div class="sidebar-logo">
            <img src="{{ asset('images/logo-pt-sumber-prima-mandiri.png') }}" alt="logo">
            <div>
                <div class="sidebar-title">PT Sumber Prima Mandiri</div>
                <div class="sidebar-sub">Production System</div>
            </div>
        </div>
    </div>

    <div class="menu">

        @php $role = auth()->user()->role; @endphp

        {{-- ── MENU ADMIN ── --}}
        @if($role === 'admin')
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid"></i> Dashboard
            </a>
            <a href="{{ route('admin.permintaan.index') }}"
               class="{{ request()->routeIs('admin.permintaan.*') ? 'active' : '' }}">
                <i class="bi bi-file-text"></i> Request Management
            </a>
            <a href="{{ route('admin.part-list.index') }}"
               class="{{ request()->routeIs('admin.part-list.*') ? 'active' : '' }}">
                <i class="bi bi-table"></i> Master Schedule
            </a>
            <a href="{{ route('admin.schedule.index') }}"
               class="{{ request()->routeIs('admin.schedule.*') ? 'active' : '' }}">
                <i class="bi bi-tools"></i> Schedule MFG
            </a>
            <a href="{{ route('admin.mesin.index') }}"
               class="{{ request()->routeIs('admin.mesin.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i> Mesin
            </a>

        {{-- ── MENU ENGINEER ── --}}
        @elseif($role === 'engineer')
            <a href="{{ route('engineer.dashboard') }}"
               class="{{ request()->routeIs('engineer.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid"></i> Dashboard
            </a>
            <a href="{{ route('engineer.request') }}"
               class="{{ request()->routeIs('engineer.request') ? 'active' : '' }}">
                <i class="bi bi-file-text"></i> Request Management
            </a>
            <a href="{{ route('engineer.master') }}"
               class="{{ request()->routeIs('engineer.master') ? 'active' : '' }}">
                <i class="bi bi-table"></i> Master Schedule
            </a>
            <a href="{{ route('engineer.parts.index') }}"
               class="{{ request()->routeIs('engineer.parts.*') ? 'active' : '' }}">
                <i class="bi bi-tools"></i> Part List
            </a>

        {{-- ── MENU OPERATOR ── --}}
        @elseif($role === 'operator')
            <a href="{{ route('operator.dashboard') }}"
               class="{{ request()->routeIs('operator.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid"></i> Dashboard
            </a>
            <a href="{{ route('operator.parts') }}"
               class="{{ request()->routeIs('operator.parts') ? 'active' : '' }}">
                <i class="bi bi-file-text"></i> Request Management
            </a>
            <a href="{{ route('operator.schedule.index') }}"
               class="{{ request()->routeIs('operator.schedule.*') ? 'active' : '' }}">
                <i class="bi bi-table"></i> Master Schedule
            </a>
            <a href="{{ route('operator.schedule.index') }}"
               class="{{ request()->routeIs('operator.schedule.*') ? 'active' : '' }}">
                <i class="bi bi-tools"></i> Schedule MFG
            </a>
        @endif

        <hr>

        {{-- Menu umum semua role --}}
        <a href="{{ route('profile') }}"
           class="{{ request()->routeIs('profile') ? 'active' : '' }}">
            <i class="bi bi-person"></i> Profil Saya
        </a>
        <a href="{{ route('logout') }}" class="text-danger">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>

    </div>
</div>