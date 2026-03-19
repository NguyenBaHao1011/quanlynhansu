<?php
require __DIR__ . '/vendor/autoload.php';

$client = new Google\Client();

$client->setClientId('YOUR_CLIENT_ID');
$client->setClientSecret('YOUR_CLIENT_SECRET');
$client->setRedirectUri('http://localhost/hrm-system/google_callback.php');

if (!isset($_GET['code'])) {
    die("Không nhận được code");
}

$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
$client->setAccessToken($token);

$oauth = new Google\Service\Oauth2($client);
$user = $oauth->userinfo->get();

session_start();
$_SESSION['user'] = $user->email;

echo "Đăng nhập thành công: " . $user->email;