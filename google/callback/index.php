<?php

// require vendor autoload file
require_once '../../vendor/autoload.php';

$home_url = '/';
$private_url = '/google';

session_start();
$client = new Google_Client();
$client->setAuthConfig('../../client_secret.json');

$token = false;

if(isset($_SESSION['access_token']) && !empty($_SESSION['access_token'])) {
	$client->setAccessToken($_SESSION['access_token']);
	header('Location: ' . filter_var($private_url, FILTER_SANITIZE_URL));
	exit;
}

if (isset($_GET['code'])) {
	$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

	$oauth2 = new Google_Service_Oauth2($client);
	$user = $oauth2->userinfo->get();

	$_SESSION['access_token'] = $token['access_token'];
	$_SESSION['email'] = $user['email'];
	$_SESSION['picture'] = $user['picture'];
	$_SESSION['name'] = $user['name'];
	$_SESSION['id'] = $user['id'];

	header('Location: ' . filter_var($private_url, FILTER_SANITIZE_URL));
	exit;
} else {
	header('Location: ' . filter_var($home_url, FILTER_SANITIZE_URL));
	exit;
}




// if ($client->getAccessToken()) {
// 	$user = $oauth2->userinfo->get();
// 	$_SESSION['email'] = $user['email'];
// 	$_SESSION['picture'] = $user['picture'];
// 	$_SESSION['name'] = $user['name'];
// 	$_SESSION['id'] = $user['id'];
// 	$_SESSION['token'] = $token;
// 	header('Location: http://localhost:8000/google');
// 	exit;
// } else {
// 	$auth_url = $client->createAuthUrl();
// 	header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
// 	exit;
// }