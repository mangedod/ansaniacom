<?php
		$judul_per_hlm = 8;
		$batas_paging  = 5;

		$hlm     = $var[4];
		$whereb  = "and refuserid='$_SESSION[useridresel]'";

		$sql = "select count(*) as jml from tbl_member where 1 $whereb";
		$hsl = sql($sql);
		$tot = sql_result($hsl, 0,'jml');

		$tpl->assign("jml_listres",$tot);
		
		$hlm_tot = ceil($tot / $judul_per_hlm);		
		if (empty($hlm)){
			$hlm = 1;
		}
		if ($hlm > $hlm_tot){
		$hlm = $hlm_tot;
		}
		$ord = ($hlm - 1) * $judul_per_hlm;
		if ($ord < 0 ) $ord=0;
		
		$perintah     = "select userid,userfullname,useremail,userphonegsm from tbl_member where 1 $whereb limit $ord, $judul_per_hlm";// GROUP BY refuserid
		$hasil        = sql($perintah);
		$dataresellers = array();
		$no           = 0;
		while($data   = sql_fetch_data($hasil))
		{
			$reselleruseridnya   = $data['userid'];
   			$namacustomer  = $data['userfullname'];
   			$emailcustomer = $data['useremail'];
   			$phonecustomer = $data['userphonegsm'];
			 
			$no++;
			$dataresellers[$reselleruseridnya] = array("reselleruseridnya"=>$reselleruseridnya,"no"=>$no,"namaresell"=>$namacustomer,"emailresell"=>$emailcustomer,"phoneresell"=>$phonecustomer);
		}
		sql_free_result($hasil);
		$tpl->assign("dataresellers",$dataresellers);
		
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
			$stringpage[$pageid] = array("nama"=>"$Awal","link"=>"$fulldomain/$kanal/$aksi/1");
			$pageid++;
			$stringpage[$pageid] = array("nama"=>"$Sebelumnya","link"=>"$fulldomain/$kanal/$aksi/$prev");

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
				$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$fulldomain/$kanal/$aksi/$ii");
			}
			$pageid++;
		}
		if ($hlm < $hlm_tot){
			$next = $hlm + 1;
			$stringpage[$pageid] = array("nama"=>"$Selanjutnya","link"=>"$fulldomain/$kanal/$aksi/$next");
			$pageid++;
			$stringpage[$pageid] = array("nama"=>"$Akhir","link"=>"$fulldomain/$kanal/$aksi/$hlm_tot");
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