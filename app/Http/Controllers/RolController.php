<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{
    /**
     * Roles que son parte del núcleo del sistema y no se pueden borrar
     * (para no dejar el sistema sin un rol administrador).
     */
    protected array $rolesProtegidos = ['Administrador'];

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:roles.ver')->only(['index']);
        $this->middleware('permission:roles.crear')->only(['create', 'store']);
        $this->middleware('permission:roles.editar')->only(['edit', 'update']);
        $this->middleware('permission:roles.eliminar')->only(['destroy']);
    }

    public function index()
    {
        $roles = Role::withCount('users')->orderBy('name')->get();
        $totalPermisos = Permission::count();

        return view('roles.index', compact('roles', 'totalPermisos'));
    }

    public function create()
    {
        $permisos = $this->permisosAgrupados();

        return view('roles.create', compact('permisos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permisos' => 'array',
            'permisos.*' => 'exists:permissions,name',
        ]);

        $rol = Role::create(['name' => $data['name']]);
        $rol->syncPermissions($data['permisos'] ?? []);

        return redirect()->route('roles.index')->with('status', 'Rol creado correctamente.');
    }

    public function edit(Role $rol)
    {
        $permisos = $this->permisosAgrupados();
        $permisosAsignados = $rol->permissions->pluck('name')->toArray();

        return view('roles.edit', compact('rol', 'permisos', 'permisosAsignados'));
    }

    public function update(Request $request, Role $rol)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $rol->id,
            'permisos' => 'array',
            'permisos.*' => 'exists:permissions,name',
        ]);

        if (in_array($rol->name, $this->rolesProtegidos) && $data['name'] !== $rol->name) {
            return back()->with('error', 'No puedes renombrar un rol del núcleo del sistema.');
        }

        $rol->name = $data['name'];
        $rol->save();
        $rol->syncPermissions($data['permisos'] ?? []);

        return redirect()->route('roles.index')->with('status', 'Rol actualizado correctamente.');
    }

    public function destroy(Role $rol)
    {
        if (in_array($rol->name, $this->rolesProtegidos)) {
            return back()->with('error', 'Ese rol es parte del núcleo del sistema y no se puede eliminar.');
        }

        if ($rol->users()->count() > 0) {
            return back()->with('error', 'No puedes eliminar un rol que tiene usuarios asignados.');
        }

        $rol->delete();

        return redirect()->route('roles.index')->with('status', 'Rol eliminado correctamente.');
    }

    /**
     * Agrupa los permisos por módulo (lo que va antes del punto en "modulo.accion")
     * para poder pintarlos organizados en la vista.
     */
    protected function permisosAgrupados()
    {
        return Permission::orderBy('name')->get()->groupBy(function ($permiso) {
            return explode('.', $permiso->name)[0];
        });
    }
}
