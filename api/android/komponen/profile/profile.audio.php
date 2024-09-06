<?php
$userid = sql_get_var("select userid from tbl_member where username='$username'");

$judul_per_hlm = 10;
$batas_paging = 5;
$hlm = $var[4];

$sql = "select count(*) as jml from tbl_audio where proses='1' and userid='$userid'";
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

$mysql = "select id,ringkas,nama,create_date,alias,secid,gambar,gambar1,audio,folder,waveform,userid,jmlcomment,views,durasi from tbl_audio where proses='1'  and userid='$userid' and published='1' order by id  desc limit $ord, $judul_per_hlm";
$hasil = sql( $mysql);


$datadetail = array();		
$i = 0;
while ($data =  sql_fetch_data($hasil)) {	
	$tanggal = $data['create_date'];
	$nama = $data['nama'];
	$id = $data['id'];
	$ringkas = ringkas($data['ringkas'],25);
	$alias = $data['alias'];
	$tanggal1 = tanggal($tanggal);
	$gambar = $data['gambar'];
	$gambar1 = $data['gambar1'];
	$secid = $data['secid'];
	$folder = $data['folder'];
	$waveform = $data['waveform'];
	$userid = $data['userid'];
	$views = $data['views'];
	$jmlcomment = $data['jmlcomment'];
	$durasi = durasi($data['durasi']);
	$audio = $data['audio'];
	
	$views = rupiah($views);
	$jmlcomment = rupiah($jmlcomment);
	
	$perintah = "select alias from tbl_audio_sec where secid='$secid'";
	$res = sql($perintah);
	$dt =  sql_fetch_data($res);
	$secalias = $dt['alias'];
	sql_free_result($res);
	
	if($i==0){ $gambar= $gambar1; }
	else { $gambar = $gambar; }
	
	
	if(!empty($waveform)) $waveform = "$fulldomain/uploads/images/$folder/$waveform";
	 else $waveform = "";
	 
	if(!empty($audio)) $audio = "$fulldomain/uploads/audio/$folder/$audio";
	 else $audio = "";
	 
	$user = getprofileid($userid);
	
	if(!empty($gambar)) $gambar = "$fulldomain/uploads/images/$folder/$gambar";
	 else $gambar = "$user[avatar]";

		 

	$link = "$fulldomain/$username/listen/$id/$alias";
		
	$datadetail[$id] = array("id"=>$id,"no"=>$i,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal1,"date"=>$tanggal,"alias"=>$alias,"url"=>$link,
		"gambar"=>$gambar,"audio"=>$audio,"waveform"=>$waveform,"user"=>$user,"views"=>$views,"jmlcomment"=>$jmlcomment,"durasi"=>$durasi);
	$i++;
	
	
		
}
sql_free_result($hasil);

//Paging 
$batas_page =5;

$stringpage = array();
$pageid =0;

if ($hlm > 1){
	$prev = $hlm - 1;
	$stringpage[$pageid] = array("nama"=>"Awal","link"=>"$fulldomain/$username/$aksi/1");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"Sebelumnya","link"=>"$fulldomain/$username/$aksi/$prev");

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
		$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$fulldomain/$username/$aksi/$ii");
	}
	$pageid++;
}
if ($hlm < $hlm_tot){
	$next = $hlm + 1;
	$stringpage[$pageid] = array("nama"=>"Selanjutnya","link"=>"$fulldomain/$username/$aksi/$next");
	$pageid++;
	$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"$fulldomain/$username/$aksi/$hlm_tot");
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
$result['dataaudio'] = $datadetail;
$result['stringpage'] = $stringpage;
	
echo json_encode($result);
	
?>
