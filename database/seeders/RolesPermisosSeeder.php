<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermisosSeeder extends Seeder
{
    public function run(): void
    {
        $modulos = [
            'usuarios',
            'roles',
            'empleados',
            'categorias',
            'proveedores',
            'productos',
            'clientes',
            'ventas',
            'pedidos',
            'inventario',
            'reportes',
        ];

        $acciones = ['ver', 'crear', 'editar', 'eliminar'];

        foreach ($modulos as $modulo) {
            foreach ($acciones as $accion) {
                Permission::firstOrCreate(['name' => "{$modulo}.{$accion}"]);
            }
        }

        $admin = Role::firstOrCreate(['name' => 'Administrador']);
        $admin->syncPermissions(Permission::all());

        $vendedor = Role::firstOrCreate(['name' => 'Vendedor']);
        $vendedor->syncPermissions([
            'clientes.ver', 'clientes.crear', 'clientes.editar',
            'ventas.ver', 'ventas.crear', 'ventas.editar',
            'productos.ver',
        ]);

        $inventario = Role::firstOrCreate(['name' => 'Encargado de inventario']);
        $inventario->syncPermissions([
            'productos.ver', 'productos.crear', 'productos.editar',
            'categorias.ver', 'categorias.crear', 'categorias.editar',
            'proveedores.ver', 'proveedores.crear', 'proveedores.editar',
            'pedidos.ver', 'pedidos.crear', 'pedidos.editar',
            'inventario.ver', 'inventario.crear', 'inventario.editar',
        ]);
    }
}
