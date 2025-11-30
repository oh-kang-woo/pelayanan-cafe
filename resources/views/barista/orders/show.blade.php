@extends('layouts.app')

@section('content')
<style>
    /* --- 1. GLOBAL SETTINGS (Clean Dark Mode) --- */
    .detail-wrapper {
        min-height: 100vh;
        padding: 40px 20px;
        background-color: #18181b;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: #e4e4e7;
    }

    /* --- 2. ORDER CARD CONTAINER (Classic Elegant + Accent) --- */
    .order-panel {
        background-color: #27272a;
        border: 1px solid #3f3f46;
        /* Tambahan: Aksen Warna di Atas */
        border-top: 4px solid #6366f1; /* Indigo Accent */
        border-radius: 12px;
        padding: 40px;
        max-width: 800px;
        margin: 0 auto;
        /* Tambahan: Bayangan halus berwarna indigo */
        box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.1), 0 8px 10px -6px rgba(99, 102, 241, 0.1);
        transition: transform 0.3s ease;
    }

    /* --- 3. HEADER SECTION --- */
    .order-header {
        border-bottom: 1px solid #52525b;
        padding-bottom: 20px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .table-title {
        font-size: 1.8rem;
        font-weight: 600;
        margin: 0;
        color: #fff;
        line-height: 1.2;
        letter-spacing: -0.5px;
    }

    .table-title span {
        color: #818cf8; /* Aksen Indigo Muda */
        font-weight: 400;
    }

    .order-meta {
        text-align: right;
        font-size: 0.9rem;
        color: #a1a1aa;
        font-family: monospace;
    }

    .customer-badge {
        display: inline-block;
        margin-top: 8px;
        font-size: 0.9rem;
        color: #d4d4d8;
        font-style: italic;
    }

    /* --- 4. ITEM LIST (Classic Row Style) --- */
    .item-list {
        display: flex;
        flex-direction: column;
    }

    .item-row {
        background-color: transparent;
        border-bottom: 1px solid #3f3f46;
        padding: 20px 15px; /* Sedikit padding samping agar hover rapi */
        margin: 0 -15px; /* Negative margin untuk kompensasi padding */
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .item-row:last-child {
        border-bottom: none;
    }

    /* Efek Hover List Item: Warna Background Halus */
    .item-row:hover {
        background-color: rgba(99, 102, 241, 0.08); /* Indigo transparan */
        border-bottom-color: transparent;
    }

    /* Detail Menu (Kiri) */
    .menu-details {
        flex-grow: 1;
        padding-right: 20px;
    }

    .menu-name {
        font-size: 1.1rem;
        font-weight: 500;
        color: #fff;
        margin: 0;
        letter-spacing: 0.5px;
    }

    /* QTY Text (Kanan) */
    .qty-text {
        font-size: 1.5rem;
        font-weight: 700;
        color: #a1a1aa;
        min-width: 50px;
        text-align: center;
        transition: color 0.3s;
    }

    .item-row:hover .qty-text {
        color: #fff; /* Angka jadi putih saat hover */
    }

    /* Highlight QTY > 1 */
    .qty-high {
        color: #f59e0b; /* Kuning Amber */
    }

    /* Catatan Khusus (Notes) */
    .menu-note {
        display: block;
        margin-top: 6px;
        font-size: 0.85rem;
        color: #f87171; /* Merah soft */
        font-style: italic;
    }

    .menu-note svg {
        width: 14px;
        height: 14px;
        margin-right: 4px;
        vertical-align: middle;
    }

    /* --- 5. ACTION BUTTONS --- */
    .action-area {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #3f3f46;
    }

    .btn-finish {
        width: 100%;
        background-color: #e4e4e7; /* Abu terang */
        color: #18181b; /* Teks Gelap */
        border: 2px solid transparent; /* Persiapan untuk border hover */
        padding: 16px;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    /* Efek Hover Button: Glow Berwarna */
    .btn-finish:hover {
        background-color: #2361d3;
        color: #e3e2ec; /* Teks berubah jadi Indigo */
        border-color: #818cf8; /* Border halus */
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.4); /* Glow Indigo */
        transform: translateY(-2px);
    }

    .ready-banner {
        border: 1px solid #10b981;
        background-color: rgba(16, 185, 129, 0.1); /* Background hijau transparan */
        color: #10b981;
        padding: 15px;
        text-align: center;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .back-link {
        color: #71717a;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 24px;
        font-size: 0.9rem;
        font-weight: 500;
        transition: color 0.2s;
    }

    .back-link:hover {
        color: #818cf8; /* Hover jadi warna aksen */
    }
</style>

<div class="detail-wrapper">

    <!-- Tombol Kembali -->
    <a href="{{ route('barista.orders.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali
    </a>

    <div class="order-panel">
        <!-- Header -->
        <div class="order-header">
            <div>
                <h1 class="table-title">Meja <span>{{ $order->table->name }}</span></h1>
                @if($order->customer_name)
                    <div class="customer-badge">
                        Customer: {{ $order->customer_name }}
                    </div>
                @endif
            </div>
            <div class="order-meta">
                <div>#{{ $order->id }}</div>
                <div style="margin-top: 4px;">{{ $order->created_at->format('H:i') }}</div>
            </div>
        </div>

        <!-- List Item -->
        <div class="item-list">
            @foreach ($order->items as $item)
                <div class="item-row">
                    <!-- Detail Menu (Left Side) -->
                    <div class="menu-details">
                        <div class="menu-name">{{ $item->menu->name }}</div>

                        <!-- Catatan Khusus -->
                        @if(!empty($item->notes) && $item->notes != '-')
                            <div class="menu-note">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                {{ $item->notes }}
                            </div>
                        @endif
                    </div>

                    <!-- QTY Text (Right Side - Tanpa Kotak) -->
                    <div class="qty-text {{ $item->quantity > 1 ? 'qty-high' : '' }}">
                        {{ $item->quantity }}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Tombol Aksi -->
        <div class="action-area">
            @if ($order->status !== 'ready')
                <form action="{{ route('barista.orders.ready', $order->id) }}" method="POST">
                    @csrf
                    <button class="btn-finish">
                        Tandai Selesai
                    </button>
                </form>
            @else
                <div class="ready-banner">
                    Pesanan Selesaia
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
