<div class="mb-4">
    <label class="form-label">Nombre del rol</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $rol?->name) }}" required>
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div>
    <label class="form-label d-block mb-2">Permisos</label>

    @foreach ($permisos as $modulo => $permisosDelModulo)
        <div class="permiso-modulo mb-2">
            <div class="d-flex justify-content-between align-items-center permiso-modulo-header">
                <div class="fw-semibold text-capitalize">{{ $modulo }}</div>
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input toggle-modulo" type="checkbox"
                           data-modulo="modulo-{{ $modulo }}"
                           id="toggle-{{ $modulo }}">
                    <label class="form-check-label small text-muted" for="toggle-{{ $modulo }}">Todos</label>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-3 permiso-modulo-body" data-modulo-group="modulo-{{ $modulo }}">
                @foreach ($permisosDelModulo as $permiso)
                    <div class="form-check">
                        <input class="form-check-input permiso-checkbox" type="checkbox" name="permisos[]"
                               value="{{ $permiso->name }}" id="permiso-{{ $permiso->id }}"
                               data-modulo="modulo-{{ $modulo }}"
                               @checked(in_array($permiso->name, $permisosAsignados))>
                        <label class="form-check-label small" for="permiso-{{ $permiso->id }}">
                            {{ explode('.', $permiso->name)[1] ?? $permiso->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<style>
    .permiso-modulo {
        border: 1px solid #e9ecef;
        border-radius: 0.65rem;
        padding: 0.75rem 1rem;
    }

    .permiso-modulo-header {
        margin-bottom: 0.5rem;
    }

    .permiso-modulo-body .form-check-label {
        text-transform: capitalize;
    }
</style>

<script>
    (function () {
        document.querySelectorAll('.toggle-modulo').forEach(function (toggle) {
            var modulo = toggle.dataset.modulo;
            var checkboxes = document.querySelectorAll('.permiso-checkbox[data-modulo="' + modulo + '"]');

            // Estado inicial del switch: marcado si ya estaban todos los permisos del módulo activos
            toggle.checked = checkboxes.length > 0 && Array.from(checkboxes).every(function (cb) { return cb.checked; });

            toggle.addEventListener('change', function () {
                checkboxes.forEach(function (cb) { cb.checked = toggle.checked; });
            });

            checkboxes.forEach(function (cb) {
                cb.addEventListener('change', function () {
                    toggle.checked = Array.from(checkboxes).every(function (c) { return c.checked; });
                });
            });
        });
    })();
</script>
