<?php
ini_set("display_errors", "on");
require ("../librari/phpmailer/class.phpmailer.php");
include("../setingan/web.config.inc.php");

$tanggalsekarang = date("Y-m-d H:i:s");
$sql = "SELECT transaksiid, userid, orderid, invoiceid from tbl_transaksi where batastransfer<='$tanggalsekarang' and status='1'";
$hsl = sql($sql);

while($dt = sql_fetch_data($hsl))
{
	$transaksiid 		= $dt['transaksiid'];
	$userid		 		= $dt['userid'];
	$orderid	 		= $dt['orderid'];
	$invoiceid	 		= $dt['invoiceid'];
	
	if(empty($userid) or ($userid=='0'))
	{
		$perintah 	= "SELECT * FROM tbl_tamu WHERE orderid='$orderid'";
		$hasil 		= sql($perintah);
		$data 		= sql_fetch_data($hasil);

		$userfullname	= $data['userfullname'];
		$email 			= $data['useremail'];
		$userphonegsm 	= $data['userphonegsm'];
	}
	else
	{
		$perintah 	= "SELECT * FROM tbl_member WHERE userid='$userid'";
		$hasil 		= sql($perintah);
		$data 		= sql_fetch_data($hasil);

		$userfullname	= $data['userfullname'];
		$email 			= $data['useremail'];
		$userphonegsm	= $data['userphonegsm'];
	}
	
	$headers 			= "From : $owner";
	$subject			= "Pembatalan Order Nomor #$invoiceid";
	
	/*$isi				= "
	Dear $userFullName,<br /><br />

	Terima kasih untuk kunjungan Anda pada website $title.<br /><br />
	
	Mohon maaf, kami memberitahukan bahwa transaksi yang telah Anda lakukan
	dengan nomor invoice <strong>$invoiceid</strong> akan dilakukan pembatalan transaksi
	yang disebabkan karena :<br /><br />
	
	<br /><br />
	
	Terimakasih atas kepercayaan Anda berbelanja di $title. Kami senang dapat melayani Anda.
	Semoga dilain waktu kami bisa kembali mendapatkan kepercayaan sebagai tempat belanja Anda.
	Dapatkan kesempatan untuk memperoleh berbagai diskon menarik dengan menjadi member di $title. 
	Jika Anda belum menjadi member kami bisa melakukan pendaftaran di :<br /><br />
	
	$fulldomain/login/register<br /><br />
	
	Regards,<br />
	$title
	";*/
	$infopembatalan = "Anda belum melakukan pembayaran sampai waktu yang telah ditentukan";
	
	$contentemail	= sql_get_var("select keterangan from tbl_wording where alias='batal-invoice' and jenis = 'email' limit 1");
				
	$contentemail	= str_replace("[userfullname]","$userfullname",$contentemail);
	$contentemail	= str_replace("[invoiceid]","$invoiceid",$contentemail);
	$contentemail	= str_replace("[title]","$title",$contentemail);
	$contentemail	= str_replace("[infopembatalan]","$infopembatalan",$contentemail);
	$contentemail	= str_replace("[owner]","$owner",$contentemail);

	$sendmail			= sendmail($userfullname,$email,$subject,$contentemail,$contentemail,1);
	
	$contentsms	= sql_get_var("select keterangan from tbl_wording where alias='batal-invoice' and jenis = 'sms' limit 1");

	$contentsms	= str_replace("[invoiceid]","$invoiceid",$contentsms);
	$contentsms	= str_replace("[infopembatalan]","$infopembatalan",$contentsms);
	$contentsms	= str_replace("[owner]","$owner",$contentsms);

	//$sendsms = kirimSMS($userphonegsm,$contentsms);
				
	$ubah = sql("UPDATE tbl_transaksi set status='5' where transaksiid='$transaksiid'");
	
	$ubah1 = sql("DELETE from tbl_product_stokonhold where invoiceid='$invoiceid'");
	
	$vou = sql_get_var_row("select vouchercodeid, kodevoucher from tbl_transaksi where transaksiid='$transaksiid'");
	$vouchercodeid 	= $vou['vouchercodeid'];
	$kodevoucher	= $vou['kodevoucher'];

	if($ubah)
	{
		$perintah = "update tbl_voucher_kode set status='0' where vouchercodeid='$vouchercodeid'";
		$hasil = sql($perintah);
	}
	
	echo "Canceling $invoiceid<br>\r\n";
}

sql_free_result($hsl);

?>
