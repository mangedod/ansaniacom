<?
//$_GET['code'] <- id (u'll get it from player show)

$id = (int) $_GET['code']; // filtering

if($id == 1){
$video = 'http://vplanet.pl/upload/filmy/7176_47e408682d122.flv';//url to flv file
$thumb = 'http://vplanet.pl/thumbs/duze/7176.jpg'; //Thumbnail must be located in the same domain as SWF file (otherwise Flash's sandbox will block content)
$link = 'http://vplanet.pl';//url to web site
}
?>