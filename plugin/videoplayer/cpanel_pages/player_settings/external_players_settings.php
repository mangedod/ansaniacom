<?php
//query
if(isset($_POST['save'])){
$external_show_link = (int) $_POST['external_show_link'];
$external_show_gears = (int) $_POST['external_show_gears'];
$external_autostart = (int) $_POST['external_autostart'];
$external_isurl = (int) $_POST['external_isurl'];
mysql_query("UPDATE ".$prefix."player_config SET value='".$external_isurl."' WHERE name='external_isurl'");
mysql_query("UPDATE ".$prefix."player_config SET value='".$external_show_link."' WHERE name='external_show_link'");
mysql_query("UPDATE ".$prefix."player_config SET value='".$external_show_gears."' WHERE name='external_show_gears'");
mysql_query("UPDATE ".$prefix."player_config SET value='".$external_autostart."' WHERE name='external_autostart'");
}
//req
$sql = "SELECT * FROM ".$prefix."player_config";
$result = mysql_query($sql);
while($wynik=mysql_fetch_array($result)){
$tab = $wynik['name'];
$config[$tab] = $wynik['value'];
}

?>
<div class="title2"><?php echo $lang['extplayersettings'];?></div>
<div class="empty"></div>
<form action="" method="post">


<div class="form_header1"><div class="form_name"><?php echo $lang['showlinkoption'];?>:</div><div class="form_desc"><label><input type="radio" name="external_show_link" value="1" <?php if($config['external_show_link'] == 1){ echo 'CHECKED';}?>/> <?php echo $lang['on']; ?></label><label> <input type="radio" name="external_show_link" value="0" <?php if($config['external_show_link'] == 0){ echo 'CHECKED';}?>/> <?php echo $lang['off']; ?></label></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div><?php echo $lang['showlinkoptiond'];?>
</div></div>


<div class="form_header2"><div class="form_name"><?php echo $lang['showgearsoption']; ?>:</div><div class="form_desc"><label><input type="radio" name="external_show_gears" value="1" <?php if($config['external_show_gears'] == 1){ echo 'CHECKED';}?>/> <?php echo $lang['on']; ?></label><label> <input type="radio" name="external_show_gears" value="0" <?php if($config['external_show_gears'] == 0){ echo 'CHECKED';}?>/> <?php echo $lang['off']; ?></label></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div><?php echo $lang['showgearsoptiond']; ?>
</div></div>

<div class="form_header1"><div class="form_name"><?php echo $lang['autostart']; ?>:</div><div class="form_desc"><label><input type="radio" name="external_autostart" value="1" <?php if($config['external_autostart'] == 1){ echo 'CHECKED';}?>/> <?php echo $lang['on']; ?></label><label> <input type="radio" name="external_autostart" value="0" <?php if($config['external_autostart'] == 0){ echo 'CHECKED';}?>/> <?php echo $lang['off']; ?></label></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div><?php echo $lang['autostartd']; ?>
</div></div>

<div class="form_header2"><div class="form_name"><?php echo $lang['linkvideo']; ?>:</div><div class="form_desc"><label><input type="radio" name="external_isurl" value="1" <?php if($config['external_isurl'] == 1){ echo 'CHECKED';}?>/> <?php echo $lang['on']; ?></label><label> <input type="radio" name="external_isurl" value="0" <?php if($config['external_isurl'] == 0){ echo 'CHECKED';}?>/> <?php echo $lang['off']; ?></label></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div> <?php echo $lang['linkvideod']; ?>
</div></div>


<div class="form_header1"><div class="form_name">&nbsp;</div><div class="form_desc"><label><input type="submit" name="save" value="<?php echo $lang['save']; ?>"/></div>
</div></div>
</form>
<div class="empty"></div>