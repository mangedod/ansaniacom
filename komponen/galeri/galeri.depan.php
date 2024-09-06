<?php 
$sql = "select id,gambar1,secid,nama,ringkas from tbl_galeri where published='1' and gambar!='' group by secid order by id desc limit 2";
$hsl = sql($sql);
$a=1;
while ($row = sql_fetch_data($hsl))
{
	$nama = $row['nama'];
	$alias = getalias($nama);
	$id2 = $row['id'];
	$gambar = $row['gambar1'];
	$secid = $row['secid'];
	$ringkas = $row['ringkas'];
	
	$url = "$fulldomain/galeri/read/$secid/$id2/$alias";
	
	$gambar =  "$fulldomain/gambar/galeri/$gambar";
	
	$datagaleridepan[$id2] = array("a"=>$a,"nama"=>$nama,"ringkas"=>$ringkas,"gambar"=>$gambar,"url"=>$url);
	$a++;
}
sql_free_result($hsl);
		
$tpl->assign("datadepangaleri",$datagaleridepan);
?>