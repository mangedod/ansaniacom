<?php	
	$perintah	= "select userid,username,userfullname,avatar from tbl_member where usertipe='0' order by follower desc limit 16";
	$hasil		= sql($perintah);
	$datafollowerdepan	= array();
	$id	= 1;
	while($data	= sql_fetch_data($hasil))
	{
		$userid	= $data['userid'];
		$username	= $data['username'];
		$namateman	= $data['userfullname'];
		$gambar		= $data['avatar'];
			
		if(preg_match("/\</i",$namateman) and !preg_match("/>/i",$namateman)) $namateman = $namateman.">";
			$namateman = bersih($namateman);
			
		$link		= "$fulldomain/$username";
					
		$datafollowerdepan[$id]=array("id"=>$id,"namateman"=>$namateman,"link"=>$link,"avatar"=>$gambar,"approve"=>$approve,"linkdel"=>$linkdel,"status"=>$status,"linkfol"=>$linkfol);
		$id++;
	}
	sql_free_result($hasil);
	$tpl->assign("datafollowerdepan",$datafollowerdepan);
	
?>