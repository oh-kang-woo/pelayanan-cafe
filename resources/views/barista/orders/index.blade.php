@extends('layouts.app')

@section('content')
<style>
    /* --- 1. LAYOUT --- */
    .barista-wrapper {
        min-height: 100vh;
        padding: 40px 20px;
        background: radial-gradient(circle at bottom, #0f1219, #090a0f);
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        color: #fff;
    }

    .page-header {
        margin-bottom: 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 20px;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        background: linear-gradient(90deg, #fff, #aab2bd);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* --- GRID --- */
    .orders-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 25px;
    }

    /* --- CARD --- */
    .order-card {
        background: rgba(25, 30, 45, 0.6);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 25px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 220px;
        transition: 0.3s ease;
    }

    .order-card:hover {
        transform: translateY(-5px) scale(1.02);
        background: rgba(25, 30, 45, 0.8);
        box-shadow: 0 15px 30px rgba(0,0,0,0.5);
    }

    /* BORDER STATUS */
    .status-border-pending { border-top: 3px solid #ff9f43; }
    .status-border-processing { border-top: 3px solid #00c6ff; }
    .status-border-completed { border-top: 3px solid #00f260; }

    /* --- CARD HEADER --- */
    .card-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 18px;
    }

    .table-info h5 {
        font-size: 1.4rem;
        margin: 3px 0 0;
        font-weight: 700;
    }

    .table-info span {
        font-size: 0.8rem;
        color: #8892b0;
        letter-spacing: 1px;
    }

    .time-badge {
        background: rgba(255, 255, 255, 0.1);
        padding: 6px 10px;
        border-radius: 8px;
        font-family: 'Courier New', monospace;
        font-weight: 700;
        color: #ccd6f6;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.9rem;
    }

    /* STATUS BADGE */
    .status-badge {
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 15px;
        display: inline-block;
    }

    .badge-pending { background: rgba(255, 159, 67, 0.2); color: #ff9f43; }
    .badge-processing { background: rgba(0, 198, 255, 0.2); color: #00c6ff; }
    .badge-completed { background: rgba(0, 242, 96, 0.2); color: #00f260; }

    .btn-action {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid rgba(255,255,255,0.2);
        background: transparent;
        color: #fff;
        font-weight: 600;
        letter-spacing: 1px;
        transition: 0.3s ease;
        text-align: center;
        text-decoration: none;
    }

    .btn-action:hover {
        background: #fff;
        color: #000;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        background-color: #ff9f43;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
        animation: pulse-animation 2s infinite;
    }

    @keyframes pulse-animation {
        0% { box-shadow: 0 0 0 0 rgba(255, 159, 67, 0.7); }
        70% { box-shadow: 0 0 0 6px rgba(255, 159, 67, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 159, 67, 0); }
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        color: #8892b0;
        padding: 50px 0;
    }
</style>

<div class="barista-wrapper">
    <div class="container-fluid">

        <!-- HEADER -->
        <div class="page-header">
            <div>
                <h2 class="page-title">Kitchen Display</h2>
                <small style="color: #8892b0;">Pantau dan proses pesanan masuk secara real-time</small>
            </div>

            <div style="font-size: 1.5rem; font-weight:700; color:#00c6ff;">
                {{ now()->format('H:i') }}
            </div>
        </div>

        @if(count($notifications) > 0)
            <div style="margin-bottom: 25px; padding: 20px; background:#1e2536; border-radius:10px;">
                <h4 style="margin-bottom: 15px;">Notifikasi</h4>

                @foreach ($notifications as $n)
                    <div style="padding: 12px; border-bottom:1px solid rgba(255,255,255,0.1);">
                        <strong>{{ $n->title }}</strong><br>
                        <small>{{ $n->message }}</small>
                    </div>
                @endforeach
            </div>
        @endif


        <!-- GRID -->
        <div class="orders-grid">
            @forelse ($orders as $order)
                @php
                    $status = strtolower($order->status);
                    $borderClass = match($status) {
                        'processing' => 'status-border-processing',
                        'ready', 'completed' => 'status-border-completed',
                        default => 'status-border-pending'
                    };
                    $badgeClass = match($status) {
                        'processing' => 'badge-processing',
                        'ready', 'completed' => 'badge-completed',
                        default => 'badge-pending'
                    };
                    $btnText = match($status) {
                        'processing' => 'Lanjut Proses',
                        'ready', 'completed' => 'Lihat Detail',
                        default => 'Proses Pesanan'
                    };
                @endphp

                <div class="order-card {{ $borderClass }}">

                    <!-- HEADER -->
                    <div class="card-header-flex">
                        <div class="table-info">
                            <span>Order #{{ $order->id }}</span>
                            <h5>Meja: {{ $order->table->name }}</h5>
                        </div>

                        <div class="time-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            </svg>
                            {{ $order->created_at->format('H:i') }}
                        </div>
                    </div>

                    <!-- BODY -->
                    <div>
                        <div class="status-badge {{ $badgeClass }}">
                            @if($status == 'pending') <span class="pulse-dot"></span> @endif
                            {{ strtoupper($order->status) }}
                        </div>

                        <div style="color: #aab2bd; font-size: 0.9rem;">
                            Customer:
                            <strong style="color:#fff;">
                                {{ $order->customer_name ?? 'Guest' }}
                            </strong>
                        </div>
                    </div>

                    <!-- FOOTER -->
                    <a href="{{ route('barista.orders.show', $order->id) }}" class="btn-action" style="margin-top: 25px;">
                        {{ $btnText }}
                    </a>

                </div>

            @empty
                <div class="empty-state">
                    <h4>Tidak ada pesanan.</h4>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
