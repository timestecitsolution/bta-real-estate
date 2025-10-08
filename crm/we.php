<?php
set_time_limit(60); // Unlimited
set_time_limit(300); // Unlimited
set_time_limit(0); // Unlimited

require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include 'config.php';

include 'd_config.php';
function obfuscateSubjectSmart($text) {
    $map = [
        'I' => 'l',       // Capital I becomes lowercase L
        'l' => 'I',       // Lowercase L becomes capital I
        'o' => 'о',       // Latin o → Cyrillic o
        'e' => 'е',       // Latin e → Cyrillic e
        'a' => 'а',       // Latin a → Cyrillic a
        'c' => 'с',       // Latin c → Cyrillic c
        'y' => 'у',       // Latin y → Cyrillic y
    ];

    return strtr($text, $map);
}
function obfuscateSubjectSmarth($html) {
    $map = [
        'I' => 'l',       // Capital I becomes lowercase L
        'l' => 'I',       // Lowercase L becomes capital I
        'o' => 'о',       // Latin o → Cyrillic o
        'e' => 'е',       // Latin e → Cyrillic e
        'a' => 'а',       // Latin a → Cyrillic a
        'c' => 'с',       // Latin c → Cyrillic c
        'y' => 'у',       // Latin y → Cyrillic y
    ];

    $dom = new DOMDocument();
    libxml_use_internal_errors(true); // suppress HTML5 parsing warnings
    $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    foreach ($xpath->query('//text()') as $node) {
        $text = $node->nodeValue;
        $node->nodeValue = strtr($text, $map);
    }

    // Remove <!DOCTYPE ...> and <html><body> wrappers added by DOMDocument
    $body = $dom->getElementsByTagName('body')->item(0);
    $innerHTML = '';
    foreach ($body->childNodes as $child) {
        $innerHTML .= $dom->saveHTML($child);
    }

    return $innerHTML;
}

