<?php
		
		$judul_per_hlm = 8;
		$batas_paging = 5;
		
		
		if ($kanal=="profile")
		{
			$hlm =$var[6];
			$subaksi =$var[5];
		
			$uid = sql_get_var("select userid from tbl_member where username='$username'");
			$whereb 	= "and userid='$uid'";
			$useridd	= $uid;
			$kanal = $username;
		}
		else
		{
			$hlm =$var[5];
			$subaksi =$var[4];
		
			$whereb 	= "and userid='$_SESSION[useridresel]'";
			$useridd	= $_SESSION['useridresel'];
			$kanal = $kanal;
		}
		
		if(!empty($subaksi) and $subaksi!="uncategorize")
		{
			$perintah1 = "select * from tbl_blog_sec where alias='$subaksi'";
			$hasil1 = sql($perintah1);
			$row1 = sql_fetch_data($hasil1);
			$namasec = $row1['nama'];
			$secid = $row1['secid'];
			$subaksi = $row1['alias'];
			$where = "and secid='$secid'";
		}
		else
		{
			$subaksi=="uncategorize";
		}
		
		$sql = "select count(*) as jml from tbl_blog where 1 $whereb $where";
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
		
		$perintah	= "select  id,ringkas,nama,create_date,alias,secid,gambar,gambar1,views from tbl_blog where 1 $whereb $where order by create_date desc limit $ord, $judul_per_hlm";
		$hasil		= sql($perintah);
		$datadetail	= array();
		$no = 0;
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
			$secid = $data['secid'];
			
			$views = number_format($data['views'],0,",",".");
			
			$perintah = "select alias from tbl_blog_sec where secid='$secid'";
			$res = sql($perintah);
			$dt =  sql_fetch_data($res);
			$secalias1 = $dt['alias'];
			sql_free_result($res);
			
			if(empty($secalias1))
				$secalias1= "uncategorize";
			
			if($i==0){ $gambar= $gambar1; }
			else { $gambar = $gambar; }
			
			$ex = explode("-",$gambar);
			$yearm = $ex[1];
			
			if(!empty($gambar)) $gambar = "$fulldomain/gambar/blog/$gambar";
			 else $gambar = "$fulldomain/images/noimages.jpg";
			 
			$link = "$fulldomain/$kanal/readblog/$secalias1/$id/$alias";
			 
			$no++;
			$datadetail[$id] = array("id"=>$id,"no"=>$i,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar,"views"=>$views);
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

?>