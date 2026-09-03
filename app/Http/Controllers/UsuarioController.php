<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:usuarios.ver')->only(['index']);
        $this->middleware('permission:usuarios.crear')->only(['create', 'store']);
        $this->middleware('permission:usuarios.editar')->only(['edit', 'update', 'toggleEstado']);
        $this->middleware('permission:usuarios.eliminar')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $query = User::with(['empleado', 'roles']);

        if ($busqueda = $request->get('q')) {
            $query->where(function ($q) use ($busqueda) {
                $q->where('name', 'like', "%{$busqueda}%")
                  ->orWhere('username', 'like', "%{$busqueda}%")
                  ->orWhere('email', 'like', "%{$busqueda}%");
            });
        }

        $usuarios = $query->orderBy('name')->paginate(10)->withQueryString();

        $totalUsuarios = User::count();
        $totalActivos = User::where('estado', 'activo')->count();
        $totalInactivos = User::where('estado', 'inactivo')->count();
        $totalRoles = Role::count();

        return view('usuarios.index', compact(
            'usuarios',
            'totalUsuarios',
            'totalActivos',
            'totalInactivos',
            'totalRoles'
        ));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();
        $empleados = Empleado::whereDoesntHave('user')->orderBy('nombre')->get();

        return view('usuarios.create', compact('roles', 'empleados'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'empleado_id' => 'nullable|exists:empleados,id',
            'role' => 'required|exists:roles,name',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $usuario = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'empleado_id' => $data['empleado_id'] ?? null,
            'estado' => $data['estado'],
        ]);

        $usuario->assignRole($data['role']);

        return redirect()->route('usuarios.index')->with('status', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario)
    {
        $roles = Role::orderBy('name')->get();
        $empleados = Empleado::where(function ($q) use ($usuario) {
            $q->whereDoesntHave('user')->orWhere('id', $usuario->empleado_id);
        })->orderBy('nombre')->get();

        return view('usuarios.edit', compact('usuario', 'roles', 'empleados'));
    }

    public function update(Request $request, User $usuario)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($usuario->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($usuario->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'empleado_id' => 'nullable|exists:empleados,id',
            'role' => 'required|exists:roles,name',
            'estado' => 'required|in:activo,inactivo',
        ]);

        $usuario->name = $data['name'];
        $usuario->username = $data['username'];
        $usuario->email = $data['email'];
        $usuario->empleado_id = $data['empleado_id'] ?? null;
        $usuario->estado = $data['estado'];

        if (!empty($data['password'])) {
            $usuario->password = Hash::make($data['password']);
        }

        $usuario->save();
        $usuario->syncRoles([$data['role']]);

        return redirect()->route('usuarios.index')->with('status', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')->with('status', 'Usuario eliminado correctamente.');
    }

    public function toggleEstado(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes desactivar tu propio usuario.');
        }

        $usuario->estado = $usuario->estado === 'activo' ? 'inactivo' : 'activo';
        $usuario->save();

        return back()->with('status', 'Estado actualizado.');
    }
}
