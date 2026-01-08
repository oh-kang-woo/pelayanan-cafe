<style>
/* ===== NAVBAR ===== */
.navbar {
    width: 100%;
    background: #1c1b1a;
    border-bottom: 2px solid #c59d5f;
    padding: 14px 25px;
    position: sticky;
    top: 0;
    z-index: 9999;

    display: flex;
    justify-content: space-between;
    align-items: center;

    font-family: 'Inter', sans-serif;
    color: #f4f1ea;
}

/* BRAND */
.navbar-brand {
    font-size: 1.4rem;
    font-weight: 800;
    color: #c59d5f;
    letter-spacing: 1px;
}

/* RIGHT SECTION */
.navbar-right {
    display: flex;
    align-items: center;
    gap: 22px;
}

/* ROLE BADGE */
.role-badge {
    background: #c59d5f22;
    padding: 6px 12px;
    border-radius: 6px;
    border: 1px solid #c59d5f55;
    font-size: 0.85rem;
    color: #e6e1d8;
}

/* ===== NOTIFICATION BELL ===== */
.notif-bell {
    position: relative;
    cursor: pointer;
    font-size: 20px;
}

.notif-badge {
    position: absolute;
    top: -5px;
    right: -8px;
    background: red;
    color: white;
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 50%;
}

.notif-dropdown {
    display: none;
    position: absolute;
    right: 0;
    top: 35px;
    width: 260px;
    background: #1f1f1f;
    border: 1px solid #333;
    border-radius: 6px;
    padding: 10px;
    color: white;
}

.notif-item {
    padding: 8px 0;
    font-size: 13px;
    border-bottom: 1px solid #444;
}

/* ===== USER DROPDOWN ===== */
.dropdown {
    position: relative;
}

.dropdown-toggle {
    cursor: pointer;
    font-weight: 600;
}

.dropdown-menu {
    display: none;
    position: absolute;
    right: 0;
    top: 35px;
    background: #1f1f1f;
    border: 1px solid #333;
    border-radius: 6px;
    min-width: 170px;
    padding: 10px 0;
}

.dropdown-menu a,
.dropdown-menu form button {
    width: 100%;
    padding: 10px 20px;
    background: none;
    border: none;
    text-align: left;
    color: #e6e1d8;
    cursor: pointer;
}

.dropdown-menu a:hover,
.dropdown-menu form button:hover {
    background: #c59d5f22;
    color: #c59d5f;
}
</style>

@php
$notifs = \App\Models\Notification::where('user_id', auth()->id())
    ->where('is_read', false)
    ->latest()
    ->limit(10)
    ->get();
@endphp

<div class="navbar">
    <div class="navbar-brand">Kafe Online</div>

    <div class="navbar-right">

        {{-- NOTIFICATION BELL --}}
        <div class="notif-bell" id="notifBell">
            🔔
            @if($notifs->count())
                <span class="notif-badge">{{ $notifs->count() }}</span>
            @endif

            <div class="notif-dropdown" id="notifDropdown">
                @forelse($notifs as $n)
                    <div class="notif-item">
                        <strong>{{ $n->title }}</strong><br>
                        <span>{{ $n->message }}</span>
                    </div>
                @empty
                    <div style="text-align:center;">Tidak ada notifikasi</div>
                @endforelse
            </div>
        </div>

        {{-- ROLE BADGE --}}
        <div class="role-badge">
            {{ auth()->check() ? auth()->user()->role : 'Guest' }}
        </div>

        {{-- USER DROPDOWN --}}
        @auth
        <div class="dropdown">
            <div class="dropdown-toggle" id="dropdownUser">
                {{ auth()->user()->name }}
            </div>

            <div class="dropdown-menu" id="dropdownMenu">
                <a href="#">Profil Saya</a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button>Logout</button>
                </form>
            </div>
        </div>
        @endauth

        @guest
            <a href="{{ route('login') }}" style="color:white; font-weight:600;">Login</a>
        @endguest
    </div>
</div>

<script>
document.getElementById('notifBell').addEventListener('click', function(e){
    e.stopPropagation();
    let panel = document.getElementById('notifDropdown');
    panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
});

document.getElementById('dropdownUser')?.addEventListener('click', function(e){
    e.stopPropagation();
    let menu = document.getElementById('dropdownMenu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
});

document.addEventListener('click', function(){
    document.getElementById('notifDropdown').style.display = 'none';
    document.getElementById('dropdownMenu').style.display = 'none';
});
</script>
