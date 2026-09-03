<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('usuarios', App\Http\Controllers\UsuarioController::class)->except(['show']);
    Route::patch('/usuarios/{usuario}/estado', [App\Http\Controllers\UsuarioController::class, 'toggleEstado'])->name('usuarios.estado');

    Route::resource('roles', App\Http\Controllers\RolController::class)
        ->parameters(['roles' => 'rol'])
        ->except(['show']);

    // Modulos aun sin construir: muestran una pagina "en construccion"
    // para que el sidebar no tenga enlaces rotos mientras se van armando.
    $modulosPendientes = [
        'productos'   => ['titulo' => 'Productos',   'icono' => 'box'],
        'categorias'  => ['titulo' => 'Categorías',  'icono' => 'tag'],
        'proveedores' => ['titulo' => 'Proveedores', 'icono' => 'truck'],
        'clientes'    => ['titulo' => 'Clientes',    'icono' => 'people'],
        'ventas'      => ['titulo' => 'Ventas',      'icono' => 'cart'],
        'pedidos'     => ['titulo' => 'Pedidos',     'icono' => 'clipboard'],
        'inventario'  => ['titulo' => 'Inventario',  'icono' => 'boxes'],
        'reportes'    => ['titulo' => 'Reportes',    'icono' => 'chart'],
    ];

    foreach ($modulosPendientes as $slug => $info) {
        Route::get("/{$slug}", function () use ($info) {
            return view('modulo-pendiente', $info);
        })->name($slug);
    }
});
