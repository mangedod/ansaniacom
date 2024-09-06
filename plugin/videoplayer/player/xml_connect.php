<?php
require_once('../config.php');

$sql4 = "SELECT * FROM ".$prefix."player_config";
$result4 = mysql_query($sql4);
while($wynik4=mysql_fetch_array($result4)){
$tab = $wynik4['name'];
$config[$tab] = $wynik4['value'];
}
$page = mysql_real_escape_string($_GET['ref']);

if(strpos($page, $domain)===false){
$isExternal = $config['external_isurl'];
$player_loc = 'external';
$isExternal = 1;
}else{
$player_loc = 'internal';
$isExternal = 0;
}
	
if($config['select_method'] == 1){
require_once('video_select.php');
}else{
$_GET['code'] = str_replace('[]','&',$_GET['code']);
require_once('selectit.php');
}

if(empty($thumb)){$thumb = 0;}
if(empty($video)){$video = 0;}
if(empty($link)){$link = 0;}

echo'<?xml version="1.0" encoding="UTF-8"?>
<decoder>
<sys urlMOV="'.$video.'" thumbMOV="'.$thumb.'" linkMOV="'.$link.'" logo="'.$config['logo_url'].'" mount="'.$config['logo_h'].'" rev="'.$config['reverse_menu'].'" auto="'.$config[$player_loc.'_autostart'].'" fontColor="'.$config['base_font_color'].'" activeColor="'.$config['active_font_color'].'" silverColor1="'.$config['interface_gradient_colors_1'].'" silverColor2="'.$config['interface_gradient_colors_2'].'" silverColor3="'.$config['interface_gradient_colors_3'].'" isLink="'.$config[$player_loc.'_show_link'].'"  isGears="'.$config[$player_loc.'_show_gears'].'" deblocking="'.$config['deblocking'].'" smoothing="'.$config['allow_smoothing'].'" isExternal="'.$isExternal.'" />

</decoder>';

?>