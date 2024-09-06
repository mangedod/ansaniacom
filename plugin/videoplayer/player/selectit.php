<?php
$get = explode('::',$_GET['code']);

$video = str_replace('video=','',$get[0]);
$thumb = str_replace('thumb=','',$get[1]);
$link = str_replace('url=','',$get[2]);
?> 