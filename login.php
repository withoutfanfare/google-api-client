<?php
	require_once 'vendor/autoload.php';

	session_start();

	$client = new Google_Client();
	$client->setAuthConfig('client_secret.json');

	// set the scopes
	// $client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);
	$client->addScope(Google_Service_Oauth2::USERINFO_PROFILE);

	// set the redirect url
	$client->setRedirectUri('http://localhost:8000/google/callback');

	// set the access type
	$client->setAccessType('online');

	// set the approval prompt
	$client->setApprovalPrompt('auto');

	// get the auth url
	$auth_url = $client->createAuthUrl();

	// redirect to the auth url
	header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));

	exit;
