<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosDemoSeeder extends Seeder
{
    /**
     * Usuarios de prueba, uno o varios por cada rol, para poder ver
     * el módulo de Usuarios/Roles con datos reales.
     */
    public function run(): void
    {
        $usuarios = [
            [
                'name' => 'Carla Vendedora',
                'username' => 'cvendedora',
                'email' => 'carla.vendedora@papeleria.test',
                'estado' => 'activo',
                'rol' => 'Vendedor',
            ],
            [
                'name' => 'Luis Vendedor',
                'username' => 'lvendedor',
                'email' => 'luis.vendedor@papeleria.test',
                'estado' => 'activo',
                'rol' => 'Vendedor',
            ],
            [
                'name' => 'Marta Almacén',
                'username' => 'mmarta',
                'email' => 'marta.almacen@papeleria.test',
                'estado' => 'activo',
                'rol' => 'Encargado de inventario',
            ],
            [
                'name' => 'Jorge Inventario',
                'username' => 'jinventario',
                'email' => 'jorge.inventario@papeleria.test',
                'estado' => 'inactivo',
                'rol' => 'Encargado de inventario',
            ],
            [
                'name' => 'Ana Administradora',
                'username' => 'aadmin',
                'email' => 'ana.admin@papeleria.test',
                'estado' => 'activo',
                'rol' => 'Administrador',
            ],
        ];

        foreach ($usuarios as $datos) {
            $rol = $datos['rol'];
            unset($datos['rol']);

            $usuario = User::firstOrCreate(
                ['username' => $datos['username']],
                array_merge($datos, [
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ])
            );

            $usuario->syncRoles([$rol]);
        }
    }
}
