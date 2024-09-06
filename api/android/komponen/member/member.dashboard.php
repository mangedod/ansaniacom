<?php 
$judul_per_hlm = 10;
$batas_paging = 5;
$hlm = $var[4];
$last = $var[5];

if(!empty($last)) { $where = " and id < $last"; }

$sql = "select count(*) as jml from tbl_buku where published='1' $where";
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

$mysql = "select bukuid,lengkap,nama,create_date,alias,secid,gambar,gambar1,penulis,penerbit from tbl_buku where published='1' $where order by bukuid desc limit $ord, $judul_per_hlm";
$hasil = sql( $mysql);


$datadetail = array();		
$i = 0;
while ($data =  sql_fetch_data($hasil)) {	
	$tanggal = $data['create_date'];
	$nama = $data['nama'];
	$bukuid = $data['bukuid'];
	$ringkas = ringkas($data['lengkap'],25);
	$alias = $data['alias'];
	$tanggal1 = tanggal($tanggal);
	$gambar = $data['gambar'];
	$gambar1 = $data['gambar1'];
	$secid = $data['secid'];
	$folder = $data['folder'];
	$waveform = $data['waveform'];
	$userid = $data['userid'];
	$views = $data['views'];
	$penulis = $data['penulis'];
	$durasi = durasi($data['durasi']);
	$penerbit = $data['penerbit'];
	
	$views = rupiah($views);
	$jmlcomment = rupiah($jmlcomment);
	
	$perintah = "select alias from tbl_buku_sec where secid='$secid'";
	$res = sql($perintah);
	$dt =  sql_fetch_data($res);
	$secalias = $dt['alias'];
	sql_free_result($res);
	

	$user = getprofileid($userid);
	
	if(!empty($gambar)) $gambar = "$fulldomain/gambar/buku/$gambar";
	 else $gambar = "$user[avatar]";

		 

	$link = "$fulldomain/$kanal/listen/$id/$alias";
		
	$datadetail[] = array("bukuid"=>$bukuid,"no"=>$i,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal1,"penulis"=>$penulis,"penerbit"=>$penerbit,"date"=>$tanggal,"alias"=>$alias,"url"=>$link,"gambar"=>$gambar);
	$i++;
	
	
		
}
sql_free_result($hasil);

//Paging 
$batas_page =5;

$stringpage = array();
$pageid =0;

if ($hlm > 1){
	$prev = $hlm - 1;
	$stringpage[$pageid] = array("nama"=>"Awal","link"=>"$fulldomain/$kanal/$aksi/1");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"Sebelumnya","link"=>"$fulldomain/$kanal/$aksi/$prev");

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
		$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$fulldomain/$kanal/$aksi/$ii");
	}
	$pageid++;
}
if ($hlm < $hlm_tot){
	$next = $hlm + 1;
	$stringpage[$pageid] = array("nama"=>"Selanjutnya","link"=>"$fulldomain/$kanal/$aksi/$next");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"$fulldomain/$kanal/$aksi/$hlm_tot");
}
else
{
	$stringpage[$pageid] = array("nama"=>"Selanjutnya","link"=>"");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"");
}

$result['status']="OK";
$result['message']="Data berhasil di load";
$result['halaman']= $hlm;
$result['totalhalaman'] = $hlm_tot;
$result['databuku'] = $datadetail;
$result['stringpage'] = $stringpage;
	
echo json_encode($result);

?>