@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="h4 fw-bold mb-1">Dashboard</h1>
        <p class="text-muted mb-0">Resumen general del sistema — {{ now()->locale('es')->translatedFormat('d \d\e F \d\e Y') }}</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="kpi-label">Productos activos</div>
                    <div class="kpi-value">{{ $productosActivos }}</div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card card border-0 shadow-sm h-100 {{ $stockBajo > 0 ? 'kpi-warning' : '' }}">
                <div class="card-body">
                    <div class="kpi-label">Stock bajo</div>
                    <div class="kpi-value">{{ $stockBajo }}</div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="kpi-label">Ventas de hoy</div>
                    <div class="kpi-value">{{ $ventasHoy }}</div>
                    <div class="kpi-sub">Bs {{ number_format($totalVentasHoy, 2) }}</div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="kpi-card card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="kpi-label">Clientes activos</div>
                    <div class="kpi-value">{{ $clientesActivos }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3">
                    <h2 class="h6 fw-bold mb-0">Productos con stock bajo</h2>
                </div>
                <div class="card-body pt-0">
                    @forelse ($productosStockBajo as $producto)
                        <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div>
                                <div class="fw-semibold">{{ $producto->nombre }}</div>
                                <div class="text-muted small">{{ $producto->codigo }}</div>
                            </div>
                            <span class="badge rounded-pill text-bg-warning">
                                {{ $producto->stock_actual }} / mín. {{ $producto->stock_minimo }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">No hay productos con stock bajo por ahora.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-3">
                    <h2 class="h6 fw-bold mb-0">Accesos rápidos</h2>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('productos') }}" class="btn btn-outline-primary btn-sm">Productos</a>
                        <a href="{{ route('ventas') }}" class="btn btn-outline-primary btn-sm">Ventas</a>
                        <a href="{{ route('clientes') }}" class="btn btn-outline-primary btn-sm">Clientes</a>
                        <a href="{{ route('inventario') }}" class="btn btn-outline-primary btn-sm">Inventario</a>
                        <a href="{{ route('reportes') }}" class="btn btn-outline-primary btn-sm">Reportes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .kpi-card {
        border-radius: 0.9rem;
        border-left: 4px solid #4f7cff;
    }

    .kpi-card.kpi-warning {
        border-left-color: #f59f00;
    }

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

    .kpi-sub {
        color: #94a3b8;
        font-size: 0.85rem;
    }
</style>
@endsection
