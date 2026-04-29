<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — {{ setting('site_name', config('app.name')) }}</title>

    @if(setting('site_logo'))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . setting('site_logo')) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            padding: 1rem;
            font-family: ui-sans-serif, system-ui, sans-serif;
        }

        .login-wrap {
            width: 100%;
            max-width: 860px;
        }

        .login-card {
            display: flex;
            flex-direction: row;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.12);
            max-height: 460px;
        }

        /* Image panel */
        .login-image {
            flex: 1;
            position: relative;
            overflow: hidden;
            min-height: 200px;
        }
        .login-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .login-image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.08), rgba(0,0,0,0.02));
        }

        /* Form panel */
        .login-form-panel {
            flex: 1;
            padding: 2.5rem 2.25rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: 1.5rem;
        }
        .login-logo img { height: 32px; width: auto; }
        .login-logo span {
            font-size: 1rem;
            font-weight: 800;
            color: #111;
            letter-spacing: -0.02em;
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111;
            margin: 0 0 0.25rem;
        }
        .login-subtitle {
            font-size: 0.8rem;
            color: #888;
            margin: 0 0 1.75rem;
        }

        .login-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.875rem;
            color: #111;
            outline: none;
            transition: border-color 0.2s;
            background: #fff;
        }
        .login-input:focus { border-color: #111; }
        .login-input.error { border-color: #f87171; }

        .login-error {
            margin: 0.35rem 0 0;
            font-size: 0.75rem;
            color: #ef4444;
        }

        .login-btn {
            width: 100%;
            padding: 0.85rem;
            background: #111;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s;
            margin-top: 0.5rem;
        }
        .login-btn:hover { opacity: 0.85; }

        .login-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 1.5rem;
            font-size: 0.8rem;
            color: #999;
            text-decoration: none;
            transition: color 0.2s;
        }
        .login-back:hover { color: #111; }

        .login-fields { display: flex; flex-direction: column; gap: 1rem; }

        /* ── Mobile ── */
        @media (max-width: 600px) {
            body { padding: 0; align-items: flex-start; background: #fff; }

            .login-wrap { max-width: 100%; }

            .login-card {
                flex-direction: column;
                border-radius: 0;
                box-shadow: none;
                min-height: 100vh;
            }

            .login-image {
                flex: none;
                height: 220px;
                width: 100%;
            }

            .login-form-panel {
                flex: 1;
                padding: 1.75rem 1.5rem 2rem;
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>

<div class="login-wrap">
    <div class="login-card">

        {{-- LEFT / TOP: Image --}}
        <div class="login-image">
            <img src="{{ asset('storage/images_static/bg_tio.jpg') }}" alt="Login Visual">
            <div class="login-image-overlay"></div>
        </div>

        {{-- RIGHT / BOTTOM: Form --}}
        <div class="login-form-panel">

            {{-- Logo --}}
            <a href="{{ route('frontend.home') }}" class="login-logo">
                @if(setting('site_logo'))
                    <img src="{{ asset('storage/' . setting('site_logo')) }}" alt="Logo">
                @endif
                <span>{{ setting('site_name', config('app.name')) }}</span>
            </a>

            <h2 class="login-title">Login</h2>
            <p class="login-subtitle">Masuk ke panel admin</p>

            {{-- Session Status --}}
            @if(session('status'))
                <div style="margin-bottom:1rem; padding:0.75rem 1rem; background:#ecfdf5; border:1px solid #6ee7b7; border-radius:8px; font-size:0.85rem; color:#065f46;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="login-fields">
                @csrf

                {{-- Email --}}
                <div>
                    <input id="email" type="email" name="email"
                           value="{{ old('email') }}"
                           required autofocus autocomplete="username"
                           placeholder="Email"
                           class="login-input {{ $errors->has('email') ? 'error' : '' }}">
                    @error('email')
                        <p class="login-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <input id="password" type="password" name="password"
                           required autocomplete="current-password"
                           placeholder="Password"
                           class="login-input {{ $errors->has('password') ? 'error' : '' }}">
                    @error('password')
                        <p class="login-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="login-btn">Login</button>
            </form>

            {{-- Back --}}
            <a href="{{ route('frontend.home') }}" class="login-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M12 5l-7 7 7 7"/>
                </svg>
                Kembali
            </a>
        </div>

    </div>
</div>

</body>
</html>
