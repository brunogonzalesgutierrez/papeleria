@php
    $rolActual = $usuario?->roles->first()?->name;
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Nombre completo</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $usuario?->name) }}" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Usuario (para iniciar sesión)</label>
        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
               value="{{ old('username', $usuario?->username) }}" required>
        @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $usuario?->email) }}" required>
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Empleado vinculado (opcional)</label>
        <select name="empleado_id" class="form-select @error('empleado_id') is-invalid @enderror">
            <option value="">— Ninguno —</option>
            @foreach ($empleados as $empleado)
                <option value="{{ $empleado->id }}" @selected(old('empleado_id', $usuario?->empleado_id) == $empleado->id)>
                    {{ $empleado->nombre_completo }}
                </option>
            @endforeach
        </select>
        @error('empleado_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Contraseña {{ $usuario ? '(dejar vacío para no cambiarla)' : '' }}</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
               {{ $usuario ? '' : 'required' }}>
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Rol</label>
        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
            <option value="">— Selecciona un rol —</option>
            @foreach ($roles as $rol)
                <option value="{{ $rol->name }}" @selected(old('role', $rolActual) === $rol->name)>
                    {{ $rol->name }}
                </option>
            @endforeach
        </select>
        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select @error('estado') is-invalid @enderror">
            <option value="activo" @selected(old('estado', $usuario?->estado ?? 'activo') === 'activo')>Activo</option>
            <option value="inactivo" @selected(old('estado', $usuario?->estado) === 'inactivo')>Inactivo</option>
        </select>
        @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
