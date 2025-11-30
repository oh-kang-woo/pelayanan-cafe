@extends('layouts.app')

@section('content')
<style>
    /* --- 1. SETUP LAYOUT & BACKGROUND --- */
    .login-wrapper-future {
        /* Menggunakan viewport height 100% agar full screen */
        min-height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        /* Gradiasi Radial: Pusat biru gelap menyebar ke hitam pekat */
        background: radial-gradient(circle at center, #0a192f 0%, #000000 100%);
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        position: relative;
        overflow: hidden;
    }

    /* Efek Grid Halus di Background (Opsional untuk nuansa Tech) */
    .login-wrapper-future::before {
        content: "";
        position: absolute;
        width: 200%;
        height: 200%;
        top: -50%;
        left: -50%;
        background-image:
            linear-gradient(rgba(0, 198, 255, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0, 198, 255, 0.03) 1px, transparent 1px);
        background-size: 30px 30px;
        transform: perspective(500px) rotateX(60deg);
        z-index: 0;
        pointer-events: none;
    }

    /* --- 2. CARD GLASSMORPHISM --- */
    .card-future {
        position: relative;
        z-index: 2;
        background: rgba(18, 25, 40, 0.75); /* Gelap transparan */
        backdrop-filter: blur(20px);        /* Blur kuat */
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-top: 1px solid rgba(0, 198, 255, 0.3); /* Highlight atas biru */
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.8),
                    0 0 20px rgba(0, 198, 255, 0.1); /* Glow ambient */
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        padding: 40px;
    }

    .card-future:hover {
        transform: translateY(-5px); /* Efek melayang saat hover */
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.9),
                    0 0 30px rgba(0, 198, 255, 0.15);
    }

    /* --- 3. TYPOGRAPHY & HEADER --- */
    .header-title {
        color: #fff;
        font-weight: 700;
        font-size: 1.8rem;
        letter-spacing: 1.5px;
        margin-bottom: 5px;
        text-shadow: 0 0 15px rgba(0, 198, 255, 0.6);
    }

    .header-subtitle {
        color: #8892b0;
        font-size: 0.9rem;
        margin-bottom: 30px;
    }

    /* Ikon Kafe Glowing */
    .icon-glow {
        color: #00c6ff;
        font-size: 3rem;
        margin-bottom: 15px;
        filter: drop-shadow(0 0 8px rgba(0, 198, 255, 0.6));
    }

    /* --- 4. FORM INPUTS --- */
    .form-group-custom {
        margin-bottom: 20px;
    }

    .label-future {
        color: #ccd6f6;
        font-size: 0.85rem;
        margin-bottom: 8px;
        display: block;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .input-future {
        width: 100%;
        background: rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
        padding: 12px 15px;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .input-future:focus {
        background: rgba(0, 10, 25, 0.8);
        border-color: #00c6ff;
        outline: none;
        box-shadow: 0 0 15px rgba(0, 198, 255, 0.3); /* Cahaya biru saat mengetik */
    }

    .input-future::placeholder {
        color: rgba(255, 255, 255, 0.3);
    }

    /* --- 5. BUTTON NEON --- */
    .btn-future {
        width: 100%;
        padding: 14px;
        background: linear-gradient(90deg, #0052d4, #4364f7, #6fb1fc);
        border: none;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        margin-top: 10px;
        box-shadow: 0 4px 15px rgba(0, 82, 212, 0.4);
    }

    .btn-future:hover {
        background: linear-gradient(90deg, #00c6ff, #0072ff);
        box-shadow: 0 0 20px rgba(0, 198, 255, 0.7), 0 0 40px rgba(0, 198, 255, 0.3);
        transform: scale(1.02);
        color: #fff;
    }

    /* --- 6. ALERTS --- */
    .alert-glow {
        background: rgba(255, 71, 87, 0.1);
        border: 1px solid rgba(255, 71, 87, 0.3);
        color: #ff6b81;
        padding: 10px;
        border-radius: 8px;
        font-size: 0.9rem;
        margin-bottom: 20px;
    }
</style>

<div class="login-wrapper-future">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">

                <div class="card-future">
                    <div class="text-center">
                        <div class="icon-glow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M.5 6a.5.5 0 0 0-.488.608l1.652 7.434A2.5 2.5 0 0 0 4.104 16h5.792a2.5 2.5 0 0 0 2.44-1.958l.131-.59a3 3 0 0 0 1.3-5.854l.221-.99A.5.5 0 0 0 14 6H.5ZM2.244 15c.324.88 1.146 1.482 2.06 1.482h5.792c.914 0 1.736-.602 2.06-1.482l1.366-6.146a.5.5 0 0 0-.488-.608L12.5 8.5H3.5l-1.366-.608a.5.5 0 0 0-.488.608L2.244 15Zm10.518-8.23c.36-.91.503-1.896.11-2.61-.396-.715-1.127-1.16-2.126-1.16H4.254c-.999 0-1.73.445-2.126 1.16-.393.714-.25 1.7.11 2.61h10.518ZM1.455 4.954C1.042 3.966 1.256 2.76 1.943 1.834 2.87.597 4.542 0 6.64 0h2.72c2.098 0 3.77.597 4.697 1.834.687.926.901 2.132.488 3.12H1.455Z"/>
                            </svg>
                        </div>

                        <h2 class="header-title">LOGIN KAFE</h2>
                        <p class="header-subtitle">Welcome to Future Coffee Experience</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert-glow">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf

                        <div class="form-group-custom">
                            <label for="email" class="label-future">Email Address</label>
                            <input type="email" name="email" class="input-future" placeholder="Enter your email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        </div>

                        <div class="form-group-custom">
                            <label for="password" class="label-future">Password</label>
                            <input type="password" name="password" class="input-future" placeholder="Enter your password" required autocomplete="current-password">
                        </div>

                        <button type="submit" class="btn-future">
                            Access System
                        </button>

                    </form>

                    <div class="text-center mt-4">
                        <small style="color: rgba(255,255,255,0.3); font-size: 0.75rem;">
                            &copy; {{ date('Y') }} Kafe Online System. All rights reserved.
                        </small>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
