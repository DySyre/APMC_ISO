$appPath = "C:\\Program Files\\APMC Helper\\APMC.Helper.exe"

if (-not (Test-Path $appPath)) {
    Write-Host "Executable not found at: $appPath"
    Write-Host "Update register-protocol.ps1 with the correct path before running."
    exit 1
}

$baseKey = "HKCR:\\apmc"
New-Item -Path $baseKey -Force | Out-Null
New-ItemProperty -Path $baseKey -Name "(Default)" -Value "URL:APMC Protocol" -PropertyType String -Force | Out-Null
New-ItemProperty -Path $baseKey -Name "URL Protocol" -Value "" -PropertyType String -Force | Out-Null

$iconKey = Join-Path $baseKey "DefaultIcon"
New-Item -Path $iconKey -Force | Out-Null
New-ItemProperty -Path $iconKey -Name "(Default)" -Value "$appPath,1" -PropertyType String -Force | Out-Null

$commandKey = Join-Path $baseKey "shell\\open\\command"
New-Item -Path $commandKey -Force | Out-Null
New-ItemProperty -Path $commandKey -Name "(Default)" -Value "`"$appPath`" `"%1`"" -PropertyType String -Force | Out-Null

Write-Host "Protocol registered. Test with: apmc://open?url=https%3A%2F%2Fexample.com%2Ffile.pdf"
