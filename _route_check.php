<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rol = \Spatie\Permission\Models\Role::find(3);

echo 'Rol class: ' . get_class($rol) . PHP_EOL;
echo 'Rol id: ' . $rol->id . PHP_EOL;
echo 'Rol getRouteKeyName: ' . $rol->getRouteKeyName() . PHP_EOL;
echo 'Rol getRouteKey: ' . $rol->getRouteKey() . PHP_EOL;

$route = app('router')->getRoutes()->getByName('roles.update');
echo 'Route parameterNames: ' . json_encode($route->parameterNames()) . PHP_EOL;

try {
    $url = route('roles.update', $rol);
    echo 'URL OK: ' . $url . PHP_EOL;
} catch (\Throwable $e) {
    echo 'URL ERROR: ' . $e->getMessage() . PHP_EOL;
}

try {
    $url2 = route('roles.update', ['role' => $rol]);
    echo 'URL con key explicita OK: ' . $url2 . PHP_EOL;
} catch (\Throwable $e) {
    echo 'URL con key explicita ERROR: ' . $e->getMessage() . PHP_EOL;
}

try {
    $url3 = route('roles.update', ['role' => $rol->id]);
    echo 'URL con id explicito OK: ' . $url3 . PHP_EOL;
} catch (\Throwable $e) {
    echo 'URL con id explicito ERROR: ' . $e->getMessage() . PHP_EOL;
}
