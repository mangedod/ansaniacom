<?php
require 'facebook/facebook.php';
require 'config/fbconfig.php';

$facebook = new Facebook(array(
            'appId' => APP_ID,
            'secret' => APP_SECRET,
            ));
$user = $facebook->getUser();
?>
