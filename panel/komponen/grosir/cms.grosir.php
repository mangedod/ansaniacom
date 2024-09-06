<?php
//Variable halaman ini
$nama_tabel		= "tbl_product_post";
$nama_tabel1	= "tbl_product_image";
$nama_tabel2	= "tbl_product_comment";
$nama_tabel3	= "tbl_product";
$judul_per_hlm 	= 50;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

$gambarl_maxw 	= 800;
$gambarl_maxh 	= 1200;
$gambarm_maxw 	= 400;
$gambarm_maxh 	= 600;
$gambars_maxw 	= 200;
$gambars_maxh 	= 300;

$gambarscreen_maxw 	= 458;
$gambarscreen_maxh 	= 258;

$gambaricon_maxw = 60;
$gambaricon_maxh = 60;

//Variable Umum
if(isset($_POST['produkpostid'])) $produkpostid = $_POST['produkpostid'];
 else $produkpostid = $_GET['produkpostid'];

if(isset($_POST['produkid'])) $produkid = $_POST['produkid'];
 else $produkid = $_GET['produkid'];

if(isset($_POST['kodeproduk'])) $kodeproduk = $_POST['kodeproduk'];
 else $kodeproduk = $_GET['kodeproduk'];

if(isset($_POST['secid'])) $secid = $_POST['secid'];
 else $secid = $_GET['secid'];

if(isset($_POST['subid'])) $subid = $_POST['subid'];
 else $subid = $_GET['subid'];

if(isset($_POST['albumid'])) $albumid = $_POST['albumid'];
 else $albumid = $_GET['albumid'];

if(isset($_POST['commentid'])) $commentid = $_POST['commentid'];
 else $commentid = $_GET['commentid'];

