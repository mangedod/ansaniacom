<?php 
$hlm =$var[4];
$judul_per_hlm = 10;
$batas_paging = 5;

$where ="and toUserName='$var[3]'";
$limit = "limit 5";

$sql = "select count(*) as jml from tbl_post where isi!='' $where";
#$sql = "select count(*) as jml from tbl_post where userName='$_SESSION[usernameresel]'";
$hsl = mysql_query( $sql);
$tot = sql_result($hsl, 0,'jml');
$hlm_tot = ceil($tot / $judul_per_hlm);		
if (empty($hlm)){
	$hlm = 1;
	}
if ($hlm > $hlm_tot){
	$hlm = $hlm_tot;
	}

$ord = ($hlm - 1) * $judul_per_hlm;
if ($ord < 0 ) $ord=0;
$datapost=array();
$perintah="select postId,isi,userName,jmlKomen,toUserName,tanggal,jmlLike from tbl_post where isi!='' $where order by postId desc limit $ord, $judul_per_hlm";
#$perintah="select postId,isi,userName,jmlKomen,toUserName,tanggal,jmlLike from tbl_post where toUserName='$_SESSION[usernameresel]' order by postId desc limit $ord, $judul_per_hlm";

$hasil=mysql_query($perintah);
$u=1;
while($data=mysql_fetch_object($hasil))
{
	$postId		= $data->postId;
	$isi		= getEmotIcon($data->isi);
	$userName	= $data->userName;
	$namalengkap= getNamalengkap($userName);
	$toUserName	= $data->toUserName;
	$avatar		= getAvatarName($userName);
	$avatarnya	= getAvatarName($_SESSION[usernameresel]);
	$jmlLike	= $data->jmlLike;
	$tanggal	= $data->tanggal;
	$skr		= date("Y-m-d");
	
	$toUser = getFullName($toUserName);
	
	if($userName!=$toUserName) $isi = "<a href=\"$fulldomain/member/profile/$toUserName\"><b>>> $toUser</b></a> $isi";
	
	//explode tanggal
	$tgl=explode(" ",$tanggal);
	$tegeel=$tgl[0];
	$tegeel1=tanggalLahir($tegeel);
	$jam=$tgl[1];
	$jam1=$jam;
	//explode waktu
	$time=explode(":",$jam1);
	$tm1=$time[0];
	$tm2=$time[1];
	$tm3=$time[2];
	
	if($tm1>12)
		$ket="pm";
	else
		$ket="am";
	
	if($tegeel==$skr)
		$tgltampil=$tm1.":".$tm2." ".$ket;
	else
		$tgltampil=$tegeel1." at ".$tm1.":".$tm2." ".$ket;
	
	//check like stats name
	$query3="select userName from tbl_post_like where postId='$postId' order by tanggal desc limit 1";
	$hsl3=mysql_query($query3);
	$dta3=mysql_fetch_object($hsl3);
	if($_SESSION[usernameresel]==$dta3->userName)
		$userlikename="You";
	else
		$userlikename="<a href=$fulldomain/$dta3->userName>".getNamalengkap($dta3->userName)."</a>";
	
	//check like stats
	$query2="select userName from tbl_post_like where postId='$postId'";
	$hhsl=mysql_query($query2);
	$dta=mysql_fetch_object($hhsl);
	if ($data)
	{
		$userlike=$dta->userName;
		if($userlike==($_SESSION[usernameresel]))
			$unlike="benar";
		else
			$unlike="salah";
	}
	$jmlKomen=$data->jmlKomen;
	if($jmlKomen>2)
		$jmlKomenBaru=$jmlKomen-2;
	else
		$jmlKomenBaru=0;
	
	if(!empty($avatar))
		$avatar=$avatar;
	else
		$avatar="$lokasiwebtemplate/no_pic.jpg";
	
	
	//komentar posting status
	$sql="select id,userName,isi from tbl_post_komen where postId='$postId' order by tanggal asc $limit";
	$hsl=mysql_query($sql);
	while($row=mysql_fetch_object($hsl))
	{
		$id=$row->id;
		$oleh=$row->userName;
		$nama=getNamalengkap($oleh);
		$komentar=$row->isi;
		$komentar=nl2br($komentar);
		$gambar=getAvatarName($oleh);
		
		if($oleh==$_SESSION[usernameresel])
			$hapus=1;
		else
			$hapus=0;
		
		$datakomen[$postId][$id]=array("id"=>$id,"nama"=>$nama,"komentar"=>$komentar,"gambar"=>$gambar,"oleh"=>$oleh,"hapus"=>$hapus);
	}
	
	if($userName==$_SESSION[usernameresel]) $hapus1 = 1;
		else $hapus1= 0;
	$datapost[$u]=array("u"=>$u,"postId"=>$postId,"isi"=>$isi,"avatar"=>$avatar,"hapus"=>$hapus1,"jmlKomen"=>$jmlKomen,"jmlKomenBaru"=>$jmlKomenBaru,"namalengkap"=>$namalengkap,"wallphoto"=>$wallphoto,"linkphoto"=>$linkphoto,
	"wallvideo"=>$wallvideo,"videoid"=>$videoid,"userDirName"=>$userDirName,"userName"=>$userName,"unlike"=>$unlike,"jmlLike"=>$jmlLike,"userlikename"=>$userlikename,"tgltampil"=>$tgltampil,"avatarnya"=>$avatarnya);
	$u++;
}
mysql_free_result($hasil);
$tpl->assign("datapost",$datapost);
$tpl->assign("datakomen",$datakomen);

//Paging 
$batas_page =5;
		
$stringpage = array();
$pageid =0;
		
if ($hlm > 1){
	$prev = $hlm - 1;
	$stringpage[$pageid] = array("nama"=>"Awal","link"=>"$fulldomain/$kanal/profile/$var[3]/1");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"Sebelumnya","link"=>"$fulldomain/$kanal/profile/$var[3]/$prev");
}
else {
	$stringpage[$pageid] = array("nama"=>"Awal","link"=>"");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"Sebelumnya","link"=>"");
}

$hlm2 = $hlm - (ceil($batas_page/2));
$hlm4= $hlm+(ceil($batas_page/2));
		
if($hlm2 <= 0 ) $hlm3=1;
   else $hlm3 = $hlm2;
$pageid++;
for ($ii=$hlm3; $ii <= $hlm_tot and $ii<=$hlm4; $ii++){
	if ($ii==$hlm){
		$stringpage[$pageid] = array("nama"=>"$ii","link"=>"");
	}else{
		$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$fulldomain/$kanal/profile/$var[3]/$ii");
	}
	$pageid++;
}
if ($hlm < $hlm_tot){
	$next = $hlm + 1;
	$stringpage[$pageid] = array("nama"=>"Selanjutnya","link"=>"$fulldomain/$kanal/profile/$var[3]/$next");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"$fulldomain/$kanal/profile/$var[3]/$hlm_tot");
}
else
{
	$stringpage[$pageid] = array("nama"=>"Selanjutnya","link"=>"");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"");
}
$tpl->assign("stringpage",$stringpage);
//Selesai Paging
?>