<?
header("Content-type: text/xml");
include("../../setingan/database.inc.php");
include("../../setingan/fungsi.php");

$pengakses = $_SERVER['REQUEST_URI'];
$kodekiriman1 = explode("/",$pengakses);
$kodekiriman = $kodekiriman1[4];

$ids = $kodekiriman1[5];
$ids = base64_decode($ids);

$kode = base64_decode($kodekiriman);
$kode = str_replace(".flv","",$kode);

$kodenow = strtotime("now");

$validasikode = $kode+5;

echo "<rss version=\"2.0\" 
	xmlns:media=\"http://search.yahoo.com/mrss/\" 
	xmlns:jwplayer=\"http://developer.longtailvideo.com/trac/wiki/FlashFormats\">
	<channel>
		<title>SalingSapaTV</title>";

	$perintah = "select filesName,cover,contentId,judul,tanggalPost from tbl_video where contentId='$ids' limit 1";
	$hasil = sql($perintah);
	while($data= sql_fetch_object($hasil))
	{
	$gambar = $data->cover;
	$id = $data->contentId;
	$video = $data->filesName;
	$nama = $data->nama;
	$oleh = $data->judul;
	$ringkas = $data->judul;
	$tanggal = $data->tanggalPost;
/*	
		echo "<item>
			<title>SalingSapa Bumper</title>
			<link>http://www.salingsapa.com/</link>
			<description>SalingSapa Bumper</description>
			<pubDate>$tanggal</pubDate>
			<media:credit role=\"author\">SalingSapa</media:credit>
			<media:group>
				<media:content url=\"$domain/media/video/sstv.mp4\" />
				<media:thumbnail url=\"$domain/media/video/$id/$gambar\" />
			</media:group>
		</item>
";
*/echo "<item>
			<title>$nama</title>
			<link>http://www.salingsapa.com/</link>
			<description>$ringkas.</description>
			<pubDate>$tanggal</pubDate>
			<media:credit role=\"author\">$oleh</media:credit>
			<media:group>
				<media:content url=\"$domain/media/video/$id/$video\" />
				<media:thumbnail url=\"$domain/media/video/$id/$gambar\" />
			</media:group>
		</item>
";

	}
	mysql_free_result($hasil);
	echo"</channel>
</rss>";
?>