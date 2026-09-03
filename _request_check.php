<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$admin = null;

$request = Illuminate\Http\Request::create('/roles/3/edit', 'GET');
$response = $kernel->handle($request);

echo 'Status: ' . $response->getStatusCode() . PHP_EOL;

if ($response->getStatusCode() >= 500) {
    $content = $response->getContent();
    // Extraer solo el mensaje de excepción si es posible
    if (preg_match('/"message":"(.*?)"/', $content, $m)) {
        echo 'Message: ' . $m[1] . PHP_EOL;
    } else {
        file_put_contents(__DIR__ . '/_error_output.html', $content);
        echo 'Contenido guardado en _error_output.html (' . strlen($content) . ' bytes)' . PHP_EOL;
    }
}

$kernel->terminate($request, $response);
