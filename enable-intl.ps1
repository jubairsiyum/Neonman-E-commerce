# PowerShell script to enable PHP intl extension
Write-Host "============================================" -ForegroundColor Cyan
Write-Host "  Enabling PHP intl Extension" -ForegroundColor Cyan
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""

$phpIni = "C:\php-8.4.12\php.ini"

# Check if file exists
if (-not (Test-Path $phpIni)) {
    Write-Host "ERROR: php.ini not found at: $phpIni" -ForegroundColor Red
    Write-Host "Please check your PHP installation path." -ForegroundColor Yellow
    exit 1
}

# Backup php.ini
Write-Host "Creating backup of php.ini..." -ForegroundColor Yellow
Copy-Item $phpIni "$phpIni.backup" -Force
Write-Host "Backup created: $phpIni.backup" -ForegroundColor Green
Write-Host ""

# Enable intl extension
Write-Host "Enabling intl extension in php.ini..." -ForegroundColor Yellow
$content = Get-Content $phpIni
$newContent = $content -replace ';extension=intl', 'extension=intl'
$newContent | Set-Content $phpIni
Write-Host "intl extension enabled!" -ForegroundColor Green
Write-Host ""

Write-Host "============================================" -ForegroundColor Cyan
Write-Host "  DONE!" -ForegroundColor Green
Write-Host "============================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "IMPORTANT: Please close ALL terminal windows and reopen." -ForegroundColor Yellow
Write-Host ""
Write-Host "After reopening, verify with:" -ForegroundColor Cyan
Write-Host "  php -m | Select-String intl" -ForegroundColor White
Write-Host ""
Write-Host "You should see 'intl' in the output." -ForegroundColor Cyan
Write-Host ""
