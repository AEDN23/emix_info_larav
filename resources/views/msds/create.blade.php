@extends('layouts.app')

@section('title', 'Input Data MSDS')

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
    <h1 class="page-title">Input Data Material Safety Data Sheet (MSDS)</h1>

    <div class="card">
        <div class="card-header">
            Tambah Data
        </div>
        <div class="card-body">
            <form action="{{ route('msds.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <table class="form-table">
                    <tr>
                        <td class="form-label">Nomor Dokumen</td>
                        <td class="form-input-container">
                            <input type="text" name="nomer_msds" value="{{ $nextNo }}" readonly
                                style="background-color: #f3f4f6; cursor: not-allowed;">
                            <small class="text-muted" style="color: #6c757d; font-size: 0.8rem;">* Nomor dokumen otomatis
                                dibuat oleh sistem</small>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">Nama Dokumen</td>
                        <td class="form-input-container">
                            <input type="text" name="nama_msds" value="{{ old('nama_msds') }}" placeholder="Nama Dokumen"
                                required>
                            @error('nama_msds') <span class="error">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">Departemen</td>
                        <td class="form-input-container">
                            <select name="departemen_id" required>
                                <option value="">--- Pilih Departemen ---</option>
                                @foreach($departemens as $dept)
                                    <option value="{{ $dept->id }}" {{ old('departemen_id') == $dept->id ? 'selected' : '' }}>
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
                            <input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}"
                                placeholder="Tahun Dokumen" required>
                            @error('tahun') <span class="error">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">Keterangan</td>
                        <td class="form-input-container">
                            <input type="text" name="keterangan" value="{{ old('keterangan') }}"
                                placeholder="Keterangan Dokumen">
                            @error('keterangan') <span class="error">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">Upload PDF</td>
                        <td class="form-input-container">
                            <input type="file" name="file" accept=".pdf" required>
                            @error('file') <span class="error">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">Upload Video</td>
                        <td class="form-input-container">
                            <input type="file" name="video" accept="video/*">
                            @error('video') <span class="error">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                </table>

                <button type="submit" class="btn-simpan">Simpan</button>
            </form>
        </div>
    </div>
@endsection