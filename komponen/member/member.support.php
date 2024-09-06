<?php

$childaksi = $var[4];
$tpl->assign("childaksi",$childaksi);

if($childaksi=="detail")
{
	$subscriberid = $var[5];
	
	if(isset($_POST['info']) && !empty($_POST['info']))
	{
		$info = clean($_POST['info']);
		$tgl = date("Y-m-d H:i:s");
		
		$sql = "update tbl_subscriber set info='$info',tanggal='$tgl',status='1' where subscriberid='$subscriberid' and refuserid='$_SESSION[useridresel]'";
		$hsl = sql($sql);
		
		if($hsl)
		{
			$msg = "Follow Up berhasil dilakukan dan disimpan, silahkan terus pantau daftar ini untuk mengajak sebanyak mungkin orang untuk gabung di Sygma Online Store";
			$tpl->assign("msg",$msg);
		}
	}
	
	$perintah	= "select  subscriberid,userfullname,useremail,userhandphone,kota,update_date,status,tanggal,info from tbl_subscriber where subscriberid='$subscriberid'  and refuserid='$_SESSION[useridresel]'";
	$hasil		= sql($perintah);
	$datadetail	= array();
	$no = (($hlm-1)*$judul_per_hlm)+1;
	while($data = sql_fetch_data($hasil))
	{
		$tanggal        = $data['update_date'];
		$userfullname   = ucwords($data['userfullname']);
		$id             = $data['subscriberid'];
		$userhandphone  = $data['userhandphone'];
		$useremail      = $data['useremail'];
		$tanggal        = date("d/m/Y H:i:s",strtotime($tanggal));
		$tanggalapprove = date("d/m/Y H:i:s",strtotime($data['tanggal']));
		$kota           = $data['kota'];
		$status         = $data['status'];
		$info           = $data['info'];
		 
		$datadetail[$id] = array("id"=>$id,"no"=>$no,"userfullname"=>$userfullname,"useremail"=>$useremail,"tanggal"=>$tanggal,"userhandphone"=>$userhandphone,"kota"=>$kota,"status"=>$status,"info"=>$info,"tanggalfollow"=>$tanggalapprove);
		$no++;
		unset($status,$kota);
	}
	sql_free_result($hasil);
	$tpl->assign("datadetail",$datadetail);
	
}
else
{
	$judul_per_hlm = 10;
	$batas_paging = 5;
	$hlm =$var[5];
	
	
	$sql = "select count(*) as jml from tbl_contact_message where email!=''  and contactuserid='$_SESSION[useridresel]'";
	$hsl = sql($sql);
	$tot = sql_result($hsl, 0,'jml');
	
	$tpl->assign("jml_post",$tot);
	
	$hlm_tot = ceil($tot / $judul_per_hlm);		
	if (empty($hlm)){
		$hlm = 1;
	}
	if ($hlm > $hlm_tot){
	$hlm = $hlm_tot;
	}
	$ord = ($hlm - 1) * $judul_per_hlm;
	if ($ord < 0 ) $ord=0;
	
	$perintah	= "select id,nama,email,phone,pesan,view,ip,status,create_date from tbl_contact_message where  email!=''  and contactuserid='$_SESSION[useridresel]' order by id desc limit $ord, $judul_per_hlm";
	$hasil		= sql($perintah);
	$datadetail	= array();
	$no = (($hlm-1)*$judul_per_hlm)+1;
	while($data = sql_fetch_data($hasil))
	{
		$tanggal = $data['create_date'];
		$userfullname = ucwords($data['nama']);
		$id = $data['id'];
		$userhandphone = $data['phone'];
		$useremail = $data['email'];
		$tanggal = tanggal($tanggal);
		$pesan = $data['pesan'];
		$status = $data['status'];
		 
		$datadetail[$id] = array("id"=>$id,"no"=>$no,"userfullname"=>$userfullname,"useremail"=>$useremail,"tanggal"=>$tanggal,"userhandphone"=>$userhandphone,"pesan"=>$pesan,"status"=>$status);
		$no++;
		unset($status,$kota);
	}
	sql_free_result($hasil);
	$tpl->assign("datadetail",$datadetail);
	
	//Paging 
	$batas_page =5;
	
	$stringpage = array();
	$pageid =0;
	
	$Selanjutnya 	= "&rsaquo;";
	$Sebelumnya 	= "&lsaquo;";
	$Akhir			= "&raquo;";
	$Awal 			= "&laquo;";
	
	if ($hlm > 1){
		$prev = $hlm - 1;
		$stringpage[$pageid] = array("nama"=>"$Awal","link"=>"$fulldomain/$kanal/$aksi/list/1");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"$Sebelumnya","link"=>"$fulldomain/$kanal/$aksi/list/$prev");
	
	}
	else {
		$stringpage[$pageid] = array("nama"=>"$Awal","link"=>"");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"$Sebelumnya","link"=>"");
	}
	
	$hlm2 = $hlm - (ceil($batas_page/2));
	$hlm4= $hlm+(ceil($batas_page/2));
	
	if($hlm2 <= 0 ) $hlm3=1;
	   else $hlm3 = $hlm2;
	$pageid++;
	for ($ii=$hlm3; $ii <= $hlm_tot and $ii<=$hlm4; $ii++){
		if ($ii==$hlm){
			$stringpage[$pageid] = array("nama"=>"$ii","link"=>"","class"=>"active");
		}else{
			$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$fulldomain/$kanal/$aksi/list/$ii");
		}
		$pageid++;
	}
	if ($hlm < $hlm_tot){
		$next = $hlm + 1;
		$stringpage[$pageid] = array("nama"=>"$Selanjutnya","link"=>"$fulldomain/$kanal/list/$aksi/$next");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"$Akhir","link"=>"$fulldomain/$kanal/$aksi/list/$hlm_tot");
	}
	else
	{
		$stringpage[$pageid] = array("nama"=>"$Selanjutnya","link"=>"");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"$Akhir","link"=>"");
	}
	$tpl->assign("stringpage",$stringpage);
	//Selesai Paging
}
?>