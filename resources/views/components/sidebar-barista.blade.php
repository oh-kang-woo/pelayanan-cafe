<aside class="c-sidebar">
    <div class="c-sidebar__top">
        <div class="c-sidebar__logo">
            <i class="fas fa-mug-hot"></i> SIKODING CAFE
        </div>

        <ul class="c-sidebar__menu">
            <li><a href="#" class="active"><i class="fas fa-th-large"></i> Dashboard</a></li>
            <li><a href="#"><i class="fas fa-list"></i> Daftar Pesanan</a></li>
            <li><a href="#"><i class="fas fa-coffee"></i> Menu Barista</a></li>
        </ul>
    </div>

    <div class="c-sidebar__bottom">
        <div class="c-filter-card">
            <span class="c-filter-label"><i class="fas fa-filter"></i> Filter Pesanan</span>

            <form action="{{ route('barista.orders.filter') }}" method="GET">
                <input type="date" name="date" class="c-input-date"
                       value="{{ request('date', date('Y-m-d')) }}">

                <button class="c-btn-filter">Tampilkan</button>
            </form>
        </div>
    </div>
</aside>
