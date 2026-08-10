@echo off
title Toxaway Knitting Co. - Local Server
color 0A
echo.
echo ========================================
echo   TOXAWAY KNITTING CO. - LOCAL SERVER
echo ========================================
echo.
echo Starting servers...
echo.
echo Laravel Server: http://localhost:8000
echo Vite Dev Server: http://localhost:5173
echo.
echo ========================================
echo.

REM Start Laravel server in new window
start cmd /k "php artisan serve"

REM Wait 2 seconds for Laravel to start
timeout /t 2 /nobreak

REM Start Vite dev server in new window
start cmd /k "npm run dev"

echo.
echo ✓ All servers started successfully!
echo ✓ Open your browser to http://localhost:8000
echo.
echo This window can be closed. The servers will continue running
echo in the other terminal windows.
echo.
pause
