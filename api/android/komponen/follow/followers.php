<?php
	$judul_per_hlm 	= 20;
	$batas_paging 	= 5;

	if ($kanal == "profile")
	{
		$uid	= $uid;
	}
	else
	{
		$hlm 	= $_GET['hlm'];
		$uid	= $_GET['userid'];
	}
	
	$sql 	= "select count(*) as jml from tbl_follow where fid='$uid'";
	$hsl	= sql($sql);
	$tot 	= sql_result($hsl, 0, jml);
	$hlm_tot= ceil($tot / $judul_per_hlm);		
	if (empty($hlm)){
		$hlm = 1;
		}
	if ($hlm > $hlm_tot){
		$hlm = $hlm_tot;
		}
	
	$ord = ($hlm - 1) * $judul_per_hlm;
	if ($ord < 0 ) $ord=0;
	

	//daftar teman
	$perintah	= "select userid from tbl_follow where fid='$uid' order by id desc limit $ord, $judul_per_hlm";
	$hasil		= sql($perintah);
	$jumfollower	= sql_num_rows($hasil);
	$datateman	= array();
	$id	= 1;
	while($data	= sql_fetch_data($hasil))
	{
		$approveId	= $data['userid'];
		
		$dataapprove	= getProfileId($approveId);
		$approve	= $dataapprove['username'];
		$namateman	= $dataapprove['userfullname'];
		$gambar		= $dataapprove['avatar'];
			
		if(preg_match("/\</i",$namateman) and !preg_match("/>/i",$namateman)) $namateman = $namateman.">";
			$namateman = bersih($namateman);
			
		$status = sql_get_var("select id from tbl_follow where userid='$uid' and fid='$approveId'");
		$follower = sql_get_var("select follower from tbl_member where userid='$approveId'");
		
		if(!empty($status))
			$status = 1;
		else
			$status = 0;
			
		$link		= "$fulldomain/$approve";
		$linkdel	= "$fulldomain/member/unfollow/$approve";
		$linkfol	= "$fulldomain/member/follow/$approve";
					
		$datafollower[]= array("id"=>$id,"namateman"=>$namateman,"link"=>$link,"avatar"=>$gambar,"approve"=>$approve,"linkdel"=>$linkdel,"follower"=>number_format($follower,0,".","."),
		"status"=>$status,"linkfol"=>$linkfol);
		$id++;
	}
	sql_free_result($hasil);
	$result['status'] = "OK";
	$result['message'] = "Data follower berhasil diload";
	$result['userid'] = $uid;
	$result['hlm'] = $hlm;
	$result['datafollower'] = $datafollower;
	$result['jumlahfollower'] = $tot;
	
	//Paging 
	$batas_page =5;
	
	$stringpage = array();
	$pageid =0;
	
	if ($kanal == "profile")
		$kanal1	= "$username/follower";
	else
		$kanal1	= "$kanal/follower";
	
	if ($hlm > 1){
		$prev = $hlm - 1;
		$stringpage[$pageid] = array("nama"=>"&laquo;","link"=>"$domainfull/$kanal1/1");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"&lsaquo;","link"=>"$domainfull/$kanal1/$prev");

	}
	else {
		$stringpage[$pageid] = array("nama"=>"&laquo;","link"=>"");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"&lsaquo;","link"=>"");
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
			$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$domainfull/$kanal1/$ii");
		}
		$pageid++;
	}
	if ($hlm < $hlm_tot){
		$next = $hlm + 1;
		$stringpage[$pageid] = array("nama"=>"&rsaquo;","link"=>"$domainfull/$kanal1/$next");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"&raquo;","link"=>"$domainfull/$kanal1/$hlm_tot");
	}
	else
	{
		$stringpage[$pageid] = array("nama"=>"&rsaquo;","link"=>"");
		$pageid++;
		$stringpage[$pageid] = array("nama"=>"&raquo;","link"=>"");
	}
	$result['stringpage'] = $stringpage;
	echo json_encode($result);
?>