import Cocoa

final class AppDelegate: NSObject, NSApplicationDelegate {
    func applicationDidFinishLaunching(_ notification: Notification) {
        NSAppleEventManager.shared().setEventHandler(
            self,
            andSelector: #selector(handleGetURLEvent(event:replyEvent:)),
            forEventClass: AEEventClass(kInternetEventClass),
            andEventID: AEEventID(kAEGetURL)
        )
    }

    @objc private func handleGetURLEvent(event: NSAppleEventDescriptor, replyEvent: NSAppleEventDescriptor) {
        guard let urlString = event.paramDescriptor(forKeyword: AEKeyword(keyDirectObject))?.stringValue else {
            return
        }

        guard let url = URL(string: urlString),
              url.scheme?.lowercased() == "apmc" else {
            return
        }

        guard let downloadUrlString = URLComponents(url: url, resolvingAgainstBaseURL: false)?
            .queryItems?
            .first(where: { $0.name == "url" })?
            .value,
              let downloadUrl = URL(string: downloadUrlString) else {
            return
        }

        let tempDir = FileManager.default.temporaryDirectory.appendingPathComponent("APMC_PDF", isDirectory: true)
        try? FileManager.default.createDirectory(at: tempDir, withIntermediateDirectories: true)

        let filename = downloadUrl.lastPathComponent.isEmpty
            ? "document_\(Int(Date().timeIntervalSince1970)).pdf"
            : downloadUrl.lastPathComponent

        let target = tempDir.appendingPathComponent(filename)

        let task = URLSession.shared.downloadTask(with: downloadUrl) { location, _, _ in
            guard let location else { return }
            try? FileManager.default.removeItem(at: target)
            do {
                try FileManager.default.moveItem(at: location, to: target)
                NSWorkspace.shared.open(target)
            } catch {
                // Intentionally no UI for now; helper fails silently.
            }
        }
        task.resume()
    }
}
