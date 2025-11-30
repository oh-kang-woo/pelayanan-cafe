@extends('layouts.app')

@section('content')
<style>
    /* --- 1. GLOBAL LAYOUT & BACKGROUND --- */
    .order-page-wrapper {
        min-height: 100vh;
        padding: 40px 20px;
        /* Gradiasi radial gelap yang konsisten */
        background: radial-gradient(circle at top left, #0f2027, #203a43, #2c5364);
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        color: #fff;
    }

    /* --- 2. GLASS CARD CONTAINER --- */
    .glass-container {
        background: rgba(18, 25, 40, 0.75);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-top: 1px solid rgba(0, 198, 255, 0.3);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        max-width: 900px;
        margin: 0 auto; /* Center the card */
    }

    /* --- 3. TYPOGRAPHY --- */
    .page-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 5px;
        color: #fff;
        text-shadow: 0 0 10px rgba(0, 198, 255, 0.5);
    }

    .table-badge {
        display: inline-block;
        background: rgba(0, 198, 255, 0.15);
        border: 1px solid rgba(0, 198, 255, 0.4);
        color: #00c6ff;
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 25px;
        letter-spacing: 1px;
    }

    /* --- 4. FORM INPUTS (Customer Info) --- */
    .form-group-future {
        margin-bottom: 20px;
    }

    .label-future {
        display: block;
        color: #aab2bd;
        margin-bottom: 8px;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }

    .input-future {
        width: 100%;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        padding: 12px 15px;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .input-future:focus {
        background: rgba(0, 0, 0, 0.5);
        border-color: #00c6ff;
        box-shadow: 0 0 15px rgba(0, 198, 255, 0.3);
        outline: none;
    }

    /* --- 5. MENU GRID SYSTEM (Pengganti Table) --- */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 30px;
        margin-bottom: 30px;
    }

    .menu-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 15px;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: transform 0.3s ease, border-color 0.3s ease;
    }

    .menu-card:hover {
        transform: translateY(-3px);
        border-color: rgba(0, 198, 255, 0.5);
        background: rgba(255, 255, 255, 0.06);
    }

    .menu-info h4 {
        margin: 0 0 5px 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #fff;
    }

    .menu-price {
        color: #00f260; /* Hijau Neon untuk harga */
        font-weight: 500;
        font-size: 0.95rem;
    }

    /* --- 6. QUANTITY INPUT STYLING --- */
    .qty-wrapper {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .qty-label {
        font-size: 0.7rem;
        color: #888;
        margin-bottom: 3px;
    }

    .input-qty {
        width: 70px;
        background: rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        padding: 8px;
        color: #fff;
        text-align: center;
        font-weight: bold;
        font-size: 1.1rem;
    }

    .input-qty:focus {
        border-color: #00c6ff;
        outline: none;
        background: rgba(0, 0, 0, 0.6);
    }

    /* --- 7. SUBMIT BUTTON --- */
    .btn-submit-order {
        width: 100%;
        padding: 15px;
        background: linear-gradient(90deg, #0052d4, #4364f7, #6fb1fc);
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 82, 212, 0.4);
        margin-top: 10px;
    }

    .btn-submit-order:hover {
        background: linear-gradient(90deg, #00c6ff, #0072ff);
        box-shadow: 0 0 25px rgba(0, 198, 255, 0.6);
        transform: scale(1.01);
    }

</style>

<div class="order-page-wrapper">
    <div class="container">

        <div class="glass-container">
            <!-- Header Section -->
            <div class="text-center md:text-left">
                <h2 class="page-title">Buat Order Baru</h2>
                <div class="table-badge">
                    Meja: {{ $table->name }}
                </div>
            </div>

            <form action="{{ route('waiters.order.store') }}" method="POST">
                @csrf
                <input type="hidden" name="table_id" value="{{ $table->id }}">

                <!-- Customer Details Section -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group-future">
                            <label class="label-future">Nama Customer</label>
                            <input type="text" name="customer_name" class="input-future" placeholder="Masukkan nama pelanggan..." required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-future">
                            <label class="label-future">No. HP (Opsional)</label>
                            <input type="text" name="customer_phone" class="input-future" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>
                </div>

                <hr style="border-color: rgba(255,255,255,0.1); margin: 20px 0;">

                <!-- Menu Selection Section (Grid) -->
                <h4 style="color: #fff; font-weight: 600; margin-bottom: 15px;">Pilih Menu</h4>

                <div class="menu-grid">
                    @foreach($menus as $menu)
                        <div class="menu-card">
                            <div class="menu-info">
                                <h4>{{ $menu->name }}</h4>
                                <span class="menu-price">Rp {{ number_format($menu->price) }}</span>
                            </div>
                            <div class="qty-wrapper">
                                <span class="qty-label">Qty</span>
                                <input type="number"
                                       name="menus[{{ $menu->id }}]"
                                       value="0"
                                       min="0"
                                       class="input-qty"
                                       onfocus="if(this.value=='0') this.value=''">
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Submit Action -->
                <div class="mt-4">
                    <button type="submit" class="btn-submit-order">
                        Konfirmasi & Buat Pesanan
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection
