@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="h4 fw-bold mb-1">Editar rol</h1>
        <p class="text-muted mb-0">{{ $rol->name }}</p>
    </div>

    <div class="card border-0 shadow-sm" style="max-width: 760px;">
        <div class="card-body">
            <form method="POST" action="{{ route('roles.update', $rol) }}">
                @csrf
                @method('PUT')
                @include('roles._form', ['rol' => $rol, 'permisosAsignados' => old('permisos', $permisosAsignados)])

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
