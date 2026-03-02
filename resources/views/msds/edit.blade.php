@extends('layouts.app')

@section('title', 'Edit MSDS')

@section('styles')
    <style>
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 30px;
            max-width: 800px;
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
        input[type="file"],
        select,
        textarea {
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
            transition: opacity 0.2s;
        }

        .btn-submit:hover {
            opacity: 0.8;
        }

        .btn-cancel {
            background-color: #6b7280;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 600;
            display: inline-block;
            margin-right: 10px;
        }

        .error {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <h2 style="margin-bottom: 25px; color: #333;">Edit Data MSDS</h2>

        <form action="{{ route('msds.update', $msds->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama_msds">Nama MSDS</label>
                <input type="text" id="nama_msds" name="nama_msds" value="{{ old('nama_msds', $msds->nama_msds) }}" required>
                @error('nama_msds') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="departemen_id">Departemen</label>
                <select id="departemen_id" name="departemen_id" required>
                    @foreach($departemens as $dept)
                        <option value="{{ $dept->id }}" {{ old('departemen_id', $msds->departemen_id) == $dept->id ? 'selected' : '' }}>
                            {{ $dept->nama_departemen }}
                        </option>
                    @endforeach
                </select>
                @error('departemen_id') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="tahun">Tahun</label>
                <input type="text" id="tahun" name="tahun" value="{{ old('tahun', $msds->tahun) }}" required>
                @error('tahun') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="file">File Dokumen (Biarkan kosong jika tidak ingin mengubah)</label>
                <input type="file" id="file" name="file">
                <small style="color: #888;">File saat ini: <a href="{{ asset('public/storage/' . $msds->file) }}"
                        target="_blank">Lihat File</a></small>
                @error('file') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="video">Link Video</label>
                <input type="text" id="video" name="video" value="{{ old('video', $msds->video) }}">
                @error('video') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="4">{{ old('keterangan', $msds->keterangan) }}</textarea>
                @error('keterangan') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div style="margin-top: 30px; display: flex; justify-content: flex-end;">
                <a href="{{ route('msds.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">Update Data</button>
            </div>
        </form>
    </div>
@endsection