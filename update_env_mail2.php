<?php
// Read the current .env file
$envFile = __DIR__ . '/.env';
$content = file_get_contents($envFile);

// Define the MAIL settings to update
$mailSettings = array(
    'MAIL_MAILER' => 'smtp',
    'MAIL_HOST' => 'smtp.gmail.com',
    'MAIL_PORT' => '587',
    'MAIL_USERNAME' => 'ren4ns4rdua1@gmail.com',
    'MAIL_PASSWORD' => 'brainprow5',
    'MAIL_ENCRYPTION' => 'tls',
    'MAIL_FROM_ADDRESS' => 'ren4ns4rdua1@gmail.com',
    'MAIL_FROM_NAME' => '"Tourism Management"'
);

foreach ($mailSettings as $key => $value) {
    // Check if the setting exists and update it, or add it if not
    if (preg_match("/^{$key}=.*$/m", $content)) {
        $content = preg_replace("/^{$key}=.*$/m", "{$key}={$value}", $content);
        echo "Updated: {$key}={$value}\n";
    } else {
        $content .= "\n{$key}={$value}";
        echo "Added: {$key}={$value}\n";
    }
}

file_put_contents($envFile, $content);
echo "\nDone! MAIL settings updated in .env file\n";
