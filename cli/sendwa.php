#!/usr/bin/php
<?php
$h = date("G");

if($h>20) exit("Exit $h");
if($h<7) exit("Exit $h");

include("../setingan/global.inc.php");
include("../setingan/web.fungsi.php");

echo "\r\nStarting sending WA...\r\n";

$date = date("Y-m-d H:i:s");

$sql = "select id,userphonegsm,pesan,gambar from tbl_wa where status='0' and tanggal < '$date' order by id desc limit 3";
$hsl = sql($sql);
while($data = sql_fetch_data($hsl))
{
	$id = $data['id'];
	$userphonegsm = $data['userphonegsm'];
	$html = $data['pesan'];
	$gambar = $data['gambar'];
	
	
	if(strlen($userphonegsm)<5)
	{
		$s = sql("delete from tbl_wa where id='$id'");
		exit();
	}
	
	$phone = $userphonegsm;
	$message = $html;

	if(!empty($gambar))
	{
		$url = 'http://wa.adisumaryadi.net:8003/api/sendFile';

		$photo  = "@$lokasiweb/gambar/wablast/$gambar;type=image/jpeg;filename=gambar.jpeg";
		
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_TIMEOUT,30);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, array(
			'token'    => $token,
			'phone'     => $phone,
			'body'   => $photo,
			'caption'   => $html,
			'filename'   => "gambar.jpg",
		));
		$response = curl_exec($curl);
		
	
	
	}
	else
	{
		$url = 'http://wa.adisumaryadi.net:8003/api/sendMessage';
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_TIMEOUT,30);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, array(
			'token'    => $token,
			'phone'     => $phone,
			'body'   => $message,
		));
		$response = curl_exec($curl);
		curl_close($curl);
		
	
	}
			
	if(preg_match("/error/i",$response))
	{
		echo "\r\n ERROR $id - $userphonegsm\r\n";
	}
	else
	{
		$s = sql("update tbl_wa set status='1',terkirim='$date' where id='$id'");
	
		echo "\r\n$id - $userphonegsm\r\n";
	}
	
	sleep(10);
	
}
echo "\r\n";
exit();
?>