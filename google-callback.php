<?php
session_start();
require_once 'vendor/autoload.php';

$client = new Google_Client();

$client->setClientId("YOUR_GOOGLE_CLIENT_ID");
$client->setClientSecret("YOUR_GOOGLE_CLIENT_SECRET");
$client->setRedirectUri("http://localhost/help-desk-system/google-callback.php");

if (!isset($_GET['code'])) {
    exit("Login failed");
}

$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
$client->setAccessToken($token['access_token']);

$oauth = new Google_Service_Oauth2($client);
$user = $oauth->userinfo->get();

/* USER DATA */
$email = $user->email;
$name = $user->name;
$picture = $user->picture;

/* STORE SESSION */
$_SESSION['user'] = [
    "name" => $name,
    "email" => $email,
    "avatar" => $picture
];

/* REDIRECT */
header("Location: index.php");
exit;