@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="row g-4">
        <div class="col-md-4">
            <!-- Account Summary -->
            <div class="card border-0 mb-4 h-100">
                <div class="card-body text-center p-5">
                    <div class="avatar-placeholder mx-auto mb-4 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-lg"
                        style="width: 120px; height: 120px; font-size: 3rem; font-weight: 700;">
                        {{ substr(Auth::user()->name ?? 'G', 0, 1) }}
                    </div>
                    <h4 class="fw-bold mb-1">{{ Auth::user()->name }}</h4>
                    <p class="text-muted mb-3">{{ Auth::user()->username }}</p>
                    <div class="mb-4">
                        <span class="badge bg-primary px-3 py-2">
                            <i class="fas fa-shield-halved me-1"></i> {{ ucfirst(Auth::user()->role) }}
                        </span>
                    </div>
                    <div class="d-grid pt-3 border-top mt-auto">
                        <p class="small text-muted mb-1">Terdaftar sejak:</p>
                        <p class="fw-medium">{{ Auth::user()->created_at->format('d F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Profile Form Info -->
            <div class="card border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-edit text-primary me-2"></i>
                        <h5 class="mb-0 fw-bold">Informasi Akun</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-medium small">Nama Lengkap</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-medium small">Username</label>
                                <input type="text" class="form-control bg-light" value="{{ Auth::user()->username }}" disabled>
                                <div class="form-text">Username tidak dapat diubah.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-medium small">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                            </div>

                            <div class="col-md-12 pt-3">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Form -->
            <div class="card border-0">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-key text-warning me-2"></i>
                        <h5 class="mb-0 fw-bold">Ubah Kata Sandi</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3 text-start">
                            <div class="col-md-12">
                                <label class="form-label fw-medium small">Kata Sandi Saat Ini</label>
                                <input type="password" class="form-control" name="current_password" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-medium small">Kata Sandi Baru</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-medium small">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <div class="col-md-12 pt-3">
                                <button type="submit" class="btn btn-warning px-4 text-white">
                                    <i class="fas fa-lock me-2"></i>Ubah Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.1);
        }

        .avatar-placeholder {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important;
            transition: transform 0.3s ease;
        }

        .avatar-placeholder:hover {
            transform: scale(1.05);
        }
    </style>
@endsection
