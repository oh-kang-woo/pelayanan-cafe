@extends('layouts.app')

@section('content')
<style>
    /* --- 1. LAYOUT & BACKGROUND --- */
    .table-selection-wrapper {
        min-height: 85vh; /* Sesuaikan tinggi agar pas di layar */
        padding: 40px;
        background: radial-gradient(circle at top right, #0f2027, #203a43, #2c5364); /* Gradiasi Gelap Elegan */
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        color: #fff;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 10px;
        background: linear-gradient(90deg, #00c6ff, #0072ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent; /* Teks efek gradiasi */
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .page-subtitle {
        color: #aab2bd;
        margin-bottom: 40px;
        font-size: 0.95rem;
    }

    /* --- 2. GRID SYSTEM --- */
    .tables-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Responsif otomatis */
        gap: 25px;
    }

    /* --- 3. KARTU MEJA (CARD) --- */
    .table-card {
        position: relative;
        background: rgba(255, 255, 255, 0.05); /* Transparan gelap */
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 25px;
        text-align: center;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Efek pantul halus */
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 180px; /* Tinggi seragam */
    }

    /* Efek Hover: Melayang & Glow Biru */
    .table-card:hover {
        transform: translateY(-8px) scale(1.02);
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(0, 198, 255, 0.5);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4),
                    0 0 20px rgba(0, 198, 255, 0.2);
    }

    /* --- 4. INDIKATOR STATUS (Warna) --- */
    /* AVAILABLE: Gradiasi Biru/Cyan */
    .status-available {
        border-bottom: 4px solid #00f260; /* Garis hijau neon di bawah */
    }

    .status-available .icon-wrapper {
        color: #00f260;
        text-shadow: 0 0 10px rgba(0, 242, 96, 0.5);
    }

    .status-available:hover {
        background: linear-gradient(135deg, rgba(5, 117, 230, 0.1), rgba(0, 242, 96, 0.1));
    }

    /* OCCUPIED / BOOKED: Gradiasi Merah/Pink */
    .status-occupied {
        border-bottom: 4px solid #ff416c; /* Garis merah neon di bawah */
        opacity: 0.7; /* Sedikit redup */
        cursor: not-allowed;
    }

    .status-occupied .icon-wrapper {
        color: #ff4b2b;
    }

    /* --- 5. KONTEN KARTU --- */
    .table-name {
        font-size: 1.5rem;
        font-weight: 800;
        color: #fff;
        margin: 10px 0 5px 0;
        letter-spacing: 1px;
    }

    .table-status-text {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        margin-top: 5px;
    }

    /* Badge Status */
    .badge-available {
        background: rgba(0, 242, 96, 0.2);
        color: #00f260;
    }

    .badge-occupied {
        background: rgba(255, 65, 108, 0.2);
        color: #ff416c;
    }

    /* Ikon Meja */
    .icon-wrapper svg {
        width: 40px;
        height: 40px;
        transition: transform 0.3s ease;
    }

    .table-card:hover .icon-wrapper svg {
        transform: rotate(5deg) scale(1.1);
    }

</style>

<div class="table-selection-wrapper">
    <div class="container-fluid">
        <!-- Header Halaman -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="page-title">Area Meja</h2>
                <p class="page-subtitle">Silakan pilih meja yang tersedia untuk memulai pesanan.</p>
            </div>
            <!-- Legenda Status Kecil di Pojok Kanan -->
            <div class="d-none d-md-flex gap-3">
                <div class="d-flex align-items-center gap-2">
                    <span style="width: 10px; height: 10px; background: #00f260; border-radius: 50%; box-shadow: 0 0 5px #00f260;"></span>
                    <span class="text-white small">Kosong</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span style="width: 10px; height: 10px; background: #ff416c; border-radius: 50%;"></span>
                    <span class="text-white small">Terisi</span>
                </div>
            </div>
        </div>

        <!-- Grid Meja -->
        <div class="tables-grid">
            @foreach($tables as $table)
                @php
                    $isAvailable = $table->status == 'available';
                    $route = $isAvailable ? route('waiters.order.create', $table->id) : '#';
                    $statusClass = $isAvailable ? 'status-available' : 'status-occupied';
                    $badgeClass = $isAvailable ? 'badge-available' : 'badge-occupied';
                    $statusText = $isAvailable ? 'Available' : 'Occupied';
                @endphp

                <a href="{{ $route }}" class="table-card {{ $statusClass }}">
                    <!-- Ikon Meja -->
                    <div class="icon-wrapper">
                        @if($isAvailable)
                            <!-- Ikon Meja Kosong (Outline) -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M10 14v10m4-10v10M12 4v2m0 0v2m0-2h.01" />
                                <rect x="4" y="6" width="16" height="8" rx="2" stroke-opacity="0.8"/>
                            </svg>
                        @else
                            <!-- Ikon Meja Terisi (Solid/User) -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        @endif
                    </div>

                    <!-- Nama Meja -->
                    <div class="table-name">{{ $table->name }}</div>

                    <!-- Status Text -->
                    <span class="table-status-text {{ $badgeClass }}">
                        {{ $statusText }}
                    </span>

                    @if(!$isAvailable)
                        <small style="font-size: 0.7rem; margin-top: 5px; opacity: 0.6;">Sedang digunakan</small>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection
