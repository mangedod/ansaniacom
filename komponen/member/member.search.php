<?php 
ini_set("display_errors","On");
$submit	= $_POST['submit'];
$hlm 			= $var[9];

if(!isset($_POST['nama'])) $nama = $var[4];
	
if(!empty($submit) or !empty($hlm))
{
	$nama	= $_POST['nama'];
	$gender	= $_POST['gender'];
	$usia	= $_POST['usia'];
	
	if($usia != '0')
	{
		$temp	= explode("-",$usia);
		$dari	= $temp[0];
		$sampai	= $temp[1];
	}
	$status	= $_POST['status'];
	$kota	= $_POST['kota'];
	
	if($hlm)
	{
		$nama	= $var[4];
		$gender	= $var[5];
		$usia	= $var[6];
		if($usia != '0')
		{
			$temp	= explode("-",$usia);
			$dari	= $temp[0];
			$sampai	= $temp[1];
		}
		$status	= $var[7];
		$kota	= $var[8];
	}
	$now	= date("Y");
	
	$where	= "where username !='' ";
	
	if(!empty($nama))
	{
		$where	.= "and userfullname like '%$nama%' ";
		$tpl->assign("searchnama",$nama);
	}
	if(($gender != '0')and ($gender != '')and ($gender != 'Jenis Kelamin'))
	{
		$where	.= "and usergender = '$gender' ";
		$tpl->assign("searchgender",$gender);
	}
	else
		$gender = '0';
		
	if(($usia != '0')and ($usia != '')and ($usia != 'Usia'))
	{
		$where	.= "and $now-YEAR(userdob)>='$dari' and $now-YEAR(userdob)<='$sampai' ";
		$tpl->assign("searchusia","$dari-$sampai");
	}
	else
		$usia = '0';
		
	if(($status != '0') and ($status != '') and ($status != 'Status'))
	{
		$where	.= "and marriagestatusid = '$status' ";
		$tpl->assign("searchstatus",$status);
	}
	else
		$status = '0';
		
	if(!empty($kota))
	{
		$where	.= "and cityname like '%$kota%' ";
		$tpl->assign("searchkota",$kota);
	}
	
	$judul_per_hlm 	= 21;
	$batas_paging 	= 5;
	
	$sql 	= "select count(*) as jml from tbl_member $where";
	$hsl	= sql($sql);
	$tot 	= sql_result($hsl, 0,'jml');
	$hlm_tot= ceil($tot / $judul_per_hlm);		
	if (empty($hlm)){
		$hlm = 1;
		}
	if ($hlm > $hlm_tot){
		$hlm = $hlm_tot;
		}
	
	$ord = ($hlm - 1) * $judul_per_hlm;
	if ($ord < 0 ) $ord=0;
	
	$tpl->assign("tot",$tot);
	
	//daftar teman
	$perintah	= "select userid,username,userfullname,avatar,userdirname,userlastactive,cityname,userdob,aboutme from tbl_member $where order by userlastactive desc limit $ord, $judul_per_hlm";
	$hasil		= sql($perintah);
	$searchteman= array();
	$jumteman	= sql_num_rows($hasil);
	while($data	= sql_fetch_data($hasil))
	{
		$id			= $data['userid'];
		$username	= $data['username'];
		$userDirName = $data['userdirname'];
		$avatar		=  $data['avatar'];
		$namateman	= ucwords($data['userfullname']);
		$aboutme	= bersih($data['aboutme']);
		
		if(empty($avatar)){ $avatar = "$domain/images/no_pic.jpg"; }
		else
		{				
			$avatar = "$lokasiwebmember/avatars/$avatar";
		}
		
		$birthyear		= substr($data['userdob'],1,4);
		$umur			= date("Y") - $birthyear;
		
		$link		= "$fulldomain/$username";
		
		$aktif	= tanggal($data['userlastactive']);
		$cityName = $data['cityname'];
		
		if($data['userlastactive']=="0000-00-00 00:00:00") $aktif = "Tidak Diketahui"; 


		$datateman[$id]=array("id"=>$id,"namateman"=>$namateman,"link"=>$link,"umur"=>$umur,"aboutme"=>$aboutme,"avatar"=>$avatar,"kota"=>$cityName,"username"=>$username,"aktif"=>$aktif,"lecture"=>$lecture);
	}
	sql_free_result($hasil);
	$tpl->assign("datateman",$datateman);
	$tpl->assign("jumteman",$jumteman);
	
	$kata = urldecode($nama);
	
	//Paging 
	$batas_page =5;
	
	$stringpage = array();
	$pageid =0;
	
	if ($hlm > 1){
		$prev = $hlm - 1;
		$stringpage[$pageid] = array("nama"=>"Awal","link"=>"$fulldomain/$kanal/search/$nama/$gender/$usia/$status/$propinsiId/1");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"&laquo;","link"=>"$fulldomain/$kanal/search/$nama/$gender/$usia/$status/$propinsiId/$prev");

	}
	else {
		$stringpage[$pageid] = array("nama"=>"Awal","link"=>"");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"&laquo;","link"=>"");
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
			$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$fulldomain/$kanal/search/$nama/$gender/$usia/$status/$propinsiId/$ii");
		}
		$pageid++;
	}
	if ($hlm < $hlm_tot){
		$next = $hlm + 1;
		$stringpage[$pageid] = array("nama"=>"&raquo;","link"=>"$fulldomain/$kanal/search/$nama/$gender/$usia/$status/$propinsiId/$next");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"$fulldomain/$kanal/search/$nama/$gender/$usia/$status/$propinsiId/$hlm_tot");
	}
	else
	{
		$stringpage[$pageid] = array("nama"=>"&raquo;","link"=>"");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"");
	}
	$tpl->assign("stringpage",$stringpage);	
}
?>