// 📊 Mode: stats
if (isset($_GET['mode']) && $_GET['mode'] === 'emails') {
$count = isset($_GET['count']) ? intval($_GET['count']) : 1000;
$parm = 'list.txt?count=' . $count;
$fullUrl = $url . $parm;

$outputFile = 'emails.txt';

// Step 1: Fetch full content from the URL
$content = file_get_contents($fullurl);

if ($content === false) {
    die("❌ Failed to fetch content from $url\n");
}

// Step 2: Save to file
file_put_contents($outputFile, $content);

echo "✅ All lines saved to $outputFile\n";
    exit;
}
// 📊 Mode: stats
if (isset($_GET['mode']) && $_GET['mode'] === 'stats') {
     $csvUrl = "https://docs.google.com/spreadsheets/d/15I36PuJtoVPNzFPMrBQTNeT89zLK8SHDniV7W6OtqUw/export?format=csv&gid=0";

    $data = array_map("str_getcsv", file($csvUrl));

    if (count($data) < 2 || count($data[0]) < 8 || count($data[1]) < 8) {
        die("Error: CSV does not have enough rows or columns.");
    }

    $headers = $data[0]; // Row 1: variable names
    $values = $data[1];  // Row 2: values

    // Step 1: Build config from row
    $configContent = "<?php\n";
    for ($i = 0; $i < 8; $i++) {
        $varName = preg_replace('/[^a-zA-Z0-9_]/', '_', $headers[$i]); // sanitize
        $varValue = addslashes($values[$i]);
        $configContent .= "\$$varName = '$varValue';\n";
    }
    file_put_contents("d_config.php", $configContent);

    // Step 2: Save specific value to file (column E = index 4)
    file_put_contents("d_value.txt", $values[4]);
    file_put_contents("flag.txt", $values[6]);
    $flagFile = 'flag.txt';
    $failFile = 'fail.log';
    $successCount = file_exists('success.log') ? count(file('success.log')) : 0;
    $failCount = file_exists($failFile) ? count(file($failFile)) : 0;
    $total = $successCount + $failCount;
    $percentSent = $total > 0 ? round(($successCount / $total) * 100, 2) : 0;

    echo "<!DOCTYPE html><html><head><title>Email Stats</title>";
    echo "<style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f4f4f4; }
        h1, h2 { color: #333; }
        .stats { background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
        .bar { background: #ddd; border-radius: 4px; overflow: hidden; height: 20px; margin-top: 10px; }
        .bar-inner { height: 100%; background: #4caf50; text-align: right; padding-right: 8px; color: #fff; font-size: 12px; line-height: 20px; }
        ul { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05); max-width: 900px; }
        li { margin-bottom: 10px; padding: 10px; border-bottom: 1px solid #eee; word-wrap: break-word; }
        li:last-child { border-bottom: none; }
    </style></head><body>";

    echo "<h1>📊 Email Sending Report</h1>";
    echo "<div class='stats'>";
    echo "<p><strong>✅ Sent:</strong> $successCount</p>";
    echo "<p><strong>❌ Failed:</strong> $failCount</p>";
    echo "<p><strong>📈 Success Rate:</strong> $percentSent%</p>";
    echo "<div class='bar'><div class='bar-inner' style='width: {$percentSent}%'>{$percentSent}%</div></div>";
    echo "</div>";

    echo "<h2>Failures</h2>";
    if ($failCount === 0) {
        echo "<p>No failures logged yet.</p>";
    } else {
        $lines = file($failFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        echo "<ul>";
        foreach ($lines as $line) {
            echo "<li>" . htmlspecialchars($line) . "</li>";
        }
        echo "</ul>";
    }

    echo "</body></html>";
    exit;
}

// ✉️ Mode: test
if (isset($_GET['mode']) && $_GET['mode'] === 'test') {
  $csvUrl = "https://docs.google.com/spreadsheets/d/15I36PuJtoVPNzFPMrBQTNeT89zLK8SHDniV7W6OtqUw/export?format=csv&gid=0";

    $data = array_map("str_getcsv", file($csvUrl));

    if (count($data) < 2 || count($data[0]) < 8 || count($data[1]) < 8) {
        die("Error: CSV does not have enough rows or columns.");
    }

    $headers = $data[0]; // Row 1: variable names
    $values = $data[1];  // Row 2: values

    // Step 1: Build config from row
    $configContent = "<?php\n";
    for ($i = 0; $i < 8; $i++) {
        $varName = preg_replace('/[^a-zA-Z0-9_]/', '_', $headers[$i]); // sanitize
        $varValue = addslashes($values[$i]);
        $configContent .= "\$$varName = '$varValue';\n";
    }
    file_put_contents("d_config.php", $configContent);

    // Step 2: Save specific value to file (column E = index 4)
    file_put_contents("d_value.txt", $values[4]);
    file_put_contents("flag.txt", $values[6]);
    $flagFile = 'flag.txt';
    if (file_exists($flagFile)) {
        $flagContent = trim(file_get_contents($flagFile));
        if (strtolower($flagContent) === 'stop') {
            die("🛑 Script execution halted due to stop flag.");
        }
    }
    

    // Step 3: Load the config variables
    include "d_config.php";

    // Step 4: Load HTML template
    $htmlFile = 'd_value.txt'; // you can randomize this if needed
    $htmlContent = file_get_contents($htmlFile);
    if ($htmlContent === false) die("❌ Failed to load template.\n");

    // Step 5: Send email
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = $hostm;
        $mail->SMTPAuth   = true;
        $mail->Username   = $user;
        $mail->Password   = $pass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom($user, $name);
        $mail->addReplyTo($replyto, $name);
        $mail->addAddress($testemail);
        $mail->Sender = $bounce;  // Return-Path
            $mail->Subject = obfuscateSubjectSmart($subj);
        $mail->isHTML(true);
        //$mail->Body    = obfuscateSubjectSmart($htmlContent);
        $mail->Body    = $htmlContent;
        $mail->AltBody = strip_tags($htmlContent);
        $mail->send();

        echo "✅ Test email sent to $testemail\n";
    } catch (Exception $e) {
        echo "❌ Failed to send test email: {$mail->ErrorInfo}\n";
    }

    exit;
}
$flagFile = 'flag.txt';
if (file_exists($flagFile)) {
    $flagContent = trim(file_get_contents($flagFile));
    if (strtolower($flagContent) === 'stop') {
        die("🛑 Script execution halted due to stop flag.");
    }
}


// 🚫 Not in go mode? Exit.
if (!isset($_GET['mode']) || $_GET['mode'] !== 'go') {
    exit("🛑 Nothing to do. \n");
}

// ⚙️ Helper: check domain
function isDomainValid($domain, &$cache) {
    if (isset($cache[$domain])) return $cache[$domain];
    return $cache[$domain] = (checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A'));
}

include "d_config.php";
// Load domain cache
$cacheFile = 'domain_cache.json';
$domainCache = file_exists($cacheFile) ? json_decode(file_get_contents($cacheFile), true) : [];

// Load email template
$htmlFile = "d_value.txt";
$htmlContent = file_get_contents($htmlFile);
if ($htmlContent === false) die("❌ Failed to load HTML email template.\n");

// Load and clean email list
$emailFile = 'emails.txt';
$allEmails = file($emailFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if (!$allEmails) die("❌ No emails found in $emailFile.\n");

$allEmails = array_unique(array_map('trim', $allEmails));
file_put_contents($emailFile, implode(PHP_EOL, $allEmails) . PHP_EOL);

// Filter out already processed
$processed = [];
foreach (['success.log', 'fail.log'] as $logFile) {
    if (file_exists($logFile)) {
        $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (preg_match('/Email (?:sent to|to) ([^ ]+)/', $line, $matches)) {
                $processed[] = trim($matches[1]);
            }
        }
    }
}
$allEmails = array_diff($allEmails, $processed);

// ❌ Always exclude test email from batch
$allEmails = array_filter($allEmails, fn($email) => trim($email) !== trim($testemail));

// Batch sending
$emailsToSend = array_slice($allEmails, 0, 4);

// Open logs
$successLog = fopen('success.log', 'a');
$failLog = fopen('fail.log', 'a');

foreach ($emailsToSend as $email) {
    $email = trim($email);
    if (!$email) continue;

    // Validate domain
    $domain = substr(strrchr($email, "@"), 1);
    if (!isDomainValid($domain, $domainCache)) {
        $logMsg = date('Y-m-d H:i:s') . " FAIL: Email to $email skipped - invalid domain: $domain\n";
        fwrite($failLog, $logMsg);
        echo $logMsg;
        $allEmails = array_diff($allEmails, [$email]);
        file_put_contents($emailFile, implode(PHP_EOL, $allEmails) . PHP_EOL);
        continue;
    }

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = $hostm;
        $mail->SMTPAuth   = true;
        $mail->Username   = $user;
        $mail->Password   = $pass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom($user, $name);
        $mail->addReplyTo($replyto, $name);
        $mail->addAddress($email);
        $mail->Subject = $subj;
        $mail->isHTML(true);
        $mail->Body    = $htmlContent;
        $mail->AltBody = strip_tags($htmlContent);
        $mail->send();

        fwrite($successLog, date('Y-m-d H:i:s') . " SUCCESS: Email sent to $email\n");
        echo "✅ Sent: $email\n";
        $allEmails = array_diff($allEmails, [$email]);
        file_put_contents($emailFile, implode(PHP_EOL, $allEmails) . PHP_EOL);
    } catch (Exception $e) {
        fwrite($failLog, date('Y-m-d H:i:s') . " FAIL: Email to $email failed - {$mail->ErrorInfo}\n");
        echo "❌ Failed: $email - {$mail->ErrorInfo}\n";
    }

    sleep(rand(15, 20));
}

fclose($successLog);
fclose($failLog);
file_put_contents($cacheFile, json_encode($domainCache));

// Milestone check
$successCount = file_exists('success.log') ? count(file('success.log')) : 0;
$failCount = file_exists('fail.log') ? count(file('fail.log')) : 0;
$total = $successCount + $failCount;
$percentSent = $total > 0 ? round(($successCount / $total) * 100, 2) : 0;

$milestoneFile = 'last_milestone.txt';
$lastMilestone = file_exists($milestoneFile) ? (int)file_get_contents($milestoneFile) : 0;

if ($successCount >= $lastMilestone + 50) {
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = $hostm;
        $mail->SMTPAuth   = true;
        $mail->Username   = $user;
        $mail->Password   = $pass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom($user, $user);
        $mail->addAddress($testemail, 'Stats');
        $mail->Subject = "📬 Milestone Reached: $successCount sent";
        $mail->Body = "Email milestone reached:\n✅ Sent: $successCount\n❌ Failed: $failCount\n📈 Success Rate: $percentSent%";
        $mail->AltBody = strip_tags($mail->Body);
        $mail->send();

        file_put_contents($milestoneFile, $successCount);
        echo "📧 Milestone email sent at $successCount emails.\n";
    } catch (Exception $e) {
        echo "⚠️ Failed to send milestone email: {$mail->ErrorInfo}\n";
    }
}