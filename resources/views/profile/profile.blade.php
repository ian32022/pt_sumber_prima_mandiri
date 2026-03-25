@extends('layouts.app')

@section('title', 'My Profile')

@section('styles')
<style>
    .profile-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e0e0e0;
        padding: 28px;
        margin-bottom: 20px;
    }
    .avatar-circle {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb, #60a5fa);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
        user-select: none;
    }
    .role-badge {
        background-color: #e8f0fe;
        color: #1a56db;
        font-size: 0.72rem;
        padding: 3px 10px;
        border-radius: 4px;
        font-weight: 500;
    }
    .section-title {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #888;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f0f0f0;
    }
    .form-label {
        font-size: 0.84rem;
        color: #555;
        margin-bottom: 4px;
    }
    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }
    .info-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        border-bottom: 1px solid #f5f5f5;
        font-size: 0.88rem;
    }
    .info-row:last-child { border-bottom: none; }
    .info-label {
        width: 130px;
        color: #999;
        flex-shrink: 0;
    }
    .info-value { color: #222; font-weight: 500; }
    .password-toggle {
        cursor: pointer;
        color: #888;
    }
    .password-toggle:hover { color: #2563eb; }
</style>
@endsection

@section('content')

<div class="mb-4">
    <h3 class="fw-bold mb-1">My Profile</h3>
    <p class="text-muted">Kelola informasi akun dan keamanan Anda</p>
</div>

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

<div class="row g-4">

    {{-- ===== KOLOM KIRI: Info Akun ===== --}}
    <div class="col-md-4">

        {{-- Avatar & Identitas --}}
        <div class="profile-card text-center">
            <div class="avatar-circle mx-auto mb-3">
                {{ strtoupper(substr(auth()->user()->nama ?? auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
            <h5 class="fw-bold mb-1">
                {{ auth()->user()->nama ?? auth()->user()->name ?? '-' }}
            </h5>
            <p class="text-muted mb-2" style="font-size:0.87rem;">
                {{ auth()->user()->email }}
            </p>
            @if(auth()->user()->role ?? false)
                <span class="role-badge">{{ ucfirst(auth()->user()->role) }}</span>
            @endif
        </div>

        {{-- Info Detail --}}
        <div class="profile-card">
            <div class="section-title">Informasi Akun</div>

            <div class="info-row">
                <span class="info-label"><i class="bi bi-person me-2 text-primary"></i>Nama</span>
                <span class="info-value">
                    {{ auth()->user()->nama ?? auth()->user()->name ?? '-' }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-label"><i class="bi bi-envelope me-2 text-primary"></i>Email</span>
                <span class="info-value">{{ auth()->user()->email }}</span>
            </div>
            @if(auth()->user()->role ?? false)
            <div class="info-row">
                <span class="info-label"><i class="bi bi-shield me-2 text-primary"></i>Role</span>
                <span class="info-value">{{ ucfirst(auth()->user()->role) }}</span>
            </div>
            @endif
            @if(auth()->user()->jabatan ?? false)
            <div class="info-row">
                <span class="info-label"><i class="bi bi-briefcase me-2 text-primary"></i>Jabatan</span>
                <span class="info-value">{{ auth()->user()->jabatan }}</span>
            </div>
            @endif
            <div class="info-row">
                <span class="info-label"><i class="bi bi-calendar me-2 text-primary"></i>Bergabung</span>
                <span class="info-value">
                    {{ auth()->user()->created_at ? \Carbon\Carbon::parse(auth()->user()->created_at)->format('d M Y') : '-' }}
                </span>
            </div>
        </div>

    </div>

    {{-- ===== KOLOM KANAN: Form Edit ===== --}}
    <div class="col-md-8">

        {{-- Form Update Data Diri --}}
        <div class="profile-card">
            <div class="section-title">Edit Informasi Pribadi</div>
            <form action="{{ route('profile.update') ?? '/profile/update' }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control"
                               value="{{ old('nama', auth()->user()->nama ?? auth()->user()->name) }}"
                               placeholder="Nama lengkap Anda" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', auth()->user()->email) }}"
                               placeholder="email@domain.com" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- Form Ganti Password --}}
        <div class="profile-card">
            <div class="section-title">Ganti Password</div>
            <form action="{{ route('profile.update') ?? '/profile/update' }}" method="POST"
                  id="password-form">
                @csrf
                @method('PUT')
                {{-- Kirim nama & email agar tidak ter-reset --}}
                <input type="hidden" name="nama"
                       value="{{ auth()->user()->nama ?? auth()->user()->name }}">
                <input type="hidden" name="email" value="{{ auth()->user()->email }}">

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="password" id="new-password"
                                   class="form-control" placeholder="Minimal 8 karakter">
                            <span class="input-group-text password-toggle"
                                  onclick="togglePassword('new-password', this)">
                                <i class="bi bi-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation"
                                   id="confirm-password" class="form-control"
                                   placeholder="Ulangi password baru">
                            <span class="input-group-text password-toggle"
                                  onclick="togglePassword('confirm-password', this)">
                                <i class="bi bi-eye"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <p class="text-muted mb-0" style="font-size:0.8rem;">
                        <i class="bi bi-info-circle me-1"></i>
                        Kosongkan jika tidak ingin mengganti password.
                    </p>
                    <button type="submit" class="btn btn-outline-danger px-4"
                            onclick="return validatePassword()">
                        <i class="bi bi-lock me-1"></i> Update Password
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon  = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }

    function validatePassword() {
        const pw  = document.getElementById('new-password').value;
        const cpw = document.getElementById('confirm-password').value;
        if (pw && pw.length < 8) {
            alert('Password minimal 8 karakter.');
            return false;
        }
        if (pw && pw !== cpw) {
            alert('Konfirmasi password tidak cocok.');
            return false;
        }
        return true;
    }
</script>
@endpush