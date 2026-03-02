@extends('layouts.app')

@section('title', 'Beranda')

@section('styles')
    <style>
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .stat-card {
            background-color: var(--primary-blue);
            border-radius: 6px;
            overflow: hidden;
            color: white;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .stat-header {
            padding: 40px 25px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
        }

        .stat-icon {
            font-size: 2.5rem;
            opacity: 0.9;
        }

        .stat-main {
            text-align: right;
        }

        .stat-count {
            font-size: 3rem;
            font-weight: 400;
            line-height: 1;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-footer {
            background-color: white;
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--primary-blue);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            border-top: 1px solid #efefef;
        }

        .stat-footer:hover {
            background-color: #f0f0f0;
        }

        .stat-footer i {
            font-size: 0.9rem;
        }

        /* Reference Colors */
        .card-wi {
            background-color: #337ab7;
        }

        .card-std {
            background-color: #337ab7;
        }

        .card-msds {
            background-color: #337ab7;
        }

        .card-coa {
            background-color: #337ab7;
        }

        @media (max-width: 900px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <h1 class="page-title">PT. ELASTOMIX INDOESIA - INFORMASI DOKUMEN</h1>

    <div class="dashboard-grid">
        <!-- Work Instructions Card -->
        <div class="stat-card card-wi">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-main">
                    <div class="stat-count">{{ $counts['wi'] }}</div>
                    <div class="stat-label">Work Instructions</div>
                </div>
            </div>
            <a href="{{ route('wi.index') }}" class="stat-footer">
                Lihat Data
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>

        <!-- Support Document Card -->
        <div class="stat-card card-std">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-main">
                    <div class="stat-count">{{ $counts['std'] }}</div>
                    <div class="stat-label">Support Document</div>
                </div>
            </div>
            <a href="{{ route('std.index') }}" class="stat-footer">
                Lihat Data
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>

        <!-- MSDS Card -->
        <div class="stat-card card-msds">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-main">
                    <div class="stat-count">{{ $counts['msds'] }}</div>
                    <div class="stat-label">MSDS</div>
                </div>
            </div>
            <a href="{{ route('msds.index') }}" class="stat-footer">
                Lihat Data
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>

        <!-- COA Card -->
        <div class="stat-card card-coa">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-main">
                    <div class="stat-count">{{ $counts['coa'] }}</div>
                    <div class="stat-label">Certificate of Analysis (COA)</div>
                </div>
            </div>
            <a href="{{ route('coa.index') }}" class="stat-footer">
                Lihat Data
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
@endsection