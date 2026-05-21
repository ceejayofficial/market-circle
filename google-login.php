<?php
session_start();

/*
  STEP 1:
  Install Google Client:
  composer require google/apiclient
*/

require_once 'vendor/autoload.php';

$client = new Google_Client();

$client->setClientId("YOUR_GOOGLE_CLIENT_ID");
$client->setClientSecret("YOUR_GOOGLE_CLIENT_SECRET");
$client->setRedirectUri("http://localhost/help-desk-system/google-callback.php");

$client->addScope("email");
$client->addScope("profile");

// Redirect user to Google
header("Location: " . $client->createAuthUrl());
exit;