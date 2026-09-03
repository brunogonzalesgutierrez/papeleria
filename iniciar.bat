@echo off
setlocal
cd /d "%~dp0"

echo ============================================
echo   Sistema Papeleria - Iniciar
echo ============================================
echo.
echo Asegurate de que MySQL este corriendo en XAMPP Control Panel.
echo.

start "Laravel - artisan serve" cmd /k "php artisan serve"
start "Vite - npm run dev" cmd /k "npm run dev"

echo.
echo Servidor Laravel:  http://127.0.0.1:8000
echo Vite (dev, HMR):    revisa la ventana "Vite - npm run dev"
echo.
echo Usuario admin de prueba:
echo   usuario: admin
echo   password: password
echo.
pause
