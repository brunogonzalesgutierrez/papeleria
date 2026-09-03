<?php
// Crea la base de datos de MySQL si no existe, usando los datos del .env.
// Lo ejecuta compilar.bat antes de correr las migraciones.

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$port = $_ENV['DB_PORT'] ?? '3306';
$db   = $_ENV['DB_DATABASE'] ?? 'papeleria';
$user = $_ENV['DB_USERNAME'] ?? 'root';
$pass = $_ENV['DB_PASSWORD'] ?? '';

try {
    $pdo = new PDO("mysql:host={$host};port={$port}", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$db}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "  Base de datos '{$db}' verificada/creada OK.\n";
} catch (Throwable $e) {
    echo "  ERROR: no se pudo crear/verificar la base de datos '{$db}'.\n";
    echo "  Detalle: " . $e->getMessage() . "\n";
    echo "  Verifica que MySQL (XAMPP) este corriendo y que el usuario/clave en .env sean correctos.\n";
    exit(1);
}
