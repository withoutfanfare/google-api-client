<?php

require_once '../vendor/autoload.php';

$home_url = '/';
$private_url = '/restricted';

session_start();

$client = new Google_Client();
$client->setAuthConfig('../client_secret.json');

if(isset($_SESSION['access_token']) && !empty($_SESSION['access_token'])) {
	$client->setAccessToken($_SESSION['access_token']);
	header('Location: ' . filter_var($private_url, FILTER_SANITIZE_URL));
	exit;
} else {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    exit;
}