<?php
session_start();
ini_set("display_errors","On");

require_once 'google-api-php-client/src/apiClient.php';
require_once 'google-api-php-client/src/contrib/apiPlusService.php';

$client = new apiClient();
$client->setApplicationName("Google+ PHP Starter Application");

//*********** Replace with Your API Credentials **************
$client->setClientId('372760656064-nvqf4vmge3v0npntie4g9cfus7lra38r.apps.googleusercontent.com');
$client->setClientSecret('KWiKhDDfx5IxnSsYeApThxdC');
$client->setRedirectUri('http://dev.trijee.com/librari/gauth/index.php');
//
//$client->setDeveloperKey('AIzaSyDR2xOqAxl-dRhmt69qGVsd5gTTCQIDjHA');

//************************************************************
 
$client->setScopes(array('https://www.googleapis.com/auth/plus.me','email'));
$plus = new apiPlusService($client);

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
  unset($_SESSION['me']);
}

if(isset($_GET['code'])) 
{
  $client->authenticate();
  $_SESSION['access_token'] = $client->getAccessToken();
  header('location: ./index.php');
}

if (isset($_SESSION['access_token'])) {
  $client->setAccessToken($_SESSION['access_token']);
}

if($client->getAccessToken()) {
  $me = $plus->people->get('me');
  
  $_SESSION['me'] = $me;
  
  $optParams = array('maxResults' => 100);
  $activities = $plus->activities->listActivities('me', 'public', $optParams);


} else {
  $authUrl = $client->createAuthUrl();
}
?>