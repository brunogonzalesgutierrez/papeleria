@echo off
setlocal
cd /d "%~dp0"

echo ============================================
echo   Sistema Papeleria - Compilar / Levantar
echo ============================================
echo.

echo [1/6] Verificando .env...
if not exist ".env" (
    copy ".env.example" ".env"
    echo   .env creado desde .env.example
) else (
    echo   .env ya existe, OK
)

echo.
echo [2/6] Instalando dependencias de Composer...
php composer.phar install --no-interaction
if errorlevel 1 (
    echo   ERROR al instalar dependencias de Composer.
    pause
    exit /b 1
)

echo.
echo [3/6] Generando APP_KEY si hace falta...
php artisan key:generate --ansi

echo.
echo [4/6] Instalando dependencias de NPM...
call npm install
if errorlevel 1 (
    echo   ERROR al instalar dependencias de NPM.
    pause
    exit /b 1
)

echo.
echo [5/6] Ejecutando migraciones + seeders (MySQL via XAMPP)...
echo   Asegurate de que MySQL este corriendo en XAMPP Control Panel.
php artisan config:clear
php artisan migrate --force
php artisan db:seed --force

echo.
echo [6/6] Compilando assets (Vite)...
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
