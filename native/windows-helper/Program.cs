using System.Diagnostics;
using System.Net;
using System.Text;
using System.Windows.Forms;

static class Program
{
    [STAThread]
    static void Main(string[] args)
    {
        var log = new StringBuilder();
        var logPath = Path.Combine(Path.GetTempPath(), "APMC_PDF", "apmc-helper.log");
        Directory.CreateDirectory(Path.GetDirectoryName(logPath)!);
        log.AppendLine($"Started: {DateTime.UtcNow:O}");
        log.AppendLine($"Args count: {args.Length}");
        log.AppendLine($"Args: {string.Join(" ", args)}");
        log.AppendLine($"CommandLine: {Environment.CommandLine}");
        File.WriteAllText(logPath, log.ToString());

        var raw = GetFirstUriCandidate(args, Environment.CommandLine);
        if (string.IsNullOrWhiteSpace(raw))
        {
            ShowError("No protocol arguments received.", log, logPath);
            return;
        }

        if (!raw.StartsWith("apmc://", StringComparison.OrdinalIgnoreCase))
        {
            ShowError("Invalid protocol. Expected apmc://", log, logPath);
            return;
        }

        if (!TryGetQueryParam(raw, "url", out var url))
        {
            ShowError("Missing url parameter.", log, logPath);
            return;
        }
        log.AppendLine($"Signed URL: {url}");

        if (!Uri.TryCreate(url, UriKind.Absolute, out var downloadUri))
        {
            ShowError("Invalid download URL.", log, logPath);
            return;
        }

        try
        {
            var tempPath = Path.Combine(Path.GetTempPath(), "APMC_PDF");
            Directory.CreateDirectory(tempPath);

            var fileName = Path.GetFileName(downloadUri.LocalPath);
            if (string.IsNullOrWhiteSpace(fileName))
            {
                fileName = $"document_{DateTime.UtcNow:yyyyMMdd_HHmmss}.pdf";
            }

            var target = Path.Combine(tempPath, fileName);
            log.AppendLine($"Downloading to: {target}");
            File.WriteAllText(logPath, log.ToString());

            using (var client = new WebClient())
            {
                client.DownloadFile(downloadUri, target);
            }

            log.AppendLine("Download complete. Launching default app...");
            File.WriteAllText(logPath, log.ToString());
            var psi = new ProcessStartInfo
            {
                FileName = target,
                UseShellExecute = true
            };
            Process.Start(psi);
        }
        catch (Exception ex)
        {
            log.AppendLine("ERROR:");
            log.AppendLine(ex.ToString());
            ShowError("Failed to open PDF. See details in the log.", log, logPath);
        }
    }

    static bool TryGetQueryParam(string uri, string key, out string value)
    {
        value = string.Empty;

        if (!Uri.TryCreate(uri, UriKind.Absolute, out var parsed))
        {
            return false;
        }

        var query = parsed.Query.TrimStart('?');
        foreach (var part in query.Split('&', StringSplitOptions.RemoveEmptyEntries))
        {
            var kv = part.Split('=', 2);
            if (kv.Length != 2)
            {
                continue;
            }

            if (!string.Equals(kv[0], key, StringComparison.OrdinalIgnoreCase))
            {
                continue;
            }

            value = WebUtility.UrlDecode(kv[1]);
            return !string.IsNullOrWhiteSpace(value);
        }

        return false;
    }

    static string? GetFirstUriCandidate(string[] args, string commandLine)
    {
        if (args.Length > 0)
        {
            foreach (var arg in args)
            {
                if (arg.StartsWith("apmc://", StringComparison.OrdinalIgnoreCase))
                {
                    return arg;
                }
            }
        }

        var marker = "apmc://";
        var index = commandLine.IndexOf(marker, StringComparison.OrdinalIgnoreCase);
        if (index >= 0)
        {
            return commandLine.Substring(index).Trim().Trim('"');
        }

        return null;
    }

    static void ShowError(string message, StringBuilder log, string logPath)
    {
        try
        {
            File.WriteAllText(logPath, log.ToString());
            MessageBox.Show($"{message}\n\nLog: {logPath}", "APMC Helper", MessageBoxButtons.OK, MessageBoxIcon.Error);
        }
        catch
        {
            // If even logging fails, swallow.
        }
    }
}
