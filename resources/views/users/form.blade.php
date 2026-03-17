@extends('layouts.app')

@section('title', (isset($user) ? 'Edit' : 'Tambah') . ' Pengguna')

@section('content')
    <div class="row justify-content-center animate-fade-in">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-4 border-0">
                    <h5 class="fw-bold mb-0">{{ isset($user) ? 'Edit' : 'Tambah' }} Pengguna Sistem</h5>
                    <p class="text-muted small mb-0">Atur profil dan tingkat keamanan akun pengguna</p>
                </div>

                <div class="card-body p-4 p-md-5 pt-md-4">
                    <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}"
                        method="POST">
                        @csrf
                        @if(isset($user))
                            @method('PUT')
                        @endif

                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold small text-uppercase text-muted">Nama Lengkap</label>
                                <input type="text" name="name"
                                    class="form-control bg-light border-0 py-2 @error('name') is-invalid @enderror"
                                    value="{{ $user->name ?? old('name') }}" required placeholder="Masukkan nama lengkap">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase text-muted">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-muted">@</span>
                                    <input type="text" name="username"
                                        class="form-control bg-light border-0 @error('username') is-invalid @enderror"
                                        value="{{ $user->username ?? old('username') }}" required placeholder="username">
                                    @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-uppercase text-muted">Hak Akses
                                    (Role)</label>
                                <select name="role"
                                    class="form-select bg-light border-0 py-2 @error('role') is-invalid @enderror" required>
                                    <option value="user" {{ (isset($user) && $user->role == 'user') ? 'selected' : '' }}>User
                                    </option>
                                    <option value="admin" {{ (isset($user) && $user->role == 'admin') ? 'selected' : '' }}>
                                        Admin</option>
                                    <option value="checker" {{ (isset($user) && $user->role == 'checker') ? 'selected' : '' }}>Checker</option>
                                    <option value="approver" {{ (isset($user) && $user->role == 'approver') ? 'selected' : '' }}>Approver</option>
                                </select>
                                @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold small text-uppercase text-muted">Email
                                    (Opsional)</label>
                                <input type="email" name="email"
                                    class="form-control bg-light border-0 py-2 @error('email') is-invalid @enderror"
                                    value="{{ $user->email ?? old('email') }}" placeholder="user@example.com">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold small text-uppercase text-muted">Kata Sandi</label>
                                <input type="password" name="password"
                                    class="form-control bg-light border-0 py-2 @error('password') is-invalid @enderror" {{ isset($user) ? '' : 'required' }}
                                    placeholder="{{ isset($user) ? 'Kosongkan jika tidak ingin mengubah' : 'Minimal 6 karakter' }}">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mt-5 pt-3 border-top d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm">
                                <i class="fas fa-save me-2"></i>{{ isset($user) ? 'Simpan Perubahan' : 'Buat Akun' }}
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-light px-4 py-2 border">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control:focus,
        .form-select:focus {
            background-color: #fff !important;
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1) !important;
        }
    </style>
@endsection