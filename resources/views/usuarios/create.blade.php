@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1 class="h4 fw-bold mb-1">Nuevo usuario</h1>
        <p class="text-muted mb-0">Crea una cuenta y asígnale un rol.</p>
    </div>

    <div class="card border-0 shadow-sm" style="max-width: 640px;">
        <div class="card-body">
            <form method="POST" action="{{ route('usuarios.store') }}">
                @csrf
                @include('usuarios._form', ['usuario' => null])

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Guardar usuario</button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
