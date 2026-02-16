@echo off
echo ============================================
echo   Enabling PHP intl Extension
echo ============================================
echo.

set PHP_INI=C:\php-8.4.12\php.ini

echo Backing up php.ini...
copy "%PHP_INI%" "%PHP_INI%.backup" >nul

echo Enabling intl extension...
powershell -Command "(Get-Content '%PHP_INI%') -replace ';extension=intl', 'extension=intl' | Set-Content '%PHP_INI%'"

echo.
echo ============================================
echo   DONE! 
echo ============================================
echo.
echo Please restart your terminal and run:
echo   php -m ^| Select-String intl
echo.
echo If you see "intl" in the output, it's working!
echo.
pause
