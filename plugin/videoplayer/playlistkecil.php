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

if($kodenow > $validasikode) die("File Not Found");

echo"<playlist version=\"1\" xmlns=\"http://xspf.org/ns/0/\">
	<title>CyberMQ-TV</title>
	<trackList>";
	
	echo"<track>
			<title>Bumper Ad</title>
			<location>$domain/media/video/intro.flv</location>
			<info>$fuldomain/video/</info>
			<album>preroll</album>
		</track>";
	
	$perintah = "select id,screenshot,video from tbl_video where id='$ids' limit 1";
	$hasil = mysql_db_query($database,$perintah);
	while($data=mysql_fetch_object($hasil))
	{
	$gambar = $data->screenshot;
	$id = md5($data->id);
	$video = $data->video;
	echo"
		<track>
			<title>CyberMQ-TV</title>
			<creator>$domain</creator>
			<location>$domain/dirmedia/video/$id/$video</location>
			<image>$domain/gambar/$gambar</image>
		</track>";
	}
	mysql_free_result($hasil);
	echo"</trackList>
</playlist>";
?>