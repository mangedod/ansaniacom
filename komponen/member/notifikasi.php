<?php 
if($_SESSION['usernameresel'])
{
	//Notifikasi
	$perintah = "select id,fromusername,pesan,tanggal from tbl_notifikasi where (tousername='$_SESSION[usernameresel]') and status='0' order by tanggal desc limit 5";
	$hasil = sql($perintah);
	$jml = sql_num_rows($hasil);
	$notifikasi = array();
	while($data = sql_fetch_data($hasil))
	{
		$id = $data['id'];
		$id2 = base64_encode($id);
		$base = md5($id2);
		$fromusername = $data['fromusername'];
		$pesan = $data['pesan'];
		$tanggal = $data['tanggal'];
		//explode tanggal
		$tgl		= explode(" ",$tanggal);
		$tegeel		= $tgl[0];
		$tegeel1	= tanggalLahir($tegeel);
		$jam		= $tgl[1];
		$jam1		= $jam;
		//explode waktu
		$time		= explode(":",$jam1);
		$tm1		= $time[0];
		$tm2		= $time[1];
		$tm3		= $time[2];
	
		if($tm1>12)
			$ket	= "pm";
		else
			$ket	= "am";
	
		if($tegeel==$skr)
			$tgltampil	= $tm1.":".$tm2." ".$ket;
		else
			$tgltampil	= $tegeel1." at ".$tm1.":".$tm2." ".$ket;
			
		if($fromUserName=="system") { $pesan1 = "Administrator <a href=\"$fulldomain/notifikasi/go/$id2/$base\">$pesan</a>"; }
		else { $pesan1 = "<a href=\"$fulldomain/$fromusername\"><strong>$fromusername</strong></a> <a href=\"$fulldomain/notifikasi/go/$id2/$base\">$pesan</a>"; }
		
		$notifikasi[$id] = array("pesan"=>$pesan1,"tgltampil"=>$tgltampil);
	}print_r($notifikasi);
	$tpl->assign("jmlnotifikasi",$jml);
	$tpl->assign("notifikasi",$notifikasi);
	sql_free_result($hasil);
	
	
}


?>