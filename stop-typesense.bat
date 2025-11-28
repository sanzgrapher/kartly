@echo off
echo Stopping Typesense Server...
echo.
docker compose stop typesense
echo.
echo Typesense has been stopped.
echo Data is preserved in typesense-data folder.
echo.
echo To start again: ./start-typesense.bat
echo To remove completely: docker compose down