$matauang = sql_get_var("select kode from tbl_matauang where status=1");

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//View Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Produk","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Produk","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("title","Nama Produk","str","text","$data");
			$cari[] = array("kodeproduk","Kode Produk","str","text","$data");
			$cari[] = array("create_date","Tanggal Upload","date","date","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where    = $formcari[0]['where'];
			$param    = $formcari[0]['param'];

			//Orderring
			$order = getorder("create_date","desc",$pageparam,$param);
			$parorder = $order[0];
			$urlorder = $order[1];

			$sql = "select count(*) as jml from $nama_tabel3 where 1 $where $parorder";
			$hsl = sql($sql);
			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			$sql = "select produkid,title,kodeproduk,published,bestseller,ringkas,numitem from $nama_tabel3 where grosir='1' $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Item</th>\n");
			print("<th width=20%>Gambar</th>\n");
			print("<th width=60%>Produk</th>\n");
			print("<th width=5%>Item</th>\n");
			print("<th width=5%>Photo</th>\n");
			print("<th width=1%><a href=\"$urlorder&order=bestseller\" title=\"Urutkan\">Bestseller</a></th>\n");
			print("<th width=1%><a href=\"$urlorder&order=published\" title=\"Urutkan\">Published</a></th>\n");
			print("<th width=1% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$produkid     = $row['produkid'];
				$title        = $row['title'];
				$kodeproduk   = $row['kodeproduk'];
				$published    = $row['published'];
				$po_status    = $row['po_status'];
				$numitem      = $row['numitem'];
				$content      = $row['ringkas'];
				$content      = explode(" ",$content);
				$content1     = "";
				$alias        = getAlias($title);
				
				$numitem = sql_get_var("select count(*) as jml from tbl_product_post where produkid='$produkid'");
				

				$link_detail	= "$fulldomain/katalog/detail/$aliasSecc/$aliasSubb/$produkid/$alias.html";

				for($b=0;$b<30;$b++)
				{
					$content1 .= "$content[$b] ";
				}
				
				$gambar_s = sql_get_var("select gambar_s from $nama_tabel1 where produkid='$produkid' order by albumid asc limit 1");

				
				if(!empty($gambar_s)) $image_s = "<img src=\"../gambar/produk/$gambar_s\" alt=\"\" />"; else $image_s = "Masih kosong";

				if($row['published']=="1")
					$publish ="<span class=\"label label-success\">Publish</span>";
				else
					$publish ="<span class=\"label label-default\">Draft</span>";
				
				if($row['utama']=="1")
					$utama ="<span class=\"label label-success\">Utama</span>";
				else
					$utama ="<span class=\"label label-default\">Non Utama</span>";


				if($row['bestseller']=="1")
					$bestsellerflag ="<span class=\"label label-success\">Aktif</span>";
				else
					$bestsellerflag ="<span class=\"label label-default\">Non Aktif</span>";

				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><a href=\"$alamat&aksi=lihatgaleri&kodeproduk=$kodeproduk&produkid=$produkid\">$image_s</a></td>\n
					<td  valign=top ><a href=\"$alamat&aksi=detail&produkid=$produkid&hlm=$hlm\" ><b>$title</b></a><br clear=\"all\" />$content1</td>
					<td align=center valign=top><a href=\"$alamat&aksi=viewitem&kodeproduk=$kodeproduk\">$numitem items</a></td>
					<td align=center valign=top><a href=\"$alamat&aksi=lihatgaleri&kodeproduk=$kodeproduk&produkid=$produkid\">Lihat Galeri</a></td>
					<td align=center valign=top ><a href=\"$alamat&aksi=bestsellerflag&produkid=$produkid&hlm=$hlm\">$bestsellerflag</td>
					<td align=center valign=top ><a href=\"$alamat&aksi=publish&produkid=$produkid&hlm=$hlm\">$publish</td>");

				print("<td>");

				$acc[] = array("Lihat Item","detail","$alamat&aksi=viewitem&kodeproduk=$kodeproduk&hlm=$hlm");
				$acc[] = array("Lihat Galeri","galeri","$alamat&aksi=lihatgaleri&kodeproduk=$kodeproduk&produkid=$produkid&hlm=$hlm");
				
				if($published==0) $acc[] = array("Publish","push","$alamat&aksi=publish&produkid=$produkid&hlm=$hlm");
				else $acc[] = array("Unpublish","push","$alamat&aksi=publish&produkid=$produkid&hlm=$hlm");

				$acc[] = array("Komentar","detail","$alamat&aksi=viewkomen&produkid=$produkid&hlm=$hlm");
				$acc[] = array("Detail","detail","$alamat&aksi=detail&produkid=$produkid&hlm=$hlm");
				$acc[] = array("Edit","edit","$alamat&aksi=edit&produkid=$produkid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapus&produkid=$produkid&hlm=$hlm");

				cmsaction($acc);
				unset($acc);

				print("</td></tr>");

				$i %= 2;
				$i++;
				$a++;
				$ord++;
			}
			print("</table><br clear='all'>");
			sql_free_result($hsl);

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
		}
	} //EndView

	//Detail
	if($aksi=="detail")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$produkid 	= $_GET['produkid'];
			$mainmenu[] 	= array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);

			$sql = "select * from $nama_tabel3 where produkid='$produkid'";
			$hsl = sql($sql);
			$dtprod = sql_fetch_data($hsl);

			$secid     = $dtprod['secid'];
			$subid     = $dtprod['subid'];
			$brandid   = $dtprod['brandid'];
			$e_title   = $dtprod['title'];
			$e_tag     = $dtprod['tag'];
			$e_content = $dtprod['content'];
			$e_tipe    = $dtprod['tipe'];
			$e_status  = $dtprod['status'];
			$e_ringkas = $dtprod['ringkas'];

			$e_misc_matauang       = $dtprod['misc_matauang'];
			$e_misc_harga          = number_format($dtprod['misc_harga'],0,".",".");
			$e_misc_harga_reseller = number_format($dtprod['misc_harga_reseller'],0,".",".");
			$e_misc_diskon         = $dtprod['misc_diskon'];
			$e_misc_jharga         = $dtprod['misc_jharga'];

			$e_jenisvideo			= $dtprod['jenisvideo'];
			$e_screenshot			= $dtprod['screenshot'];
			$e_urlyoutube			= $dtprod['urlyoutube'];


			$row              = sql_get_var_row("select produkpostid,warnaid,sizeid,kodeproduk,body_dimension,body_weight from $nama_tabel where kodeproduk='$kodeproduk'");
			$produkpostid     = $row['produkpostid'];
			$warnaid          = $row['warnaid'];
			$sizeid           = $row['sizeid'];
			$kodeproduk       = $row['kodeproduk'];
			$e_body_dimension = $row['body_dimension'];
			$e_body_weight    = $row['body_weight'];


			$sql1 = "select albumid,gambar_m from $nama_tabel1 where produkpostid='$produkpostid' order by albumid asc";
			$hsl1 = sql($sql1);
			$e_images	= array();
			while($row1 = sql_fetch_data($hsl1))
			{
				$albumid  = $row1['albumid'];
				$gambar_m = $row1['gambar_m'];
				if(!empty($gambar_m)) $image = "<img src=\"../gambar/produk/$produkpostid/$gambar_m\" alt=\"\" />"; else $image = "Masih kosong";

				$e_images[$albumid] = array("albumid"=>$albumid,"image"=>$image);
			}

			// kategori produk
			$namasec = sql_get_var("select namasec from tbl_product_sec where secid='$secid'");

			// subkategori produk
			$namasub = sql_get_var("select namasub from tbl_product_sub where subid='$subid'");

			// Brand Produk
			$brand = sql_get_var("select nama from tbl_product_brand where brandid='$brandid'");

			// Warna Produk
			$warna = sql_get_var("select nama from tbl_warna where id='$warnaid'");

			// Ukuran Produk
			$size = sql_get_var("select nama from tbl_size where sizeid='$sizeid'");

			?>
            <style> .phonedata { display:none; }  </style>
			<br clear="all" />
            <table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Kategori</th>
				</tr>
                <tr>
					<td width="20%" class="tdinfo">Kategori Produk</td>
					<td ><?php echo $namasec?></td>
				</tr>
				<tr>
					<td valign="top" class="tdinfo">Sub Kategori Produk</td>
					<td align="left"><?php echo $namasub?></td>
				</tr>
                <tr>
					<td valign="top" class="tdinfo">Brand Produk</td>
					<td align="left"><?php echo $brand?></td>
				</tr>
				<tr>
					<th colspan="2">Informasi Produk</th>
				</tr>
                <tr>
					<td  class="tdinfo">Nama Produk</td>
					<td ><?php echo $e_title?></td>
				</tr>
				<tr>
					<td class="tdinfo">Status</td>
            		<td>
                    	<?php
                        	if ($e_status == '1' or $e_status == '') echo "Aktif";
                        	else echo "Tidak Aktif";
                        ?>
                   	</td>
                </tr>
                <tr>
					<td valign="top" class="tdinfo">Tag</td>
                    <td><?php echo "$e_tag"; ?></td>
               	</tr>

                <tr>
                    <th colspan="2">Deskripsi Produk</th>
                </tr>
                <tr>
					<td valign="top" class="tdinfo">Deskripsi Singkat</td>
                    <td><?php echo "$e_ringkas"; ?></td>
             	</tr>
                <tr>
					<td valign="top" class="tdinfo">Deskripsi Lengkap</td>
                    <td><?php echo "$e_content"; ?></td>
             	</tr>

                <tr>
                    <th colspan="2">Informasi Detail</th>
                </tr>

                <tr>
					<td valign="top" class="tdinfo">Price</td>
                    <td>
                    	<table width="100%" border="0">
                        <tr>
                            <td width="20%" class="tdinfo">Jenis Harga</td>
                            <td>
                                <?php
									if ($e_misc_jharga == '1' or $e_misc_jharga == '') echo "Publish";
                                	else echo "Sale";
								?>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%" class="tdinfo">Mata Uang</td>
                            <td>
                                <?php
                                    echo "$e_misc_matauang";
                                ?>
                           </td>
                        </tr>
                        <tr>
                            <td width="20%" class="tdinfo">Harga</td>
                            <td><?php echo "$e_misc_matauang"; ?> <?php echo "$e_misc_harga"; ?></td>
                        </tr>
                       <tr>
                        	<td width="20%" class="tdinfo">Harga Setelah Diskon</td>
                            <td><?php echo "$e_misc_matauang"; ?> <?php echo "$e_misc_diskon"; ?></td>
                        </tr>
                        
                        </table>
                   	</td>
               	</tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=edit&produkid=$produkid"?>'" value="Ubah Data">
						<input type="button" onclick="javascript:window.location='<?php echo "$alamat&aksi=hapus&produkid=$produkid"?>'" value="Hapus Data">
					</td>
				</tr>
			</table><br clear="all" />
            <?php
		}
	}
	
	//Popup Produk
	if($aksi=="popupprodukpostid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$var1    = $_GET['var1'];
			$var2    = $_GET['var2'];
			$var3    = $_GET['var3'];
			$eventid = $_GET['eventid'];
			
			if(empty($var1) && empty($var2))
			{
				$var1 = "produkpostid";
				$var2 = "produkpostid_text";
				$var3 = "produkpostid_harga";
			}
			?>
            	<script type="text/javascript">
				function pushdata(produkpostid,title,harga)
				{
					 if (window.opener && !window.opener.closed)
					 {
					 	window.opener.$("#<?php echo $var1; ?>").val(produkpostid);
						window.opener.$("#<?php echo $var2; ?>").val(title);
						window.opener.$("#<?php echo $var3; ?>").val(harga);
					 } 
					  window.close();
                    return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("title","Nama Produk","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
				
			$sql = "select count(*) as jml from $nama_tabel where 1 $where";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);		
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
			
			//Orderring
			$order = getorder("title","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];
			
			$sql = "select title,produkpostid,warnaid,misc_harga from $nama_tabel where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Item</th>\n");
			print("<th width=60%><a href=\"$urlorder&order=title\" title=\"Urutkan\">Nama Produk</a></th>\n");
			print("<th width=20%>Warna</th>\n");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$title 	= $row['title'];
				$title_en = $row['title_english'];
				$produkpostid 	 	= $row['produkpostid'];
				$warnaid 	 	= $row['warnaid'];
				$harga		= $row['misc_harga'];
				
				$warna 	= sql_get_var("select nama from tbl_warna where id='$warnaid'");

				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td valign=top class=judul>$title</td>
					<td valign=top class=judul>$warna</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdata('$produkpostid','$title $warna','$harga');\">Select</button>");
				print("</td></tr>");

				$i %= 2;
				$i++;
				$a++;
				$ord++;
			}
			print("</table><br clear='all'>");
			
			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
		}
	} //EndView 

	//Hapus
	if($aksi=="hapus")
	{
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			$produkid = $_GET['produkid'];
			$albumid  = $_GET['albumid'];
			
			$kodeproduk   = sql_get_var("select kodeproduk from $nama_tabel3 where produkid='$produkid'");
			$produkpostid = sql_get_var("select produkpostid from $nama_tabel where kodeproduk='$kodeproduk'");

			$hapus_file	  = "$pathfile"."produk/$produkpostid";

			$perintahu 	= "select gambar_f,gambar_l,gambar_m,gambar_s from tbl_product_image where produkid='$produkid'";
			$hasilu 	= sql($perintahu);
			while($row 		= sql_fetch_data($hasilu))
			{

				$gambar_f	= $row['gambar_f'];
				$gambar_l	= $row['gambar_l'];
				$gambar_m	= $row['gambar_m'];
				$gambar_s	= $row['gambar_s'];

				if(!empty($gambar_f))
					unlink("$hapus_file/$gambar_f");
				if(!empty($gambar_l))
					unlink("$hapus_file/$gambar_l");
				if(!empty($gambar_m))
					unlink("$hapus_file/$gambar_m");
				if(!empty($gambar_s))
					unlink("$hapus_file/$gambar_s");
			
			}

			//hapus gambar
			$perintah1	= "delete from $nama_tabel1 where produkid='$produkid'";
			$hasil1		= sql($perintah1);

			//hapus produk post or item
			$perintahp	= "delete from $nama_tabel where kodeproduk='$kodeproduk'";
			$hasilp		= sql($perintahp);

			//hapus produk
			$perintahp	= "delete from $nama_tabel3 where produkid='$produkid'";
			$hasilp		= sql($perintahp);



			//hapus stok warehouse
			$perintah	= "delete from tbl_product_wh where produkpostid='$produkpostid'";
			$hasil		= sql($perintah);


			if($hasil)
			{
				$perintahn	= "update tbl_product_num set aktif=aktif-1";
				$hasiln		= sql($perintahn);

				$msg = base64_encode("Sukses menghapus Data dengan ID $produkid");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//Publish
	if($aksi=="publish")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$produkid = $_GET['produkid'];

			$perintah 	= "select published from $nama_tabel3 where produkid='$produkid' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['published']=="0") $status = 1;
				else $status=0;

			$perintah 	= "update $nama_tabel3 set published='$status' where produkid='$produkid' ";
			$hasil		= sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Sukses merubah status data dengan ID $produkid");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal merubah status data dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//Bestseller flag
	if($aksi=="bestsellerflag")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$produkid = $_GET['produkid'];

			$perintah 	= "select bestseller from $nama_tabel3 where produkid='$produkid' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['bestseller']=="0") $status = 1;
				else $status=0;

			$perintah 	= "update $nama_tabel3 set bestseller='$status' where produkid='$produkid' ";
			$hasil		= sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Sukses merubah status Bestseller Produk dengan ID $produkid");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal merubah status Bestseller produk dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	

	//SaveTambah
	if($aksi=="savetambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$_SESSION['tambahdata']	= 1;
        	$secid				= $_POST['secid'];
			$_SESSION['secid']   = $secid;
			$subid               = $_POST['subid'];
			$_SESSION['subid']   = $subid;
			$brandid             = $_POST['brandid'];
			$_SESSION['brandid'] = $brandid;
			$warnaid             = $_POST['warnaid'];
			$_SESSION['warnaid'] = $warnaid;
			$sizeid              = $_POST['sizeid'];
			$_SESSION['sizeid']  = $sizeid;

			$status              = $_POST['status'];
			$_SESSION['status']  = $status;
			$title               = cleaninsert($_POST['title']);
			$_SESSION['title']   = $title;
			$tag                 = cleaninsert($_POST['tag']);
			$_SESSION['tag']     = $tag;
			$content             = desc($_POST['content']);
			$_SESSION['content'] = $content;
			$ringkas             = desc($_POST['ringkas']);
			$_SESSION['ringkas'] = $ringkas;

			$body_dimension             = cleaninsert($_POST['ukuran']);
			$_SESSION['body_dimension'] = $body_dimension;

			$body_weight             = cleaninsert($_POST['body_weight']);
			$body_weight             = str_replace(",",".",$body_weight);
			$_SESSION['body_weight'] = $body_weight;

			$misc_matauang             = $_POST['misc_matauang'];
			$_SESSION['misc_matauang'] = $misc_matauang;
			$misc_harga                = cleaninsert($_POST['misc_harga']);
			$_SESSION['misc_harga']    = $misc_harga;
			$misc_harga                = str_replace(".","",$misc_harga);
			$misc_harga                = str_replace(",","",$misc_harga);
			$misc_diskon               = cleaninsert($_POST['misc_diskon']);
			$_SESSION['misc_diskon']   = $misc_diskon;
			$misc_diskon               = str_replace(".","",$misc_diskon);
			$misc_diskon               = str_replace(",","",$misc_diskon);
			$misc_jharga               = $_POST['misc_jharga'];
			$_SESSION['misc_jharga']   = $misc_jharga;


			$matauangid = sql_get_var("select id from tbl_matauang where kode='$misc_matauang'");

			$kodeproduk             = $_POST['kodeproduk'];
			$_SESSION['kodeproduk'] = $kodeproduk;

			$alias				= getAlias($title);
			if($jharga == "0") $cart	= 0;

			$cek = sql_get_var("select kodeproduk from $nama_tabel where kodeproduk='$kodeproduk'");

			if(!empty($cek))
			{
				$error = base64_encode("Kode Produk tidak boleh sama, silahkan isi dengan kode produk yang berbeda.");
				header("location: $alamat&aksi=tambah&hlm=$hlm&error=$error");
				exit();
			}

			if(empty($content))
			{
				$error = base64_encode("Deskripsi Produk tidak boleh kosong, silahkan isi terlebih dahulu.");
				header("location: $alamat&aksi=tambah&hlm=$hlm&error=$error");
				exit();
			}
			else
			{
				$produkpostid = newid("produkpostid",$nama_tabel);
				$produkid     = newid("produkid",$nama_tabel3);

				$xx    = count($_FILES['gambar']['tmp_name']);
				$files = $_FILES['gambar']['tmp_name'];
				$type  = $_FILES['gambar']['type'];
				$size  = $_FILES['gambar']['size'];

				//Upload Gambar
				if(!file_exists("$pathfile/produk/$produkpostid")) mkdir("$pathfile/produk/$produkpostid");
				for($x=0;$x<$xx;$x++)
				{
					$xname = "$files[$x]";

					if($size[$x]> 0)
					{
						$jenis1 	= $type[$x];
						$imageinfo 	= getimagesize($xname);
						$imagewidth = $imageinfo[0];
						$imageheight= $imageinfo[1];
						$imagetype 	= $imageinfo[2];

							$new 			= newid("albumid",$nama_tabel1);
							if(preg_match("/jp/i",$jenis1)) $ext = "jpg";
							if(preg_match("/gif/i",$jenis1)) $ext = "gif";
							if(preg_match("/png/i",$jenis1)) $ext = "png";

							//full
							$namagambarf = "$alias-$produkpostid-$new-f.$ext";
							$gambarf 	 = resizeimg($xname,"$pathfile/produk/$produkpostid/$namagambarf",$imagewidth,$imageheight);

							//large
							$namagambarl = "$alias-$produkpostid-$new-l.$ext";
							$gambarl 	 = resizeimg($xname,"$pathfile/produk/$produkpostid/$namagambarl",$gambarl_maxw,$gambarl_maxh);

							//medium
							$namagambarm = "$alias-$produkpostid-$new-m.$ext";
							$gambarm 	 = resizeimg($xname,"$pathfile/produk/$produkpostid/$namagambarm",$gambarm_maxw,$gambarm_maxh);

							//small
							$namagambars = "$alias-$produkpostid-$new-s.$ext";
							$gambars 	 = resizeimg($xname,"$pathfile/produk/$produkpostid/$namagambars",$gambars_maxw,$gambars_maxh);

							if($gambars)
							{
								$fgambar = ",gambar_f,gambar_l,gambar_m,gambar_s";
								$vgambar = ",'$namagambarf','$namagambarl','$namagambarm','$namagambars'";

							}

							$perintah1	= "insert into $nama_tabel1(albumid,produkpostid,produkid,create_date,create_userid $fgambar)
									values ('$new','$produkpostid','$produkid','$date','$cuserid' $vgambar)";
							$hasil1		= sql($perintah1);

					}
				}

				if($produkid)
				{
					$tipeid = sql_get_var("select tipeid from tbl_product_sub where secid='$secid' and subid='$subid'");
					$perintah2	= "insert into $nama_tabel3 (`produkid`,`kodeproduk`,`numitem`, `title`, `alias`, `tag`, `content`, `ringkas`, `tipeid`, `secid`, `subid`, `brandid`, 
					`published`, `misc_matauang`, `misc_matauangid`, `misc_harga`, `misc_jharga`, `misc_diskon`, 
					`tgl_expired`, `kondisi`, `status`, `blok`, `flag`, `create_date`, `create_userid`,`urlyoutube`,`jenisvideo`,grosir $fgambarsc)

					values ('$produkid','$kodeproduk','1','$title','$alias','$tag','$content','$ringkas','$tipeid','$secid','$subid','$brandid',
					'$published',  '$misc_matauang', '$matauangid', '$misc_harga', '$misc_jharga', '$misc_diskon', 
					'$tgl_expired', '$kondisi', '$status', '$blok', '$flag','$date','$cuserid','$urlyoutube','$jenisvideo','1' $vgambarsc)";

					$hasil2 	  = sql($perintah2);
				}

/*				//input produk
				$perintah = "insert into $nama_tabel (`produkpostid`, produkid, `title`,`warnaid`,`sizeid`,`kodeproduk`,`body_dimension`,`body_weight`, `misc_matauang`, `misc_matauangid`, `misc_harga`, `misc_jharga`, `misc_diskon`)
								values ('$produkpostid','$produkid','$title','$warnaid','$sizeid','$kodeproduk','$body_dimension','$body_weight',  '$misc_matauang', '$matauangid', '$misc_harga', '$misc_jharga', '$misc_diskon')";
				$hasil = sql($perintah);

*/				if($hasil2)
				{
					if($secid)
					{
						$perintahsec	= "update tbl_product_sec set num=num+1 where secid='$secid'";
						$hasilsec		= sql($perintahsec);

					}
					if($subid)
					{
						$perintahsub	= "update tbl_product_sub set num=num+1 where secid='$secid' and subid='$subid'";
						$hasilsub		= sql($perintahsub);

					}

				/*	$perintah3	= "insert into tbl_product_wh (`produkpostid`) value ('$produkpostid')";
					$hasil3		= sql($perintah3);
*/


					unset($_SESSION['secid'],$_SESSION['subid'],$_SESSION['brandid'],$_SESSION['warnaid'],$_SESSION['sizeid'],$_SESSION['title'],$_SESSION['tag'],$_SESSION['content'],$_SESSION['ringkas'],$_SESSION['kondisi'],
							$_SESSION['tipe'],$_SESSION['status'],$_SESSION['body_dimension'],$_SESSION['body_weight'],$_SESSION['misc_jharga'],$_SESSION['misc_matauang'],
							$_SESSION['misc_harga'],$_SESSION['misc_diskon'],
							$_SESSION['kodeproduk'],$_SESSION['tambahdata']);

					$msg = base64_encode("Berhasil ditambahkan Data baru");
					header("location: $alamat&aksi=detail&produkid=$produkid&hlm=$hlm&msg=$msg");
					exit();
				}
				else
				{
					$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
					header("location: $alamat&aksi=tambah&hlm=$hlm&error=$error");
					exit();
				}
			}
		}
	} 

	//Tambah
	if($aksi=="tambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$namasub = "";
			
			$produkid = newid("produkid","tbl_product");
			
			$kode = 10000+$produkid;
			$kode = substr($kode,1,4);
			
			if(empty($content)) $ringkas = $title;
			if(empty($content)) $content = $title;
			
			$kodeproduk = "ANS$kode";
			
			if($_SESSION['tambahdata']==1)
			{
				$secid   = $_SESSION['secid'];
				$subid   = $_SESSION['subid'];
				$brandid = $_SESSION['brandid'];
				$warnaid = $_SESSION['warnaid'];
				$sizeid  = $_SESSION['sizeid'];
	
				$namaprod				= $_SESSION['title'];
				$tag 					= $_SESSION['tag'];
				$content 				= $_SESSION['content'];
				$ringkas 				= $_SESSION['ringkas'];
				$tipe 					= $_SESSION['tipe'];
	
				$status 				= $_SESSION['status'];
	
				$body_dimension = $_SESSION['body_dimension'];
				$body_weight    = $_SESSION['body_weight'];
	
				$misc_jharga 			= $_SESSION['misc_jharga'];
				$misc_matauang 			= $_SESSION['misc_matauang'];
				$misc_harga 			= $_SESSION['misc_harga'];
				$misc_diskon 			= $_SESSION['misc_diskon'];
	
				$kodeproduk				= $_SESSION['kodeproduk'];
	
				// kategori produk
				$namasec = sql_get_var("select namasec from tbl_product_sec where secid='$secid'");
	
				// subkategori produk
				$namasub = sql_get_var("select namasub from tbl_product_sub where subid='$subid'");
	
				// Brand Produk
				$brand = sql_get_var("select nama from tbl_product_brand where brandid='$brandid' order by nama asc");
			}

			$baris=0;
			?>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script type="text/javascript" src="template/js/jquery-ui-timepicker-addon.js"></script>

			<style> /*.phonedata,*/ .diskonkuota, .preorder, .datavideo, .datagambar { display:none; }  .combines { width:50%; float:left; } .combines2 { width:25%}</style>

            <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});

				function popsecid(var1,var2)
				{
					sList = window.open("index.php?pop=1&kanal=produk-kategori&aksi=popsecid&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}
				function popsecsubid(var1,var2)
				{
					var secid = $("#secid").val();
				 	sList = window.open("index.php?pop=1&kanal=produk-kategori&aksi=popsecsubid&var1="+var1+"&var2="+var2+"&secid="+secid+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}
				function popbrandid(var1,var2)
				{
				 	sList = window.open("index.php?pop=1&kanal=produk-brand&aksi=popbrandid&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}
				function popwarnaid(var1,var2)
				{
				 	sList = window.open("index.php?pop=1&kanal=produk-warna&aksi=popidwarna&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}
				function popsizeid(var1,var2)
				{
				 	sList = window.open("index.php?pop=1&kanal=produk-size&aksi=popidsize&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}

				$(function() {

					$(".saveapprove").click(function(){
						$(".saveappr").val("1");
					});

					$(document).on('click','#mytable .deleterow',function(){
						var tr = $(this).closest('tr');
                            tr.css("background","#f1f1f1");
                            tr.fadeOut(300, function(){
                            	tr.remove();
                            });
                    });
				  });

				function vRemove(rTable){
					var rData = $("table#"+rTable+" tr").has('input:checked');
					rData.remove();
				}
				function selfRemove(baris){
					rows = baris.parent().parent();
					rows.remove();
				}
				$(function() {
					$( "#tglawal" ).datepicker({
					  showOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
					$( "#tglakhir" ).datepicker({
					  showOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
					$( "#misc_diskon_time_start" ).datetimepicker({
					  showOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
					$( "#misc_diskon_time_end" ).datetimepicker({
					  showOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
				});

				function cek(data)
            	{
	                if(data=="1")
	                {
	                    document.getElementById("data").className = "show";
	                }
	                else
	                {
	                    document.getElementById("data").className = "hide";
	                }
            	};

                function showImage(i)
                {
                    var x	= new Image;
                    x.src	= i;
                    var iw	= x.width;
                    var ih	= x.height;
                }

				function cekvideo(datavid)
            	{
	                if(datavid=="1")
	                {
	                    $(".datavideo").show();
						$(".datagambar").hide();
	                }
	                else if(datavid=="0")
	                {
	                    $(".datavideo").hide();
						$(".datagambar").show();
	                }
					else
					{
	                    $(".datavideo").hide();
						$(".datagambar").hide();
	                }
            	}

            </script>

			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="3">Kategori</th>
				</tr>
				<tr>
					<td width="176">Kategori Produk</td>
					<td width="471">
                    <input name="secid" type="hidden" size="20" value="" id="secid" />
                    <input name="secid_text" type="text" size="50" value="" id="secid_text" placeholder="Pilih Kategori" class="validate[required]">
                    <a href="javascript:void();" class="apop" onclick="popsecid('secid','secid_text')">..</a></td>
				</tr>
                <tr>
					<td width="176">Sub Kategori Produk</td>
					<td width="471">
                    <input name="subid" type="hidden" size="20" value="" id="subid" />
                    <input name="subid_text" type="text" size="50" value="" placeholder="Pilih Sub Kategori" id="subid_text" class="" />
                    <a href="javascript:void();" class="apop" onclick="popsecsubid('subid','subid_text')">..</a></td>
				</tr>
                <tr>
					<td width="176">Brand Produk</td>
					<td width="471">
                    <input name="brandid" type="hidden" size="20" value="<?php echo $brandid?>" id="brandid" />
                    <input name="brandid_text" type="text" size="50" value="" placeholder="Pilih Brand" id="brandid_text" class="validate[required]" />
                    <a href="javascript:void();" class="apop" onclick="popbrandid('brandid','brandid_text')">..</a></td>
				</tr>
				<tr>
					<th colspan="2">Informasi Produk</th>
				</tr>
                <tr>
					<td width="15%">Status</td>
					<td colspan="2" >
						<input type="radio" name="status" value="1" <?php if($status=="1" || $status=="") echo "checked='checked'"; ?> /> Aktif &nbsp;
                        <input type="radio" name="status" value="0" <?php if($status=="0") echo "checked='checked'"; ?> /> Tidak Aktif &nbsp;
					</td>
				</tr>
                <tr>
					<td width="15%">Kode Produk</td>
					<td width="42%">
                        <input name="kodeproduk" type="hidden"  value="<?php echo $kodeproduk; ?>" />
                        <input name="kodeproduk1" type="text" size="70" id="kodeproduk1" readonly="readonly" value="<?php echo $kodeproduk; ?>" /><br />
                        <em>Masukan kode produk dengan jelas</em>
                    </td>
				</tr>
				<tr>
					<td width="15%">Nama Produk</td>
					<td width="42%">
                        <input name="title" type="text" size="70" id="title" class="validate[required]" value="<?php echo $namaprod; ?>" /><br />
                        <em>Masukan nama produk dengan jelas antara 4-35 karakater</em>
                    </td>
				</tr>
                <tr>
					<td>Tag</td>
                    <td>
                        <input type="text" name="tag" class="inputbiasa" size="70" id="tag" value="<?php echo $tag; ?>" /><br clear="all" />
                        <em>Masukan beberapa tag untuk memudahkan pencarian produk dan pisahkan menggunakan tanda koma
                        contoh: elektronik,murah,handal</em>
                    </td>
               	</tr>
                <tr>
					<td >Deskripsi Singkat</td>
					<td ><textarea name="ringkas" style="width:100%" rows="10" id="ringkas" class="validate[required]" ><?php echo $ringkas; ?></textarea></td>
				</tr>
                <tr>
					<td >Deskripsi Lengkap</td>
					<td ><textarea name="content" cols="70" rows="10" id="content" class="ckeditor validate[required]" ><?php echo $content; ?></textarea></td>
				</tr>
               
                <tr>
					<td>Harga</td>
                    <td colspan="2">
                    	<table width="100%" border="0">
                        <tr>
                            <td width="20%">Jenis Harga</td>
                            <td colspan="3">
                                <input type="radio" name="misc_jharga" value="1" <?php if($jharga=="1" || $jharga=="") echo "checked='checked'"; ?> onclick="return cek(this.value)"/> Publish
                                &nbsp;
                                <input type="radio" name="misc_jharga" value="0" <?php if($jharga=="0") echo "checked='checked'"; ?> onclick="return cek(this.value)"/> Sale &nbsp;<br />
                                <em>Pilihlah jenis harga.</em>
                           	</td>
                        </tr>
                        <div id="data" class="show">
                            <tr>
                            	<td width="20%">Harga</td>
                            	<td colspan="3">
									<?php echo $matauang;?> <input type="hidden" name="misc_matauang" value="<?php echo $matauang; ?>" class="inputbiasa" size="15" id="misc_matauang"/>
                                	<input type="text" name="misc_harga" class="validate[required]" value="<?php echo $misc_harga; ?>" size="15" id="harga"/>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">Harga Setelah Diskon</td>
                                <td colspan="3"><?php echo $matauang;?> <input type="text" name="misc_diskon" class="validate[required]" value="<?php echo $misc_diskon; ?>" size="15" id="diskon"/> </td>
                            </tr> 
                           
                        </div>
                        </table>
                   	</td>
               	</tr>

				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left" colspan="2">
						<input type="submit" name="Submit" value="Simpan" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>

            <?php
		}
	}

	if($aksi=="saveedit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$secid				= $_POST['secid'];
			$subid				= $_POST['subid'];
			$brandid			= $_POST['brandid'];

			$status				= $_POST['status'];
			$title				= cleaninsert($_POST['title']);
			$tag				= cleaninsert($_POST['tag']);
			$kondisi			= $_POST['kondisi'];
			$content			= desc($_POST['content']);
			$ringkas			= desc($_POST['ringkas']);

			$body_dimension		= cleaninsert($_POST['ukuran']);

			$body_weight		= cleaninsert($_POST['body_weight']);
			$body_weight		= str_replace(",",".",$body_weight);

			$misc_matauang		= $_POST['misc_matauang'];
			$misc_harga			= cleaninsert($_POST['misc_harga']);
			$misc_harga			= str_replace(".","",$misc_harga);
			$misc_harga			= str_replace(",","",$misc_harga);

			$misc_diskon		= cleaninsert($_POST['misc_diskon']);
			$misc_diskon		= str_replace(".","",$misc_diskon);
			$misc_diskon		= str_replace(",","",$misc_diskon);

			$misc_jharga		= $_POST['misc_jharga'];

			$misc_harga_reseller			= cleaninsert($_POST['misc_harga_reseller']);
			$misc_harga_reseller			= str_replace(".","",$misc_harga_reseller);
			$misc_harga_reseller			= str_replace(",","",$misc_harga_reseller);

			$matauangid = sql_get_var("select id from tbl_matauang where kode='$misc_matauang'");

			$kodeproduk			= $_POST['kodeproduk'];
			$kodeproduk1		= $_POST['kodeproduk1'];


			$jenisvideo			= $_POST['jenisvideo'];
			$urlyoutube			= cleaninsert($_POST['urlyoutube']);

			$upsellingid		= $_POST['upsellingid'];

			$alias				= getAlias($title);
			if($jharga == "0") $cart	= 0;

			if($kodeproduk!=$kodeproduk1)
			{

				$cek = sql_get_var("select kodeproduk from $nama_tabel3 where kodeproduk='$kodeproduk'");

				if(!empty($cek))
				{
					$error = base64_encode("Kode Produk tidak boleh sama, silahkan isi dengan kode produk yang berbeda.");
					header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
					exit();
				}
			}

			$perintah = "update $nama_tabel3 set `kodeproduk` = '$kodeproduk', `title` = '$title', `alias` = '$alias', `tag` = '$tag', `content` = '$content', `ringkas` = '$ringkas',
					`secid` = '$secid', `subid` = '$subid', `brandid` = '$brandid',
					`misc_matauang` = '$misc_matauang', `misc_jharga` = '$misc_jharga', `misc_harga` = '$misc_harga', `misc_diskon` = '$misc_diskon',  
					`misc_harga_reseller`='$misc_harga_reseller', `misc_matauangid` = '$matauangid',
					`tgl_expired` = '$tgl_expired', `kondisi` = '$kondisi', `tipe` = '$tipe', `status` = '$status', `blok` = '$blok', `kodeproduk` = '$kodeproduk',
					`cart` = '$cart', `flag` = '$flag', update_date='$date', update_userid='$cuserid' $fgambarsc where produkid='$produkid'";
			$hasil 	  = sql($perintah);

			if($hasil)
			{
				
				$perintahg = "update $nama_tabel set `title` = '$title', `misc_matauang` = '$misc_matauang', `misc_jharga` = '$misc_jharga', `misc_harga` = '$misc_harga', 
						`misc_diskon` = '$misc_diskon', `misc_matauangid` = '$matauangid', update_date='$date', update_userid='$cuserid' where kodeproduk='$kodeproduk'";
				$hasilg 	  = sql($perintahg);

				if($secid)
				{
					$perintah1	= "update tbl_product_sec set num=num-1 where secid='$secid'";
					$hasil1		= sql($perintah1);
					if($hasil1)
					{
						$perintahsec	= "update tbl_product_sec set num=num+1 where secid='$secid'";
						$hasilsec		= sql($perintahsec);
					}
				}
				if($subid)
				{
					$perintah2	= "update tbl_product_sub set num=num-1 where secid='$e_secid' and subid='$subid'";
					$hasil2		= sql($perintah2);
					if($hasil2)
					{
						$perintahsub	= "update tbl_product_sub set num=num+1 where secid='$secid' and subid='$subid'";
						$hasilsub		= sql($perintahsub);
					}
				}

				$perintah 	= "update tbl_product_total set totalstok='$totalstokall' where produkpostid='$produkpostid'";
				$hasil 		= sql($perintah);

				$msg = base64_encode("Berhasil mengubah data dengan ID $produkpostid");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="edit")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$produkid 	= $_GET['produkid'];
			$mainmenu[] 	= array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);

			//TAMPIL
			$sql = "select * from $nama_tabel3 where produkid='$produkid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);

			$secid					= $row['secid'];
			$subid					= $row['subid'];
			$kotaid					= $row['kotaid'];
			$brandid				= $row['brandid'];

			$title 					= $row['title'];
			$tag 					= $row['tag'];
			$content 				= $row['content'];
			$ringkas 				= $row['ringkas'];
			$kondisi 				= $row['kondisi'];
			$tipe 					= $row['tipe'];

			$status 				= $row['status'];

			$body_dimension 		= $row['body_dimension'];
			$body_weight 			= $row['body_weight'];

			$misc_jharga         = $row['misc_jharga'];
			$misc_matauang       = $row['misc_matauang'];
			$misc_harga          = $row['misc_harga'];
			$misc_diskon         = $row['misc_diskon'];
			$misc_harga_reseller = $row['misc_harga_reseller'];

			$upsellingid  = $row['upsellingid'];
			$kodeproduk   = $row['kodeproduk'];
			$produkpostid = sql_get_var("select produkpostid from $nama_tabel where kodeproduk='$kodeproduk'");
			
			if(!empty($upsellingid))
				$temp	= explode(",",$upsellingid);



			// kategori produk
			$namasec = sql_get_var("select namasec from tbl_product_sec where secid='$secid'");

			// subkategori produk
			$namasub = sql_get_var("select namasub from tbl_product_sub where subid='$subid'");

			// Brand Produk
			$brand = sql_get_var("select nama from tbl_product_brand where brandid='$brandid' order by nama asc");


			?>

            <script src="librari/ckeditor/ckeditor.js"></script>
            <script type="text/javascript" src="template/js/jquery-ui-timepicker-addon.js"></script>

			<style>
				/*.phonedata,*/ .diskonkuota, .preorder, .datavideo, .datagambar { display:none; }  .combines { width:50%; float:left; } .combines2 { width:25%}
				.inputbiasa { margin-bottom:5px !important; }
            </style>

            <script language="javascript">
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				function popsecid(var1,var2)
				{
					sList = window.open("index.php?pop=1&kanal=produk-kategori&aksi=popsecid&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}
				function popsecsubid(var1,var2)
				{
					var secid = $("#secid").val();
				 	sList = window.open("index.php?pop=1&kanal=produk-kategori&aksi=popsecsubid&var1="+var1+"&var2="+var2+"&secid="+secid+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}
				function popbrandid(var1,var2)
				{
				 	sList = window.open("index.php?pop=1&kanal=produk-brand&aksi=popbrandid&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}

				$(function() {

					$(".saveapprove").click(function(){
						$(".saveappr").val("1");
					});

					$(document).on('click','#mytable .deleterow',function(){
						var tr = $(this).closest('tr');
                            tr.css("background","#f1f1f1");
                            tr.fadeOut(300, function(){
                            	tr.remove();
                            });
                    });
				  });

				function vRemove(rTable){
					var rData = $("table#"+rTable+" tr").has('input:checked');
					rData.remove();
				}
				function selfRemove(baris){
					rows = baris.parent().parent();
					rows.remove();
				}

				$(function() {
					$( "#tglawal" ).datepicker({
					  showOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
					$( "#tglakhir" ).datepicker({
					  showOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
					$( "#misc_diskon_time_start" ).datetimepicker({
					  showOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
					$( "#misc_diskon_time_end" ).datetimepicker({
					  showOn: "button",
					  buttonImage: "template/images/calendar.gif",
					  buttonImageOnly: true,
					  timeFormat: "HH:mm"
					});
				});

				function cekvideo(datavid)
            	{
	                if(datavid=="1")
	                {
	                    $(".datavideo").show();
						$(".datagambar").hide();
	                }
	                else if(datavid=="0")
	                {
	                    $(".datavideo").hide();
						$(".datagambar").show();
	                }
					else
					{
	                    $(".datavideo").hide();
						$(".datagambar").hide();
	                }
            	}
            </script>

			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="produkid" value="<?php echo $produkid?>">
            <input type="hidden" name="secid1" value="<?php echo $secid?>">
            <input type="hidden" name="subid1" value="<?php echo $subid?>">
            <input type="hidden" name="kodeproduk1" value="<?php echo $kodeproduk?>">
            <input type="hidden" name="produkpostid" value="<?php echo $produkpostid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Kategori</th>
				</tr>
				<tr>
					<td width="176">Kategori Produk</td>
					<td width="471">
                    <input name="secid" type="hidden" size="20" value="<?php echo $secid?>" id="secid" />
                    <input name="secid_text" type="text" size="50" value="<?php echo $namasec?>" placeholder="Pilih Kategori" id="secid_text" class="">
                    <a href="javascript:void();" class="apop" onclick="popsecid('secid','secid_text')">..</a></td>
				</tr>
                <tr>
					<td width="176">Sub Kategori Produk</td>
					<td width="471">
                    <input name="subid" type="hidden" size="20" value="<?php echo $subid?>" id="subid" />
                    <input name="subid_text" type="text" size="50" value="<?php echo $namasub?>" id="subid_text" placeholder="Pilih Sub Kategori" />
                    <a href="javascript:void();" class="apop" onclick="popsecsubid('subid','subid_text')">..</a></td>
				</tr>
                <tr>
					<td width="176">Brand Produk</td>
					<td width="471">
                    <input name="brandid" type="hidden" size="20" value="<?php echo $brandid?>" id="brandid" />
                    <input name="brandid_text" type="text" size="50" value="<?php echo $brand?>" id="brandid_text" placeholder="Pilih Brand" class="validate[required]" />
                    <a href="javascript:void();" class="apop" onclick="popbrandid('brandid','brandid_text')">..</a></td>
				</tr>
				<tr>
					<th colspan="2">Informasi Produk</th>
				</tr>
                <tr>
					<td width="15%">Status</td>
					<td colspan="2" >
						<input type="radio" name="status" value="1" <?php if($status=="1" || $status=="") echo "checked='checked'"; ?> /> Aktif &nbsp;
                        <input type="radio" name="status" value="0" <?php if($status=="0") echo "checked='checked'"; ?> /> Tidak Aktif &nbsp;
					</td>
				</tr>
                <tr>
					<td width="15%">Kode Produk</td>
					<td width="42%">
                        <input name="kodeproduk" type="text" size="70" id="kodeproduk" class="validate[required]" value="<?php echo $kodeproduk; ?>" /><br />
                        <em>Masukan kode produk dengan jelas</em>
                    </td>
				</tr>
				<tr>
					<td width="15%">Nama Produk</td>
					<td width="42%">
                        <input name="title" type="text" size="70" id="title" class="validate[required]" value="<?php echo $title; ?>" /><br />
                        <em>Masukan nama produk dengan jelas antara 4-35 karakater</em>
                    </td>
				</tr>
                <tr>
					<td>Tag</td>
                    <td>
                        <input type="text" name="tag" class="inputbiasa" size="70" id="tag" value="<?php echo $tag; ?>" /><br clear="all" />
                        <em>Masukan beberapa tag untuk memudahkan pencarian produk dan pisahkan menggunakan tanda koma
                        contoh: elektronik,murah,handal</em>
                    </td>
               	</tr>
                <tr>
					<td >Deskripsi Singkat</td>
					<td ><textarea name="ringkas" style="width:100%" rows="10" id="ringkas" class="validate[required]" ><?php echo $ringkas; ?></textarea></td>
				</tr>
                <tr>
					<td >Deskripsi Lengkap</td>
					<td ><textarea name="content" cols="70" rows="10" id="content" class="ckeditor validate[required]" ><?php echo $content; ?></textarea></td>
				</tr>

                <tr>
					<th colspan="2">Informasi Detail</th>
				</tr>
                <tr>
					<td>Harga</td>
                    <td colspan="2">
                    	<table width="100%" border="0">
                        <tr>
                            <td width="20%">Jenis Harga</td>
                            <td colspan="3">
                                <input type="radio" name="misc_jharga" value="1" <?php if($misc_jharga=="1" || $misc_jharga=="") echo "checked='checked'"; ?> onclick="return cek(this.value)"/> Publish
                                &nbsp;
                                <input type="radio" name="misc_jharga" value="0" <?php if($misc_jharga=="0") echo "checked='checked'"; ?> onclick="return cek(this.value)"/> Sale &nbsp;<br />
                                <em>Pilihlah jenis harga.</em>
                           	</td>
                        </tr>
                        <div id="data" class="show">
                            <tr>
                            	<td width="20%">Harga</td>
                            	<td colspan="3"><?php echo $matauang;?> <input type="hidden" name="misc_matauang" value="<?php echo $matauang; ?>" class="inputbiasa" size="15" id="misc_matauang"/>
                                	<input type="text" name="misc_harga" class="validate[required]" value="<?php echo $misc_harga; ?>" size="15" id="harga"/>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">Harga Setelah Diskon</td>
                                <td colspan="3"><?php echo $matauang;?> <input type="text" name="misc_diskon" class="validate[required]" value="<?php echo $misc_diskon; ?>" size="15" id="diskon"/> </td>
                            </tr> 
                           
                        </div>
                        </table>
                   	</td>
               	</tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left" colspan="2">
						<input type="submit" name="Submit" value="Simpan" />
						<input type="button" onclick="javascript:window.location=('<?php echo $alamat?>')" value="Batal">
					</td>
				</tr>
			</table>
			</form>

            <?php
		}
	}

	//View Item
	if($aksi == "viewitem")
	{
		if(!$oto['view']) { echo $error['view']; }
		{
			$mainmenu[] = array("Lihat Produk","category","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Item","tambah","$alamat&aksi=tambahitem&kodeproduk=$kodeproduk");
			$mainmenu[] = array("Lihat Item","lihat","$alamat&aksi=viewitem&kodeproduk=$kodeproduk");
			mainaction($mainmenu,$pageparam);

			$pageparam[] = array("kodeproduk",$kodeproduk);


			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];

			//Orderring
			$order = getorder("produkpostid","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];

			$sql = "select count(*) as jml from $nama_tabel where 1 $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			$sql = "select produkpostid,kodeproduk,nomor,update_date,published,utama,body_weight from $nama_tabel where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i   = 1;
			$a   = 1;

			$namaproduk = sql_get_var("select title from $nama_tabel3 where kodeproduk='$kodeproduk'");
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n
			<tr><th width=1%>Kode SKU</th><td>$kodeproduk</td></tr>\n
			<th width=15%>Nama Produk</th><td>$namaproduk</td></tr>
			</table>\n<br clear=\"all\" /><br clear=\"all\" />");
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr>\n");
			print("<th width=15%>Item</th>\n");
			print("<th width=15%>Berat</th>\n");
			print("<th width=5%>Sisa Stok</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=published\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$produkpostid = $row['produkpostid'];
				$kodeproduk   = $row['kodeproduk'];
				$warnaid      = $row['warnaid'];
				$utamas      = $row['utama'];
				$nomor       = $row['nomor'];
				$published    = $row['published'];
				$body_weight = $row['body_weight'];
				
				$stok = sql_get_var("select totalstok from tbl_product_total where produkpostid='$produkpostid'");
				
				if($published=="1") $publish ="<span class=\"label label-success\">Publish</span>";
				 else $publish ="<span class=\"label label-default\">Draft</span>";

				print("<tr class=\"row$i\">
					
					<td width=10% height=20 valign=top><b>$nomor</b></td>
					<td align=center valign=top >$body_weight gram</td>\n
					<td align=center valign=top >$stok</td>\n
					<td align=center valign=top >$publish</td>\n");
				print("<td>");

				if($published==0) $acc[] = array("Publish","push","$alamat&aksi=publishitem&kodeproduk=$kodeproduk&produkpostid=$produkpostid&hlm=$hlm");
				else $acc[] = array("Unpublish","push","$alamat&aksi=publishitem&kodeproduk=$kodeproduk&produkpostid=$produkpostid&hlm=$hlm");
				$acc[] = array("Edit","edit","$alamat&aksi=edititem&kodeproduk=$kodeproduk&produkpostid=$produkpostid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapusitem&kodeproduk=$kodeproduk&produkpostid=$produkpostid&hlm=$hlm");

				cmsaction($acc);
				unset($acc);

				print("</td></tr>");

				$i %= 2;
				$i++;
				$a++;
				$ord++;
			}
			print("</table><br clear='all'>");

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
		}
	} //EndView
	
	//Publish
	if($aksi=="utama")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$produkpostid = $_GET['produkpostid'];

			$perintah 	= "select utama from $nama_tabel where produkpostid='$produkpostid' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['utama']=="0") $status = 1;
				else $status=0;

			$perintah 	= "update $nama_tabel set utama='$status' where produkpostid='$produkpostid' ";
			$hasil		= sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Sukses merubah status data dengan ID $produkpostid");
				header("location: $alamat&aksi=viewitem&kodeproduk=$kodeproduk&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal merubah status data dan silahkan coba kembali");
				header("location: $alamat&aksi=viewitem&kodeproduk=$kodeproduk&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//Hapus Item
	if($aksi == "hapusitem")
	{
		if(!$oto['delete']) { echo $error['delete']; }
		{
			$kodeproduk   = $_GET['kodeproduk'];
			$produkpostid = $_GET['produkpostid'];
			
			$produkid = sql_get_var("select produkid from $nama_tabel3 where kodeproduk='$kodeproduk'");
			
			
			$perintah 	= "delete from $nama_tabel where produkpostid='$produkpostid' and produkid='$produkid'";
			$hasil 		= sql($perintah);
			
			if($hasil)
			{
				$perintahn	= "update $nama_tabel3 set numitem=numitem-1 where produkid='$produkid'";
				$hasiln		= sql($perintahn);

				$msg = base64_encode("Sukses menghapus Data dengan ID $commentid");
				header("location: $alamat&aksi=viewitem&kodeproduk=$kodeproduk&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dihapus dan silahkan coba kembali");
				header("location: $alamat&aksi=viewitem&kodeproduk=$kodeproduk&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//Publish
	if($aksi=="publishitem")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$produkpostid = $_GET['produkpostid'];

			$perintah 	= "select published from $nama_tabel where produkpostid='$produkpostid' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['published']=="0") $status = 1;
				else $status=0;

			$perintah 	= "update $nama_tabel set published='$status' where produkpostid='$produkpostid' ";
			$hasil		= sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Sukses merubah status data dengan ID $produkpostid");
				header("location: $alamat&aksi=viewitem&kodeproduk=$kodeproduk&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal merubah status data dan silahkan coba kembali");
				header("location: $alamat&aksi=viewitem&kodeproduk=$kodeproduk&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//SaveTambah
	if($aksi=="savetambahitem")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$kodeproduk             	= $_POST['kodeproduk'];
			$_SESSION['kodeproduk'] 	= $kodeproduk;
			$nomor             		= $_POST['nomor'];
			$_SESSION['nomor'] 		= $nomor;
			$sizeid              		= $_POST['sizeid'];
			$_SESSION['sizeid']  		= $sizeid;
        	$body_dimension             = cleaninsert($_POST['ukuran']);
			$_SESSION['body_dimension'] = $body_dimension;

			$body_weight             = cleaninsert($_POST['body_weight']);
			$body_weight             = str_replace(",",".",$body_weight);
			$_SESSION['body_weight'] = $body_weight;

			$title                = $_POST['title'];
			$_SESSION['title']    = $title;

			$misc_matauang             = $_POST['misc_matauang'];
			$_SESSION['misc_matauang'] = $misc_matauang;
			$misc_harga                = cleaninsert($_POST['misc_harga']);
			$_SESSION['misc_harga']    = $misc_harga;
			$misc_harga                = str_replace(".","",$misc_harga);
			$misc_harga                = str_replace(",","",$misc_harga);
			$misc_diskon               = cleaninsert($_POST['misc_diskon']);
			$_SESSION['misc_diskon']   = $misc_diskon;
			$misc_diskon               = str_replace(".","",$misc_diskon);
			$misc_diskon               = str_replace(",","",$misc_diskon);
			$misc_jharga               = $_POST['misc_jharga'];
			$_SESSION['misc_jharga']   = $misc_jharga;
			$matauangid                = sql_get_var("select id from tbl_matauang where kode='$misc_matauang'");

			if($jharga == "0") $cart	= 0;
			$alias				= getAlias($title);

			$produkid = sql_get_var("select produkid from $nama_tabel3 where kodeproduk='$kodeproduk'");

			$produkpostid = newid("produkpostid",$nama_tabel);

			//input produk
			$perintah = "insert into $nama_tabel (`produkpostid`, produkid, `title`,`nomor`,`sizeid`,`kodeproduk`,`body_dimension`,`body_weight`, `misc_matauang`, `misc_matauangid`, `misc_harga`, `misc_jharga`, `misc_diskon`)
							values ('$produkpostid','$produkid','$title','$nomor','$sizeid','$kodeproduk','$body_dimension','$body_weight',  '$misc_matauang', '$matauangid', '$misc_harga', '$misc_jharga', '$misc_diskon')";
			$hasil = sql($perintah);

			if($hasil)
			{
				if($produkid)
				{
					$perintah2	= "update $nama_tabel3 set numitem=numitem+1 where produkid='$produkid'";
					$hasil2		= sql($perintah2);
				}

				$perintah3	= "insert into tbl_product_wh (`produkpostid`) value ('$produkpostid')";
				$hasil3		= sql($perintah3);
				
				$warehouseid = $_POST['warehouseid'];
				foreach ($warehouseid as $key2 => $id) {
					$produkwhid		= $_POST['produkwhid'][$key2];
					$warehouseid	= $_POST['warehouseid'][$key2];
					$totalstokwh	= $_POST['totalstokwh'][$key2];
					
					if(empty($produkwhid))
					{
						$perintah 	= "insert into tbl_product_wh (`produkpostid`,`warehouseid`,`totalstok`) values ('$produkpostid','$warehouseid','$totalstokwh')";
						$hasil 		= sql($perintah);

						$perintah2 = "insert into tbl_product_total (`produkpostid`,`totalstok`) values ('$produkpostid','$totalstokwh')";
						$hasil2    = sql($perintah2);
					}
					else
					{
						$perintah 	= "update tbl_product_wh set totalstok='$totalstokwh' where produkwhid='$produkwhid' and produkpostid='$produkpostid' and warehouseid='$warehouseid'";
						$hasil 		= sql($perintah);

						$perintah2 = "update tbl_product_total set totalstok='$totalstokwh' where produkpostid='$produkpostid'";
						$hasil2    = sql($perintah2);
					}
					$totalstokall = $totalstokall+$totalstokwh;
				}



				unset($_SESSION['warnaid'],$_SESSION['sizeid'],$_SESSION['title'],$_SESSION['body_dimension'],$_SESSION['body_weight'],
						$_SESSION['kodeproduk']);

				$msg = base64_encode("Berhasil ditambahkan Data baru");
				header("location: $alamat&aksi=viewitem&kodeproduk=$kodeproduk&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=viewitem&kodeproduk=$kodeproduk&hlm=$hlm&error=$error");
				exit();
			}

		}
	}

	//Tambah
	if($aksi=="tambahitem")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewitem&kodeproduk=$kodeproduk");
			mainaction($mainmenu,$param);

			$dtprod = sql_get_var_row("select produkid,secid,subid,brandid,title,tag,content,kondisi,tipe,status,ringkas,misc_matauang,misc_harga,misc_diskon,misc_jharga,jenisvideo,screenshot,urlyoutube from $nama_tabel3 where kodeproduk='$kodeproduk'");

			$secid        = $dtprod['secid'];
			$subid        = $dtprod['subid'];
			$brandid      = $dtprod['brandid'];
			$e_title      = $dtprod['title'];
			$e_tag        = $dtprod['tag'];
			$produkid    = $dtprod['produkid'];
			$e_tipe       = $dtprod['tipe'];
			$e_status     = $dtprod['status'];
			$e_ringkas    = $dtprod['ringkas'];

			$e_misc_matauang = $dtprod['misc_matauang'];
			$misc_harga      = $dtprod['misc_harga'];
			$e_misc_harga    = number_format($dtprod['misc_harga'],0,".",".");
			$e_misc_diskon   = $dtprod['misc_diskon'];
			$e_misc_jharga   = $dtprod['misc_jharga'];

			// kategori produk
			$namasec = sql_get_var("select namasec from tbl_product_sec where secid='$secid'");

			// subkategori produk
			$namasub = sql_get_var("select namasub from tbl_product_sub where subid='$subid'");

			// Brand Produk
			$brand = sql_get_var("select nama from tbl_product_brand where brandid='$brandid'");
			?>
            <script src="librari/ckeditor/ckeditor.js"></script>

            <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});

				function popwarnaid(var1,var2)
				{
				 	sList = window.open("index.php?pop=1&kanal=produk-warna&aksi=popidwarna&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}
				function popsizeid(var1,var2)
				{
				 	sList = window.open("index.php?pop=1&kanal=produk-size&aksi=popidsize&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}
			</script>

			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambahitem">
			<input type="hidden" name="kodeproduk" value="<?php echo $kodeproduk ?>">
            <input type="hidden" name="produkid" value="<?php echo $produkid ?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Informasi Produk</th>
				</tr>
                <tr>
					<td width="15%">Kode Produk</td>
					<td width="42%">
                        <?php echo $kodeproduk; ?>
                    </td>
				</tr>
				<tr>
					<td width="15%">Nama Produk</td>
					<td width="42%">
						<?php echo $e_title; ?>
                        <input name="title" type="hidden" size="70" id="title" class="validate[required]" value="<?php echo $e_title; ?>"/>
                    </td>
				</tr>
               	<tr>
					<td width="15%">Item</td>
					<td width="42%">
						<input type="text" name="nomor"  size="25" id="ukuran" value=""  class="validate[required]" />
                    </td>
				</tr>

                        <tr>
                            <td width="20%">Berat</td>
                            <td><input type="text" name="body_weight" class="inputbiasa validate[required]" size="25" id="body_weight" value="<?php echo $body_weight; ?>" /> Gram</td>
                        </tr>
		       
                <tr>
					<td width="15%">Stock Awal</td>
									
                    <td>
						<?php
                            $sql1 = "SELECT warehouseid,nama from tbl_warehouse where 1";

							$warehouse = array();
							$hsl1      = sql($sql1);
							
						
							while($row1 = sql_fetch_data($hsl1))
							{
								$warehouseid = $row1['warehouseid'];
								
								print("$row1[nama]<br>\n");
								
								$warehouse[$warehouseid] = array("warehouseid"=>$warehouseid,"nama"=>$row1['nama']);
							}
						
							$totalwh = 0;
							foreach($warehouse as $key => $index)
							{
								$warehouseid = $index['warehouseid'];
								$hsl2        = sql("select produkwhid, totalstok from tbl_product_wh where produkpostid='$produkpostid' and warehouseid='$warehouseid'");
								$row2        = sql_fetch_data($hsl2);
								$produkwhid  = $row2['produkwhid'];
								$totalstokwh = $row2['totalstok'];
								
								print("
										<input type=\"hidden\" name=\"produkwhid[]\" value=\"$produkwhid\" />
										<input type=\"hidden\" name=\"warehouseid[]\" value=\"$warehouseid\" />
										<input type=\"text\" name=\"totalstokwh[]\" value=\"$totalstokwh\" class=\"stock-item\" /><br>\n");
							}
							
							$a++;
							$i++;
						
							sql_free_result($hsl1);
                        ?>
                    </td>
                </tr>
                    </td>
				</tr>
				<input type="hidden" name="misc_jharga" value="<?php echo $e_misc_jharga; ?>">
                <input type="hidden" name="misc_matauang" value="<?php echo $e_misc_matauang; ?>">
                <input type="hidden" name="misc_harga" value="<?php echo $misc_harga; ?>">
                <input type="hidden" name="misc_diskon" value="<?php echo $e_misc_diskon; ?>">
				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left" colspan="2">
						<input type="submit" name="Submit" value="Simpan" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>

            <?php
		}
	}

	//SaveTambah
	if($aksi=="saveedititem")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$kodeproduk             	= $_POST['kodeproduk'];
			$nomor             		= $_POST['nomor'];
			$sizeid              		= $_POST['sizeid'];
        	$body_dimension             = cleaninsert($_POST['ukuran']);
			$body_weight = cleaninsert($_POST['body_weight']);
			$body_weight = str_replace(",",".",$body_weight);
			$title       = $_POST['title'];


			//input produk
			$perintah = "update $nama_tabel set nomor='$nomor',sizeid='$sizeid',body_dimension='$body_dimension',body_weight='$body_weight' where produkpostid='$produkpostid'";
			$hasil = sql($perintah);

			if($hasil)
			{
				$warehouseid = $_POST['warehouseid'];
				foreach ($warehouseid as $key2 => $id) {
					$produkwhid		= $_POST['produkwhid'][$key2];
					$warehouseid	= $_POST['warehouseid'][$key2];
					$totalstokwh	= $_POST['totalstokwh'][$key2];
					
					if(empty($produkwhid))
					{
						$perintah 	= "insert into tbl_product_wh (`produkpostid`,`warehouseid`,`totalstok`) values ('$produkpostid','$warehouseid','$totalstokwh')";
						$hasil 		= sql($perintah);

						$perintah2 = "insert into tbl_product_total (`produkpostid`,`totalstok`) values ('$produkpostid','$totalstokwh')";
						$hasil2    = sql($perintah2);
					}
					else
					{
						$perintah 	= "update tbl_product_wh set totalstok='$totalstokwh' where produkwhid='$produkwhid' and produkpostid='$produkpostid' and warehouseid='$warehouseid'";
						$hasil 		= sql($perintah);

						$perintah2 = "update tbl_product_total set totalstok='$totalstokwh' where produkpostid='$produkpostid'";
						$hasil2    = sql($perintah2);
					}
					$totalstokall = $totalstokall+$totalstokwh;
				}

				$msg = base64_encode("Berhasil merubah data");
				header("location: $alamat&aksi=viewitem&kodeproduk=$kodeproduk&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=viewitem&kodeproduk=$kodeproduk&hlm=$hlm&error=$error");
				exit();
			}

		}
	}

	//Tambah
	if($aksi=="edititem")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=viewitem&kodeproduk=$kodeproduk");
			mainaction($mainmenu,$param);

			$dtprod = sql_get_var_row("select secid,subid,brandid,title,tag,content,kondisi,tipe,status,ringkas,misc_matauang,misc_harga,misc_harga_reseller,misc_diskon,misc_jharga,jenisvideo,screenshot,urlyoutube from $nama_tabel3 where kodeproduk='$kodeproduk'");

			$secid        = $dtprod['secid'];
			$subid        = $dtprod['subid'];
			$brandid      = $dtprod['brandid'];
			$e_title      = $dtprod['title'];
			$e_tag        = $dtprod['tag'];
			$e_content    = $dtprod['content'];
			$e_tipe       = $dtprod['tipe'];
			$e_status     = $dtprod['status'];
			$e_ringkas    = $dtprod['ringkas'];

			$e_misc_matauang       = $dtprod['misc_matauang'];
			$e_misc_harga          = number_format($dtprod['misc_harga'],0,".",".");
			$e_misc_harga_reseller = number_format($dtprod['misc_harga_reseller'],0,".",".");
			$e_misc_diskon         = $dtprod['misc_diskon'];
			$e_misc_jharga         = $dtprod['misc_jharga']; 
		

			// kategori produk
			$namasec = sql_get_var("select namasec from tbl_product_sec where secid='$secid'");
			// subkategori produk
			$namasub = sql_get_var("select namasub from tbl_product_sub where subid='$subid'");
			// Brand Produk
			$brand = sql_get_var("select nama from tbl_product_brand where brandid='$brandid'");
			
			
			$dtprod = sql_get_var_row("select produkpostid, `title`,`nomor`,`sizeid`,`kodeproduk`,`body_dimension`,`body_weight` from $nama_tabel where produkpostid='$produkpostid'");

			$nomor        = $dtprod['nomor'];
			$body_dimension = $dtprod['body_dimension'];
			$body_weight = $dtprod['body_weight'];

			?>
            <script src="librari/ckeditor/ckeditor.js"></script>

            <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});

				function popwarnaid(var1,var2)
				{
				 	sList = window.open("index.php?pop=1&kanal=produk-warna&aksi=popidwarna&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}
				function popsizeid(var1,var2)
				{
				 	sList = window.open("index.php?pop=1&kanal=produk-size&aksi=popidsize&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0");
				}
			</script>

			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveedititem">
			<input type="hidden" name="kodeproduk" value="<?php echo $kodeproduk ?>">
            <input type="hidden" name="produkpostid" value="<?php echo $produkpostid ?>">
			<table border="0" class="tabel-cms" width="100%">
			
                <tr>
					<th colspan="2">Informasi Detail</th>
				</tr>
                 <tr>
                    <td width="20%">Nama Produk</td>
                    <td><?php echo $e_title; ?></td>
                </tr>
                <tr>
                    <td width="20%">Item</td>
                    <td><input type="text" name="nomor" class="inputbiasa validate[required]" size="25" id="nomor" value="<?php echo $nomor; ?>" /></td>
                </tr>
                                <tr>
                            <td width="20%">Berat</td>
                            <td><input type="text" name="body_weight" class="inputbiasa validate[required]" size="25" id="body_weight" value="<?php echo $body_weight; ?>" /> Gram</td>
                        </tr>
              
                 <tr>
					<td>Stock Produk</td>
				
                    <td>
						<?php
                            $sql1 = "SELECT warehouseid,nama from tbl_warehouse where 1";

							$warehouse = array();
							$hsl1      = sql($sql1);
							
						
							while($row1 = sql_fetch_data($hsl1))
							{
								$warehouseid = $row1['warehouseid'];
								
								print("$row1[nama]<br>\n");
								
								$warehouse[$warehouseid] = array("warehouseid"=>$warehouseid,"nama"=>$row1['nama']);
							}
						
							$totalwh = 0;
							foreach($warehouse as $key => $index)
							{
								$warehouseid = $index['warehouseid'];
								$hsl2        = sql("select produkwhid, totalstok from tbl_product_wh where produkpostid='$produkpostid' and warehouseid='$warehouseid'");
								$row2        = sql_fetch_data($hsl2);
								$produkwhid  = $row2['produkwhid'];
								$totalstokwh = $row2['totalstok'];
								
								print("
										<input type=\"hidden\" name=\"produkwhid[]\" value=\"$produkwhid\" />
										<input type=\"hidden\" name=\"warehouseid[]\" value=\"$warehouseid\" />
										<input type=\"text\" name=\"totalstokwh[]\" value=\"$totalstokwh\" class=\"stock-item\" /><br>\n");
							}
							
							$a++;
							$i++;
						
							sql_free_result($hsl1);
                        ?>
                    </td>
                </tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left" colspan="2">
						<input type="submit" name="Submit" value="Simpan" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>

            <?php
		}
	}

	//Tambah
	if($aksi=="tambahicon")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);

			?>
            <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
            </script>

			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambahicon">
        	<input type="hidden" name="produkpostid" value="<?php echo $produkpostid?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Icon Produk</th>
				</tr>
                <tr>
					<td >Icon Produk</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" /><br />
                    <em>Gambar yang dimasukan harus memiliki ukuran  <?php echo $gambaricon_maxw." x ". $gambaricon_maxh?></em></td>
				</tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Gambar" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>

            <?php
		}
	}

	//SaveTambahGambar
	if($aksi=="savetambahicon")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
        	$produkpostid	= $_POST['produkpostid'];
			//Upload Gambar
			if(!file_exists("$pathfile/produk/$produkpostid")) mkdir("$pathfile/produk/$produkpostid");

			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$namagambars = "icon-$kanal-$produkpostid.$ext";
				$gambars = resizeimg($_FILES['gambar']['tmp_name'],"$pathfile/produk/$produkpostid/$namagambars",$gambars_maxw,$gambars_maxh);

				if($gambars){
					$vgambar = ",icon='$namagambars'";
				}
			}

			$perintah 	= "update $nama_tabel SET update_date='$date',update_userid='$cuserid' $vgambar WHERE produkpostid='$produkpostid'";
			$hasil = sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Berhasil ditambahkan Data baru");
				header("location: $alamat&aksi=detail&produkpostid=$produkpostid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&produkpostid=$produkpostid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//Hapus
	if($aksi=="hapusicon")
	{
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			$del_file	= "$pathfile"."produk/$produkpostid";

			$perintah 	= "select icon from $nama_tabel where produkpostid='$produkpostid'";
			$hasil 		= sql($perintah);
			$row	= sql_fetch_data($hasil);

			$icon	= $row['icon'];

			if(!empty($icon)) unlink("$del_file/$icon");

			$perintah1 = "update $nama_tabel set icon='' where produkpostid='$produkpostid'";
			$hasil1 = sql($perintah1);

			if($hasil1)
			{
				$msg = base64_encode("Success mengapus gambar dengan Data dengan ID $produkpostid");
				header("location: $alamat&aksi=detail&produkpostid=$produkpostid&albumid&$albumid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gambar tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&produkpostid=$produkpostid&albumid&$albumid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
	
	//View Galeri
	if($aksi == "lihatgaleri")
	{
		if(!$oto['view']) { echo $error['view']; }
		{
			$mainmenu[] = array("Lihat Produk","back","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Photo","tambah","$alamat&aksi=tambahgambar&kodeproduk=$kodeproduk&produkid=$produkid");
			$mainmenu[] = array("Lihat Photo","lihat","$alamat&aksi=lihatgaleri&kodeproduk=$kodeproduk&produkid=$produkid");
			mainaction($mainmenu,$pageparam);

			$pageparam[] = array("produkid",$produkid);

			$formcari = cmsformcari($cari,$pageparam);
			$where    = $formcari[0]['where'];
			$param    = $formcari[0]['param'];

			//Orderring
			$order    = getorder("albumid","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];

			$sql = "select count(*) as jml from $nama_tabel1 where 1 $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			$sql = "select albumid,produkpostid,produkid,gambar_m,update_date from $nama_tabel1 where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i   = 1;
			$a   = 1;

			$namaproduk  = sql_get_var("select title from $nama_tabel3 where kodeproduk='$kodeproduk'");
		
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n
			<tr><th width=1%>Kode SKU</th><td>$kodeproduk</td></tr>\n
			<th width=15%>Nama Produk</th><td>$namaproduk</td></tr>
			</table>\n<br clear=\"all\" /><br clear=\"all\" />");

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=1%>Item</th>\n");
			print("<th width=94%>Preview Photo</th>\n");		
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$albumid      = $row['albumid'];
				$produkpostid = $row['produkpostid'];
				$produkid     = $row['produkid'];
				$kodeproduk   = sql_get_var("select kodeproduk from $nama_tabel3 where produkid='$produkid'");
				$gambar_m     = $row['gambar_m'];
				$update_date  = tanggal($row['update_date']);
				$published    = $row['published'];
				
				if(!empty($gambar_m)) $image_m = "<img src=\"../gambar/produk/$gambar_m\" alt=\"\" style=\"width:200px\" />"; else $image_m = "Masih kosong";


				print("<tr class=\"row$i\"><td width=1% height=20 valign=top align=center>&nbsp;$a</td>
					<td  valign=top class=judul>$image_m</td>\n");
				print("<td>");

				$acc[] = array("Edit","edit","$alamat&aksi=editgambar&kodeproduk=$kodeproduk&produkpostid=$produkpostid&albumid=$albumid&hlm=$hlm");
				$acc[] = array("Hapus","delete","$alamat&aksi=hapusgambar&kodeproduk=$kodeproduk&produkid=$produkid&albumid=$albumid&hlm=$hlm");

				cmsaction($acc);
				unset($acc);

				print("</td></tr>");

				$i %= 2;
				$i++;
				$a++;
				$ord++;
			}
			print("</table><br clear='all'>");

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
		}
	} //EndView
	
	//Hapus
	if($aksi=="hapusgambar")
	{
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			$albumid      = $_GET['albumid'];
			$produkid = $_GET['produkid'];
			$kodeproduk   = $_GET['kodeproduk'];
			$del_file     = "$pathfile"."produk/";

			$perintah = "select gambar_f,gambar_l,gambar_m,gambar_s from $nama_tabel1 where albumid='$albumid' and produkpostid='$produkpostid' and produkid='$produkid'";
			$hasil    = sql($perintah);
			$row      = sql_fetch_data($hasil);

			$gambar_f	= $row['gambar_f'];
			$gambar_l	= $row['gambar_l'];
			$gambar_m	= $row['gambar_m'];
			$gambar_s	= $row['gambar_s'];

			if(!empty($gambar_f)) unlink("$del_file/$gambar_f");
			if(!empty($gambar_l)) unlink("$del_file/$gambar_l");
			if(!empty($gambar_m)) unlink("$del_file/$gambar_m");
			if(!empty($gambar_s)) unlink("$del_file/$gambar_s");

			$perintah1 = "delete from $nama_tabel1 where albumid='$albumid' and produkid='$produkid'";
			$hasil1 = sql($perintah1);

			if($hasil1)
			{
				$msg = base64_encode("Berhasil menghapus gambar dengan ID $albumid");
				header("location: $alamat&aksi=lihatgaleri&kodeproduk=$kodeproduk&produkid=$produkid&albumid&$albumid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gambar tidak dapat dihapus dan silahkan coba kembali");
				header("location: $alamat&aksi=lihatgaleri&kodeproduk=$kodeproduk&produkid=$produkid&albumid&$albumid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//EDIT GAMBAR
	if($aksi=="saveeditgambar")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$albumid      = $_POST['albumid'];
			$produkid     = $_POST['produkid'];
			$nama         = sql_get_var("select title from $nama_tabel3 where produkid='$produkid'");
			$alias        = getAlias($nama);

			//Upload Gambar
			if(!file_exists("$pathfile/$kanal")) mkdir("$pathfile/$kanal");

			if($_FILES['gambar']['size']>0)
			{
				$ext = getimgext($_FILES['gambar']);
				$files= $_FILES['gambar']['tmp_name'];

				$imageinfo 	= getimagesize($files);
				$imagewidth = $imageinfo[0];
				$imageheight= $imageinfo[1];
				$imagetype 	= $imageinfo[2];

					//FULL
					$namagambarf = "$alias-$produkid-$albumid-f.$ext";
					$gambarf 	 = resizeimg($files,"$pathfile/produk/$produkpostid/$namagambarf",$imagewidth,$imageheight);
					//LARGE
					$namagambarl = "$alias-$produkid-$albumid-l.$ext";
					$gambarl 	 = resizeimg($files,"$pathfile/produk/$produkpostid/$namagambarl",$gambarl_maxw,$gambarl_maxh);
					//MEDIUM
					$namagambarm = "$alias-$produkid-$albumid-m.$ext";
					$gambarm 	 = resizeimg($files,"$pathfile/produk/$produkpostid/$namagambarm",$gambarm_maxw,$gambarm_maxh);
					//SMALL
					$namagambars = "$alias-$produkid-$albumid-s.$ext";
					$gambars 	 = resizeimg($files,"$pathfile/produk/$produkpostid/$namagambars",$gambars_maxw,$gambars_maxh);

					if($gambars){
						$vgambar = ",gambar_f='$namagambarf',gambar_l='$namagambarl',gambar_m='$namagambarl',gambar_s='$namagambars'";
					}
			}

				$perintah 	= "update $nama_tabel1 set gambar_f='$namagambarf',gambar_l='$namagambarl',gambar_m='$namagambarm',gambar_s='$namagambars',update_date='$date',
							update_userid='$cuserid' $vgambar where albumid='$albumid' and produkid='$produkid'";
				$hasil 		= sql($perintah);

			if($hasil)
			{
				$msg = base64_encode("Berhasil mengubah data dengan ID $albumid");
				header("location: $alamat&aksi=lihatgaleri&kodeproduk=$kodeproduk&produkid=$produkid&albumid&$albumid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat edit dan silahkan coba kembali");
				header("location: $alamat&aksi=lihatgaleri&kodeproduk=$kodeproduk&produkid=$produkid&albumid&$albumid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	if($aksi=="editgambar")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		else
        {
			$albumid 	  = $_GET['albumid'];
			$mainmenu[]   = array("Kembali","back","$alamat&aksi=lihatgaleri&kodeproduk=$kodeproduk&produkid=$produkid");
			mainaction($mainmenu,$param);

			$sql = "select albumid,produkid from $nama_tabel1 where albumid='$albumid' and produkid='$produkid'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);

			$albumid      = $row['albumid'];
			$produkid     = $row['produkid'];
			$nama         = sql_get_var("select title from $nama_tabel3 where produkid='$produkid'");

			?>
            <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
			</script>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="saveeditgambar">
            <input type="hidden" name="albumid" value="<?php echo $albumid?>">
            <input type="hidden" name="produkid" value="<?php echo $produkid?>">
             <input type="hidden" name="nama" value="<?php echo $nama?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Gambar Produk</th>
				</tr>
				<tr>
					<td valign="top">Nama Produk</td>
					<td align="left"><input name="namas" value="<?php echo $nama?>" type="text" size="40" id="namas" readonly="readonly"  /></td>
				</tr>
                <tr>
					<td >Gambar Produk</td>
					<td><input name="gambar" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" /></td>
				</tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan" />
						<input type="button" onclick="javascript:window.location=('<?php echo $alamat?>')" value="Batal">
					</td>
				</tr>
			</table>
			</form>

            <?php
		}
	}

	//Tambah
	if($aksi=="tambahgambar")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$mainmenu[] = array("Kembali","back","$alamat&aksi=lihatgaleri&kodeproduk=$kodeproduk&produkid=$produkid");
			mainaction($mainmenu,$param);

			?>
            <script>
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
            </script>

			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambahgambar">
        	<input type="hidden" name="produkid" value="<?php echo $produkid?>">
        	<input type="hidden" name="kodeproduk" value="<?php echo $kodeproduk?>">
			<input type="hidden" name="title" value="<?php echo $title?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Gambar Produk</th>
				</tr>
                <tr>
					<td >Gambar Produk</td>
					<td><input name="gambar[]" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file"  multiple/><br />
                    <em>Gambar yang dimasukan harus memiliki lebar lebih dari 500px</em></td>
				</tr>
				<tr>
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Simpan Gambar" />
						<input type="button" onclick="javascript:history.back();" value="Batal">
					</td>
				</tr>
			</table>
			</form>

            <?php
		}
	}

	//SaveTambahGambar
	if($aksi=="savetambahgambar")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
        	$produkid = $_POST['produkid'];
        	$kodeproduk   = $_POST['kodeproduk'];
			$nama     = sql_get_var("select title from $nama_tabel3 where produkid='$produkid'");
			$alias    = getAlias($nama);

			//Upload Gambar
			$xx 	= count($_FILES['gambar']['tmp_name']);
			$files 	= $_FILES['gambar']['tmp_name'];
			$type 	= $_FILES['gambar']['type'];
			$size 	= $_FILES['gambar']['size'];

			if(!file_exists("$pathfile/produk/")) mkdir("$pathfile/produk/");

			for($ii=0; $ii<$xx; $ii++)
			{
				$new 	= newid("albumid",$nama_tabel1);
				$xname 	= "$files[$ii]";

				$imageinfo 	= getimagesize($xname);
				$imagewidth = $imageinfo[0];
				$imageheight= $imageinfo[1];
				$imagetype 	= $imageinfo[2];

				if($size[$ii]>0)
				{
					$jenis = $type[$ii];
					if(preg_match("/jp/i",$jenis)) $ext = "jpg";
					if(preg_match("/gif/i",$jenis)) $ext = "gif";
					if(preg_match("/png/i",$jenis)) $ext = "png";

						//full
						$namagambarf = "$alias-$produkid-$new-f.$ext";
						$gambarf 	 = resizeimg($xname,"$pathfile/produk/$produkpostid/$namagambarf",$imagewidth,$imageheight);

						//large
						$namagambarl = "$alias-$produkid-$new-l.$ext";
						$gambarl 	 = resizeimg($xname,"$pathfile/produk/$produkpostid/$namagambarl",$gambarl_maxw,$gambarl_maxh);

						//medium
						$namagambarm = "$alias-$produkid-$new-m.$ext";
						$gambarm 	 = resizeimg($xname,"$pathfile/produk/$produkpostid/$namagambarm",$gambarm_maxw,$gambarm_maxh);

						//small
						$namagambars = "$alias-$produkpostid-$new-s.$ext";
						$gambars 	 = resizeimg($xname,"$pathfile/produk/$produkpostid/$namagambars",$gambars_maxw,$gambars_maxh);

						if($gambars)
						{
							$fgambar = ",gambar_f,gambar_l,gambar_m,gambar_s";
							$vgambar = ",'$namagambarf','$namagambarl','$namagambarm','$namagambars'";

						}
						$perintah	= "insert into $nama_tabel1(albumid,produkpostid,produkid,create_date,create_userid $fgambar)
									values ('$new','$produkpostid','$produkid','$date','$cuserid' $vgambar)";
						$hasil		= sql($perintah);
				}
			}
			
			
			if($hasil)
			{
				$msg = base64_encode("Berhasil ditambahkan Data baru");
				header("location: $alamat&aksi=lihatgaleri&kodeproduk=$kodeproduk&produkid=$produkid&albumid=$albumid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=lihatgaleri&kodeproduk=$kodeproduk&produkid=$produkid&albumid&$albumid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}


	//=========================================KOMENTAR=========================================
	//View Komentar
	if($aksi == "viewkomen")
	{
		if(!$oto['view']) { echo $error['view']; }
		{
			$mainmenu[] = array("Lihat Produk","category","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Produk","tambah","$alamat&aksi=tambah");
			$mainmenu[] = array("Lihat Komentar","lihat","$alamat&aksi=viewkomen&produkid=$produkid");
			mainaction($mainmenu,$pageparam);

			$pageparam[] = array("produkid",$produkid);

			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("commentid","Komentar ID","int","text","$data");
			$cari[] = array("nama","Pengirim","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];

			//Orderring
			$order = getorder("commentid","asc",$pageparam);
			$parorder = $order[0];
			$urlorder = $order[1];

			$sql = "select count(*) as jml from $nama_tabel2 where 1 $where $parorder";
			$hsl = sql($sql);

			$tot = sql_result($hsl,0,'jml');
			$hlm_tot = ceil($tot / $judul_per_hlm);
			if (empty($hlm)){ $hlm = 1;	}
			if ($hlm > $hlm_tot){ $hlm = $hlm_tot;}
			$ord = ($hlm - 1) * $judul_per_hlm;
			if ($ord < 1) { $ord = 0 ; }

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);

			$sql = "select commentid,nama,email,komentar,ip,ip,update_date,published from $nama_tabel2 where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Item</th>\n");
			print("<th width=30%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Pengirim</a></th>\n");
			print("<th width=60%>Komentar</th>\n");
			print("<th width=5%><a href=\"$urlorder&order=published\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$commentid 	= $row['commentid'];
				$nama 		= $row['nama'];
				$email 		= $row['email'];
				$komentar 	= $row['komentar'];
				$ip 		= $row['ip'];
				$update_date= tanggal($row['update_date']);
				$published 	= $row['published'];

				if($published=="1") $publish ="publish";
				 else $publish ="draft";

				print("<tr class=\"row$i\"><td width=10% height=20 valign=top align=center>&nbsp;$a</td>
					<td width=10% height=20 valign=top><b>$nama</b><br>$email<br>$ip</td>
					<td  valign=top class=judul><i>$update_date</i><br>$komentar</td>
					<td  valign=top >$publish</td>\n");
				print("<td>");

				if($published==0) $acc[] = array("Publish","push","$alamat&aksi=publishkom&produkid=$produkid&commentid=$commentid&hlm=$hlm");
				else $acc[] = array("Unpublish","push","$alamat&aksi=publishkom&produkid=$produkid&commentid=$commentid&hlm=$hlm");

				$acc[] = array("Hapus","delete","$alamat&aksi=hapuskomen&produkid=$produkid&commentid=$commentid&hlm=$hlm");

				cmsaction($acc);
				unset($acc);

				print("</td></tr>");

				$i %= 2;
				$i++;
				$a++;
				$ord++;
			}
			print("</table><br clear='all'>");

			cmspage($tot,$hlm_tot,$judul_per_hlm,$param);
		}
	} //EndView

	//Publish Komentar
	if($aksi=="publishkom")
	{
		if(!$oto['edit']) { echo $error['edit']; }
		{
			$produkid = $_GET['produkid'];
			$commentid    = $_GET['commentid'];

			$perintah 	= "select published from $nama_tabel2 where produkid='$produkid' and commentid='$commentid'";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['published']=="0") $status = 1;
				else $status=0;

			$perintah 	= "update $nama_tabel2 set published='$status' where produkid='$produkid' and commentid='$commentid'";
			$hasil		= sql($perintah);

			if($hasil)
			{
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan perumabah data Status Komentar Produk dengan ID $commentid",$uri,$ip);
				$msg = base64_encode("Success merubah status data materi dengan ID $commentid");
				header("location: $alamat&aksi=viewkomen&produkid=$produkid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Gagal merubah status data materi dan silahkan coba kembali");
				header("location: $alamat&aksi=viewkomen&produkid=$produkid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}

	//Hapus Komentar
	if($aksi == "hapuskomen")
	{
		if(!$oto['delete']) { echo $error['delete']; }
		{
			$produkid = $_GET['produkid'];
			$commentid    = $_GET['commentid'];

			$perintah 	= "delete from $nama_tabel2 where produkid='$produkid' and commentid='$commentid'";
			$hasil 		= sql($perintah);

			if($hasil)
			{
				// setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan penghapusan data Komentar Produk dengan ID $commentid",$uri,$ip);
				$msg = base64_encode("Success menghapus Data Kota dengan Kota ID $commentid");
				header("location: $alamat&aksi=viewkomen&produkid=$produkid&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dihapus dan silahkan coba kembali");
				header("location: $alamat&aksi=viewkomen&produkid=$produkid&hlm=$hlm&error=$error");
				exit();
			}
		}
	}
}
?>