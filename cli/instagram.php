#!/usr/bin/php
<?php 
ini_set("display_errors","Off");
error_reporting(0);
echo "Start Fetching instagram...\r\n";

$lokasi = "/home/host/user/q8001/sites/ansania.com/htdocs/";

include("$lokasi/setingan/global.inc.php");
include("$lokasi/setingan/web.fungsi.php");


$url = "https://imagerocket.net/uid/ansaniaofficial";
$timeout = 30;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
$html = curl_exec($ch);
curl_close($ch);

$dom = new DOMDocument;
$dom->loadHTML($html);
$xpath = new DOMXpath($dom);

$spaner = $xpath->query("//*[contains(@class, 'project-thumb')]");

$x = 0;
$data = array();
$j = ($spaner->length) - 1;
for($i=0;$i<$spaner->length;$i++)
{
	$classy = $spaner->item($i)->getAttribute("class");   
	$string = $dom->saveHTML($spaner->item($i));

	$dom2 = new domDocument;
	$dom2->loadHTML($string);
	$dom2->preserveWhiteSpace = false;
	$links = $dom2->getElementsByTagName('a');

	foreach ($links as $tag)
	{
		$val = $tag->childNodes->item(0)->nodeValue;
		$link = $tag->getAttribute('href');

		$short_code  = str_replace("/post/", "", $link);		
	}

	$images = $dom2->getElementsByTagName('img');
	foreach ($images as $tag)
	{
		$val = $tag->childNodes->item(0)->nodeValue;
		$gambar = "https://imagerocket.net/uid/".$tag->getAttribute('src');	
	}
	$text = $dom2->getElementsByTagName('p');
	foreach ($text as $tag)
    {
        $caption = $tag->textContent;        
    }
	
		
	$data[$j] = array("short_code"=>$short_code,"gambar"=>$gambar,"caption"=>$caption);
	$j--;
}


$dirname = "$lokasiweb/gambar/instagram";

for($i=0; $i<count($data); $i++) 
{

	$code = $data[$i]['short_code'];

	$is = sql_get_var("select count(*) as jml from tbl_instagram where instagramid='$code'");

	if($is<1 && !empty($code))
	{
		$caption = $data[$i]['caption'];
		$url = "https://www.instagram.com/$code/";
		$date = date("Y-m-d H:i:s");
		$gambar = $data[$i]['gambar'];
		$gambar1 = $data[$i]['gambar'];

		
		$new = newid("id","tbl_instagram");
		
		$namagambarf = "photo-instagram-$new-$code-l.jpg";
		$gambarf = file_put_contents("$dirname/$namagambarf", file_get_contents("$gambar1"));
		
		$namagambars = "photo-instagram-$new-$code.jpg";
		$gambars = file_put_contents("$dirname/$namagambars", file_get_contents("$gambar"));
		
		system("chown q8001.q8001 $dirname/$namagambarf $dirname/$namagambars");
						
		if(file_exists("$dirname/$namagambarf"))
		{
			$caption = str_replace("'","",$caption);
			
			$perintah = "insert into tbl_instagram(id,create_date,nama,gambar,gambar1,instagramid,published) 
				values ('$new','$date','$caption','$namagambars','$namagambarf','$code','1')";
			$hasil = sql($perintah);
			
			echo "$perintah Insert $nama\r\n";

		
		}


	}

}


?>