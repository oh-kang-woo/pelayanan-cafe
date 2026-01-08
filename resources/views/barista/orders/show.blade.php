@extends('layouts.app')

@section('content')
<style>
    /* --- 1. GLOBAL SETTINGS (Dark Coffee Theme) --- */
    .detail-wrapper {
        min-height: 100vh;
        padding: 40px 20px;
        background: linear-gradient(180deg, #161412, #1c1b19);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: #e6e1d8; /* Cream Coffee */
    }

    /* --- 2. ORDER PANEL (Classic Cafe + Futuristic Touch) --- */
    .order-panel {
        background: #1f1e1c;
        border: 1px solid #3d3a36;
        border-top: 4px solid #c59d5f; /* Gold Café */
        border-radius: 14px;
        padding: 40px;
        max-width: 820px;
        margin: 0 auto;
        box-shadow:
            0 12px 28px -6px rgba(0, 0, 0, 0.5),
            0 8px 20px -8px rgba(197, 157, 95, 0.25);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .order-panel:hover {
        box-shadow:
            0 18px 32px -4px rgba(0, 0, 0, 0.6),
            0 0 25px rgba(39, 155, 255, 0.15); /* Blue glow futuristik */
    }

    /* --- 3. HEADER --- */
    .order-header {
        border-bottom: 1px solid #3d3a36;
        padding-bottom: 20px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .table-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #f4f1ea;
        letter-spacing: -0.5px;
    }

    .table-title span {
        color: #c59d5f; /* Gold accent */
        font-weight: 500;
    }

    .order-meta {
        text-align: right;
        font-size: 0.9rem;
        color: #b8b4ad;
        font-family: monospace;
    }

    .customer-badge {
        margin-top: 8px;
        font-size: 0.9rem;
        font-style: italic;
        color: #d8d2c8;
    }

    /* --- 4. ITEM ROW / LIST --- */
    .item-list {
        display: flex;
        flex-direction: column;
    }

    .item-row {
        padding: 20px 15px;
        margin: 0 -15px;
        border-bottom: 1px solid #3c3936;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 10px;
        transition: all 0.25s ease;
    }

    .item-row:last-child {
        border-bottom: none;
    }

    .item-row:hover {
        background: rgba(197, 157, 95, 0.08); /* Gold soft */
        border-bottom-color: transparent;
        transform: translateX(4px);
    }

    .menu-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: #f4f1ea;
    }

    .menu-note {
        margin-top: 6px;
        font-size: 0.85rem;
        color: #ffb4a2;
        font-style: italic;
        display: flex;
        align-items: center;
        column-gap: 4px;
    }

    .qty-text {
        font-size: 1.5rem;
        font-weight: 700;
        min-width: 50px;
        text-align: center;
        color: #c0bcb5;
        transition: color 0.2s ease;
    }

    .item-row:hover .qty-text {
        color: #fff;
    }

    .qty-high {
        color: #eab308; /* Amber Highlight */
    }

    /* --- 5. ACTION AREA --- */
    .action-area {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #3c3a36;
    }

    .btn-finish {
        width: 100%;
        padding: 16px;
        background: #c59d5f; /* Cafe Gold */
        color: #1a1a1a;
        border-radius: 8px;
        font-weight: 700;
        letter-spacing: 1px;
        border: none;
        cursor: pointer;

        transition:
            background 0.3s ease,
            transform 0.25s ease,
            box-shadow 0.25s ease;
    }

    .btn-finish:hover {
        background: #e6c281;
        transform: translateY(-3px);
        box-shadow: 0 0 18px rgba(197, 157, 95, 0.4);
    }

    .btn-finish:active {
        transform: translateY(0);
        box-shadow: none;
    }

    .ready-banner {
        border: 1px solid #10b981;
        background-color: rgba(16, 185, 129, 0.12);
        color: #10b981;
        padding: 15px;
        text-align: center;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 1px;
    }

    .back-link {
        color: #a8a49e;
        display: inline-flex;
        gap: 8px;
        align-items: center;
        margin-bottom: 25px;
        font-size: 0.92rem;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .back-link:hover {
        color: #c59d5f;
    }

    /* FIX — agar tombol bisa diklik */
.action-area {
    position: relative;
    z-index: 10;
}

.btn-finish {
    position: relative;
    z-index: 10;
}

/* FIX — cegah overlap item */
.item-row {
    position: relative;
    z-index: 1;
}

</style>

<div class="detail-wrapper">

    <!-- Back -->
    <a href="{{ route('barista.orders.index') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
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
                <div style="margin-top:4px;">{{ $order->created_at->format('H:i') }}</div>
            </div>
        </div>

        <!-- Item List -->
        <div class="item-list">
            @foreach ($order->items as $item)
                <div class="item-row">
                    <div class="menu-details">
                        <div class="menu-name">{{ $item->menu->name }}</div>

                        @if(!empty($item->notes) && $item->notes != '-')
                            <div class="menu-note">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667
                                           1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464
                                           0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                {{ $item->notes }}
                            </div>
                        @endif
                    </div>

                    <div class="qty-text {{ $item->quantity > 1 ? 'qty-high' : '' }}">
                        {{ $item->quantity }}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Action -->
        <div class="action-area">
                <form action="{{ route('barista.orders.ready', $order->id) }}" method="POST">
                    @csrf
                    <button class="btn-finish">
                        Tandai Selesai
                    </button>
                </form>
        </div>

    </div>
</div>
@endsection
