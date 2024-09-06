<?php 
$mysql = "select produkpostid,ringkas,title,create_date,alias,misc_harga from tbl_product_post where published='1' order by produkpostid desc limit 6";
$hasil = sql($mysql);

$dataprodukdepan = array();
$a =1;
while ($data = sql_fetch_data($hasil)) {	
		$tanggal = $data['create_date'];
		$nama    = $data['title'];
		$ids     = $data['produkpostid'];
		$ringkas = $data['ringkas'];
		$alias   = getalias($nama);
		$tanggal = tanggal($tanggal);
		$secid   = $data['secid'];
		$misc_harga = $data['misc_harga'];
		$misc_harga		= $misc_matauang." ". number_format($misc_harga,0,".",".");
		$harga = rupiah($harga);
		
		
		// Gambar
		$sql3		= "select albumid,nama,gambar_m,gambar_s,gambar_l,gambar_f from tbl_product_image where produkpostid='$ids' order by albumid asc limit 1";
		$query3		= sql($sql3);
		while($row3		= sql_fetch_data($query3))
		{
			$albumid	= $row3['albumid'];
			$nama_image	= $row3['nama'];
			$gambar_s	= $row3['gambar_s'];
			$gambar_m	= $row3['gambar_m'];
			$gambar_l	= $row3['gambar_l'];
			$gambar_f	= $row3['gambar_f'];
			
			
			if(!empty($gambar_m))
				$image_m	= "$fulldomain/gambar/produk/$ids/$gambar_m";
			else
				$image_m	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
				
			if(!empty($gambar_s))
				$image_s	= "$fulldomain/gambar/produk/$ids/$gambar_s";
			else
				$image_s	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
			
			if(!empty($gambar_l))
				$image_l	= "$fulldomain/gambar/produk/$ids/$gambar_f";
			else
				$image_l	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
				
			if(!empty($gambar_f))
				$image_f	= "$fulldomain/gambar/produk/$ids/$gambar_f";
			else
				$image_f	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
				
			
		}
		sql_free_result($query3);

		$link = "$fulldomain/product/read/$ids/$alias";
		
		$dataprodukdepan[$ids] = array("id"=>$id,"no"=>$a,"nama"=>$nama,"ringkas"=>$ringkas,"namasec"=>$namasec,"tanggal"=>$tanggal,"alias"=>$alias,"link"=>$link,"gambar"=>$image_m,"harga"=>$misc_harga);
		$a++;	
}
$a = 0;
sql_free_result($hasil);
$tpl->assign("dataprodukdepan",$dataprodukdepan);

?>