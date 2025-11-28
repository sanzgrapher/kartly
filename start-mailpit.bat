@echo off
echo ===============================================
echo    Kartly Mailpit Setup and Testing Script
echo ===============================================
echo.

echo Checking Docker Desktop status...
docker info >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Docker Desktop is not running!
    echo.
    echo Please start Docker Desktop first:
    echo   1. Open Docker Desktop from Start menu
    echo   2. Wait for it to fully start ^(Docker icon in system tray^)
    echo   3. Run this script again
    echo.
    echo Alternatively, you can test emails without Docker:
    echo   php artisan mailpit:test all --email=your@email.com
    echo.
    pause
    exit /b 1
)
echo ✅ Docker Desktop is running

echo Starting Mailpit service...
docker-compose up -d mailpit

if %errorlevel% neq 0 (
    echo ERROR: Failed to start Mailpit
    pause
    exit /b 1
)

echo.
echo Waiting for Mailpit to be ready...
timeout /t 3 /nobreak > nul

echo.
echo Testing Mailpit connection...
curl -s http://127.0.0.1:8025/api/v1/info > nul 2>&1

if %errorlevel% neq 0 (
    echo WARNING: Mailpit may not be ready yet. Please wait a moment and try again.
) else (
    echo SUCCESS: Mailpit is running and accessible!
)

echo.
echo ===============================================
echo    Mailpit Service Information
echo ===============================================
echo Web Interface: http://127.0.0.1:8025
echo SMTP Server:   127.0.0.1:1025
echo.
echo Available Commands:
echo   php artisan mailpit:test --help           Show help
echo   php artisan mailpit:test all              Test all email types
echo   php artisan mailpit:test welcome          Test welcome email
echo   php artisan mailpit:test --clear --open   Clear inbox and open web UI
echo   php artisan mailpit:test --stats          Show statistics
echo.
echo ===============================================
echo.

set /p choice="Would you like to test emails now? (y/n): "
if /i "%choice%"=="y" (
    echo.
    echo Running email tests...
    php artisan mailpit:test all --clear --open
) else (
    echo.
    echo You can test emails later using:
    echo   php artisan mailpit:test all --open
)

echo.
echo Setup completed! Mailpit is ready for use.
pause