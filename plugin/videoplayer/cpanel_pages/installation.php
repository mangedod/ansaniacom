<?php 
if(isset($_POST['select_vid']) && isset($_POST['save1'])){
mysql_query("UPDATE ".$prefix."player_config SET value='".$_POST['select_vid']."' WHERE name='select_method'");
}

$sql = "SELECT * FROM ".$prefix."player_config";
$result = mysql_query($sql);
while($wynik=mysql_fetch_array($result)){
$tab = $wynik['name'];
$config[$tab] = $wynik['value'];
}
?>

<div class="gra"> <div class="gradient"><div class="title"><?php echo $lang['installation'];?></div> 
    <div class="men1">
<div class="pos"><div class="pos1"><a href="?p=installation&p2=main_installation" class="link_gr">- <?php echo $lang['main_installation'];?></a></div></div>
    </div>
    <div class="empty"></div>
    <div class="pos"><div class="pos1" <?php if($config['select_method'] == ''){echo'style="color:red;"';}?>><b><?php echo $lang['method'];?>:</b></div></div>
    <form method="post" action="">
    <span><input type="radio" name="select_vid" value="0" <?php if($config['select_method'] == '0'){echo'CHECKED';}?>/> <?php echo $lang['method1'];?></span><br />
	<span><input type="radio" name="select_vid" value="1" <?php if($config['select_method'] == '1'){echo'CHECKED';}?>/> <?php echo $lang['method2'];?></span><br />
    <input type="submit" name="save1" value="<?php echo $lang['save'];?>"/>
	</form>
    </div><div class="ct">
<?php 
if(!isset($_GET['p2'])){ $_GET['p2'] = 'main_installation'; }
if($_GET['p2'] == 'main_installation'){ include('cpanel_pages/installation/main_installation.php'); } 
?>
    </div></div>