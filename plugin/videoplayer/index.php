<?php
if(!file_exists('config.php')){ header("Location:install/install.php");}
require_once('config.php');
require_once('language/'.$language.'.php');
require_once('system/Auth.Class.php'); 
$oAuth = new Auth();
if(isset($_GET['logout'])){ $oAuth->Logout(); }
if($oAuth->UserName() != $admin_login){ require_once('system/login.php'); }
if($oAuth->UserName() === $admin_login){

$sql = "SELECT * FROM ".$prefix."player_config";
$result = mysql_query($sql);
while($wynik=mysql_fetch_array($result)){
$tab = $wynik['name'];
$config[$tab] = $wynik['value'];
}

if($config['select_method'] == ''){ if($_GET['p'] != 'installation'){ echo '<script type="text/javascript">window.location = \'http://'.$domain.'/'.$player_folder.'/index.php?p=installation\';</script>'; } }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Web-Anatomy: Flv-Player</title>
<link href="css.css" type="text/css" rel="stylesheet" />
<script src="DHTMLcolors/301a.js" type="text/javascript"></script>
</head>

<body><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>

    <td align="center"><table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="1000px">
<div class="page">
	<div class="header"><div class="logo"><img src="images/logo.jpg" /></div>
	<div class="menu"><a href="index.php" class="white"><?php echo $lang['start'];?></a> | <a href="?p=player_settings" class="white"><?php echo $lang['player_settings'];?></a>  | <a href="?p=installation" class="white"><?php echo $lang['installation'];?></a> | <a href="http://web-anatomy.com" class="white"> <?php echo $lang['wawebsite'];?></a> | <a href="?logout" class="white"> [ <?php echo $lang['logout'];?> ]</a></div>
	</div>
    
    <div class="content"><div class="inside">
   <?php
   if(!isset($_GET['p']) or $_GET['p'] == 'start'){ include('cpanel_pages/start.php'); }else{
   if($_GET['p'] == 'player_settings'){ include('cpanel_pages/player_settings.php'); }
   if($_GET['p'] == 'installation'){ include('cpanel_pages/installation.php'); }
   }
   ?>
    </div></div>
	<div class="footer">Copyrights (c) 2008 by <a href="http://web-anatomy.com" class="white">www.Web-Anatomy.com</a> All rights reserved  	 </div>
</div>
</td></tr></table></td></tr></table>
</body>
</html>

<?php
}else{
echo'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css.css" type="text/css" rel="stylesheet" />
<title>Web-Anatomy: Flv-Player</title>
</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="500px"><form action="index.php" method="post">
		  <div class="bigFont2">'.$lang['getaccess'].'</div> 
		  <div class="logIn"><div class="logIn2"><div class="logIn3">'.$lang['login'].':</div><div class="logIn4"><input type="text" name="username" value="'; if(!empty($_POST['username'])){echo $_POST['username'];}echo'"></div>
		  <div class="logIn3">'.$lang['password'].':</div> <div class="logIn4"><input type="password" name="userpass"></div>';
		if(!empty($alert1)){ echo '<div class="logIn3">&nbsp;</div> <div class="logIn4"><span class="red">'.$alert1.'</span></div>';}  
		  echo'<div class="logIn3">&nbsp;</div> <div class="logIn4"><input type="submit" value="Login"></div></div></div>
		  </td></tr>
		</table></form>
	</td></tr>	  
</body>
</html>
';
}
