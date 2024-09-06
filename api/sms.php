<?php
include("../setingan/global.inc.php");
include("../setingan/web.fungsi.php");

$ip = $_SERVER['REMOTE_ADDR'];
if(isset($_POST['msisdn']))
{
	$msisdn = trim($_POST['msisdn']);
}
else
{
	$msisdn = trim($_GET['msisdn']);
}
if(isset($_POST['pesan']))
{
	$pesan = $_POST['pesan'];
}
else
{
	$pesan = $_GET['pesan'];
}

$data = date('Y-m-d H:i:s')." | $ip | $msisdn | $pesan\r\n";
$file = "backlog.txt";
$open = fopen($file, "a+"); 
fwrite($open, "$data"); 
fclose($open);

$whitelist = "45.118.112.164";

if(!preg_match("/$ip/i",$whitelist))
{
	echo "FAILED: Source IP not Allow to Access API";
	exit();
}


if(empty($msisdn) && empty($pesan))
{
	echo "FAILED";	
}
else
{
	$date = date("Y-m-d H:i:s");
	$sql = "insert into tbl_smsc_smsmasuk(msisdn,pesan,terima,status) values ('$msisdn','$pesan','$date','1')";
	$hsl = sql($sql);
	
	$pesan = trim($pesan);
	$inpesan = explode("#",$pesan);
	
	if(substr($msisdn,0,2)=="62")
	{
		$msisdn = substr_replace($msisdn,'0',0,2); 
	}
	
	$keyword = strtoupper($inpesan[0]);
	
	if($keyword=="KONFIRMASI")
	{
		$data = date('Y-m-d H:i:s')." | $ip | $keyword | $pesan\r\n";
		$file = "backlog.txt";
		$open = fopen($file, "a+"); 
		fwrite($open, "$data"); 
		fclose($open);

		$invoiceid = trim($inpesan[1]);
		$jmlbayar =  trim($inpesan[2]);
		$namabayar =  trim($inpesan[3])." via SMS";
		$note =  trim($inpesan[4]);
		
		$cek = sql_get_var("select count(*) as jml from tbl_transaksi where invoiceid='$invoiceid'");
		
		if($cek<1)
		{
			kirimSMS($msisdn,"Nomor Transaksi $invoiceid tidak terdaftar, silahkan periksa kembali nomor invoice yang telah anda bayar");
		}
		else
		{
			
			$statustrans	= sql_get_var("select status from tbl_transaksi where invoiceid='$invoiceid'");
	
			if($statustrans == '5')
			{
				kirimSMS($msisdn,"Nomor Invoice $invoiceidyang anda masukan sudah dibatalkan karena melebihi batas waktu transfer yang ditentukan. Silahkan hubungi CS kami.");
			}
			elseif( $statustrans== '1')
			{
					$konfirmasiid	= sql_get_var("select id from tbl_konfirmasi where invoiceid='$invoiceid'");
						
					if(empty($konfirmasiid))
					{
						$tgl_bayar = date("Y-m-d H:i:s");
						$sql	= "insert into tbl_konfirmasi (`bank_tujuan`, `bank_dari`, `norek`, `jumlah_bayar`, `total_bayar`, `metode_pembayaran`, `atas_nama`, `status`, `create_date`, 
									`tanggalbayar`,`invoiceid`,`pesan`) values ('$bank', '$daribank', '$norek', '$jmlbayar', '$jmlbayar','$pembayaran', '$name', '1', '$tgl_konfirmasi', 
									'$tgl_bayar', '$invoiceid','$note')";
						$query = sql($sql);
							
						if($query)
						{
							$update	= sql("update tbl_transaksi set status='2' where invoiceid='$invoiceid'");
							
							$qrys	= sql("select userid,email,orderid,alamatpengiriman,resellerid from tbl_transaksi where invoiceid='$invoiceid'");
							$rows	= sql_fetch_data($qrys);
							
							$userid           = $rows['userid'];
							$email            = $rows['email'];
							$orderid          = $rows['orderid'];
							$alamatpengiriman = $rows['alamatpengiriman'];
							$resellerid 	= $row['resellerid'];
							
							if(empty($userid) or ($userid=='0'))
							{
								$perintah 	= "SELECT * FROM tbl_tamu WHERE orderid='$orderid'";
								$hasil 		= sql($perintah);
								$data 		= sql_fetch_data($hasil);
					
								$userfullname	= $data['userfullname'];
								$idtamu			= $data['id'];
								$useraddress 	= $data['useraddress'];
								$propinsiid		= $data['propinsiid'];
								$kotaid 		= $data['kotaid'];
								$userpostcode 	= $data['userpostcode'];
								$email 			= $data['useremail'];
								$telephone 		= $data['userphone'];
								$userphonegsm 	= $data['userphonegsm'];
							}
							else
							{
								$perintah 	= "SELECT * FROM tbl_member WHERE userid='$userid'";
								$hasil 		= sql($perintah);
								$data 		= sql_fetch_data($hasil);
					
								$userfullname	= $data['userfullname'];
								$userid			= $data['userid'];
								$propinsiid		= $data['propinsiid'];
								$useraddress 	= $data['useraddress'];
								$kotaid 		= $data['cityname'];
								$userpostcode	= $data['userpostcode'];
								$email 			= $data['useremail'];
								$telephone 		= $data['userphone'];
								$userphonegsm	= $data['userphonegsm'];
							}
							
							if(!empty($resellerid))
							{
								$perintah 	= "SELECT * FROM tbl_member WHERE userid='$resellerid'";
								$hasil 		= sql($perintah);
								$data 		= sql_fetch_data($hasil);
					
								$contactuseremail 			= $data['useremail'];
								$contactname 		= $data['userfullname'];
								$contactuserphone	= $data['userphonegsm'];
							}
							
							//kota
							$kota 		= sql_get_var("select namakota from tbl_kota where kotaid='$kotaid'");
							
							$billingalamat = "$useraddress<br>$kota<br>$userpostcode<br>Telp. $userphonegsm";
							
							$contentemail	= sql_get_var("select keterangan from tbl_wording where alias='konfirmasi' and jenis = 'email' limit 1");
							$contentemail	= str_replace("[userfullname]","$userfullname",$contentemail);
							$contentemail	= str_replace("[title]","$title",$contentemail);
							$contentemail	= str_replace("[invoiceid]","$invoiceid",$contentemail);
							$contentemail	= str_replace("[alamatpengiriman]","$alamatpengiriman",$contentemail);
							$contentemail	= str_replace("[owner]","$owner",$contentemail);
							$contentemail	= str_replace("[fulldomain]","$fulldomain",$contentemail);
								
							$pengirim 			= "$owner <$support_email>";
							$webmaster_email 	= "Support <$support_email>"; 
							$headers 			= "From : $owner";
							$subject			= "$title, Konfirmasi Pembayaran";
							
							$sendmail			= sendmail($userfullname,$email,$subject,$contentemail,$contentemail,1);
							
							//kirim email ke admin
							$to       = "$support_email";
							$from     = "$support_email";
							$headers  = "From : $owner";
							$subject1 = "Konfirmasi Pembayaran";
							$message  = "Ada Informasi mengenai Konfirmasi online $title dengan no invoice $invoiceid";
							
							$sendmail1	= sendmail($title,$support_email,$subject1,$message,$message,1);
							
							//kirim email ke reseller
							$tores      = "$owner <$support_email>";
							$fromres    = "Support <$support_email>";
							$headers    = "From : $owner";
							$subjectres = "Konfirmasi Pembayaran";
							$message    = "Ada Informasi mengenai Konfirmasi online $title dengan no invoice $invoiceid";
							
							$sendmail1	= sendmail($contactname,$contactuseremail,$subjectres,$message,$message,1);
							
							$pesanhasil = "Terimakasih telah melakukan konfirmasi. Barang akan segera dikirim ke tempat Anda.";
							$tpl->assign("style","alert-success");
						
							//kirim sms ke admin
							$sqlh     = "select gsm from tbl_static where alias='kontak' limit 1";
							$queryh   = sql($sqlh);
							$rowh     = sql_fetch_data($queryh);
							$gsmadmin = $rowh['gsm'];
						
							$kirimsms	= kirimSMS($gsmadmin,"info store: pembeli dgn invoice $invoiceid telah melakukan konfirmasi pembayaran,silahkan login ke $fulldomain/panel utk melihat detail pembayaran. Terimakasih");
							
							//kirim sms ke reseller
							$kirimsms	= kirimSMS($contactuserphone,"Info store: pembeli dgn invoice $invoiceid telah melakukan konfirmasi pembayaran,silahkan login ke http://www.sygmadayainsani.co.id/member utk melihat detail pembayaran. Terimakasih");
							
							$contentsms	= sql_get_var("select keterangan from tbl_wording where alias='paid' and jenis = 'sms' limit 1");
					
							$contentsms	= str_replace("[owner]","$owner",$contentsms);
							$contentsms	= str_replace("[title]","$title",$contentsms);
							$contentsms	= str_replace("[invoiceid]","$invoiceid",$contentsms);
							$contentsms	= str_replace("[totaltagihan]","$jumlah_bayar",$contentsms);
							$contentsms	= str_replace("[pembayaran]","$pembayaran",$contentsms);
					
							$sendsms = kirimSMS($userphonegsm,$contentsms);
							
							setlog($_SESSION[userfullname],"system","Melakukan Konfirmasi Pembayaran.","$fulldomain/panel/index.php?tab=5&tabsub=9&kanal=konfirmasi&invoice=$invoice","confirm");
						}
					}
			}
			
			kirimSMS($msisdn,"Konfirmasi untuk nomor inovoice $invoiceid berhasil dilakukan, kami akan memvalidasi terlebih dahulu dan akan menghubungi anda kembali");
		}
		 
		echo "OK";
	}
}
?>