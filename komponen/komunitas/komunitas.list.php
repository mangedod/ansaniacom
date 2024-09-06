<?php 

$mysql = "select id,ringkas,nama,create_date,alias,secid,gambar,gambar1,userid from tbl_blog where published='1' $where order by id  desc limit 5";
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
	$userid = $data['userid'];
	
	$perintah = "select alias from tbl_blog_sec where secid='$secid'";
	$res = sql($perintah);
	$dt =  sql_fetch_data($res);
	$secalias1 = $dt['alias'];
	sql_free_result($res);
	
	if(empty($secalias1))
		$secalias1= "uncategorize";

	$ex = explode("-",$gambar);
	$yearm = $ex[1];
	
	if(!empty($gambar)) $gambar = "$fulldomain/gambar/blog/$userid/$gambar";
	 else $gambar = "$fulldomain/images/noimages.jpg";

	$link = "$fulldomain/blog/read/$secalias1/$id/$alias";
		
	$datadetail[$id] = array("id"=>$id,"no"=>$i,"nama"=>$nama,"ringkas"=>$ringkas,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$gambar);
	$i++;
		
}
sql_free_result($hasil);
$tpl->assign("datadetail",$datadetail);

//member	
$mysql = "select userid,userfullname,avatar,username from tbl_member where avatar !='' order by rand() limit 5 ";
$hasil = sql( $mysql);

$datamember = array();		
$i = 0;
while ($data =  sql_fetch_data($hasil)) {	
	$userid = $data['userid'];
	$userfullname = $data['userfullname'];
	$username = $data['username'];
	$avatar = $data['avatar'];

	if(!empty($avatar)) $avatar = "$lokasiwebmember/avatars/$avatar";
	 else $avatar = "$domain/images/no_pic.jpg";

	$link = "$fulldomain/$username";
		
	$datamember[$userid] = array("userid"=>$userid,"no"=>$i,"fname"=>$userfullname,"avatar"=>$avatar,"url"=>$link);
	$i++;
		
}
sql_free_result($hasil);
$tpl->assign("member",$datamember);

?>
