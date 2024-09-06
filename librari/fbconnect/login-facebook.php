<?php
require 'facebook/facebook.php';
require 'config/fbconfig.php';

$facebook = new Facebook(array(
            'appId' => APP_ID,
            'secret' => APP_SECRET,
            ));

$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } 
  catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
  
    if (!empty($user_profile )) 
	{
	    $username = $user_profile['name'];
		$uid      = $user_profile['id'];
		$email    = $user_profile['email'];
		$fblink   = $user_profile['link'];
		$avatar   = "https://graph.facebook.com/$uid/picture";

        $_SESSION['fbid']     	= $uid;
        $_SESSION['fbname']   	= $username;
        $_SESSION['fbemail']  	= $email;
		$_SESSION['fbavatar'] 	= $avatar;
		$_SESSION['fblink'] 	= $fblink;
    }
} 
else {
  $login_url = $facebook->getLoginUrl(array( 'scope' => 'email,publish_actions'));
	// $login_url = $facebook->getLoginUrl(array( 'scope' => 'email,publish_stream,publish_actions,user_activities,status_update'));
	
	header("Location: " . $login_url);
}
?>
