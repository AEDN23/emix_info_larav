@extends('layouts.app')

@section('title', 'Detail Work Instruction')

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
    <a href="{{ route('wi.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>

    <div class="card">
        <h2 style="border-bottom: 2px solid #eee; padding-bottom: 15px; color: var(--primary-blue);">Detail Work Instruction
            (WI)</h2>

        <div class="detail-grid">
            <div class="label">Nomor WI</div>
            <div class="value">{{ $wi->nomer_wi }}</div>

            <div class="label">Nama WI</div>
            <div class="value">{{ $wi->nama_wi }}</div>

            <div class="label">Departemen</div>
            <div class="value">{{ $wi->departemen->nama_departemen ?? '-' }}</div>

            <div class="label">Tahun</div>
            <div class="value">{{ $wi->tahun }}</div>

            <div class="label">Keterangan</div>
            <div class="value">{{ $wi->keterangan }}</div>

            <div class="label">File Dokumen</div>
            <div class="value">
                <a href="{{ asset('storage/' . $wi->file) }}" target="_blank"
                    style="color: var(--primary-blue); font-weight: 600;">
                    <i class="fas fa-file-pdf"></i> Lihat/Download Dokumen
                </a>
            </div>

            <div class="label">Video</div>
            <div class="value">
                @if($wi->video && $wi->video != '-')
                    <a href="{{ asset('storage/' . $wi->video) }}" target="_blank" style="color: #2ecc71; font-weight: 600;">
                        <i class="fas fa-video"></i> Tonton Video
                    </a>
                @else
                    -
                @endif
            </div>

            <div class="label">Dibuat Oleh</div>
            <div class="value">{{ $wi->creator->name ?? '-' }}</div>

            <div class="label">Waktu Input</div>
            <div class="value">{{ $wi->created_at->format('d M Y, H:i') }}</div>
        </div>
    </div>
@endsection