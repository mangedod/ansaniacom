<?php
	include("../../../setingan/web.config.inc.php");
	
	$kodeinvoice = $_GET['kodereginvoiceid'];
		
	$invoiceid = base64_decode($kodeinvoice);

		// ambil data toko
		$tk	= sql_get_var_row("select nama,alamat,telp,gsm from tbl_static where alias='kontak'");
		$namatk		= $tk['nama'];
		$alamattk	= $tk['alamat'];
		$telptk		= $tk['telp'];
		$gsmtk		= $tk['gsm'];
						
		// kueri tabel konfirmasi
		$sql1	= "select transregisid, reginvoiceid, regorderid, totaltagihan, pembayaran, userid, namalengkap,
				status, email, tanggaltransaksi, batastransfer
				from tbl_transaksi_registrasi where reginvoiceid='$invoiceid'";
		$hsl1 = sql($sql1);
		$row1 = sql_fetch_data($hsl1);
		
		$transregisid            = $row1['transregisid'];
		$invoiceid               = $row1['reginvoiceid'];
		$regorderid              = $row1['regorderid'];
		$totaltagihan            = $row1['totaltagihan'];
		$pembayaran              = $row1['pembayaran'];
		$userid                  = $row1['userid'];
		$namalengkap             = $row1['namalengkap'];
		$status                  = $row1['status'];
		$email                   = $row1['email'];
		$tanggaltransaksi        = tanggal($row1['tanggaltransaksi']);
		$datetransfer            = tanggal($row1['batastransfer']);
		$bank_tujuan             = $row1['bank_tujuan'];
			
		if($pembayaran == "COD")
			$pembayaran = "Cash On Delivery";
		else
			$pembayaran = "Transfer Bank";			
			
		$totaltagihan2      = "IDR. ".number_format($totaltagihan,0,".",".");
		
		// if($status     == "0") {$statusorder = "ORDER";$warnafont = "#e41b1a";}
		if($status == "1") {$statusorder = "BILLED";$warnafont = "#e41b1a";}
		elseif($status == "2") {$statusorder = "CONFIRMED";$warnafont = "#59B210";}
		elseif($status == "3") {$statusorder = "PAID";$warnafont = "#59B210";}
		// elseif($status == "4") {$statusorder = "SHIPPING";$warnafont = "#59B210";}
		// elseif($status == "5") {$statusorder = "VOID";$warnafont = "#e41b1a";}
			
		sql_free_result($hsl1);
		
		// kueri bank
			$perintah = "select * from tbl_norek where status='1'";
			$hasil = sql($perintah);
			$rekening = array();
			while ($data=sql_fetch_data($hasil)) 
			{
				$id			= $data['id'];
				$id_bank	= $data['bank'];
				$norek		= $data['norek'];
				$atasnama	= $data['atasnama'];
				
				$sql8	= "select namabank from tbl_bank where bankid='$id_bank'";
				$res8	= sql($sql8);
				$row8	= sql_fetch_data($res8);
				$logo	= $row8['logobank'];
				$bank	= $row8['namabank'];
		
				$rekening[$id] = array("idr"=>$id,"akun"=>$norek,"bank"=>$bank,"namaak"=>$atasnama);
			
			}

				$perintah 	= "SELECT * FROM tbl_member WHERE userid='$userid'";
				$hasil 		= sql($perintah);
				$data 		= sql_fetch_data($hasil);
	
				$userfullname	= $data['userfullname'];
				$userid			= $data['userid'];
				$propinsiid		= $data['propinsiid'];
				$useraddress 	= $data['useraddress'];
				$kotaid 		= $data['kotaid'];
				$userpostcode	= $data['userpostcode'];
				$email 			= $data['useremail'];
				$telephone 		= $data['userphone'];
				$userphonegsm	= $data['userphonegsm'];
			
			//kota
			$kota 		= sql_get_var("select namakota from tbl_kota where kotaid='$kotaid'");
			
			$billingalamat = "$useraddress<br>$kota<br>$userpostcode<br>Telp. $userphonegsm";
		
		$urlconfirm = "$fulldomain/konfirmasi/$kodeinvoice";
		
		include("cetak.invoicereg.php");
		
		/*header("location: $fulldomain/gambar/pdf/$invoiceid.pdf");
	}
	else
	{
		header("location: $fulldomain/gambar/pdf/$invoiceid.pdf");
	}*/
		
?>