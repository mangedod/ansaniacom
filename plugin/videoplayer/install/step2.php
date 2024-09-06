<?php
$check = 0;

$langs = array();
if ($handle = opendir('../language')) {
    /* To jest poprawna metoda  */
    while (false !== ($file = readdir($handle))) {
        $langs[] = $file;
    }

    closedir($handle);
}

$err=1;

if(isset($_POST['save'])){
$errors = array();

if(empty($_POST['host'])){
$errors[] = 'Field: Host is empty';
}
if(empty($_POST['name'])){
$errors[] = 'Field: Data base name is empty';
}
if(empty($_POST['login'])){
$errors[] = 'Field: Data base login is empty';
}
if(empty($_POST['password'])){
$errors[] = 'Field: Data base password is empty';
}
if(empty($_POST['domain'])){
$errors[] = 'Field: Domain is empty';
}
if(empty($_POST['folder'])){
$errors[] = 'Field: Language is empty';
}
if(empty($_POST['adm_login'])){
$errors[] = 'Field: Admin login is empty';
}
if(empty($_POST['adm_password'])){
$errors[] = 'Field: Admin password is empty';
}
if(empty($_POST['language'])){ 
$errors[] = 'Field: Language is empty';
}

@ $tt2 = file_get_contents('http://google.com');

if($tt2){

if(!empty($_POST['domain']) && !empty($_POST['folder'])){
@ $tt = file_get_contents('http://'.$_POST['domain'].'/'.$_POST['folder'].'/index.php');
	if (!$tt){
	$errors[] = 'Domain or Folder field is incorrect, couldnt connect to file: http://'.$_POST['domain'].'/'.$_POST['folder'].'/index.php';
	}
}

}

if(!empty($_POST['host']) && !empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['name'])){
@ $connect = mysql_connect($_POST['host'], $_POST['login'], $_POST['password']) 
or $errors[] = 'Couldn\'t connect to database: ' . mysql_error();
@ $connect2 = mysql_select_db($_POST['name'], $connect);
	if(!$connect2 && $connect){
		$errors[] = 'Incorrect data base name';
	}
}

if(empty($errors)){
$check =1;
}
}
?>

<div class="title2">Configuration file</div>
<div class="empty"></div>    
<div class="ct">
<?php
if(!empty($errors)){
foreach($errors as $value){
			echo '<span class="red"><b>'.$value.'</b></span><br>';
		}
}

if($check != 1){

?>
<form action="" method="post">
<div class="form_header1"><div class="form_name">Data base host:</div><div class="form_desc"><label><input type="text" name="host" value="<?php if(!empty($_POST['host'])){ echo $_POST['host']; }?>"></label></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div> usually: localhost
</div></div>

<div class="form_header2"><div class="form_name">Data base name:</div><div class="form_desc"><label><input type="text" name="name" value="<?php if(!empty($_POST['name'])){ echo $_POST['name']; } ?>" /></label></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div> write data base name
</div></div>

<div class="form_header1"><div class="form_name">Data base login:</div><div class="form_desc"><label><input type="text" name="login" value="<?php if(!empty($_POST['login'])){ echo $_POST['login']; } ?>" /></label></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div> write data base login
</div></div>


<div class="form_header2"><div class="form_name">Data base password:</div><div class="form_desc"><label><input type="password" name="password" value="<?php if(!empty($_POST['password'])){ echo $_POST['password']; } ?>" /></label></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div> write data base password
</div></div>

<div class="form_header1"><div class="form_name">Data base prefix:</div><div class="form_desc"><label><input type="text" name="prefix" value="<?php if(!empty($_POST['prefix'])){ echo $_POST['prefix']; }?>" /></label></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div> prevent for overwriting tables (optionally)
</div></div>

<div class="form_header2"><div class="form_name">Your domain:</div><div class="form_desc"><label><input type="text" name="domain" value="<?php if(isset($_POST['domain'])){ echo $_POST['domain']; }else{ echo $_SERVER['SERVER_NAME']; } ?>" /></label></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div> domain where player is placed (example: google.pl)
</div></div>

<div class="form_header1"><div class="form_name">Player folder:</div><div class="form_desc"><label><input type="text" name="folder" value="<?php if(!empty($_POST['folder'])){ echo $_POST['folder'];}else{echo 'flv_player';} ?>" /></label></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div> folder where player is placed (propably: flv_player)
</div></div>

<div class="form_header2"><div class="form_name">Admin login:</div><div class="form_desc"><label><input type="text" name="adm_login" value="<?php if(!empty($_POST['adm_login'])){ echo $_POST['adm_login']; }?>" /></label></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div> write your control panel login
</div></div>

<div class="form_header1"><div class="form_name">Admin password:</div><div class="form_desc"><label><input type="password" name="adm_password" value="<?php if(!empty($_POST['adm_password'])){ echo $_POST['adm_password']; }?>" /></label></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div> write your control panel password
</div></div>


<div class="form_header1"><div class="form_name">Panel language:</div><div class="form_desc"><label><select name="language">
<?php
foreach($langs as $value){
if($value != '.' && $value != '..'){
$value = str_replace(".php", "", $value);
echo'<option>'.$value.'</option>';
}
}
?></select></label></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div> select control panel language
</div></div>

<div class="form_header1"><div class="form_name">&nbsp;</div><div class="form_desc"><label><input type="submit" name="save" value="Generate config file"/></div>
</form>
<?php }else{ ?>
  <textarea name="textarea" id="textarea" cols="60" rows="15"><?php 
  echo '<?php
$dbhost  = \''.$_POST['host'].'\';
$dbname  = \''.$_POST['name'].'\';
$dblogin = \''.$_POST['login'].'\';
$dbhaslo = \''.$_POST['password'].'\';
$connect = mysql_connect($dbhost, $dblogin, $dbhaslo); 
mysql_select_db($dbname, $connect);
$prefix = \''.$_POST['prefix'].'\';

$language = \''.$_POST['language'].'\';

$domain = \''.$_POST['domain'].'\';
$player_folder = \''.$_POST['folder'].'\'; 

$admin_login = \''.$_POST['adm_login'].'\'; 
$admin_pass = \''.$_POST['adm_password'].'\';
?>';
  ?></textarea>
  <div class="title2">Save it as config.php in <span class="red"><?php echo $_POST['folder'];?></span> folder</div>
  
  <div class="form_header1"><div class="form_name">&nbsp;</div><div class="form_desc"><label><input type="button" name="save" value="Check it and follow next step" onClick="window.location='?step=3';"/></div>
  
<?php } ?>
</div></div>
</div>