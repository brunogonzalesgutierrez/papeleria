@echo off
setlocal
cd /d "%~dp0"

echo ============================================
echo   Sistema Papeleria - Compilar / Levantar
echo ============================================
echo.

echo [0/7] Verificando requisitos (PHP y Node)...
where php >nul 2>nul
if errorlevel 1 (
    echo   ERROR: no se encontro "php" en el PATH.
    echo   Agrega la carpeta de PHP de XAMPP ^(ej. C:\xampp\php^) a las variables de entorno.
    pause
    exit /b 1
)
where npm >nul 2>nul
if errorlevel 1 (
    echo   ERROR: no se encontro "npm" en el PATH.
    echo   Instala Node.js desde https://nodejs.org/ y volve a intentar.
    pause
    exit /b 1
)
echo   PHP y Node encontrados, OK

echo.
echo [1/7] Verificando .env...
if not exist ".env" (
    copy ".env.example" ".env"
    echo   .env creado desde .env.example
) else (
    echo   .env ya existe, OK
)

echo.
echo [2/7] Instalando dependencias de Composer...
php composer.phar install --no-interaction
if errorlevel 1 (
    echo   ERROR al instalar dependencias de Composer.
    pause
    exit /b 1
)

echo.
echo [3/7] Generando APP_KEY si hace falta...
php artisan key:generate --ansi

echo.
echo [4/7] Instalando dependencias de NPM...
call npm install
if errorlevel 1 (
    echo   ERROR al instalar dependencias de NPM.
    pause
    exit /b 1
)

echo.
echo [5/7] Verificando / creando base de datos MySQL...
echo   Asegurate de que MySQL este corriendo en XAMPP Control Panel.
php crear_bd.php
if errorlevel 1 (
    pause
    exit /b 1
)

echo.
echo [6/7] Ejecutando migraciones + seeders...
php artisan config:clear
php artisan migrate --force
php artisan db:seed --force

echo.
echo [7/7] Compilando assets (Vite)...
call npm run build

echo.
echo ============================================
echo   Listo. Levantando servidores de desarrollo...
echo ============================================
echo.

start "Laravel - artisan serve" cmd /k "php artisan serve"
start "Vite - npm run dev" cmd /k "npm run dev"

echo.
echo Servidor Laravel:  http://127.0.0.1:8000
echo Vite (dev, HMR):   revisa la ventana "Vite - npm run dev"
echo.
echo Usuario admin de prueba:
echo   usuario: admin
echo   password: password
echo.
pause
