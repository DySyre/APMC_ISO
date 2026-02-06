# MSI Installer (WiX v4)

This creates an MSI that installs the helper and registers the `apmc://` protocol.

## Prereqs
- WiX Toolset v4

## Build
From the repo root:
```powershell
wix build .\native\windows-helper\installer\APMC.Helper.wxs -o .\native\windows-helper\installer\APMC.Helper.msi
```

## Notes
- The MSI installs to `C:\Program Files\APMC Helper\APMC.Helper.exe`
- It writes registry keys for the `apmc` URL protocol.
