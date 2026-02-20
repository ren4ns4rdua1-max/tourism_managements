<?php
// Read the current .env file
$envFile = __DIR__ . '/.env';
$content = file_get_contents($envFile);

// Check if MAIL_ settings already exist
if (strpos($content, 'MAIL_MAILER=') !== false) {
    echo "MAIL settings already exist in .env file\n";
} else {
    // Add MAIL settings to the .env file
    $mailSettings = "\n# Mail Settings\n";
    $mailSettings .= "MAIL_MAILER=smtp\n";
    $mailSettings .= "MAIL_HOST=smtp.gmail.com\n";
    $mailSettings .= "MAIL_PORT=587\n";
    $mailSettings .= "MAIL_USERNAME=ren4ns4rdua1@gmail.com\n";
    $mailSettings .= "MAIL_PASSWORD=brainprow5\n";
    $mailSettings .= "MAIL_ENCRYPTION=tls\n";
    $mailSettings .= "MAIL_FROM_ADDRESS=ren4ns4rdua1@gmail.com\n";
    $mailSettings .= "MAIL_FROM_NAME=\"Tourism Management\"\n";
    
    $content .= $mailSettings;
    file_put_contents($envFile, $content);
    echo "MAIL settings added to .env file\n";
}
