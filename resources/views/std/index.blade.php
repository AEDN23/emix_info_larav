@extends('layouts.app')

@section('title', 'Data Support Document')

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
            background-color: var(--primary);
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

        /* Custom Modal Styles (If any additional needed, Bootstrap handles fullscreen) */
        .modal-header {
            border-bottom: 2px solid #f0f0f0;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <h2 style="font-size: 1.25rem; color: #333;">Daftar Support Documents (STD)</h2>
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('std.create') }}" class="btn-add">
                        <i class="fas fa-plus"></i> Tambah Data
                    </a>
                @endif
            @endauth
        </div>

        @if (session('success'))
            <div style="background-color: #d1fae5; color: #065f46; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table id="stdTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor STD</th>
                        <th>Nama STD</th>
                        <th>Departemen</th>
                        <th>Tahun</th>
                        <th>keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stds as $std)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $std->nomer_std }}</td>
                            <td>{{ $std->nama_std }}</td>
                            <td>{{ $std->departemen->nama_departemen ?? '-' }}</td>
                            <td>{{ $std->tahun }}</td>
                            <td>
                                {{ $std->keterangan }}
                            </td>
                            <td>
                                <div style="display: flex;">


                                    @auth
                                        @if(Auth::user()->role === 'admin')
                                            <form action="{{ route('std.destroy', $std->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-delete" title="Hapus"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                            <a href="{{ route('std.edit', $std->id) }}" class="btn-action btn-edit" title="Edit"><i
                                                    class="fas fa-edit"></i></a>

                                        @endif
                                    @endauth
                                    <a href="{{ route('std.show', $std->id) }}" class="btn-action btn-view" title="Detail"><i
                                            class="fas fa-eye"></i></a>

                                    @if($std->file)
                                        <button type="button" class="btn-action btn-pdf" title="Lihat PDF"
                                            onclick="showPreview('{{ $std->nama_std }}', '{{ $std->nomer_std }}', '{{ asset('public/storage/' . $std->file) }}')">
                                            <i class="fas fa-file-pdf"></i>
                                        </button>
                                    @endif

                                    @if($std->video && $std->video !== '-')
                                        <button type="button" class="btn-action btn-video" title="Lihat Video"
                                            onclick="showVideoPreview('{{ $std->nama_std }}', '{{ $std->nomer_std }}', '{{ asset('public/storage/' . $std->video) }}')">
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

    <!-- Fullscreen Preview Modal PDF -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center" style="padding: 10px 20px;">
                    <div>
                        <h5 class="mb-0" style="font-size: 14px; font-weight: bold; color: #2E3338;">NAMA STD <span style="margin: 0 10px;">:</span><span id="modalNama"></span></h5>
                        <h5 class="mb-0" style="font-size: 14px; font-weight: bold; color: #2E3338; margin-top: 5px;">NOMOR STD <span style="margin: 0 10px;">:</span><span id="modalNomor"></span></h5>
                    </div>
                    <button type="button" class="btn text-success fw-bold p-0" data-bs-dismiss="modal" style="font-size: 14px; letter-spacing: 1px;">CLOSE</button>
                </div>
                <div class="modal-body p-0" style="overflow: hidden; background-color: #525659;">
                    <iframe id="previewIframe" src="" frameborder="0" style="width: 100%; height: 100%;"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Fullscreen Preview Modal Video -->
    <div class="modal fade" id="videoPreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center" style="padding: 10px 20px;">
                    <div>
                        <h5 class="mb-0" style="font-size: 14px; font-weight: bold; color: #2E3338;">NAMA STD <span style="margin: 0 10px;">:</span><span id="modalVideoNama"></span></h5>
                        <h5 class="mb-0" style="font-size: 14px; font-weight: bold; color: #2E3338; margin-top: 5px;">NOMOR STD <span style="margin: 0 10px;">:</span><span id="modalVideoNomor"></span></h5>
                    </div>
                    <button type="button" class="btn text-success fw-bold p-0" data-bs-dismiss="modal" style="font-size: 14px; letter-spacing: 1px;">CLOSE</button>
                </div>
                <div class="modal-body p-0" style="background-color: #000;">
                    <video id="videoPlayer" controls style="width: 100%; height: 100%;">
                        <source id="videoSource" src="" type="video/mp4">
                        Browser Anda tidak mendukung tag video.
                    </video>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('public/pdfjs/pdf.min.js') }}"></script>
    <script>
        const pdfjsLoaded = window['pdfjs-dist/build/pdf'] || window.pdfjsLib;
        if (pdfjsLoaded) {
            pdfjsLoaded.GlobalWorkerOptions.workerSrc = '{{ asset("public/pdfjs/pdf.worker.min.js") }}';
        }
        $(document).ready(function () {
            $('#stdTable').DataTable({
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                },
                "order": [[0, "asc"]]
            });
        });

        function showPreview(nama, nomor, fileUrl) {
            document.getElementById('modalNama').innerText = nama;
            document.getElementById('modalNomor').innerText = nomor;
            document.getElementById('previewIframe').src = fileUrl;
            var modal = new bootstrap.Modal(document.getElementById('previewModal'));
            modal.show();
        }

        function showVideoPreview(nama, nomor, fileUrl) {
            document.getElementById('modalVideoNama').innerText = nama;
            document.getElementById('modalVideoNomor').innerText = nomor;
            var player = document.getElementById('videoPlayer');
            document.getElementById('videoSource').src = fileUrl;
            player.load();
            var modal = new bootstrap.Modal(document.getElementById('videoPreviewModal'));
            modal.show();
        }

        // Clean up iframe src when modal is hidden to stop any unwanted requests or audio
        document.getElementById('previewModal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('previewIframe').src = '';
        });

        // Pause video when modal is hidden
        document.getElementById('videoPreviewModal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('videoPlayer').pause();
        });
    </script>
@endsection