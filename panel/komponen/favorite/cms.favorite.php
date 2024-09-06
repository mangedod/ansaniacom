<?php 
//Variable halaman ini
$nama_tabel		= "tbl_cms_favorit";
$judul_per_hlm 	= 100;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['gid'])) $gid = $_POST['gid'];
 else $gid = $_GET['gid'];

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Menu
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; } else
		{
			$mainmenu[] = array("Lihat Favorite","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("namagroup","Nama Group","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);

			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];

			$sql = "select count(*) as jml from $nama_tabel where userid='$_SESSION[cms_userid]' $where";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			//Orderring
			$order = getorder("kanal","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];

			$perintah2 	= "select kanal,id from tbl_cms_favorit where userid='$_SESSION[cms_userid]' $where $parorder limit $ord, $judul_per_hlm";
			$hasil2 	= sql($perintah2);
			$aa = 1;
			while ($data = sql_fetch_data($hasil2))
			{
				$favkanal 	= $data['kanal'];
				$id = $data['id'];

				$q = sql("select url,kode,nama,menusubid,menuid from tbl_cms_menuchild  where url='$favkanal'");
				$data2 = sql_fetch_data($q);

				$namachild = $data2['nama'];
				$url 		= $data2['url'];
				$kode 		= $data2['kode'];
				$menuid		= $data2['menuid'];
				$menusubidc = $data2['menusubid'];



					echo "<div style=\"float:left; width:auto; margin:5px; text-align:center\">
					<div class=\"favmenu fav-$aa\">
					<a href=\"index.php?tab=$menuid&amp;tabsub=$menusubidc&amp;kanal=$url\">";
						if(file_exists("./template/images/dashboard/$url.png")){ echo "<img src=\"./template/images/dashboard/$url.png\" alt=\"\" border=\"0\" />";}
						else { echo "<img src=\"./template/images/dashboard/none.png\" alt=\"\" border=\"0\" />"; }
					echo"<br />
						<span>$namachild</span></a>
					</div>
					<br clear=\"all\" />
					<a href=\"$alamat&aksi=hapus&id=$id\">hapus</a>
					</div>";


				$aa %= 15;
				$aa++;
			}
			sql_free_result($hasil2);
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
		}
	} //EndView



	//HapusGroup
	if($aksi=="hapus")
	{
		if(!$oto['delete']) { echo $error['delete']; } else
		{
			$id = $_GET['id'];

			$perintah = "delete from $nama_tabel where userid='$_SESSION[cms_userid]' and id='$id'";
			$hasil = sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Success mengapus favorite menu dengan id $id");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
				$error = base64_encode("Data tidak dapat dihapus dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
	}

}
?>