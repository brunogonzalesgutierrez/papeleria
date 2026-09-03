@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1">Usuarios</h1>
            <p class="text-muted mb-0">Cuentas del sistema y el rol que tiene cada una.</p>
        </div>
        @can('usuarios.crear')
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary">+ Nuevo usuario</a>
        @endcan
    </div>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="kpi-label">Total usuarios</div>
                    <div class="kpi-value">{{ $totalUsuarios }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card card border-0 shadow-sm h-100 kpi-success">
                <div class="card-body">
                    <div class="kpi-label">Activos</div>
                    <div class="kpi-value">{{ $totalActivos }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card card border-0 shadow-sm h-100 {{ $totalInactivos > 0 ? 'kpi-warning' : '' }}">
                <div class="card-body">
                    <div class="kpi-label">Inactivos</div>
                    <div class="kpi-value">{{ $totalInactivos }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="kpi-label">Roles definidos</div>
                    <div class="kpi-value">{{ $totalRoles }}</div>
                    @can('roles.ver')
                        <a href="{{ route('roles.index') }}" class="kpi-sub-link">Gestionar roles →</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="GET" class="mb-3">
                <div class="input-group" style="max-width: 340px;">
                    <span class="input-group-text bg-white border-end-0">
                        <svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="7" cy="7" r="5.5" stroke="#94a3b8" stroke-width="1.4"/>
                            <path d="M11 11L14.5 14.5" stroke="#94a3b8" stroke-width="1.4" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <input type="text" name="q" class="form-control border-start-0 ps-0" placeholder="Buscar por nombre, usuario o email"
                           value="{{ request('q') }}">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table align-middle usuarios-table">
                    <thead>
                        <tr class="text-muted small text-uppercase">
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usuarios as $usuario)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar">{{ strtoupper(substr($usuario->name, 0, 1)) }}</div>
                                        <div>
                                            <div class="fw-semibold">
                                                {{ $usuario->name }}
                                                @if ($usuario->id === auth()->id())
                                                    <span class="badge rounded-pill text-bg-light border ms-1 fw-normal">Tú</span>
                                                @endif
                                            </div>
                                            <div class="text-muted small">{{ '@' . $usuario->username }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted">{{ $usuario->email }}</td>
                                <td>
                                    @forelse ($usuario->roles as $rol)
                                        <span class="badge rounded-pill role-badge role-badge-{{ crc32($rol->name) % 4 }}">{{ $rol->name }}</span>
                                    @empty
                                        <span class="text-muted small">Sin rol</span>
                                    @endforelse
                                </td>
                                <td>
                                    <span class="badge rounded-pill {{ $usuario->estado === 'activo' ? 'text-bg-success' : 'text-bg-secondary' }}">
                                        {{ ucfirst($usuario->estado) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-2">
                                        @can('usuarios.editar')
                                            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                            @if ($usuario->id !== auth()->id())
                                                <form action="{{ route('usuarios.estado', $usuario) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                        {{ $usuario->estado === 'activo' ? 'Desactivar' : 'Activar' }}
                                                    </button>
                                                </form>
                                            @endif
                                        @endcan
                                        @can('usuarios.eliminar')
                                            @if ($usuario->id !== auth()->id())
                                                <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('¿Eliminar este usuario?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                                </form>
                                            @endif
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <div class="mb-2">No hay usuarios que coincidan con la búsqueda.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $usuarios->links() }}
        </div>
    </div>
</div>

<style>
    .kpi-card {
        border-radius: 0.9rem;
        border-left: 4px solid #4f7cff;
    }

    .kpi-card.kpi-success { border-left-color: #2f9e44; }
    .kpi-card.kpi-warning { border-left-color: #f59f00; }

    .kpi-label {
        color: #64748b;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }

    .kpi-value {
        font-size: 1.9rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.2;
    }

    .kpi-sub-link {
        font-size: 0.8rem;
        color: #4f7cff;
        text-decoration: none;
        font-weight: 600;
    }

    .kpi-sub-link:hover { color: #364fc7; }

    .usuarios-table th {
        border-top: none;
        letter-spacing: 0.03em;
    }

    .user-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f7cff, #364fc7);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .role-badge {
        border: 1px solid transparent;
        font-weight: 600;
        font-size: 0.74rem;
    }

    .role-badge-0 { background: #eef2ff; color: #4338ca; }
    .role-badge-1 { background: #ecfdf5; color: #15803d; }
    .role-badge-2 { background: #fff7ed; color: #c2410c; }
    .role-badge-3 { background: #fdf2f8; color: #be185d; }
</style>
@endsection
