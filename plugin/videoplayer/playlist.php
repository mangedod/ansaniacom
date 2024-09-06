<?
$asal = $_SERVER['HTTP_REFERER'];
//if(eregi("salingsapa",$asal))
//{
header("Content-type: text/xml");
include("../../setingan/web.config.inc.php");

$pengakses = $_SERVER['REQUEST_URI'];
$kodekiriman1 = explode("/",$pengakses);
$kodekiriman = $kodekiriman1[4];

$id = $kodekiriman1[5];

$kode = base64_decode($kodekiriman);
$kode = str_replace(".flv","",$kode);
$contentId = base64_decode($id);

$kodenow = strtotime("now");

$validasikode = $kode+5;

echo "<rss version=\"2.0\" 
	xmlns:media=\"http://search.yahoo.com/mrss/\" 
	xmlns:jwplayer=\"http://developer.longtailvideo.com/trac/wiki/FlashFormats\">
	<channel>
		<title>SalingSapaTV</title>";
	
	$sql		= "select id,secid,ulamaid,masjidid,nama,ringkas,lengkap,durasi,oleh,alias,video,youtubeid,gambar1,gambar,create_date,jenis,views from tbl_video where id='$contentId'";
$query		= sql($sql);
$row 		= sql_fetch_data($query);
$id 		= $row['id'];
$nama 		= $row['nama'];
$ringkas	= $row['ringkas'];
$video 		= $row['video'];
$gambar1 	= $row['gambar1'];
$gambar 	= $row['gambar'];
$youtubeid 	= $row['youtubeid'];
$ulamaid 	= $row['ulamaid'];
if($gambar1)
	$screenshot="$fulldomain/media/video/$id/$gambar1";
else
	$screenshot="";

$newvideo = "$id/$video";
$newvideo = str_replace(".flv",".mp4",$newvideo);

$perintahs = "select id,gambar,nama,oleh,ringkas,video,create_date from tbl_videoads order by rand() limit 1";
	$hasils = sql($perintahs);
	$datas=sql_fetch_data($hasils);

	$ads_id = $datas['id'];
	$ads_video = $datas['video'];
	$ads_nama = $datas['nama'];
	$ads_ringkas = $datas['ringkas'];

	
		echo "<item>
			<title>$ads_nama</title>
			<description>$ads_ringkas</description>
			<media:content url=\"$domain/media/videoads/$ads_id/$ads_video\" />
			<media:thumbnail url=\"$domain/gambar/$gambar\" />
		</item>
"; 
echo "<item>
			<title>$nama</title>
			<description>$ringkas.</description>
			<media:content url=\"rtmp://live.salingsapa.com/vod/mp4:$id/$video\" />
			<media:thumbnail url=\"$domain/gambar/$gambar\" />
		</item>
";

	mysql_free_result($query);
	echo"</channel>
</rss>";
//}
?>