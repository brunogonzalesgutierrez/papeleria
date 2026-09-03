@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="h4 fw-bold mb-1">Nuevo rol</h1>
        <p class="text-muted mb-0">Ponle un nombre y marca los permisos que va a tener.</p>
    </div>

    <div class="card border-0 shadow-sm" style="max-width: 760px;">
        <div class="card-body">
            <form method="POST" action="{{ route('roles.store') }}">
                @csrf
                @include('roles._form', ['rol' => null, 'permisosAsignados' => old('permisos', [])])

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Guardar rol</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
