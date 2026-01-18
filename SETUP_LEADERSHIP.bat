@echo off
echo ========================================
echo Leadership Management Setup
echo ========================================
echo.

cd /d "%~dp0"

echo Step 1: Running Migration...
echo ----------------------------------------
c:\xampp\php\php.exe artisan migrate --force
echo.

echo Step 2: Running Seeder...
echo ----------------------------------------
c:\xampp\php\php.exe artisan db:seed --class=LeadershipItemSeeder
echo.

echo Step 3: Linking Storage...
echo ----------------------------------------
c:\xampp\php\php.exe artisan storage:link
echo.

echo ========================================
echo Setup Complete!
echo ========================================
echo.
echo You can now:
echo - Access Leadership Management: http://localhost:3000/admin/leadership
echo - View Leadership Page: http://localhost:3000/about/leadership
echo - Upload images for each leader through the CMS
echo.
pause
