@extends('layouts.app')

@section('title', 'Edit Data Work Instruction')

@section('styles')
    <style>
        .card {
            background: white;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 0;
            max-width: 1000px;
            margin: 20px auto;
            border: 1px solid #e5e7eb;
        }

        .card-header {
            padding: 15px 25px;
            border-bottom: 1px solid #f3f4f6;
            font-weight: 600;
            color: #374151;
            font-size: 1.1rem;
        }

        .card-body {
            padding: 30px 50px;
        }

        .form-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
        }

        .form-table td {
            vertical-align: middle;
            padding: 5px;
        }

        .form-label {
            width: 30%;
            font-weight: 600;
            color: #4b5563;
            text-align: right;
            padding-right: 30px !important;
        }

        .form-input-container {
            width: 70%;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 0.9rem;
            color: #374151;
            background-color: #fff;
        }

        input[readonly] {
            background-color: #f3f4f6;
            cursor: not-allowed;
        }

        input::placeholder {
            color: #9ca3af;
        }

        .btn-simpan {
            background-color: #2b78a9;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            margin-top: 20px;
        }

        .btn-simpan:hover {
            background-color: #23618a;
        }

        .error {
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 4px;
            display: block;
        }

        .page-title {
            font-size: 1.8rem;
            color: #1f2937;
            margin-bottom: 30px;
            font-weight: 500;
        }
    </style>
@endsection

@section('content')
    <h1 class="page-title">Edit Data Work Instruction</h1>

    <div class="card">
        <div class="card-header">
            Edit Data - {{ $wi->nomer_wi }}
        </div>
        <div class="card-body">
            <form action="{{ route('wi.update', $wi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <table class="form-table">
                    <tr>
                        <td class="form-label">Nomor Dokumen</td>
                        <td class="form-input-container">
                            <input type="text" name="nomer_wi" value="{{ old('nomer_wi', $wi->nomer_wi) }}" readonly
                                style="background-color: #f3f4f6; cursor: not-allowed;">
                            <small class="text-muted" style="color: #6c757d; font-size: 0.8rem;">* Nomor dokumen tidak dapat
                                diubah</small>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">Nama Dokumen</td>
                        <td class="form-input-container">
                            <input type="text" name="nama_wi" value="{{ old('nama_wi', $wi->nama_wi) }}"
                                placeholder="Nama Dokumen" required>
                            @error('nama_wi') <span class="error">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">Departemen</td>
                        <td class="form-input-container">
                            <select name="departemen_id" required>
                                <option value="">--- Pilih Departemen ---</option>
                                @foreach($departemens as $dept)
                                    <option value="{{ $dept->id }}" {{ old('departemen_id', $wi->departemen_id) == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->nama_departemen }}
                                    </option>
                                @endforeach
                            </select>
                            @error('departemen_id') <span class="error">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">Tahun Dokumen</td>
                        <td class="form-input-container">
                            <input type="number" name="tahun" value="{{ old('tahun', $wi->tahun) }}"
                                placeholder="Tahun Dokumen" required>
                            @error('tahun') <span class="error">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">Keterangan</td>
                        <td class="form-input-container">
                            <input type="text" name="keterangan" value="{{ old('keterangan', $wi->keterangan) }}"
                                placeholder="Keterangan Dokumen">
                            @error('keterangan') <span class="error">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">Update PDF</td>
                        <td class="form-input-container">
                            <input type="file" name="file" accept=".pdf">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file</small>
                            @if($wi->file)
                                <div style="margin-top: 5px;">
                                    <small>File saat ini: <a href="{{ asset('storage/' . $wi->file) }}" target="_blank">Lihat
                                            File</a></small>
                                </div>
                            @endif
                            @error('file') <span class="error">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">Update Video</td>
                        <td class="form-input-container">
                            <input type="file" name="video" accept="video/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah video</small>
                            @if($wi->video && $wi->video !== '-')
                                <div style="margin-top: 5px;">
                                    <small>Video saat ini: <a href="{{ asset('storage/' . $wi->video) }}" target="_blank">Lihat
                                            Video</a></small>
                                </div>
                            @endif
                            @error('video') <span class="error">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                </table>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn-simpan">Update</button>
                    <a href="{{ route('wi.index') }}" class="btn-simpan"
                        style="background-color: #6c757d; text-decoration: none; display: inline-block;">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection