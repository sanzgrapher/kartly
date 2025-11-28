@echo off
echo ===============================================
echo    Stopping Kartly Mailpit Service
echo ===============================================
echo.

echo Stopping Mailpit service...
docker-compose stop mailpit

if %errorlevel% neq 0 (
    echo ERROR: Failed to stop Mailpit service
    pause
    exit /b 1
)

echo.
echo SUCCESS: Mailpit service stopped.
echo.
echo To start Mailpit again, run:
echo   start-mailpit.bat
echo   or
echo   docker-compose up -d mailpit
echo.
pause