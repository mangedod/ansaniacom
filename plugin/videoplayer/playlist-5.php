<?
include("../../setingan/database.inc.php");
include("../../setingan/configurasi.site.php");
$pengakses = $_SERVER['REQUEST_URI'];
$kodekiriman1 = explode("/",$pengakses);
$kodekiriman = $kodekiriman1[4];
$ids = $kodekiriman1[5];
$ids = base64_decode($ids);

$kode = base64_decode($kodekiriman);
$kode = str_replace(".flv","",$kode);

$kodenow = strtotime("now");

$validasikode = $kode+5;


echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<rss xmlns:media=\"http://search.yahoo.com/mrss/\" VERSION=\"2.0\">
  <channel>
  <title>$title</title>";
	
	
	
	$perintah = "select id,screenshot1,video from tbl_video where id='$ids' limit 1";
	$hasil = mysql_db_query($database,$perintah);
	while($data=mysql_fetch_object($hasil))
	{
	$gambar = $data->screenshot1;
	$id = md5($data->id);
	$video = $data->video;
	echo"<item>
			<title>Bumper Ad</title>
			<media:content url=\"$domain/medias/video/intro.flv\"/>
			<media:thumbnail url=\"$domain/gambar/$gambar\"/>
		</item>";
		
	echo"
		<item>
			<title>MyPangadaran TV</title>
			<media:content url=\"$domain/medias/video/$id/$video\" />
			<media:thumbnail url=\"$domain/gambar/$gambar\" />
		</item>";
	}
	mysql_free_result($hasil);
	echo"</channel>
</rss>";
?>