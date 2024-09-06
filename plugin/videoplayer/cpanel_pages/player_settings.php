 <div class="gra"><div class="gradient"><div class="title"><?php echo $lang['player_settings'];?></div> 
    <div class="men1">
<div class="pos"><div class="pos1"><a href="?p=player_settings&p2=internal_players_settings" class="link_gr">- <?php echo $lang['intplayersettings'];?></a></div></div>
<div class="pos"><div class="pos1"><a href="?p=player_settings&p2=external_players_settings" class="link_gr">- <?php echo $lang['extplayersettings'];?></a></div></div>
<div class="pos"><div class="pos1"><a href="?p=player_settings&p2=movie_settings" class="link_gr">- <?php echo $lang['moviesettings'];?></a></div></div>
<div class="pos"><div class="pos1"><a href="?p=player_settings&p2=gui_settings" class="link_gr">- <?php echo $lang['guisettings'];?></a></div></div>
    </div>
    
    </div> 
    <div class="ct">
<?php 
if(!isset($_GET['p2'])){ echo '<div class="title2">'.$lang['select'].'</div>'; }else{
if($_GET['p2'] == 'internal_players_settings'){ include('cpanel_pages/player_settings/internal_players_settings.php'); } 
if($_GET['p2'] == 'external_players_settings'){ include('cpanel_pages/player_settings/external_players_settings.php'); } 
if($_GET['p2'] == 'movie_settings'){ include('cpanel_pages/player_settings/movie_settings.php'); } 
if($_GET['p2'] == 'gui_settings'){ include('cpanel_pages/player_settings/gui_settings.php'); } 
}
?>
    </div></div>