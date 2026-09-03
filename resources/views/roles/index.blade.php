@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1">Roles y permisos</h1>
            <p class="text-muted mb-0">Define qué puede hacer cada tipo de usuario en el sistema.</p>
        </div>
        <div class="d-flex gap-2">
            @can('usuarios.ver')
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">← Usuarios</a>
            @endcan
            @can('roles.crear')
                <a href="{{ route('roles.create') }}" class="btn btn-primary">+ Nuevo rol</a>
            @endcan
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-3">
        @foreach ($roles as $i => $rol)
            @php
                $colorClase = 'role-card-' . ($i % 4);
                $numPermisos = $rol->permissions()->count();
            @endphp
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 role-card {{ $colorClase }}">
                    <div class="card-body">
                        <div class="role-icon mb-3">{{ strtoupper(substr($rol->name, 0, 1)) }}</div>

                        <h2 class="h6 fw-bold mb-1">{{ $rol->name }}</h2>
                        <p class="text-muted small mb-3">
                            {{ $rol->users_count }} {{ $rol->users_count === 1 ? 'usuario' : 'usuarios' }} ·
                            {{ $numPermisos }} {{ $numPermisos === 1 ? 'permiso' : 'permisos' }}
                        </p>

                        <div class="progress role-progress mb-3" style="height: 6px;">
                            <div class="progress-bar" style="width: {{ $totalPermisos > 0 ? round(($numPermisos / $totalPermisos) * 100) : 0 }}%"></div>
                        </div>

                        <div class="d-flex gap-2">
                            @can('roles.editar')
                                <a href="{{ route('roles.edit', $rol) }}" class="btn btn-sm btn-outline-primary">Editar permisos</a>
                            @endcan
                            @can('roles.eliminar')
                                <form action="{{ route('roles.destroy', $rol) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar este rol?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .role-card {
        border-radius: 0.9rem;
        border-top: 4px solid #4f7cff;
    }

    .role-icon {
        width: 42px;
        height: 42px;
        border-radius: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        color: #fff;
        background: linear-gradient(135deg, #4f7cff, #364fc7);
    }

    .role-progress {
        border-radius: 999px;
        background-color: #eef2ff;
    }

    .role-progress .progress-bar {
        background: linear-gradient(135deg, #4f7cff, #364fc7);
        border-radius: 999px;
    }

    .role-card-1 { border-top-color: #2f9e44; }
    .role-card-1 .role-icon { background: linear-gradient(135deg, #40c463, #2f9e44); }
    .role-card-1 .role-progress .progress-bar { background: linear-gradient(135deg, #40c463, #2f9e44); }

    .role-card-2 { border-top-color: #f59f00; }
    .role-card-2 .role-icon { background: linear-gradient(135deg, #ffb84d, #f59f00); }
    .role-card-2 .role-progress .progress-bar { background: linear-gradient(135deg, #ffb84d, #f59f00); }

    .role-card-3 { border-top-color: #d6336c; }
    .role-card-3 .role-icon { background: linear-gradient(135deg, #f06595, #d6336c); }
    .role-card-3 .role-progress .progress-bar { background: linear-gradient(135deg, #f06595, #d6336c); }
</style>
@endsection
