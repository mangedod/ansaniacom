<?php
include "../../setingan/global.inc.php";
include "../../setingan/web.fungsi.php";

$content = $_GET['id'];

echo '<rss version="2.0" xmlns:jwplayer="http://rss.jwpcdn.com/">
<channel> 
  ';

$sql		= "select id,nama,ringkas,video,gambar1 from tbl_konten where id='$content'";
$query		= sql($sql);
$row 		= sql_fetch_data($query);
$id 		= $row['id'];
$nama 		= $row['nama'];
$ringkas 	= $row['ringkas'];
$video 		= $row['video'];
$gambar1 	= $row['gambar1'];

if($video) $video = "http://www.salingsapa.com/media/video/$video";
if($gambar1)	$gambar = "http://www.salingsapa.com/media/video/$gambar1";

$sql1		= "select id,video from tbl_videoads where published='1' order by rand() limit 1";
$query1		= sql($sql1);
$row1 		= sql_fetch_data($query1);
$idads 		= $row1['id'];
$videoads 	= $row1['video'];

if($videoads) $videoads = "http://www.salingsapa.com/media/videoads/$videoads";

echo'<item>
    <title></title>
    <description></description>
    <jwplayer:image>'.$gambar.'</jwplayer:image>
    <jwplayer:source file="'.$videoads.'" />
  </item>
  	<item>
    <title></title>
    <description></description>
    <jwplayer:image>'.$gambar.'</jwplayer:image>
    <jwplayer:source file="'.$video.'" />
  </item>';

echo '</channel>
</rss>';

?>
