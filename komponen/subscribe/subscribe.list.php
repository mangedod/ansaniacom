<?php
if(isset($_POST['emailsubscribe']))
{
	$uri            = clean($_POST['uri']);
	$groupid        = clean($_POST['groupid']);
	$emailsubscribe = clean($_POST['emailsubscribe']);
	$userfullname = clean($_POST['userfullname']);
	
	cekspam($emailsubscribe);
	
	if(!preg_match("/^[a-z0-9]+([\w-])*(((?<![_-])\.(?![_-]))[\w-]*[a-z0-9])*@(?![-])([a-z0-9-]){2,}((?<![-])\.[a-z]{2,6})+$/i", $emailsubscribe))
	{
		$pesan[] = array("pesan"=>"Email is still empty or email writing less is correct, please fill in the First.");
		$salah = true;
	}
	else{ $salah = false; }
	
	if(!$salah)
	{
		
		$jumlahemail = sql_get_var("select count(*) as jumlah from tbl_subscriber where useremail='$emailsubscribe'");
		
	
		if($jumlahemail>0)
		{
			$_SESSION['popnewsletter'] = "1";
			setcookie("popupnewsletter","1", time() + (86400 * 30 * 365), "/", "ansania.com"); // 86400 = 1 day
			
			header("location: $fulldomain"."subscribe/registered/$emailsubscribe");
		}
		else
		{
				if(empty($userfullname))
				{
					$user = explode("@",$emailsubscribe);
					$userfullname = ucwords($user[0]);
				}
				
				$perintah = "select max(subscriberid) as baru from tbl_subscriber";
				$hasil = sql($perintah);
				$data = sql_fetch_data($hasil);
				$baru = $data['baru']+1;
				
				$tgl = date("Y-m-d H:i:s");
			
				$query = "insert into tbl_subscriber (subscriberid,userfullname,useremail,userhandphone,kota,sefter,groupid,uri,status,tanggal,create_date)
						 values ('$baru','$userfullname','$emailsubscribe','$userphone','$kota','$sefter','$groupid','$uri','0','$tgl','$tgl')";
				$hasil = sql($query);
				
			
				if($hasil)
				{
					//Kirim Email Terima Kasih
					$isi = "Gabung di Newsletter $title
			=================

			Yth. $userfullname,

			Selamat sekarang email anda terdaftar di Newsletter Ansania, kami akan
			mengirimkan informasi kepada anda bila ada program promo dari special
			untuk anda dari Ansania.

			Terima Kasih
			$owner";

			$isihtml = "<br />
			<strong>Gabung di Newsletter $title</strong>
			====================<br />
			Yth. $userfullname,<br />
			Selamat sekarang email anda terdaftar di Newsletter Ansania, kami akan
			mengirimkan informasi kepada anda bila ada program promo dari special
			untuk anda dari Ansania.
			<br />
			<br />

			
			Terima Kasih<br />

			$owner";

			$subject = "Terima Kasih Sudah Bergabung di Newsletter Ansania";

			sendmail($userfullname,$emailsubscribe,$subject,$isi,emailhtml($isihtml));
					
					
					$_SESSION['popnewsletter'] = "1";
					setcookie("popupnewsletter","1", time() + (86400 * 30 * 365), "/", ".ansania.com"); // 86400 = 1 day
					
					header("location: $fulldomain"."subscribe/success");
					exit();
				}
				else
				{
					$msg = "Pendaftaran Newsletter gagal dilakukan, silahkan untuk mencoba sekali menggunakan form yang kami sedikan dibawah ini";
					$tpl->assign("msg",$msg);
					$tpl->assign("pesan",$pesan);
				}
		}
	}
	else
	{
		$msg = "Pendaftaran Newsletter gagal dilakukan, silahkan untuk mencoba sekali menggunakan form yang kami sedikan dibawah ini";
		$tpl->assign("msg",$msg);
		$tpl->assign("pesan",$pesan);
	} 
}

?>