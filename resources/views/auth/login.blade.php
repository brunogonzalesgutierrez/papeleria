@extends('layouts.app')

@section('content')
<div class="login-wrapper d-flex align-items-center justify-content-center">
    <div class="login-card card border-0 shadow-lg">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="login-icon mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                    </svg>
                </div>
                <h1 class="h4 fw-bold mb-1">Sistema Papelería</h1>
                <p class="text-muted mb-0">Inicia sesión para continuar</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-floating mb-3">
                    <input id="username" type="text"
                           class="form-control @error('username') is-invalid @enderror"
                           name="username" value="{{ old('username') }}"
                           required autocomplete="username" autofocus
                           placeholder="Usuario">
                    <label for="username">Usuario</label>

                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password" required autocomplete="current-password"
                           placeholder="Contraseña">
                    <label for="password">Contraseña</label>

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-muted" for="remember">
                            {{ __('Recordarme') }}
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="small text-decoration-none" href="{{ route('password.request') }}">
                            {{ __('¿Olvidaste tu contraseña?') }}
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                    {{ __('Iniciar sesión') }}
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .login-wrapper {
        min-height: calc(100vh - 180px);
        padding: 2.5rem 1rem;
        background: radial-gradient(circle at top, #eef2ff 0%, #f8fafc 60%);
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        border-radius: 1rem;
    }

    .login-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: linear-gradient(135deg, #4f7cff, #364fc7);
        box-shadow: 0 8px 20px -6px rgba(54, 79, 199, 0.55);
    }

    .login-card .form-control:focus {
        border-color: #4f7cff;
        box-shadow: 0 0 0 0.2rem rgba(79, 124, 255, 0.2);
    }

    .login-card .btn-primary {
        background: linear-gradient(135deg, #4f7cff, #364fc7);
        border: none;
    }

    .login-card .btn-primary:hover {
        background: linear-gradient(135deg, #3d69f0, #2c40ab);
    }
</style>
@endsection
