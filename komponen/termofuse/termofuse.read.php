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
			$pesan		= cleaninsert($_POST['pesan']);
			$tanggal	= DATE('Y-m-d H:m:s');
			$ip 		= $_SERVER['REMOTE_ADDR'];

			$tpl->assign("nama","$nama");
			$tpl->assign("email","$email");
			$tpl->assign("pesan","$pesan");

			$sql	= "select max(id) as idbaru from tbl_contact";
			$query	= sql($sql);
			$idbaru	= sql_result($query,0,idbaru) + 1;

			$perintah	= "insert into tbl_contact (`id`,`nama`,`email`,`pesan`,`ip`, `tanggal`) values ('$idbaru','$nama','$email','$pesan','$ip', '$tanggal')";
			$hasil		= sql($perintah);

			if($hasil)
			{
				$pesanhasil = "Selamat Pesan Anda di $title telah berhasil disimpan.";
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
		
	$perintah 	= "select id,nama,oleh,ringkas,lengkap,gambar1,gambar,create_date,alias from tbl_static where alias='kontak'";
	$hasil 		= sql($perintah);
	$data 		=  sql_fetch_data($hasil);
	
	$idcontent 		= $data['id'];
	$nama			= $data['nama'];
	$oleh 			= $data['oleh'];
	$lengkap		= $data['lengkap'];
	$tanggal 		= tanggal($data['create_date']);
	$gambar 		= $data['gambar1'];
	$gambarshare 	= $data['gambar'];
	$ringkas 		= $data['ringkas'];
	$alias 			= $data['alias'];
	
	$file1 			= $data['file1'];
	$file2 			= $data['file2'];

	if(empty($katid)) $katid="0";

	//Sesuaikan dengan path
	$lengkap = str_replace("jscripts/tiny_mce/plugins/emotions","$domain/plugin/emotion",$lengkap);
	$lengkap = str_replace("../../","/",$lengkap);

	$tpl->assign("detailid",$idcontent);
	$tpl->assign("detailnama",$nama);
	$tpl->assign("detaillengkap",$lengkap);
	$tpl->assign("detailringkas",$ringkas);
	$tpl->assign("detailcreator",$oleh);
	$tpl->assign("detailtanggal",$tanggal);
	
	if(!empty($gambar)) $tpl->assign("detailgambar","$fulldomain/gambar/$kanal/$gambar");
	if(!empty($gambarshare)) $tpl->assign("detailgambarshare","$fulldomain/gambar/$kanal/$gambarshare");
	
	sql_free_result($hasil);
?>