<?php 
	include($lokasiweb."/librari/captcha/securimage.php");
	$kodegen = md5(time());

	$tpl->assign('kodegen', $kodegen);
	if($_POST['action'] == "savepesan")
	{
		$code 	= $_POST['code'];
		$img 	= new Securimage();
		$valid 	=  $img->check($code);

		if ($valid == false)
		{
		  $pesanhasil = "Kode antispam harap diisi dengan benar.";
		  $berhasil = "0";
		}
		else
		{
			$nama		= cleaninsert($_POST['userfullname']);
			$email		= cleaninsert($_POST['useremail']);
			$pesan		= desc($_POST['pesan']);
			$phone		= cleaninsert($_POST['userphone']);
			$tanggal	= DATE('Y-m-d H:m:s');
			$ip 		= $_SERVER['REMOTE_ADDR'];

			$tpl->assign("nama","$nama");
			$tpl->assign("email","$email");
			$tpl->assign("pesan","$pesan");

			$sql	= "select max(id) as idbaru from tbl_contact_message";
			$query	= sql($sql);
			$idbaru	= sql_result($query,0,idbaru) + 1;

			$perintah	= "insert into tbl_contact_message (`id`,`nama`,`email`,`pesan`,`ip`,phone,contactuserid, `create_date`) values ('$idbaru','$nama','$email','$pesan','$ip', '$phone','$contactid','$tanggal')";
			$hasil		= sql($perintah);

			if($hasil)
			{
				//Info Ke Referensi 
				$subject = "Ada Yang Bertanya Tentang $title";
				$message = "Hai $contactname, ada pengunjung kedalam website $domain bertanya kepada Anda tentang $title.
					Pertanyaan dari <strong>$nama</strong> dengan alamat email <strong>$email</strong>, Nomor Handphone <strong>$phone</strong> .
					<br><br>Pertanyaan:<br>
					$pesan<br><br>
					Silahkan tindak lanjuti informasi berikut dengan login ke $title dan masuk ke fitur Pertanyaan masuk";
				
				$kirimEmail = sendmail($contactname,$contactuseremail,$subject,$message,emailhtml($message));
				$kirimSms   = kirimSMS($contactuserphone,"Ada Pertanyaan Masuk via $title ($fulldomain), silahkan followup Nama: $nama Nohp: $phone. Silahkan login untuk info selengkapnya");
				
				// sendgcm($contactid,"New Contact : Ada Pertanyaan masuk, segera tindak lanjuti");
					
				$pesanhasil = "Selamat Pesan Anda di $title telah berhasil dikirimkan. Silahkan tunggu informasi dari kami selanjutnya melalui email ataupun nomor telephone Anda. Terima Kasih";
				$berhasil = "1";
			}
			else
			{
				$pesanhasil = "Penyimpanan pesan gagal dilakukan.";
				$berhasil = "0";
			}
		}
		$tpl->assign("pesan",$pesan);
		$tpl->assign("pesanhasil",$pesanhasil);
		$tpl->assign("berhasil",$berhasil);
	}

if($_POST['message'])
{
	$message = $_POST['message'];
	$userfullname1 = $_POST['userfullname'];
	
	$tpl->assign("message_isi",$message);
	$tpl->assign("message_userfullname",$userfullname1);
	
}	

?>