<?php  
$sql	= "select id,nama,url,gambar,ringkas,warna from tbl_slide where published='1' and tipe='1' and (userid='0' or userid='$contactid') order by id desc  limit 3";
$query	= sql($sql);
$no = 1;
$a = 0;
while($row = sql_fetch_data($query))
{
	$id		= $row['id'];
	$nama	= $row['nama'];
	$url	= $row['url'];
	$gambar	= $row['gambar'];
	$ringkas	= $row['ringkas'];
	$warna	= $row['warna'];
	
	if(!empty($gambar))
	{
		$gambar	= "$fulldomain/gambar/slide_store/$gambar";
		
		$slide[$id]	= array("id"=>$id,"no"=>$no,"nama"=>$nama,"ringkas"=>$ringkas,"url"=>$url,"gambar"=>$gambar,"warna"=>$warna);
		$a++;
	}
	$no++;
}
sql_free_result($query);
$tpl->assign("slide",$slide);
$tpl->assign("jmlslide",$a);
?>