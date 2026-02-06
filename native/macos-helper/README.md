# APMC macOS Helper (Swift)

This helper app registers the `apmc://` URL scheme and opens PDFs in the local default editor.

## Create the macOS app
1. Open Xcode and create a new **App** (macOS, Swift, AppKit).
2. Set the product name to `APMCHelper`.
3. Replace the generated files with the ones in this folder.
4. Add the URL scheme in **Info.plist** (see file here).

## Behavior
- The browser calls: `apmc://open?url=<SIGNED_URL>`
- The helper downloads the PDF to a temp folder
- The helper opens the PDF with the system default app

## Notes
- This must be a real app bundle to receive URL events.
- You will need to sign and notarize for production distribution.
