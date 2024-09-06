<?php
if(!file_exists('../config.php')){
 $error = 1;
}

?>

<div class="title2">Database</div>
<div class="empty"></div>    
<div class="ct">
<?php
if(empty($error)){
require_once('../config.php');

mysql_query("CREATE TABLE IF NOT EXISTS `".$prefix."player_config` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `value` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;
");
mysql_query("INSERT INTO `".$prefix."player_config` (`id`, `name`, `value`) VALUES
(2, 'internal_show_link', '1'),
(5, 'internal_show_gears', '1'),
(6, 'internal_autostart', '0'),
(9, 'external_show_link', '1'),
(11, 'external_show_gears', '1'),
(13, 'external_autostart', '0'),
(15, 'allow_smoothing', '1'),
(16, 'deblocking', '0'),
(18, 'base_font_color', '434343'),
(19, 'active_font_color', '97d611'),
(20, 'interface_gradient_colors_1', 'f7f7f7'),
(21, 'interface_gradient_colors_2', 'f7f7f7'),
(22, 'interface_gradient_colors_3', 'bdbdbd'),
(23, 'logo_url', 'http://web-anatomy.com/flv_player/player/serce.png'),
(24, 'logo_w', '213'),
(25, 'logo_h', '53'),
(27, 'external_isurl', '1'),
(30, 'reverse_menu', '1'),
(31, 'select_method', '');");



  if(!mysql_error()){
  echo '<div class="title2">Finish! <span class="red"><u>DELETE INSTALL FOLDER</u></span></div>
  
  <div class="form_name">&nbsp;</div><div class="form_desc"><label><input type="button" name="save" value="FINISH" onClick="window.location=\'http://'.$domain.'/'.$player_folder.'\';"/></div>';
  }else{
  echo 'Error: '.mysql_error();
  }

  
 }else{ ?>
<div class="title2"><span class="red"> Couldn't find config.php file, back to step 2 to create it. </span></div>
  
  <div class="form_header1"><div class="form_name">&nbsp;</div><div class="form_desc"><label><input type="button" name="save" value="Back to step 2" onClick="window.location='?step=2';"/></div>
<?php } ?>
</div></div>
</div>
