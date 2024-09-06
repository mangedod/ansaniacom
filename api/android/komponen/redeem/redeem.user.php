<?php
$userid = $var[4];
$judul_per_hlm = 10;
$batas_paging = 5;
$start = $var[5];
$limit = $var[6];

$datamember = sql_get_var_row("select userfullname,userid,username from tbl_member where userid='$userid'");
$username = $datamember['username'];



if(!empty($last)) { $where = " and id < $last"; }

$sql = "select count(*) as jml from tbl_member_redeem where userid='$userid'";
$hsl = sql( $sql);
$tot = sql_result($hsl, 0, jml);
$hlm_tot = ceil($tot / $judul_per_hlm);		
if (empty($hlm)){
	$hlm = 1;
	}
if ($hlm > $hlm_tot){
	$hlm = $hlm_tot;
	}

$ord = ($hlm - 1) * $judul_per_hlm;
if ($ord < 0 ) $ord=0;

$mysql = "select id,vouchercode,nama,redeemid,useddate,status,create_date from tbl_member_redeem where userid='$userid' order by id desc limit $start, $limit";
$hasil = sql( $mysql);


$datadetail = array();		
$i = 0;
while ($data =  sql_fetch_data($hasil)) {	
	$tanggal = $data['create_date'];
	$nama = $data['nama'];
	$id = $data['id'];
	$ringkas = ringkas($data['ringkas'],25);
	$vouchercode = $data['vouchercode'];
	$useddate = tanggal($useddate);
	$redeemid = $data['redeemid'];
	$status = $data['status'];
	
	$expiredate = date('Y-m-d H:i:s', strtotime($tanggal. "+$pointexpire months"));	
	$expiredate = tanggaltok($expiredate);
	
	if($status=="1")
	{
		$status = "Sudah digunakan";
	}
	else
	{
		$status = "Belum digunakan";
	}
			
	$datadetail[] = array("id"=>$id,"no"=>$i,"nama"=>$nama,"vouchercode"=>$vouchercode,"tanggal"=>$tanggal1,"status"=>$status,"expiredate"=>$expiredate);
	$i++;
	
	
		
}
sql_free_result($hasil);

$result['status']="OK";
$result['message']="Data berhasil di load";
$result['datalist'] = $datadetail;
	
echo json_encode($result);


?>
