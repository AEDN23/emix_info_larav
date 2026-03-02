@extends('layouts.app')

@section('title', 'Data Work Instruction')

@section('styles')
    <style>
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 25px;
        }

        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        th {
            text-align: left;
            padding: 12px 15px;
            background-color: #f8f9fa;
            color: #555;
            font-weight: 600;
            border-bottom: 2px solid #eee;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            color: #444;
        }

        .btn-action {
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.8rem;
            margin-right: 5px;
            display: inline-block;
            border: none;
            cursor: pointer;
        }

        .btn-edit {
            background-color: #ffc107;
            color: #000;
        }

        .btn-delete {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-view {
            background-color: #17a2b8;
            color: #fff;
        }

        .btn-pdf {
            background-color: #e74c3c;
            color: #fff;
        }

        .btn-video {
            background-color: #2ecc71;
            color: #fff;
        }

        .btn-add {
            background-color: var(--primary-blue);
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-active {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-inactive {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 95%;
            height: 95%;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
        }

        .modal-body {
            flex-grow: 1;
            width: 100%;
            overflow: hidden;
            background: #fdfdfd;
        }

        #pdfViewer,
        #videoPlayer {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <h2 style="font-size: 1.25rem; color: #333;">Daftar Work Instructions (WI)</h2>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('wi.create') }}" class="btn-add">
                    <i class="fas fa-plus"></i> Tambah Data
                </a>
            @endif
        </div>

        @if (session('success'))
            <div style="background-color: #d1fae5; color: #065f46; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table id="wiTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor WI</th>
                        <th>Nama WI</th>
                        <th>Departemen</th>
                        <th>Tahun</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wis as $wi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $wi->nomer_wi }}</td>
                            <td>{{ $wi->nama_wi }}</td>
                            <td>{{ $wi->departemen->nama_departemen ?? '-' }}</td>
                            <td>{{ $wi->tahun }}</td>
                            <td>
                                <span class="badge {{ $wi->active == '1' ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $wi->active == '1' ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex;">


                                    @if(Auth::user()->role === 'admin')
                                        <form action="{{ route('wi.destroy', $wi->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" title="Hapus"><i
                                                    class="fas fa-trash"></i></button>

                                        </form>
                                        <a href="{{ route('wi.edit', $wi->id) }}" class="btn-action btn-edit" title="Edit"><i
                                                class="fas fa-edit"></i></a>

                                    @endif
                                    <a href="{{ route('wi.show', $wi->id) }}" class="btn-action btn-view" title="Detail"><i
                                            class="fas fa-eye"></i></a>

                                    @if($wi->file)
                                        <button type="button" class="btn-action btn-pdf" title="Lihat PDF"
                                            onclick="viewPDF('{{ asset('public/storage/' . $wi->file) }}', '{{ $wi->nama_wi }}')">
                                            <i class="fas fa-file-pdf"></i>
                                        </button>
                                    @endif

                                    @if($wi->video && $wi->video !== '-')
                                        <button type="button" class="btn-action btn-video" title="Lihat Video"
                                            onclick="viewVideo('{{ asset('public/storage/' . $wi->video) }}', '{{ $wi->nama_wi }}')">
                                            <i class="fas fa-video"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <!-- Modal PDF -->
    <div id="pdfModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3 id="pdfTitle">PDF Viewer</h3>
                <button class="modal-close" onclick="closeModal('pdfModal')">&times;</button>
            </div>
            <div class="modal-body">
                <iframe id="pdfViewer" src="" type="application/pdf"></iframe>
            </div>
        </div>
    </div>

    <!-- Modal Video -->
    <div id="videoModal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3 id="videoTitle">Video Player</h3>
                <button class="modal-close" onclick="closeModal('videoModal')">&times;</button>
            </div>
            <div class="modal-body">
                <video id="videoPlayer" controls style="width: 100%; height: 100%;">
                    <source id="videoSource" src="" type="video/mp4">
                    Browser Anda tidak mendukung tag video.
                </video>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#wiTable').DataTable({
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                },
                "order": [[0, "asc"]]
            });
        });

        function viewPDF(url, title) {
            document.getElementById('pdfTitle').innerText = 'Dokumen: ' + title;
            document.getElementById('pdfViewer').src = url;
            document.getElementById('pdfModal').style.display = 'flex';
        }

        function viewVideo(url, title) {
            document.getElementById('videoTitle').innerText = 'Video: ' + title;
            const player = document.getElementById('videoPlayer');
            const source = document.getElementById('videoSource');
            source.src = url;
            player.load();
            document.getElementById('videoModal').style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            if (modalId === 'pdfModal') {
                document.getElementById('pdfViewer').src = '';
            } else if (modalId === 'videoModal') {
                document.getElementById('videoPlayer').pause();
            }
        }

        // Close on overlay click
        window.onclick = function (event) {
            if (event.target.classList.contains('modal-overlay')) {
                closeModal(event.target.id);
            }
        }
    </script>
@endsection