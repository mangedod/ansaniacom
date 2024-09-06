<?php 
//Variable halaman ini
$nama_tabel		= "tbl_voucher";
$nama_tabel1	= "tbl_voucher_kode";
$judul_per_hlm 	= 25;
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];

//Variable Umum
if(isset($_POST['id'])) $id = $_POST['id'];
 else $id = $_GET['voucherid'];
if(isset($_POST['secid'])) $secid = $_POST['secid'];
 else $secid = $_GET['secid']; 

if(!$oto['oto']) { echo $error['oto']; }
else
{
	//Vie Content
	if($aksi=="view")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Data","lihat","$alamat&aksi=view");
			$mainmenu[] = array("Tambah Data","tambah","$alamat&aksi=tambah");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("nama","Nama Voucher","str","text","$data");
			$cari[] = array("nilaibelanja","Nilai Belanja","str","text","$data");
			
			$dataselect[] = array("0","Draft");
			$dataselect[] = array("1","Published");
			
			$cari[] = array("published","Status","select","select",$dataselect);

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("id","desc",$pageparam,$param);
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
			
			$sql = "select id,nama,jenis,jumlah,tglawal,tglakhir,published,untuk,kategori,produkpostid,ketentuan,nominal1,nominal2,maxuser,qty,used from $nama_tabel where 1 $where 
					$parorder limit $ord, $judul_per_hlm";//tipe
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=5%>Nomor</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Nama Voucher</a></th>\n");
			print("<th width=20%>Ketentuan</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=tglakhir\" title=\"Urutkan\">Berlaku untuk</a></th>\n");
			print("<th width=10%>Jumlah Voucher <br>(Belum dipakai)</th>\n");
			print("<th width=10%>Voucher yang sudah digunakan</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=published\" title=\"Urutkan\">Status</a></th>\n");
			print("<th width=5% align=center><b>Action</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$id 			= $row['id'];
				$nama			= $row['nama'];
				$jenis			= $row['jenis'];
				$jumlah			= $row['jumlah'];
				$tglawal		= tanggalvalid($row['tglawal']);
				$tglakhir		= tanggalvalid($row['tglakhir']);
				$published		= $row['published'];
				$untuk			= $row['untuk'];
				$kategori		= $row['kategori'];
				$produkpostid	= $row['produkpostid'];
				$ketentuan		= $row['ketentuan'];
				$nominal1		= $row['nominal1'];
				$nominal2		= $row['nominal2'];
				$maxuser		= $row['maxuser'];
				$used			= $row['used'];

				$jumlah_voucher	= sql_get_var("select count(*) from $nama_tabel1 where voucherid='$id'");
				$qty 			= $jumlah_voucher - $used;
				
				if($published=="1") $publish ="publish";
				 else $publish ="draft";
				 
				if($jenis == "persen")
					$jumlah	= $jumlah." %";
				elseif($jenis == "nominal")
					$jumlah	= "Rp. ".number_format($jumlah,0,".",".");
					
				if($untuk=="all") $berlaku = "All Items";
				elseif($untuk=="kategori") 
				{
					$namakategori	= sql_get_var("select namasec from tbl_product_sec where secid='$kategori'");
					$berlaku 		= "Kategori Produk <strong>$namakategori</strong>";
				}
				elseif($untuk=="produk") 
				{
					$namaproduk		= sql_get_var("select title from tbl_product_post where produkpostid='$produkpostid'");
					$berlaku 		= "Produk <strong>$namaproduk</strong>";
				}
				
				if($ketentuan=="all") $ketentuan2 = "Semua Nominal Pembelian";
				elseif($ketentuan=="lebih dari")
				{
					$ketentuan2 = "Pembelian lebih dari ".number_format($nominal1,0,".",".");
				}
				
					
				//$pengguna = sql_get_var("select count(*) as pengguna from tbl_transaksi where kode_voucher='$kode' and status='3'");
				
				if($pengguna > 0)
					$pengguna	= "$pengguna";//<a href=\"$alamat&aksi=pengguna&id=$id&hlm=$hlm\"></a>
				elseif($jenis == "nominal")
					$pengguna	= $pengguna;
				
				print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul><a href='$alamat&aksi=detail&voucherid=$id'><strong>$nama</strong></a></td>\n
					<td  valign=top class=judul>$ketentuan2</td>\n
					<td  valign=top class=judul>$berlaku</td>\n
					<td  valign=top class=judul align=center>$qty</td>\n
					<td  valign=top class=judul align=center>$used</td>\n
					<td  valign=top >$publish</td>");//<br /><strong>Diskon : </strong> $jumlah
					
				print("<td>");
				
				if($published==0) $acc[] = array("Publish","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				else $acc[] = array("Unpublish","push","$alamat&aksi=publish&id=$id&hlm=$hlm");
				
				
				if($used < 1)
				{
					$acc[] = array("Edit","edit","$alamat&aksi=edit&id=$id&hlm=$hlm");
					$acc[] = array("Hapus","delete","$alamat&aksi=hapus&id=$id&hlm=$hlm");
				}
								
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
	

	//Vie Content
	if($aksi=="detail")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$pageparam[] = array("voucherid",$id);
			$namavoucher = sql_get_var("select nama from $nama_tabel where id='$id'");
			
			$mainmenu[] = array("Lihat Voucher","lihat","$alamat&aksi=view");
			mainaction($mainmenu,$pageparam);
			
			//Search Paramater Fungsi namafield,Label,
			$cari[] = array("kodevoucher","Kode Voucher","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
			
			//Orderring
			$order = getorder("vouchercodeid","asc",$pageparam,$param);
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
			
			$sql = "select `vouchercodeid`,`voucherid`,`kodevoucher`,`status`, dikirim from $nama_tabel1 where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=2%>No</th>\n");
			print("<th width=20%><a href=\"$urlorder&order=kodevoucher\" title=\"Urutkan\">Kode Voucher</a></th>\n");
			print("<th width=30%>Nilai Voucher</th>\n");
			print("<th width=20%>Expired Date</th>\n");
			print("<th width=8% align=center><b>Hapus</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$vouchercodeid 	= $row['vouchercodeid'];
				$voucherid 		= $row['voucherid'];
				$kodevoucher  	= $row['kodevoucher'];
				$memberid    	= $row['memberid'];
				$usedate      	= $row['usedate'];
				$is_status      = $row['status'];
				$is_dikirim      = $row['dikirim'];
				
				$sqlkat = "select id,jenis,jumlah,tglawal,tglakhir from $nama_tabel where id='$voucherid'";
				$hslkat = sql($sqlkat);
				$datakat = sql_fetch_data($hslkat);

				$jenis			= $datakat['jenis'];
				$jumlah			= $datakat['jumlah'];
				$tglawal		= tanggalvalid($datakat['tglawal']);
				$tglakhir		= tanggalvalid($datakat['tglakhir']);

				if($jenis == "persen")
					$jumlah	= $jumlah." %";
				elseif($jenis == "nominal")
					$jumlah	= "Rp. ".number_format($jumlah,0,".",".");

				if ($is_status==0) {
					// $statusvoc = "Voucher Belum Digunakan";
					$statusvoc = "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">
									Belum Terpakai
		                          </div>";
				}else{
					// $statusvoc = "Voucher Sudah Digunakan";
					$statusvoc = "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">
									Terpakai
		                          </div>";
				}
				
				print("<tr class=\"row$i\"><td width=5% height=50 valign=top>&nbsp;$a</td>
					<td  valign=top class=judul align=center><span class=\"barcode\">$kodevoucher</span></td>\n
					<td  valign=top >$jumlah</td>
					<td  valign=top >$tglawal ~ $tglakhir</td>
					<td  valign=top align=center>$statusvoc</td>");
				/*print("<td  valign=top align=center>");
				if(($is_status == 0) and ($is_dikirim == 0))
				print("<a href=\"$alamat&aksi=hapuscode&id=$id&vouchercodeid=$vouchercodeid&hlm=$hlm\"><img src='template/images/delete.png' /></a>");
				
				print("</td>");*/
					
				/*print("<td>");
				
				$acc[] = array("Hapus","delete","$alamat&aksi=hapuscode&id=$id&vouchercodeid=$vouchercodeid&hlm=$hlm");
				print("</td>");*/
								
				// cmsaction($acc);
				unset($acc);
				
				print("</tr>");

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
			$id = $_GET['id'];

			$perintah = "delete from $nama_tabel1 where voucherid='$id'";
			$hasil = sql($perintah);

			$perintah = "delete from $nama_tabel where id='$id'";
			$hasil = sql($perintah);

			if($hasil)
			{  
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Penghapusan data Voucher dengan ID $id",$uri,$ip); 
				$msg = base64_encode("Success mengapus menu dengan Data dengan ID $id");
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

	//Hapus
	if($aksi=="hapuscode")
	{
		if(!$oto['delete']) { echo $error['delete']; }
		else
        {
			$id 			= $_GET['id'];
			$vouchercodeid	= $_GET['vouchercodeid'];

			$perintah 	= "delete from $nama_tabel1 where voucherid='$id' and vouchercodeid='$vouchercodeid'";
			$hasil 		= sql($perintah);

			if($hasil)
			{   
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Penghapusan data Code Voucher dengan ID $vouchercodeid",$uri,$ip);
				$msg = base64_encode("Success mengapus menu dengan Data dengan ID $vouchercodeid");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
				header("location: $alamat&aksi=detail&id=$id&hlm=$hlm&error=$error");
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
			$id = $_GET['id'];
			
			$perintah 	= "select published from $nama_tabel where id='$id' ";
			$hasil 		= sql($perintah);
			$data 		= sql_fetch_data($hasil);

			if($data['published']=="0") $status = 1;
				else $status=0;
				
			$perintah 	= "update $nama_tabel set published='$status' where id='$id' ";
			$hasil		= sql($perintah);
		
			if($hasil)
			{
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Perubahan data Status Voucher dengan ID $id",$uri,$ip);   
				$msg = base64_encode("Success merubah status data dengan ID $id");
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


	//SaveTambah
	if($aksi=="savetambah")
	{
		if(!$oto['add']) { echo $error['add']; }
		else
        {
			$nama			= cleaninsert($_POST['nama']);
			$alias			= getAlias($nama);
			$jenis			= cleaninsert($_POST['jenis']);
			$jumlah			= cleaninsert($_POST['jumlah']);
			$tglawal		= cleaninsert($_POST['tglawal']);
			$tglakhir		= cleaninsert($_POST['tglakhir']);
			$untuk			= cleaninsert($_POST['untuk']);
			$produkpostid	= cleaninsert($_POST['produkpostid']);
			$kategori		= cleaninsert($_POST['secid']);
			$ketentuan		= cleaninsert($_POST['ketentuan']);
			$brandid		= cleaninsert($_POST['brandid']);
			$qty			= cleaninsert($_POST['qty']);
			$jeniskode		= cleaninsert($_POST['jeniskode']);
			$kodevoucher	= cleaninsert($_POST['kodevoucher']);
			
			if($_POST['nominal3']!="") $nominal1 = cleaninsert($_POST['nominal3']);	
			else $nominal1 = cleaninsert($_POST['nominal1']);	
			
			$nominal2		= cleaninsert($_POST['nominal2']);
			$maxuser		= cleaninsert($_POST['maxuser']);			

			$new = newid("id",$nama_tabel);
				
			$perintah 	= "INSERT INTO $nama_tabel (id,nama,jenis,jumlah,tglawal,tglakhir,untuk,brandid,produkpostid,kategori,ketentuan,nominal1,nominal2,maxuser,qty,
						create_date,create_userid,jeniskode) 
						VALUES ('$new','$nama','$jenis','$jumlah','$tglawal','$tglakhir','$untuk','$brandid','$produkpostid','$kategori','$ketentuan','$nominal1',
						'$nominal2','$maxuser','$qty','$date','$cuserid','$jeniskode')";
			// die($perintah);
			$hasil 		= sql($perintah);
			
			if($hasil)
			{ 
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Penambahan data Voucher dengan ID $new",$uri,$ip);  
				for($v=1; $v<=$qty; $v++)
				{
					$newid      = newid("vouchercodeid","$nama_tabel1");
					
					if($jeniskode == '1')
						$kodevoucher= $kodevoucher;
					else
						$kodevoucher= generateCode(6);
						
					
					/*$uniquekey  = md5($salt . $newid);
					$kodevoucher = strtoupper(substr($uniquekey, 0, 13));*/
		
					$perintah1 	= "insert into $nama_tabel1 (vouchercodeid,voucherid,kodevoucher,create_date,create_userid,status) 
								values ('$newid','$new','$kodevoucher','$date','$cuserid','0')";
								// die($perintah1);
					$hasil1 	= sql($perintah1);
				}

				$msg = base64_encode("Berhasil ditambahkan Data baru");
				header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
				exit();
			}
			else
			{
				$error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
				header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
				exit();
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
			
			?>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				$(function() {
						$( "#tglawal" ).datepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
						  buttonImageOnly: true
						});
						$( "#tglakhir" ).datepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
						  buttonImageOnly: true
						});

				});
				function popsecid(var1,var2)
				{
					sList = window.open("index.php?pop=1&kanal=produk-kategori&aksi=popsecid&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbar=1");
				}
				function popprodukpostid(var1,var2)
				{
					sList = window.open("index.php?pop=1&kanal=voucher&aksi=popprodukpostid&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbar=1");
				}
				function getVoucher(data)
				{
					if(data=="kategori")
					{
						$('.tr').show();
						$('.view').hide();
					}
					else if(data=="produk")
					{
						$('.tr').hide();
						$('.view').show();
					}
					else
					{
						$('.tr').hide();
						$('.view').hide();
					}
				};
				function getKetentuan(data)
				{
					if(data=="all")
					{
						$('.ket1').hide();
						$('.ket2').hide();
					}
					else if(data=="kurang dari")
					{
						$('.ket1').show();
						$('.ket2').hide();
					}
					else if(data=="lebih dari")
					{
						$('.ket1').show();
						$('.ket2').hide();
					}
					else if(data=="antara")
					{
						$('.ket1').hide();
						$('.ket2').show();
					}
					else
					{
						$('.ket1').hide();
						$('.ket2').hide();
					}
				};
				function getUnik(data)
				{
					if(data=="1")
					{
						$('.unik').show();
					}
					else if(data=="0")
					{
						$('.unik').hide();
					}
					else
					{
						$('.unik').hide();
					}
				};
			</script>
		  	<style>
				.tr{ display:none;}
				.view{ display:none;}
				.ket1{ display:none;}
				.ket2{ display:none;}
				.unik{ display:none;}
				.detail { float:left; width:100%; margin-bottom:5px; background-color:#fcdcdc; padding:5px;}
				.details { float:left; width:100%; margin-bottom:5px; background-color:#f7f6f6; padding:5px;}
				.label-detail { float:left; width:130px; font-weight:bold; }
				.buttons { float:left; border:1px #cccccc solid; padding:5px 10px;}
				.header-tabel { float:left; background-color:#f1f1f1; overflow:hidden; padding:5px 0; text-align:center; font-weight:bold; margin-right:1px; margin-bottom:1px; }
				.isi-tabel-0 { float:left; background-color:#f7f6f6; overflow:hidden; padding:5px 0; text-align:center; margin-right:1px; margin-bottom:1px; }
				.isi-tabel-1 { float:left; background-color:#fcdcdc; overflow:hidden; padding:5px 0; text-align:center; margin-right:1px; margin-bottom:1px; }
				.header-tabel-dark { float:left; background-color:#e8e8e8; overflow:hidden; padding:5px 0; text-align:center; font-weight:bold; margin-right:1px; }
				.shipping { display:none; }
            </style>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
            <input type="hidden" name="jenis" value="nominal">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Tambah Voucher</th>
				</tr>
				<tr> 
					<td width="15%">Nama Voucher</td>
					<td ><input name="nama" type="text" size="70" value="" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Nilai Voucher</td>
					<td ><input name="jumlah" type="text" size="70" value="" id="jumlah" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Berlaku untuk</td>
					<td><select name="untuk" onchange="getVoucher(this.value)">
                        	<option value="">Pilih</option>
                            <option value="all">Semua Produk</option>
                            <option value="kategori">Kategori Tertentu</option>
                            <option value="produk">Produk Pilihan</option>
                        </select></td>
				</tr>
                <tr class="tr">
					<td>Kategori</td>
                	<td><input name="secid" type="hidden" size="20" value="" id="secid" />
                    <input name="secid_text" type="text" size="20" value="" id="secid_text" placeholder="Pilih Kategori" class="validate[required]" /> 
                    <a href="#" class="apop" onclick="popsecid('secid','secid_text')">..</a><br clear="all"/>
                    </td>
                </tr>
                <tr class="view">
					<td>Pilih Produk</td>
                	<td><input name="produkpostid" type="hidden" size="20" value="" id="produkpostid" />
                    <input name="produkpostid_text" type="text" size="20" value="" id="produkpostid_text" placeholder="Pilih Produk" class="validate[required]" /> 
                    <a href="#" class="apop" onclick="popprodukpostid('produkpostid','produkpostid_text')">..</a><br clear="all"/>
                    </td>
                </tr>
                <tr> 
					<td>Ketentuan Diskon</td>
					<td><select name="ketentuan" onchange="getKetentuan(this.value)">
                        	<option value="">Pilih</option>
                            <option value="all">Semua Jumlah Pembelian</option>
                            <option value="lebih dari">Lebih Dari</option>
                        </select></td>
				</tr>
                <tr class="ket1">
					<td>Nominal</td>
                	<td><input name="nominal1" type="text" size="20" value="" id="nominal1" class="validate[required]" /></td>
                </tr>
                <tr> 
					<td >Tanggal Awal Berlaku</td>
					<td ><input name="tglawal" type="text" size="20" value="" id="tglawal" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Tanggal Akhir Berlaku</td>
					<td ><input name="tglakhir" type="text" size="20" value="" id="tglakhir" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Kuantitas</td>
					<td ><input name="qty" type="text" size="5" value="" id="qty" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Jenis Kode Voucher</td>
					<td ><input name="jeniskode" type="radio" size="5" value="0" id="jeniskode" class="validate[required]" onclick="getUnik(this.value)" checked="checked" /> Unique 
                    	<input name="jeniskode" type="radio" size="5" value="1" id="jeniskode" class="validate[required]" onclick="getUnik(this.value)" /> Tidak Unique 
                    </td>
				</tr>
                <tr class="unik">
					<td>Kode Voucher</td>
                	<td><input name="kodevoucher" type="text" size="20" value="" id="kodevoucher" class="validate[required]" /></td>
                </tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
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
			$id 			= $_POST['id'];
			$nama			= cleaninsert($_POST['nama']);
			$alias			= getAlias($nama);
			$kode			= generateCode(6);
			$jenis			= cleaninsert($_POST['jenis']);
			$jumlah			= cleaninsert($_POST['jumlah']);
			$tglawal		= cleaninsert($_POST['tglawal']);
			$tglakhir		= cleaninsert($_POST['tglakhir']);
			$untuk			= cleaninsert($_POST['untuk']);
			$produkpostid	= cleaninsert($_POST['produkpostid']);
			$kategori		= cleaninsert($_POST['secid']);
			$ketentuan		= cleaninsert($_POST['ketentuan']);
			$brandid		= cleaninsert($_POST['brandid']);
			$qty 			= cleaninsert($_POST['qty']);
			
			if($_POST['nominal3']!="") $nominal1 = cleaninsert($_POST['nominal3']);	
			else $nominal1 = cleaninsert($_POST['nominal1']);	
			
			$nominal2		= cleaninsert($_POST['nominal2']);
			$maxuser		= cleaninsert($_POST['maxuser']);			
			
			$perintah = "update $nama_tabel set nama='$nama',jenis='$jenis',jumlah='$jumlah',tglawal='$tglawal',tglakhir='$tglakhir',untuk='$untuk',brandid='$brandid',
						produkpostid='$produkpostid',kategori='$kategori',ketentuan='$ketentuan',nominal1='$nominal1',nominal2='$nominal2',maxuser='$maxuser',
						qty='$qty',update_date='$date',update_userid='$cuserid' where id='$id'";
			$hasil = sql($perintah);

			if($hasil)
			{ 
				setlog($_SESSION['cms_userid'],"$_SESSION[cms_userfullname] melakukan Penghapusan data Tipe Belanja dengan ID $id",$uri,$ip);  
				$msg = base64_encode("Berhasil mengubah data dengan ID $id");
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
			$id = $_GET['id'];
			$mainmenu[] = array("Kembali","back","$alamat&aksi=view");
			mainaction($mainmenu,$param);
			
			$sql = "select id,nama,kode,jenis,jumlah,tglawal,tglakhir,ketentuan,untuk,kategori,produkpostid,nominal1,nominal2,maxuser,brandid,qty from $nama_tabel  where id='$id'";
			$hsl = sql($sql);
			$row = sql_fetch_data($hsl);
			
			$kategori 		= $row['kategori'];
			$produkpostid 	= $row['produkpostid'];
			$brandids 		= $row['brandid'];
	
			$nama			= $row['nama'];
			$kode			= $row['kode'];
			$jenis			= $row['jenis'];
			$jumlah			= $row['jumlah'];
			$untuk			= $row['untuk'];
			$ketentuan		= $row['ketentuan'];
			$nominal1		= $row['nominal1'];
			$nominal2		= $row['nominal2'];
			$maxuser		= $row['maxuser'];
			$tglawal		= $row['tglawal'];
			$tglakhir		= $row['tglakhir'];
			$qty      		= $row['qty'];
			
			$kategori_text		= sql_get_var("select namasec from tbl_product_sec where secid='$kategori'");
			$produkpostid_text 	= sql_get_var("select title from tbl_product_post where produkpostid='$produkpostid'");
			
			?>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script>	
				$(document).ready(function() {
					$("#menufrm").validationEngine()
				});
				$(function() {
						$( "#tglawal" ).datepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
						  buttonImageOnly: true
						});
						$( "#tglakhir" ).datepicker({
						  showOn: "button",
						  buttonImage: "template/images/calendar.gif",
						  buttonImageOnly: true
						});

				});
				function popsecid(var1,var2)
				{
					sList = window.open("index.php?pop=1&kanal=produk-kategori&aksi=popsecid&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbar=1");
				}
				function popprodukpostid(var1,var2)
				{
					sList = window.open("index.php?pop=1&kanal=voucher&aksi=popprodukpostid&var1="+var1+"&var2="+var2+"", "list", "width=800,height=500,top=60,left=60,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbar=1");
				}
				function getVoucher(data)
				{
					if(data=="kategori")
					{
						$('.tr').show();
						$('.view').hide();
					}
					else if(data=="produk")
					{
						$('.tr').hide();
						$('.view').show();
					}
					else
					{
						$('.tr').hide();
						$('.view').hide();
					}
				};
				function getKetentuan(data)
				{
					if(data=="all")
					{
						$('.ket1').hide();
						$('.ket2').hide();
					}
					else if(data=="kurang dari")
					{
						$('.ket1').show();
						$('.ket2').hide();
					}
					else if(data=="lebih dari")
					{
						$('.ket1').show();
						$('.ket2').hide();
					}
					else if(data=="antara")
					{
						$('.ket1').hide();
						$('.ket2').show();
					}
					else
					{
						$('.ket1').hide();
						$('.ket2').hide();
					}
				};
			</script>
		  	<style>
				.tr{ display:none;}
				.view{ display:none;}
				.ket1{ display:none;}
				.ket2{ display:none;}
				.detail { float:left; width:100%; margin-bottom:5px; background-color:#fcdcdc; padding:5px;}
				.details { float:left; width:100%; margin-bottom:5px; background-color:#f7f6f6; padding:5px;}
				.label-detail { float:left; width:130px; font-weight:bold; }
				.buttons { float:left; border:1px #cccccc solid; padding:5px 10px;}
				.header-tabel { float:left; background-color:#f1f1f1; overflow:hidden; padding:5px 0; text-align:center; font-weight:bold; margin-right:1px; margin-bottom:1px; }
				.isi-tabel-0 { float:left; background-color:#f7f6f6; overflow:hidden; padding:5px 0; text-align:center; margin-right:1px; margin-bottom:1px; }
				.isi-tabel-1 { float:left; background-color:#fcdcdc; overflow:hidden; padding:5px 0; text-align:center; margin-right:1px; margin-bottom:1px; }
				.header-tabel-dark { float:left; background-color:#e8e8e8; overflow:hidden; padding:5px 0; text-align:center; font-weight:bold; margin-right:1px; }
				.shipping { display:none; }
            </style>
			<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
            <input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id?>">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Edit Voucher</th>
				</tr>
				<tr> 
					<td width="15%">Nama Voucher</td>
					<td ><input name="nama" type="text" size="70" value="<?php echo $nama?>" id="nama" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Jenis Voucher</td>
					<td ><select name="jenis" class="validate[required]">
                        	<option value="">Pilih Jenis Voucher</option>
                            <option value="persen" <?php if($jenis=="persen") echo "selected"; ?>>Persentase</option>
                            <option value="nominal" <?php if($jenis=="nominal") echo "selected"; ?>>Nominal</option>
                        </select></td>
				</tr>
                <tr> 
					<td >Nilai Voucher</td>
					<td ><input name="jumlah" type="text" size="70" value="<?php echo $jumlah?>" id="jumlah" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td>Berlaku untuk</td>
					<td><select name="untuk" onchange="getVoucher(this.value)">
                        	<option value="">Pilih</option>
                            <option value="all" <?php if($untuk=="all") echo "selected"; ?>>Semua Produk</option>
                            <option value="kategori" <?php if($untuk=="kategori") echo "selected"; ?>>Kategori Tertentu</option>
                            <option value="produk" <?php if($untuk=="produk") echo "selected"; ?>>Produk Pilihan</option>
                        </select></td>
				</tr>
                <tr class='tr' <?php if($untuk=="kategori"){ ?> style="display:table-row"<?php } ?>>
					<td>Kategori</td>
                	<td><input name="secid" type="hidden" size="20" value="<?php echo $kategori?>" id="secid" />
                    <input name="secid_text" type="text" size="20" value="<?php echo $kategori_text?>" id="secid_text" class="validate[required]" /> 
                    <a href="#" class="apop" onclick="popsecid('secid','secid_text')">..</a><br clear="all"/>
                    </td>
                </tr>
                <tr class='view'>
					<td>Pilih Produk</td>
                	<td><input name="produkpostid" type="hidden" size="20" value="<?php echo $produkpostid?>" id="produkpostid" />
                    <input name="produkpostid_text" type="text" size="20" value="<?php echo $produkpostid_text?>" id="produkpostid_text" class="validate[required]" /> 
                    <a href="#" class="apop" onclick="popprodukpostid('produkpostid','produkpostid_text')">..</a><br clear="all"/>
                    </td>
                </tr>
                <tr> 
					<td>Ketentuan Diskon</td>
					<td><select name="ketentuan" onchange="getKetentuan(this.value)">
                        	<option value="">Pilih</option>
                            <option value="all" <?php if($ketentuan=="all") echo "selected"; ?>>Semua Jumlah Pembelian</option>
                            <option value="lebih dari" <?php if($ketentuan=="lebih dari") echo "selected"; ?>>Lebih Dari</option>
                        </select></td>
				</tr>
                <tr class='ket1'>
					<td>Nominal</td>
                	<td><input name="nominal1" type="text" size="20" value="<?php echo $nominal1?>" id="nominal1" class="validate[required]" /></td>
                </tr>
                <tr> 
					<td >Tanggal Awal Berlaku</td>
					<td ><input name="tglawal" type="text" size="20" value="<?php echo $tglawal?>" id="tglawal" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td >Tanggal Akhir Berlaku</td>
					<td ><input name="tglakhir" type="text" size="20" value="<?php echo $tglakhir?>" id="tglakhir" class="validate[required]" /></td>
				</tr>
                <tr> 
					<td width="15%">Kuantitas</td>
					<td ><input name="qty" type="text" size="5" value="<?php echo $qty?>" id="qty" class="validate[required]" /></td>
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
	
	//Vie Menu
	if($aksi=="popprodukpostid")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$var1    = $_GET['var1'];
			$var2    = $_GET['var2'];
			
			if(empty($var1) && empty($var2))
			{
				$var1 = "produkpostid";
				$var2 = "produkpostid_text";
			}
			?>
            	<script type="text/javascript">
				function pushdataa(produkpostid,nama)
				{
					 if (window.opener && !window.opener.closed)
					 {
					 	window.opener.$("#<?php echo $var1; ?>").val(produkpostid);
						window.opener.$("#<?php echo $var2; ?>").val(nama);
					 } 
					  window.close();
                    return false;
				} 
				</script>
            <?php 
            //Search Paramater Fungsi namafield,Label,
			$cari[] = array("title","Nama Product","str","text","$data");

			$formcari = cmsformcari($cari,$pageparam);
			
			$where = $formcari[0]['where'];
			$param = $formcari[0]['param'];
				
			$sql = "select count(*) as jml from tbl_product_post where 1 $where";
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
			
			$sql = "select title,produkpostid from tbl_product_post  where 1 $where $parorder limit $ord, $judul_per_hlm";
			$hsl = sql($sql);
			$i = 1;
			$a = 1;
			
			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=10%>Nomor</th>\n");
			print("<th width=10%><a href=\"$urlorder&order=secid\" title=\"Urutkan\">Produk ID</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=title\" title=\"Urutkan\">Nama Produk</a></th>\n");
			print("");
			print("<th width=10% align=center><b>Select</b></th></tr></thead>");

			while ($row = sql_fetch_data($hsl))
			{
				$nama         = $row['title'];
				$produkpostid = $row['produkpostid'];
				
				print("<tr class=\"row$i\"><td width=10% height=20 valign=top>&nbsp;$a</td>
					<td width=10% height=20 valign=top>&nbsp;<b>$produkpostid</b></td>
					<td  valign=top class=judul>$nama</td>\n");
				print("<td><button class=\"btn dropdown-toggle\" onclick=\"pushdataa('$produkpostid','$nama');\">Select</button>");
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
}

?>