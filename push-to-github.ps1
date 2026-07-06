# Run after installing Git: https://git-scm.com/download/win
# Right-click > Run with PowerShell, or from project folder:
#   powershell -ExecutionPolicy Bypass -File .\push-to-github.ps1

$ErrorActionPreference = 'Stop'
Set-Location $PSScriptRoot

$git = Get-Command git -ErrorAction SilentlyContinue
if (-not $git) {
    Write-Host 'Git is not installed. Download from https://git-scm.com/download/win then run this script again.' -ForegroundColor Red
    exit 1
}

$remoteUrl = 'https://github.com/Anaconda2017/insyrancenew.git'

if (-not (Test-Path .git)) {
    git init
    git branch -M main
}

$currentRemote = git remote get-url origin 2>$null
if ($LASTEXITCODE -ne 0) {
    git remote add origin $remoteUrl
} elseif ($currentRemote -ne $remoteUrl) {
    git remote set-url origin $remoteUrl
}

git add .
git status

$hasChanges = git diff --cached --quiet; $hasChanges = $LASTEXITCODE -ne 0
if ($hasChanges) {
    git commit -m @"
Upgrade to Laravel 12 and PHP 8.2 with resilient notifications and safe email handling.

- Refactor Firebase push notifications to read credentials from storage/app/json
- Add SafeMail and NotificationDispatchService for graceful failures
- Upgrade Laravel 8 to Laravel 12
"@
} else {
    Write-Host 'No staged changes to commit.' -ForegroundColor Yellow
}

Write-Host ''
Write-Host 'Pushing to main...' -ForegroundColor Cyan
git push -u origin main

Write-Host ''
Write-Host 'Done. Repository: https://github.com/Anaconda2017/insyrancenew' -ForegroundColor Green
