<?php
$subaksi =$var[4];

if($subaksi=="detail")
{	
	$id =$var[5];

	$perintah = "select secid,nama,alias,ringkas,lengkap,gambar1,gambar,create_date,alias from tbl_training where secid='$id'";
	// echo $perintah;
	$hasil = sql($perintah);
	$data =  sql_fetch_data($hasil);
	
	$idcontent   = $data['secid'];
	$nama        = $data['nama'];
	$alias       = $data['alias'];
	$lengkap     = $data['lengkap'];
	$tanggal     = tanggal($data['create_date']);
	$gambar      = $data['gambar1'];
	$gambarshare = $data['gambar'];
	$ringkas     = $data['ringkas'];
	$alias       = $data['alias'];
	$views       = $data['views'];
	
	if(empty($katid)) $katid="0";
	
	//Sesuaikan dengan path
	$lengkap = str_replace("jscripts/tiny_mce/plugins/emotions","$domain/plugin/emotion",$lengkap);
	$lengkap = str_replace("../../","/",$lengkap);
	
	
	$linkjoin = "$fulldomain/member/training/join/$idcontent/$alias";
	
	
	$tpl->assign("detailid",$idcontent);
	$tpl->assign("detailnama",$nama);
	$tpl->assign("detaillengkap",$lengkap);
	$tpl->assign("detailringkas",$ringkas);
	$tpl->assign("detailcreator",$oleh);
	$tpl->assign("detailtanggal",$tanggal);
	$tpl->assign("linkjoin",$linkjoin);
	
	if(!empty($gambar)) $tpl->assign("detailgambar","$fulldomain/gambar/training/$gambar");
	if(!empty($gambarshare)) $tpl->assign("detailgambarshare","$fulldomain/gambar/training/$gambarshare");
	
	sql_free_result($hasil);
	
	$perintah	= "select  id,ringkas,nama,create_date,alias,gambar,gambar1 from tbl_training_materi where secid='$idcontent' and published='1' order by id asc";
	$hasil		= sql($perintah);
	$daftarmateri	= array();
	$no = 1;
	while($data = sql_fetch_data($hasil))
	{
		$tanggal = $data['create_date'];
		$nama    = $data['nama'];
		$id      = $data['id'];
		$ringkas = $data['ringkas'];
		$alias   = $data['alias'];
		$tanggal = tanggal($tanggal);
		$gambar  = $data['gambar'];
		$gambar1 = $data['gambar1'];
		$secid   = $data['secid'];
		
		$views = number_format($data['views'],0,",",".");
		
		
		if(!empty($gambar)) $gambar = "$fulldomain/gambar/training/$gambar";
		 else $gambar = "$fulldomain/images/noimages.jpg";
		 
		$daftarmateri[$id] = array("secid"=>$secid,"no"=>$no,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal,"jmlmateri"=>$jmlmateri,"linkdetail"=>$linkdetail,"linkjoin"=>$linkjoin,"gambar"=>$gambar,"views"=>$views);
		$no++;
	}
	sql_free_result($hasil);
	$tpl->assign("daftarmateri",$daftarmateri);
	
}
else if($subaksi=="join")
{
	$id =$var[5];
	$perintah = "select secid,nama,alias,ringkas,lengkap,gambar1,gambar,create_date,alias from tbl_training where secid='$id'";
	$hasil = sql($perintah);
	$data =  sql_fetch_data($hasil);
	
	$secid       = $data['secid'];
	$nama        = $data['nama'];
	$alias       = $data['alias'];
	$lengkap     = $data['lengkap'];
	$tanggal     = tanggal($data['create_date']);
	$gambar      = $data['gambar1'];
	$gambarshare = $data['gambar'];
	$ringkas     = $data['ringkas'];
	$alias       = $data['alias'];
	$views       = $data['views'];
	
	if(empty($katid)) $katid="0";
	
	//Sesuaikan dengan path
	$lengkap = str_replace("jscripts/tiny_mce/plugins/emotions","$domain/plugin/emotion",$lengkap);
	$lengkap = str_replace("../../","/",$lengkap);
	
	
	$linkdetail = "$fulldomain/member/training/detail/$secid/$alias";
	$linkjoin = "$fulldomain/member/training/join/$secid/$alias";
	
	
	$tpl->assign("detailid",$idcontent);
	$tpl->assign("detailnama",$nama);
	$tpl->assign("detaillengkap",$lengkap);
	$tpl->assign("detailringkas",$ringkas);
	$tpl->assign("detailcreator",$oleh);
	$tpl->assign("detailtanggal",$tanggal);
	$tpl->assign("linkjoin",$linkjoin);
	$tpl->assign("linkdetail",$linkdetail);
	
	if(!empty($gambar)) $tpl->assign("detailgambar","$fulldomain/gambar/training/$gambar");
	if(!empty($gambarshare)) $tpl->assign("detailgambarshare","$fulldomain/gambar/training/$gambarshare");
	
	sql_free_result($hasil);
	
	
		
	$perintah	= "select  id,ringkas,nama,create_date,alias,gambar,gambar1 from tbl_training_materi where secid='$secid' and published='1' order by id asc";
	$hasil		= sql($perintah);
	$daftarmateri	= array();
	$no = 1;
	while($data = sql_fetch_data($hasil))
	{
		$tanggal = $data['create_date'];
		$nama = $data['nama'];
		$id = $data['id'];
		$ringkas = $data['ringkas'];
		$alias = $data['alias'];
		$tanggal = tanggal($tanggal);
		$gambar = $data['gambar'];
		$gambar1 = $data['gambar1'];
		
		$views = number_format($data['views'],0,",",".");
		
		
		if(!empty($gambar)) $gambar = "$fulldomain/gambar/training/$gambar";
		 else $gambar = "$fulldomain/images/noimages.jpg";
		 
		$linkdetail = "$fulldomain/member/training/join/$secid/$alias/$id";
		 
		$daftarmateri[$id] = array("secid"=>$secid,"no"=>$no,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal,"jmlmateri"=>$jmlmateri,"linkdetail"=>$linkdetail,"linkjoin"=>$linkjoin,"gambar"=>$gambar,"views"=>$views);
		$no++;
	}
	sql_free_result($hasil);
	$tpl->assign("materisec",$daftarmateri);
	
	$materiid = $var[7];
	
	if(empty($subaksi)) $subaksi = "read";
	
	if(empty($materiid))
	{
		$materiid = sql_get_var("select id from tbl_training_materi where secid='$secid' order by id asc limit 1");
	}
	
	//Cari Urutan
	$sql2 = "select id from tbl_training_materi where secid='$secid' order by id asc";
	$hsl2 = sql($sql2);
	$no = 1;	
	while($dt2 = sql_fetch_data($hsl2))
	{
		$materiids = $dt2['id'];
		if($materiids==$materiid)
		{
			$nourut = "$no";
		}
		$no++;
	}
	
	
	//Tampilkan Materi
	$sql2 = "select nama,id,secid,lengkap,video from tbl_training_materi where secid='$secid' and id='$materiid'";
	$hsl2 = sql($sql2);	
	$dt = sql_fetch_data($hsl2);
	
	$namamateri = "Materi $nourut : ".$dt['nama'];
	$materiid = $dt['id'];
	$jenis = $dt['jenis'];
	$lengkap = $dt['lengkap'];
	$video = $dt['video'];
	
	$folder = md5($trainingid);
	
	$kategori = sql_get_var("select nama from tbl_training where secid='$secid'");
	
	
	$tpl->assign("materiid",$materiid);
	$tpl->assign("namamateri",$namamateri);
	$tpl->assign("lengkapmateri",$lengkap);
	$tpl->assign("jenismateri","video");
	
	
	if(!empty($video))
	{
		if(empty($video)) $filename = "$lokasiwebtemplate/images/img.training.noimage.jpg";
		else $filename = "/gambar/training/$video";
	}
	
	if($jenis=="text")
	{
		if(empty($filename)) $filename = "$lokasiwebtemplate/images/img.training.noimage.jpg";
		else $filename = "$lokasimember/materi/$folder/$filename";
		
		$text = file_get_contents($filename);
		$text = nl2br($text);
	}
	
	$tpl->assign("matericontent",$text);
	$tpl->assign("filename",$filename);
}
else
{
	$subaksi = "list";
	$judul_per_hlm = 10;
	$batas_paging = 5;
	
	
	$hlm =$var[5];
	
	$sql = "select count(*) as jml from tbl_training where 1 $whereb $where";
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
	
	$perintah	= "select  secid,ringkas,nama,create_date,alias,gambar,gambar1 from tbl_training where 1 $whereb $where order by create_date asc limit $ord, $judul_per_hlm";
	$hasil		= sql($perintah);
	$datadetail	= array();
	$no = 0;
	while($data = sql_fetch_data($hasil))
	{
		$tanggal = $data['create_date'];
		$nama = $data['nama'];
		$secid = $data['secid'];
		$ringkas = $data['ringkas'];
		$alias = $data['alias'];
		$tanggal = tanggal($tanggal);
		$gambar = $data['gambar'];
		$gambar1 = $data['gambar1'];
		$secid = $data['secid'];
		
		$jmlmateri = sql_get_var("select count(*) as jml from tbl_training_materi where secid='$secid'");
		
		$views = number_format($data['views'],0,",",".");
		
		
		if(!empty($gambar)) $gambar = "$fulldomain/gambar/training/$gambar";
		 else $gambar = "$fulldomain/images/noimages.jpg";
		 
		$linkdetail = "$fulldomain/member/training/join/$secid/$alias";
		$linkjoin = "$fulldomain/member/training/detail/$secid/$alias";
		 
		$no++;
		$datadetail[$secid] = array("secid"=>$secid,"no"=>$i,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal,"jmlmateri"=>$jmlmateri,"linkdetail"=>$linkdetail,"linkjoin"=>$linkjoin,"gambar"=>$gambar,"views"=>$views);
	}
	sql_free_result($hasil);
	$tpl->assign("datadetail",$datadetail);
	
	//Paging 
	$batas_page =5;
	
	$stringpage = array();
	$pageid =0;
	
	$Selanjutnya 	= "selanjutnya";
	$Sebelumnya 	= "sebelumnya;";
	$Akhir			= "akhir";
	$Awal 			= "awal";
	
	if ($hlm > 1){
		$prev = $hlm - 1;
		$stringpage[$pageid] = array("nama"=>"$Awal","link"=>"$fulldomain/$kanal/$aksi/$subaksi/1");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"$Sebelumnya","link"=>"$fulldomain/$kanal/$aksi/$subaksi/$prev");
	
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
			$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$fulldomain/$kanal/$aksi/$subaksi/$ii");
		}
		$pageid++;
	}
	if ($hlm < $hlm_tot){
		$next = $hlm + 1;
		$stringpage[$pageid] = array("nama"=>"$Selanjutnya","link"=>"$fulldomain/$kanal/$aksi/$subaksi/$next");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"$Akhir","link"=>"$fulldomain/$kanal/$aksi/$subaksi/$hlm_tot");
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