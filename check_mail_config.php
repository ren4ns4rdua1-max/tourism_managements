<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "MAIL_MAILER: " . env('MAIL_MAILER', 'not set') . PHP_EOL;
echo "MAIL_HOST: " . env('MAIL_HOST', 'not set') . PHP_EOL;
echo "MAIL_PORT: " . env('MAIL_PORT', 'not set') . PHP_EOL;
echo "MAIL_USERNAME: " . env('MAIL_USERNAME', 'not set') . PHP_EOL;
echo "MAIL_PASSWORD: " . env('MAIL_PASSWORD', 'not set') . PHP_EOL;
echo "MAIL_ENCRYPTION: " . env('MAIL_ENCRYPTION', 'not set') . PHP_EOL;
echo "MAIL_FROM_ADDRESS: " . env('MAIL_FROM_ADDRESS', 'not set') . PHP_EOL;
echo "MAIL_FROM_NAME: " . env('MAIL_FROM_NAME', 'not set') . PHP_EOL;
