<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

include("../../setingan/global.inc.php");
include("../../setingan/web.config.inc.php");

$msisdn = $_GET['msisdn'];
$pesan = $_GET['pesan'];
$key = $_GET['key'];

$ip = $_SERVER['REMOTE_ADDR'];
$data = date('Y-m-d H:i:s')." | $ip | $msisdn | $pesan\r\n";
$file = "$lokasiweb/logs/backlogsms.txt";
$open = fopen($file, "a+"); 
fwrite($open, "$data"); 
fclose($open);

//konfigurasi SMS Server
$key1 = "b1smillah";

if($key==$key)
{
	if(empty($msisdn) || empty($pesan)) die("Nomor Destinasi atau pesan Kosong");
	else
	{
			$kirim = date("Y-m-d H:i:s");
			$terima = date("Y-m-d H:i:s");
			
			$perintah = "INSERT INTO tbl_smsc_smsmasuk(msisdn,pesan,smsc,kirim,terima) VALUES ('$msisdn','$pesan','$smsc','$kirim','$terima')";
			$hasil = sql($perintah);
			
			if($hasil) echo"accepted";
			else echo"failed";
			
			if(strlen($msisdn)<9)
			{
				exit();
			}
			
			//Proses SMS
			
			//Mulai Proses Pesan
			$inpesan = strtoupper($pesan);
			$keyword = explode("#",$inpesan);
			$var1 = explode("#",$pesan);
			$isi = explode("#",$pesan);
			
				
			if($keyword[0]=="CEKTRANS")
			{
							
			}
			else if($keyword[0]=="KONFIRMASI")
			{
							
			}			
			else
			{
				//SMS Keyword
				$per = "select isipesan,keyword from tbl_smsc_smsautorespon where published='1' and jenis='keyword'";
				$has = sql($per);
				while($dt = sql_fetch_data($has))
				{
					$isipesan = $dt['isipesan'];
					$keyrespon = $dt['keyword'];
					
					if($keyword[0]==$keyrespon && !empty($isipesan))
					{
						$getkey = true;
						kirimSMS($msisdn,$isipesan);
					}
				} 
				
				$ip = $_SERVER['REMOTE_ADDR'];
				$data = date('Y-m-d H:i:s')." | $ip | $msisdn | $pesan\r\n";
				$file = "$lokasiweb/logs/backlog.txt";
				$open = fopen($file, "a+"); 
				fwrite($open, "$data"); 
				fclose($open);


				//Kirimkan Autorespon bila Keyword Semua Kosong
				if(!$getkey)
				{
					$per = "select isipesan from tbl_smsc_smsautorespon where published='1' and jenis='respon' order by id limit 1";
					$has = sql($per);
					$dt = sql_fetch_data($has);
					$isipesan = $dt['isipesan'];
					
					if(!empty($isipesan))
					{
						kirimSMS($msisdn,$isipesan);
					}
				}
				
			}
			
			
	}
}
else die("Anda tidak mempunyai Otoritas untuk Mengirimkan SMS melalui AdiSMS");
?>