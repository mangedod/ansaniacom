<?php
//query
if(isset($_POST['save'])){
$allow_smoothing = (int) $_POST['allow_smoothing'];
$deblocking = (int) $_POST['deblocking'];

mysql_query("UPDATE ".$prefix."player_config SET value='".$allow_smoothing."' WHERE name='allow_smoothing'");
mysql_query("UPDATE ".$prefix."player_config SET value='".$deblocking."' WHERE name='deblocking'");
}
//req
$sql = "SELECT * FROM ".$prefix."player_config";
$result = mysql_query($sql);
while($wynik=mysql_fetch_array($result)){
$tab = $wynik['name'];
$config[$tab] = $wynik['value'];
}

?>
<div class="title2"><?php echo $lang['moviesettings'];?></div>
<form action="" method="post">
<div class="form_header2"><div class="form_name"><?php echo $lang['allowsmoothing'];?>:</div><div class="form_desc"><label><input type="radio" name="allow_smoothing" value="1" <?php if($config['allow_smoothing'] == 1){ echo 'CHECKED';}?>/> <?php echo $lang['on'];?></label><label> <input type="radio" name="allow_smoothing" value="0" <?php if($config['allow_smoothing'] == 0){ echo 'CHECKED';}?>/> <?php echo $lang['off'];?></label></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div><?php echo $lang['allowsmoothingd'];?>
</div></div>

<div class="form_header1"><div class="form_name"><?php echo $lang['deblocking'];?>:</div><div class="form_desc"><label><input type="radio" name="deblocking" value="0" <?php if($config['deblocking'] == 0){ echo 'CHECKED';}?>/> 0</label><label> <input type="radio" name="deblocking" value="1" <?php if($config['deblocking'] == 1){ echo 'CHECKED';}?>/> 1</label><label> <input type="radio" name="deblocking" value="2" <?php if($config['deblocking'] == 2){ echo 'CHECKED';}?>/> 2</label><label> <input type="radio" name="deblocking" value="3" <?php if($config['deblocking'] == 3){ echo 'CHECKED';}?>/> 3</label><label> <input type="radio" name="deblocking" value="4" <?php if($config['deblocking'] == 4){ echo 'CHECKED';}?>/> 4</label><label> <input type="radio" name="deblocking" value="5" <?php if($config['deblocking'] == 5){ echo 'CHECKED';}?>/> 5</label></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div>0 - <?php echo $lang['allowthebest'];?>.
<br />1 - <?php echo $lang['dont'];?>. 
<br />2 - <?php echo $lang['usesorenson'];?>.<br />3 - <?php echo $lang['useon2'];?>. 
<br />4 - <?php echo $lang['useon22'];?>. 
<br />5 - <?php echo $lang['useon23'];?>.<br />
</div></div>

<div class="form_header1"><div class="form_name">&nbsp;</div><div class="form_desc"><label><input type="submit" name="save" value="<?php echo $lang['save'];?>"/></div>
</div></div>
</form>
<div class="empty"></div>