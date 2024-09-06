#!/usr/bin/php
<?php 
ini_set("display_errors","on"); 

$lokasi = "/home/ansania.com/public_html/";

include("$lokasi/setingan/global.inc.php");
include("$lokasi/setingan/web.fungsi.php");

$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://instagram-scraper-2022.p.rapidapi.com/ig/posts_username/?user=ansaniaofficial",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: instagram-scraper-2022.p.rapidapi.com",
		"X-RapidAPI-Key: 26d8ff80c3msh752764b8fe06df0p16e580jsn0cf42b25a4be"
	],
]);

$data = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$dirname = "$lokasiweb/gambar/instagram";



$data = json_decode($data, TRUE);
$data = $data['data']['user']['edge_owner_to_timeline_media']['edges'];

for($i=0; $i<count($data); $i++) 
{

	$code = $data[$i]['node']['shortcode'];

	$is = sql_get_var("select count(*) as jml from tbl_instagram where instagramid='$code'");

	if($is<1)
	{
		$caption = $data[$i]['node']['edge_media_to_caption']['edges'][0]['node']['text'];
		$url = "https://www.instagram.com/$code/";
		$date = $data[$i]['node']['taken_at_timestamp'];
		$gambar = $data[$i]['node']['display_resources'][1]['src'];
		$gambar1 = $data[$i]['node']['display_resources'][2]['src'];


		$date = date("Y-m-d H:i:s",$date);

		
		$new = newid("id","tbl_instagram");
		
		$namagambarf = "photo-instagram-$new-$code-l.jpg";
		$gambarf = file_put_contents("$dirname/$namagambarf", file_get_contents("$gambar1"));
		
		$namagambars = "photo-instagram-$new-$code.jpg";
		$gambars = file_put_contents("$dirname/$namagambars", file_get_contents("$gambar"));
		
		//system("chown q8001.q8001 $dirname/$namagambarf $dirname/$namagambars");
						
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