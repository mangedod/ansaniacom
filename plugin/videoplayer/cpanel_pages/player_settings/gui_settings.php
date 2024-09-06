<?php
//query
if(isset($_POST['save'])){
$base_font_color = str_replace("#", "", $_POST['base_font_color']);
$active_font_color =  str_replace("#", "", $_POST['active_font_color']);
$rev =  (int) $_POST['rev'];
$interface_gradient_colors_1 =  str_replace("#", "", $_POST['interface_gradient_colors_1']);
$interface_gradient_colors_2 =  str_replace("#", "", $_POST['interface_gradient_colors_2']);
$interface_gradient_colors_3 =  str_replace("#", "", $_POST['interface_gradient_colors_3']);
$logo_url =  $_POST['logo_url'];
@ $size = getimagesize($_POST['logo_url']);
$logo_w = $size[0];
$logo_h = $size[1];

mysql_query("UPDATE ".$prefix."player_config SET value='".$rev."' WHERE name='reverse_menu'");
mysql_query("UPDATE ".$prefix."player_config SET value='".$logo_h."' WHERE name='logo_h'");
mysql_query("UPDATE ".$prefix."player_config SET value='".$logo_w."' WHERE name='logo_w'");
mysql_query("UPDATE ".$prefix."player_config SET value='".$logo_url."' WHERE name='logo_url'");
mysql_query("UPDATE ".$prefix."player_config SET value='".$base_font_color."' WHERE name='base_font_color'");
mysql_query("UPDATE ".$prefix."player_config SET value='".$active_font_color."' WHERE name='active_font_color'");
mysql_query("UPDATE ".$prefix."player_config SET value='".$interface_gradient_colors_1."' WHERE name='interface_gradient_colors_1'");
mysql_query("UPDATE ".$prefix."player_config SET value='".$interface_gradient_colors_2."' WHERE name='interface_gradient_colors_2'");
mysql_query("UPDATE ".$prefix."player_config SET value='".$interface_gradient_colors_3."' WHERE name='interface_gradient_colors_3'");
}
//req
$sql = "SELECT * FROM ".$prefix."player_config";
$result = mysql_query($sql);
while($wynik=mysql_fetch_array($result)){
$tab = $wynik['name'];
$config[$tab] = $wynik['value'];
}

?><div class="title2"><?php echo $lang['guisettings'];?></div>
<div class="empty"></div>
<form action="" method="post">
<div id="colorpicker301" class="colorpicker301"></div>
<div class="form_header2"><div class="form_name"><?php echo $lang['basefont'];?>:</div><div class="form_desc"><div><input type="text" ID="input_field_1" name="base_font_color" value="#<?php echo $config['base_font_color'];?>"/></div><input type="text" ID="sample_1" size="1" style="background-color:#<?php echo $config['base_font_color'];?>;" value="">&nbsp;</div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div><a href="javascript:void(0)" onclick="showColorGrid3('input_field_1','sample_1');" class="link_gr">[<?php echo $lang['choosecolor'];?>]</a>
</div></div>

<div class="form_header1"><div class="form_name"><?php echo $lang['activefont'];?>:</div><div class="form_desc"><input type="text" ID="input_field_2" name="active_font_color" value="#<?php echo $config['active_font_color'];?>"/><input type="text" ID="sample_2" size="1" style="background-color:#<?php echo $config['active_font_color'];?>;" value=""></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div><a href="javascript:void(0)" onclick="showColorGrid3('input_field_2','sample_2');" class="link_gr">[<?php echo $lang['choosecolor'];?>]</a>
</div></div>

<div class="form_header2"><div class="form_name"><?php echo $lang['gradient'];?> (1):</div><div class="form_desc"><input type="text" ID="input_field_3" name="interface_gradient_colors_1" value="#<?php echo $config['interface_gradient_colors_1'];?>"/><input type="text" ID="sample_3" size="1" value="" style="background-color:#<?php echo $config['interface_gradient_colors_1'];?>;"></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div><a href="javascript:void(0)" onclick="showColorGrid3('input_field_3','sample_3');" class="link_gr">[<?php echo $lang['choosecolor'];?>]</a>
</div></div>

<div class="form_header1"><div class="form_name"><?php echo $lang['gradient'];?> (2):</div><div class="form_desc"><input type="text" ID="input_field_4" value="#<?php echo $config['interface_gradient_colors_2'];?>" name="interface_gradient_colors_2" /><input type="text" ID="sample_4" size="1" value="" style="background-color:#<?php echo $config['interface_gradient_colors_2'];?>;"></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div><a href="javascript:void(0)" onclick="showColorGrid3('input_field_4','sample_4');" class="link_gr">[<?php echo $lang['choosecolor'];?>]</a>
</div></div>

<div class="form_header2"><div class="form_name"><?php echo $lang['gradient'];?> (3):</div><div class="form_desc"><input type="text" ID="input_field_5" name="interface_gradient_colors_3" value="#<?php echo $config['interface_gradient_colors_3'];?>"/><input type="text" ID="sample_5" size="1" value="" style="background-color:#<?php echo $config['interface_gradient_colors_3'];?>;"></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div><a href="javascript:void(0)" onclick="showColorGrid3('input_field_5','sample_5');" class="link_gr">[<?php echo $lang['choosecolor'];?>]</a>
</div></div>

<div class="form_header1"><div class="form_name"><?php echo $lang['revmenu'];?>:</div><div class="form_desc"><label><input type="radio" name="rev" value="1" <?php if($config['reverse_menu'] == 1){ echo 'CHECKED';}?>/> <?php echo $lang['up'];?></label><label> <input type="radio" name="rev" value="0" <?php if($config['reverse_menu'] == 0){ echo 'CHECKED';}?>/> <?php echo $lang['down'];?></label></div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div><?php echo $lang['revmenud'];?>
</div></div>

<div class="form_header2"><div class="form_name"><?php echo $lang['logo'];?>:</div><div class="form_desc"><input type="text" value="<?php echo $config['logo_url'];?>" name="logo_url" /> [png]</div>
<div class="form_name">&nbsp;</div><div class="form_desc">
<div class="form_belka"></div><?php echo $lang['uractlogo'];?>:<br />
<img src="<?php echo $config['logo_url'];?>" /><br>
<b><?php echo $lang['width'];?>:</b> <?php echo $config['logo_w'];?>px <b><?php echo $lang['height'];?>:</b> <?php echo $config['logo_h'];?>px
</div></div>

<div class="form_header1"><div class="form_name">&nbsp;</div><div class="form_desc"><label><input type="submit" name="save" value="<?php echo $lang['save'];?>"/></div>
</div></div>
</form>
<div class="empty"></div>