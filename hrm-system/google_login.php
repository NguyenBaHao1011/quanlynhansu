<?php
require __DIR__ . '/vendor/autoload.php';

$client = new Google\Client();

$client->setClientId('YOUR_CLIENT_ID');
$client->setClientSecret('YOUR_CLIENT_SECRET');
$client->setRedirectUri('http://localhost/hrm-system/google_callback.php');

$client->addScope("email");
$client->addScope("profile");

header('Location: ' . $client->createAuthUrl());
exit;