<?php
//query
if(isset($_POST['save'])){
$internal_show_link = (int) $_POST['internal_show_link'];
$internal_show_gears = (int) $_POST['internal_show_gears'];
$internal_autostart = (int) $_POST['internal_autostart'];

mysql_query("UPDATE ".$prefix."player_config SET value='".$internal_show_link."' WHERE name='internal_show_link'");
mysql_query("UPDATE ".$prefix."player_config SET value='".$internal_show_gears."' WHERE name='internal_show_gears'");
mysql_query("UPDATE ".$prefix."player_config SET value='".$internal_autostart."' WHERE name='internal_autostart'");
}
//req
$sql = "SELECT * FROM ".$prefix."player_config";
$result = mysql_query($sql);
while($wynik=mysql_fetch_array($result)){
$tab = $wynik['name'];
$config[$tab] = $wynik['value'];
}

?>
<div class="title2"><?php echo $lang['intplayersettings'];?></div>
<div class="empty"></div>
<form action="" method="post">


<div class="form_header1"><div class="form_name"><?php echo $lang['showlinkoption'];?>:</div><div class="form_desc"><label><input type="radio" name="internal_show_link" value="1" <?php if($config['internal_show_link'] == 1){ echo 'CHECKED';}?>/> <?php echo $lang['on']; ?><label> <input type="radio" name="internal_show_link" value="0" <?php if($config['internal_show_link'] == 0){ echo 'CHECKED';}?>/> <?php echo $lang['off']; ?></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div><?php echo $lang['showlinkoptiond'];?>
</div></div>


<div class="form_header2"><div class="form_name"><?php echo $lang['showgearsoption'];?>:</div><div class="form_desc"><label><input type="radio" name="internal_show_gears" value="1" <?php if($config['internal_show_gears'] == 1){ echo 'CHECKED';}?>/> <?php echo $lang['on']; ?><label> <input type="radio" name="internal_show_gears" value="0" <?php if($config['internal_show_gears'] == 0){ echo 'CHECKED';}?>/> <?php echo $lang['off']; ?></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div><?php echo $lang['showgearsoptiond'];?>
</div></div>

<div class="form_header1"><div class="form_name"><?php echo $lang['autostart'];?>:</div><div class="form_desc"><label><input type="radio" name="internal_autostart" value="1" <?php if($config['internal_autostart'] == 1){ echo 'CHECKED';}?>/> <?php echo $lang['on']; ?><label> <input type="radio" name="internal_autostart" value="0" <?php if($config['internal_autostart'] == 0){ echo 'CHECKED';}?>/> <?php echo $lang['off']; ?></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div><?php echo $lang['autostartd'];?>
</div></div>


<div class="form_header1"><div class="form_name">&nbsp;</div><div class="form_desc"><label><input type="submit" name="save" value="<?php echo $lang['save'];?>"/></div>
</div></div>
</form>
<div class="empty"></div>