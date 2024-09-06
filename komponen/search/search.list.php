<?php 

	if($_POST[aksi] == "search" or $aksi == "list-search")
		$aksi			= "list-search";
	else
		$aksi			= "list";
	
	if($_POST[aksi] == "search" or preg_match("/search/i",$aksi))
	{
		
		if($_POST[aksi] == "search")
		{
			$key		= $_POST[key];
			
			session_start();
			$_SESSION[key]		= $key;
		}
		
		$key		= $_SESSION[key];
		
		if($key == "")
		{
			$where	.= "";
			$wherem	.= "";
		}
		if($key != "")
		{
			$where	.= "and nama like '%$key%'";
			$wherem	.= "and userfullname like '%$key%'";
		}

		$secalias	= 'allsec';
		
		$tpl->assign("rubrik","Pencarian");
		$hlm = $var[5];
		$hlmm = $var[5];
	}
	else
	{
		$where	.= '';
		$wherem	.= "";
		
		$tpl->assign("aliass",$aliass);
		
		session_start();
		unset($_SESSION['key']);
		$hlm = $var[5];
		$hlmm = $var[5];
	}
	
	$tpl->assign("key",$key);

$judul_per_hlm = 6;
$batas_paging = 5;

$sql = "select count(*) as jml from tbl_member where useractivestatus='1' $wherem";
$hsl = sql($sql);
$totm = sql_result($hsl, 0,'jml');
$hlm_totm = ceil($totm / $judul_per_hlm);		
if (empty($hlmm)){
	$hlmm = 1;
	}
if ($hlmm > $hlm_totm){
	$hlmm = $hlm_totm;
	}

$ord = ($hlmm - 1) * $judul_per_hlm;
if ($ord < 0 ) $ord=0;
$x=0;

$tpl->assign("totm",$totm);

$sql	= "select userid,userfullname,aboutme,usercreateddate,avatar,username from tbl_member where useractivestatus='1' $wherem order by userfullname asc limit $ord, $judul_per_hlm";
$query	= sql($sql);
$aa		= 1;
while($row = sql_fetch_data($query))
{
	$userid		= $row['userid'];
	$nama		= $row['userfullname'];
	$alias		= getAlias($nama);
	$lengkap	= substr($row['aboutme'],0,300);

	$gambar	= $row['avatar'];
	$tanggal= $row['usercreateddate'];
	$username= $row['username'];
	$tanggal=explode("-",$tanggal);
	$tanggal="$tanggal[2].$tanggal[1].$tanggal[0]";
	if(strlen($judul) > 50)
	{
		$nama	= substr($nama,0,50);
		$nama	.="...";
	}
	else
		$nama		= $nama;
	
	if($gambar)
		$gambar="$fulldomain/uploads/avatars/$gambar";
	else
		$gambar="$fulldomain/images/noimages.jpg";
		
	$link_detail	= "$fulldomain/$username";
	
	$list[$userid]	= array("id"=>$userid,"tanggal"=>$tanggal,"nama"=>$nama,"ringkas"=>$lengkap,"link"=>$link_detail,"gambar"=>$gambar,"no"=>$aa);
	
	$aa++;
}
sql_free_result($query);
$tpl->assign("datadetailmember",$list);

$sql = "select count(*) as jml from tbl_konten where published='1' $where";
$hsl = sql( $sql);
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

$tpl->assign("tot",$tot);

$mysql = "select id,ringkas,nama,create_date,alias,secid,gambar,gambar1,tipe from tbl_konten where published='1' $where order by id  desc limit $ord, $judul_per_hlm";
$hasil = sql( $mysql);


$datadetail = array();		
$i = 0;
while ($data =  sql_fetch_data($hasil)) {	
	$tanggal = $data['create_date'];
	$nama = $data['nama'];
	$id = $data['id'];
	$ringkas = $data['ringkas'];
	$alias = $data['alias'];
	$tanggal = tanggal($tanggal);
	$gambar = $data['gambar'];
	$gambar1 = $data['gambar1'];
	$secid = $data['secid'];
	$tipe = $data['tipe'];
	
	if($tipe=="text")
		$kanals = "konten";
	else
		$kanals = $tipe;
	
	$perintah = "select alias,nama from tbl_konten_sec where secid='$secid'";
	$res = sql($perintah);
	$dt =  sql_fetch_data($res);
	$secalias1 = $dt['alias'];
	$namasec = $dt['nama'];
	sql_free_result($res);
	
	if($i==0){ $gambar= $gambar1; }
	else { $gambar = $gambar; }
	
	//if($tipe=="text") $tipe ="khazanah";
	
	
	if(!empty($gambar)) $gambar = "$fulldomain/gambar/$tipe/$gambar";
	 else $gambar = "";
	 
	if(empty($namasec))
		$namasec = "Tidak Ada Kategori";
	
	if(empty($secalias1))
		$secalias1 = "allsec";
		 

	$link = "$fulldomain/$kanals/read/$secalias1/$id/$alias"; 
		
	$datadetail[$id] = array("id"=>$id,"no"=>$i,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar,"namasec"=>$namasec);
	$i++;
		
}
sql_free_result($hasil);
$tpl->assign("datadetail",$datadetail);

if($hlm_tot > $hlm_totm)
	$hlm_tot = $hlm_tot;
else
	$hlm_tot = $hlm_totm;

//Paging 
$batas_page =5;

$stringpage = array();
$pageid =0;

if ($hlm > 1){
	$prev = $hlm - 1;
	$stringpage[$pageid] = array("nama"=>"Awal","link"=>"$fulldomain/$kanal/$aksi/$secalias/1");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"Sebelumnya","link"=>"$fulldomain/$kanal/$aksi/$secalias/$prev");

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
		$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$fulldomain/$kanal/$aksi/$secalias/$ii");
	}
	$pageid++;
}
if ($hlm < $hlm_tot){
	$next = $hlm + 1;
	$stringpage[$pageid] = array("nama"=>"Selanjutnya","link"=>"$fulldomain/$kanal/$aksi/$secalias/$next");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"$fulldomain/$kanal/$aksi/$secalias/$hlm_tot");
}
$tpl->assign("stringpage",$stringpage);
		
?>
