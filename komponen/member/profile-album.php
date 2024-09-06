<?php 
$userName=$var[3];
$userDirName=getDirName($profilId);
$userFullName=getNamalengkap($userName);
$avatar=getAvatarName($userName);

$perintah="select subid,namasub from tbl_content_sub where userId='$profilId'";
$hasil=mysql_query($perintah);
$jumlah=mysql_num_rows($hasil);

$dataAlbum=array();
while($data=mysql_fetch_object($hasil))
{
	$subid=$data->subid;
	$namasub=$data->namasub;
	
	$mysql="select albumid,gambar_m from tbl_content_album where subid='$subid' and userId='$profilId'";
	$hsl=mysql_query($mysql);
	$baris=mysql_fetch_object($hsl);
	$gambar=$baris->gambar_m;
	$albumid=$baris->albumid;
	$gambar="$fulldomain/dirmember/$userDirName/album/$albumid/$gambar";
	$url="$fulldomain/member/profile/$userName/album/list/$subid";
	$dataAlbum[$subid]=array("subid"=>$subid,"nama"=>$namasub,"gambar"=>$gambar,"url"=>$url);
}
mysql_free_result($hasil);
$tpl->assign("dataAlbum",$dataAlbum);
$tpl->assign("namalengkap",$userFullName);
$tpl->assign("avatar",$avatar);
$tpl->assign("jumlah",$jumlah);
?>