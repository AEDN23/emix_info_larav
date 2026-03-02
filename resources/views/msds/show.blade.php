@extends('layouts.app')

@section('title', 'Detail MSDS')

@section('styles')
    <style>
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 40px;
            max-width: 900px;
            margin: 0 auto;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 20px;
            margin-top: 30px;
        }

        .label {
            font-weight: 700;
            color: #555;
        }

        .value {
            color: #333;
        }

        .btn-back {
            background-color: #6b7280;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    <a href="{{ route('msds.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>

    <div class="card">
        <h2 style="border-bottom: 2px solid #eee; padding-bottom: 15px; color: var(--primary-blue);">Detail MSDS</h2>

        <div class="detail-grid">
            <div class="label">Nama MSDS</div>
            <div class="value">{{ $msds->nama_msds }}</div>

            <div class="label">Departemen</div>
            <div class="value">{{ $msds->departemen->nama_departemen ?? '-' }}</div>

            <div class="label">Tahun</div>
            <div class="value">{{ $msds->tahun }}</div>

            <div class="label">Keterangan</div>
            <div class="value">{{ $msds->keterangan }}</div>

            <div class="label">File Dokumen</div>
            <div class="value">
                <a href="{{ asset('public/storage/' . $msds->file) }}" target="_blank"
                    style="color: var(--primary-blue); font-weight: 600;">
                    <i class="fas fa-file-download"></i> Lihat/Download Dokumen
                </a>
            </div>

            <div class="label">Video</div>
            <div class="value">
                @if($msds->video && $msds->video != '-')
                    <a href="{{ asset('public/storage/' . $msds->video) }}" target="_blank"
                        style="color: #2ecc71; font-weight: 600;">
                        <i class="fas fa-video"></i> Tonton Video
                    </a>
                @else
                    -
                @endif
            </div>

            <div class="label">Dibuat Oleh</div>
            <div class="value">{{ $msds->creator->name ?? '-' }}</div>

            <div class="label">Waktu Input</div>
            <div class="value">{{ $msds->created_at ? $msds->created_at->format('d M Y, H:i') : '-' }}</div>
        </div>
    </div>
@endsection