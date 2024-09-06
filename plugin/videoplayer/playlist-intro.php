<?
header("Content-type: text/xml");
include("../../setingan/database.inc.php");
include("../../setingan/fungsi.php");

$pengakses = $_SERVER['REQUEST_URI'];
$kodekiriman1 = explode("/",$pengakses);
$kodekiriman = $kodekiriman1[4];

$ids = $kodekiriman1[4];

$kode = base64_decode($kodekiriman);
$kode = str_replace(".flv","",$kode);

$kodenow = strtotime("now");

$validasikode = $kode+5;

echo "<rss version=\"2.0\" 
	xmlns:media=\"http://search.yahoo.com/mrss/\" 
	xmlns:jwplayer=\"http://developer.longtailvideo.com/trac/wiki/FlashFormats\">
	<channel>
		<title>SalingSapaTV</title>";

	$perintah = "select id,audio from tbl_intro order by rand()";
	$hasil = sql($perintah);
	while($data=mysql_fetch_object($hasil))
	{
	$id = md5($data->id);
	$audio = $data->audio;
	
echo "
<item>
		  <jwplayer:author>SalingSapa</jwplayer:author>
		  <jwplayer:title>SalingSapa</jwplayer:title>
		  <jwplayer:description>SalingSapa</jwplayer:description>
		  <jwplayer:file>$fulldomain/media/intro/$audio</jwplayer:file>
		  <jwplayer:start>0</jwplayer:start>
		</item>
";

	}
	mysql_free_result($hasil);
	echo"</channel>
</rss>";
?>