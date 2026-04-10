@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <div class="row g-4">
        <!-- Hero Section -->
        <div class="col-12">
            <div class="card border-0 text-white overflow-hidden shadow-sm"
                style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); min-height: 250px; position: relative; border-radius: 8px;">
                <div class="card-body p-5 d-flex flex-column justify-content-center"
                    style="position: relative; z-index: 2;">
                    <h1 class="display-5 fw-bold mb-3">Selamat Datang di Emix Info</h1>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <a href="{{ route('wi.index') }}" class="btn btn-outline-light px-4 py-2 fw-bold rounded-pill">Lihat
                            Data WI</a>
                        <a href="{{ route('std.index') }}"
                            class="btn btn-outline-light px-4 py-2 fw-bold rounded-pill">Lihat Data STD</a>
                        <a href="{{ route('msds.index') }}"
                            class="btn btn-outline-light px-4 py-2 fw-bold rounded-pill">Lihat Data MSDS</a>
                        <a href="{{ route('coa.index') }}"
                            class="btn btn-outline-light px-4 py-2 fw-bold rounded-pill">Lihat Data COA</a>
                    </div>
                </div>
                <!-- Dynamic blob background effect -->
                <div
                    style="position: absolute; right: -50px; bottom: -50px; width: 300px; height: 300px; background: rgba(255,255,255,0.1); border-radius: 50%; z-index: 1;">
                </div>
                <div
                    style="position: absolute; right: 80px; top: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.05); border-radius: 50%; z-index: 1;">
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('wi.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 p-2" style="border-radius: 8px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3 d-flex align-items-center justify-content-center"
                            style="min-width: 60px;">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem; font-weight: 700;">Working Instructions
                            </h6>
                            <h3 class="fw-bold mb-0 text-dark">{{ \App\Models\Wi::count() }}</h3>
                            <small class="text-success small fw-bold" style="font-size: 0.75rem;">Dokumen Terdaftar</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6">
            <a href="{{ route('std.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 p-2" style="border-radius: 8px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-indigo bg-opacity-10 rounded-3 p-3 me-3 d-flex align-items-center justify-content-center"
                            style="color: #6366f1; background-color: #eef2ff; min-width: 60px;">
                            <i class="fas fa-file-contract fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem; font-weight: 700;">Standard (STD)</h6>
                            <h3 class="fw-bold mb-0 text-dark">{{ \App\Models\Std::count() }}</h3>
                            <small class="text-success small fw-bold" style="font-size: 0.75rem;">Dokumen Terdaftar</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6">
            <a href="{{ route('msds.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 p-2" style="border-radius: 8px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3 me-3 d-flex align-items-center justify-content-center"
                            style="min-width: 60px;">
                            <i class="fas fa-file-medical fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem; font-weight: 700;">MSDS</h6>
                            <h3 class="fw-bold mb-0 text-dark">{{ \App\Models\Msds::count() }}</h3>
                            <small class="text-success small fw-bold" style="font-size: 0.75rem;">Dokumen Terdaftar</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('coa.index') }}" style="text-decoration: none;">
                <div class="card border-0 shadow-sm h-100 p-2" style="border-radius: 8px;">
                    <div class="card-body d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success rounded-3 p-3 me-3 d-flex align-items-center justify-content-center"
                            style="min-width: 60px;">
                            <i class="fas fa-file-signature fa-2x"></i>
                        </div>

                        <div>
                            <h6 class="text-muted mb-1" style="font-size: 0.85rem; font-weight: 700;">COA</h6>
                            <h3 class="fw-bold mb-0 text-dark">{{ \App\Models\Coa::count() }}</h3>
                            <small class="text-success small fw-bold" style="font-size: 0.75rem;">Dokumen Terdaftar</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Quick Actions (Admin Only) -->
        @auth
            @if(Auth::user()->role === 'admin')
                <div class="col-12 mt-5">
                    <h5 class="fw-bold mb-3 text-center text-dark" style="font-size: 1.1rem;">Akses Cepat Admin</h5>
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-2 col-sm-6">
                            <a href="{{ route('wi.create') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm text-center p-4 h-100 hover-lift" style="border-radius: 8px;">
                                    <div class="bg-primary rounded-circle d-inline-flex mx-auto mb-3 justify-content-center align-items-center text-white"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                    <span class="fw-bold text-dark" style="font-size: 0.9rem;">Tambah WI</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <a href="{{ route('std.create') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm text-center p-4 h-100 hover-lift" style="border-radius: 8px;">
                                    <div class="bg-primary rounded-circle d-inline-flex mx-auto mb-3 justify-content-center align-items-center text-white"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                    <span class="fw-bold text-dark" style="font-size: 0.9rem;">Tambah STD</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <a href="{{ route('msds.create') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm text-center p-4 h-100 hover-lift" style="border-radius: 8px;">
                                    <div class="bg-primary rounded-circle d-inline-flex mx-auto mb-3 justify-content-center align-items-center text-white"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                    <span class="fw-bold text-dark" style="font-size: 0.9rem;">Tambah MSDS</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <a href="{{ route('coa.create') }}" class="text-decoration-none">
                                <div class="card border-0 shadow-sm text-center p-4 h-100 hover-lift" style="border-radius: 8px;">
                                    <div class="bg-primary rounded-circle d-inline-flex mx-auto mb-3 justify-content-center align-items-center text-white"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                    <span class="fw-bold text-dark" style="font-size: 0.9rem;">Tambah COA</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <a href="{{ route('users.create') }}" class="text-decoration-none"
                                style="pointer-events: none; opacity: 0.6;">
                                <div class="card border-0 shadow-sm text-center p-4 h-100 hover-lift" style="border-radius: 8px;">
                                    <div class="bg-secondary rounded-circle d-inline-flex mx-auto mb-3 justify-content-center align-items-center text-white"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <span class="fw-bold text-dark" style="font-size: 0.9rem;">Tambah User</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </div>

    <style>
        .hover-lift {
            transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.2s;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
        }
    </style>
@endsection