@echo off
title Iniciando Laravel y Vite...
cd /d C:\xampp\htdocs\Laravel\savingcats

REM Abrir Laravel (php artisan serve) en una nueva terminal
start "Laravel Server" cmd /k "cd /d C:\xampp\htdocs\Laravel\savingcats && php artisan serve --host=192.168.1.142 --port=8000"

REM Esperar un segundo para que la primera terminal arranque
timeout /t 1 >nul

REM Abrir Vite (npm run dev) en otra terminal
start "Vite Dev" cmd /k "cd /d C:\xampp\htdocs\Laravel\savingcats && npm run dev -- --host 192.168.1.142"

REM Esperar 2 segundos para que la segunda terminal arranque
timeout /t 2 >nul

REM (Opcional) Abrir navegador automáticamente
start http://192.168.1.142:8000