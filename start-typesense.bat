@echo off
echo Starting Typesense Server via Docker...
echo.
echo Make sure Docker Desktop is running!
echo.
docker compose up -d typesense
echo.
echo Typesense is starting...
echo Checking health status...
timeout /t 3 /nobreak > nul
docker compose ps typesense
echo.
echo Typesense should be available at http://localhost:8108
echo To view logs: docker compose logs -f typesense
echo To stop: docker compose down
