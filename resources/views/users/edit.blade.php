@extends('layouts.app')

@section('title', 'Edit User')

@section('styles')
    <style>
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 30px;
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.95rem;
        }

        .btn-submit {
            background-color: #ffc107;
            color: #000;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
        }

        .btn-cancel {
            background-color: #6b7280;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 600;
            display: inline-block;
            width: 100%;
            text-align: center;
            margin-top: 10px;
        }

        .error {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        .help-text {
            font-size: 0.75rem;
            color: #777;
            margin-top: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <h2 style="margin-bottom: 25px; color: #333; text-align: center;">Edit User</h2>

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                @error('username') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="email">Email (Opsional)</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}">
                @error('email') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                    <option value="leader" {{ old('role', $user->role) == 'leader' ? 'selected' : '' }}>Leader</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div style="border-top: 1px solid #eee; margin: 30px 0; padding-top: 20px;">
                <p style="font-weight: 600; color: #333; margin-bottom: 15px;">Ubah Password (Opsional)</p>

                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" id="password" name="password">
                    <p class="help-text">Kosongkan jika tidak ingin mengubah password.</p>
                    @error('password') <p class="error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation">
                </div>
            </div>

            <button type="submit" class="btn-submit">Update User</button>
            <a href="{{ route('users.index') }}" class="btn-cancel">Batal</a>
        </form>
    </div>
@endsection