@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="pending-card card border-0 shadow-sm mx-auto">
        <div class="card-body text-center py-5">
            <div class="pending-icon mx-auto mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0h13A1.5 1.5 0 0 1 16 1.5v13a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5zM1.5 1a.5.5 0 0 0-.5.5V14.5a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5V1.5a.5.5 0 0 0-.5-.5zM4 4h8v1H4zM4 7h8v1H4zM4 10h5v1H4z"/>
                </svg>
            </div>
            <h1 class="h5 fw-bold mb-1">{{ $titulo }}</h1>
            <p class="text-muted mb-0">Este módulo está en construcción. Muy pronto vas a poder gestionar {{ strtolower($titulo) }} desde aquí.</p>
        </div>
    </div>
</div>

<style>
    .pending-card {
        max-width: 520px;
        border-radius: 1rem;
    }

    .pending-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: linear-gradient(135deg, #94a3b8, #64748b);
    }
</style>
@endsection
