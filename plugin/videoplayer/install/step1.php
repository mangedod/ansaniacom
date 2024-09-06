<?php
$err = 0;

$files = array();
$files[] = '../cpanel_pages/start.php';
$files[] = '../cpanel_pages/player_settings.php';
$files[] = '../cpanel_pages/player_settings/external_players_settings.php';
$files[] = '../cpanel_pages/player_settings/internal_players_settings.php';
$files[] = '../cpanel_pages/player_settings/movie_settings.php';
$files[] = '../cpanel_pages/player_settings/gui_settings.php';
$files[] = '../player/selectit.php';
$files[] = '../player/video_select.php';
$files[] = '../player/waPlayer.swf';
$files[] = '../player/xml_connect.php';
$files[] = '../system/Auth.Class.php';
$files[] = '../system/login.php';
$files[] = '../system/move_to.php';
$files[] = '../einterface.php';
$files[] = '../index.php';
?>

<div class="title2">Checking files</div>
<div class="empty"></div>    
<div class="ct">
<table width="551" border="0">
  <tr>
    <td width="57" align="left">&nbsp;</td>
    <td width="439" align="left"><b>File patch:</b></td>
    <td width="41" align="center"><b>Status:</b></td>
  </tr>
  <?php
  foreach($files as $value){
  if (!file_exists($value)) { $status = '<span class="red"><b>x</b></span>'; $err = 1;}else{ $status = '<span class="green">ok</span>';}
  echo'
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">'.$value.'</td>
    <td align="center">'.$status.'</td>
  </tr>';
  }
  ?>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<?php if($err != 1){ ?>
<div class="form_header1"><div class="form_name">&nbsp;</div><div class="form_desc"><label><input type="button" name="save" value="Next step" onClick="window.location='?step=2';"/></div>
<?php }else{?>
<div class="title2">Files with <span class="red"><b>x</b></span> doesn't exits, installation aborted.</div>
<?php } ?>
</div></div>
</div>