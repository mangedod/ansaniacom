<?
header("Content-type: text/xml");
include("../../setingan/database.inc.php");
include("../../setingan/fungsi.php");

$pengakses = $_SERVER['REQUEST_URI'];
$kodekiriman1 = explode("/",$pengakses);
$kodekiriman = $kodekiriman1[4];

$ids = $kodekiriman1[4];
$jenis = $kodekiriman1[5];

$kode = base64_decode($kodekiriman);
$kode = str_replace(".flv","",$kode);

$kodenow = strtotime("now");

$validasikode = $kode+5;

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<rss version=\"2.0\" xmlns:jwplayer=\"http://rss.jwpcdn.com/\">
	<channel>
		";

	$perintah = "select id,channel,nama,server from tbl_channel where alias='$ids' and tipe='$jenis' limit 1";
	$hasil = sql($perintah);
	while($data=mysql_fetch_object($hasil))
	{
	$gambar = $data->screenshot1;
	$id = md5($data->id);
	$video = $data->video;
	$nama = $data->nama;
	$channel = $data->channel;
	$server = $data->server;
	
	if($server=="wowza")
	{
	
echo "
<item> 
      <jwplayer:provider>rtmp</jwplayer:provider>
      <jwplayer:streamer>rtmp://stream.salingsapa.com:1935/live/</jwplayer:streamer> 
	  <jwplayer:file>$channel</jwplayer:file>
</item> 
";
}
else
{
echo "
<item>
		  <jwplayer:author>SalingSapa</jwplayer:author>
		  <jwplayer:title>$nama</jwplayer:title>
		  <jwplayer:description>$nama</jwplayer:description>
		  <jwplayer:streamer>rtmp://live.salingsapa.com/live/</jwplayer:streamer>
		  <jwplayer:file>$channel</jwplayer:file>
		  <jwplayer:provider>rtmp</jwplayer:provider>
		  <jwplayer:start>0</jwplayer:start>
		</item>
";
}

	}
	mysql_free_result($hasil);
	echo"</channel>
</rss>";
?>