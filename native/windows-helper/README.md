# APMC Windows Helper (C# .NET)

This is a tiny helper app that registers an `apmc://` protocol and opens a PDF in the local default editor.

## Behavior
- The browser calls: `apmc://open?url=<SIGNED_URL>`
- The helper downloads the PDF to a temp folder
- The helper opens the PDF with the system default app

## Build
```powershell
dotnet build .\APMC.Helper.csproj -c Release
```

## Install (manual)
1. Copy the built `APMC.Helper.exe` to a stable path, e.g.:
   `C:\Program Files\APMC Helper\APMC.Helper.exe`
2. Run the protocol registration script as Administrator:
```powershell
.\register-protocol.ps1
```

## Test
```text
apmc://open?url=https%3A%2F%2Fexample.com%2Ffile.pdf
```

## Notes
- This helper is intentionally minimal. Add logging or UI if needed.
- You should wrap this in an MSI installer for production.
