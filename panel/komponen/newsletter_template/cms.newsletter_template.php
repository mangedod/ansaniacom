<?php
//Variable halaman ini
$nama_tabel = "tbl_newsletter_template";
$judul_per_hlm = 25;
$otoritas = kodeoto($kanal);
$oto = $otoritas[0];
$gambars_maxw = 350;
$gambars_maxh = 300;
$gambarl_maxw = 800;
$gambarl_maxh = 600;


//Variable Umum
if (isset($_POST['id']))
    $id = $_POST['id'];
else
    $id = $_GET['id'];
if (isset($_POST['secid']))
    $secid = $_POST['secid'];
else
    $secid = $_GET['secid'];

if (!$oto['oto']) {
    echo $error['oto'];
} else {
    //Vie Content
    if ($aksi == "view") {
        if (!$oto['view']) {
            echo $error['view'];
        } else {
            $mainmenu[] = array("Lihat Template", "lihat", "$alamat&aksi=view");
            $mainmenu[] = array("Tambah Template", "tambah", "$alamat&aksi=tambah");
            mainaction($mainmenu, $pageparam);

            //Search Paramater Fungsi namafield,Label,
            $cari[] = array("templatename", "Template Name", "str", "text", "$data");


            $sql = "select templateid,templatename from $nama_tabel  order by templatename asc";
            $hsl = sql($sql);
            while ($data = sql_fetch_data($hsl)) {
                $secid1 = $data['templateid'];
                $namasec = $data['templatename'];
                $katselect[] = array("$secid1", "$namasec");
            }
            sql_free_result($hsl);

            $formcari = cmsformcari($cari, $pageparam);
            $where = $formcari[0]['where'];
            $param = $formcari[0]['param'];

            //Orderring
            $order = getorder("templateid", "desc", $pageparam, $param);
            $parorder = $order[0];
            $urlorder = $order[1];


            $sql = "select count(*) as jml from $nama_tabel where 1 $where $parorder";
            $hsl = sql($sql);

            $tot = sql_result($hsl, 0,'jml');
            $hlm_tot = ceil($tot / $judul_per_hlm);
            if (empty($hlm)) {
                $hlm = 1;
            }
            if ($hlm > $hlm_tot) {
                $hlm = $hlm_tot;
            }
            $ord = ($hlm - 1) * $judul_per_hlm;
            if ($ord < 1) {
                $ord = 0;
            }

            cmspage($tot, $hlm_tot, $judul_per_hlm, $param);

            $sql = "select templateid,templatename,create_date,image from $nama_tabel where 1 $where order by templateid desc limit $ord, $judul_per_hlm";
            $hsl = sql($sql);
            $i = 1;
            $a = 1;

            print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
            print("<tr><th width=5%>Nomor</th>\n");
            print("<th width=5%><a href=\"$urlorder&order=id\" title=\"Urutkan\">ID</a></th>\n");
            print("<th width=70%><a href=\"$urlorder&order=nama\" title=\"Urutkan\">Template Name</a></th>\n");
            print("<th width=10%><a href=\"$urlorder&order=secid\" title=\"Urutkan\">Image</a></th>\n");
            print("<th width=5% align=center><b>Action</b></th></tr></thead>");

            while ($row = sql_fetch_data($hsl)) {
                $id = $row['templateid'];
                $nama = $row['templatename'];
                $image = $row['image'];

                if (empty($image))
                    $image = "Masih kosong";
                else
                    $image = "<img src=\"../gambar/$kanal/$image\" style=\"width:200px\" alt=\"\" />";

                print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td width=5% height=20 valign=top>&nbsp;<b>$id</b></td>
					<td  valign=top >$nama</td>
					<td  valign=top >$image</td>");

                print("<td>");

                $acc[] = array("Detail", "detail", "$alamat&aksi=detail&id=$id");
                $acc[] = array("Edit", "edit", "$alamat&aksi=edit&id=$id");
                $acc[] = array("Hapus", "delete", "$alamat&aksi=hapus&id=$id");

                cmsaction($acc);
                unset($acc);

                print("</td></tr>");

                $i %= 2;
                $i++;
                $a++;
                $ord++;
            }
            print("</table><br clear='all'>");

            cmspage($tot, $hlm_tot, $judul_per_hlm, $param);
        }
    } //EndView 
    
	//Detail
    if ($aksi == "detail") {
        if (!$oto['view']) {
            echo $error['view'];
        } else {
            $id = $_GET['id'];
            $mainmenu[] = array("Kembali", "back", "$alamat&aksi=view");
            mainaction($mainmenu, $param);

            $sql	= "select templateid,subject,plainmail,htmlmail,templatename from $nama_tabel where templateid='$id'";
			$query	= sql($sql);
			$row = sql_fetch_data($query);
			
			$templatename		= $row['templatename'];
			$subject		= $row['subject'];
			$plainmail		= stripslashes($row['plainmail']);
			$htmlmail		= stripslashes($row['htmlmail']);
				
            ?>
            <form method="post" name="menufrm" id="menufrm">
                <input type="hidden" name="aksi" value="saveedit">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <table border="0" class="tabel-cms" width="100%">
                    <tr>
                        <th colspan="2">Detail</th>
                    </tr>
                    <tr> 
                        <td valign="top" width="20%" class="tdinfo">Template Name</td> 
                        <td align="left"><?php echo $templatename ?></td>
                    </tr>
                    <tr> 
                        <td valign="top" width="20%" class="tdinfo">Subject</td> 
                        <td align="left"><?php echo $subject ?></td>
                    </tr>
                    <tr> 
                        <td  class="tdinfo">Plain Newsletter</td>
                        <td ><?php echo $plainmail ?></td>
                    </tr>
                    <tr> 
                        <td class="tdinfo" >HTML Newsletter</td>
                        <td ><iframe width="100%" height="700" style="border:1px solid #CCCCCC" src="<?php= ('../komponen/newsletter/preview.php?id='.$id) ?>"></iframe></td>
                    </tr>
                </table>
            </form>

            <?php
        }
    }
    
    //previewhtml
    if ($aksi == "previewhtml") {
        if (!$oto['view']) {
            echo $error['view'];
        } else {
            $id = $_GET['id'];
            $mainmenu[] = array("Kembali", "back", "$alamat&aksi=view");
            mainaction($mainmenu, $param);

            $sql	= "select templateid,subject,plainmail,htmlmail,templatename from $nama_tabel where templateid='$id'";
			$query	= sql($sql);
			$row = sql_fetch_data($query);
			
			$templatename		= $row['templatename'];
			$subject		= $row['subject'];
			$plainmail		= stripslashes($row['plainmail']);
			$htmlmail		= stripslashes($row['htmlmail']);
        
        echo $htmlmail;
}
    }
    //Hapus
    if ($aksi == "hapus") {

        if (!$oto['delete']) {
            echo $error['delete'];
        } else {

            $id = $_GET['id'];
            $perintah = "select image from $nama_tabel where templateid='$id'";
            $hasil = sql($perintah);
            $row = sql_fetch_data($hasil);

            $gambar = $row['image'];

            if (!empty($gambar))    unlink("$pathfile$kanal/$gambar");

            $perintah = "delete from $nama_tabel where templateid='$id'";
            $hasil = sql($perintah);
			
            if ($hasil) {
                $msg = base64_encode("Success mengapus menu dengan Data dengan ID $id");
                header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
                exit();
            } else {
                $error = base64_encode("Data tidak dapat hapus dan silahkan coba kembali");
                header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
                exit();
            }
        }
    }

    //SaveTambah
    if ($aksi == "savetambah") {
        if (!$oto['add']) {  echo $error['add'];  } 
		else {
            $templatename = cleaninsert($_POST['templatename']);
            $subject = cleaninsert($_POST['subject']);
            $plainmail = addslashes($_POST['plainmail']);
            $htmlmail = $_POST['htmlmail'];
            $publish = false;
            
            $labels = explode(",",$templatelabels);
	
            $new = newid("templateid","tbl_newsletter_template");

            //Upload Gambar
            if (!file_exists("$pathfile/$kanal"))
                mkdir("$pathfile/$kanal");

            if ($_FILES['image']['size'] > 0) {
                $ext = getimgext($_FILES['image']);
                $namagambars = "$kanal-$alias-$new.$ext";
                $gambars = resizeimg($_FILES['image']['tmp_name'], "$pathfile/$kanal/$namagambars", $gambars_maxw, $gambars_maxh);

                if($gambars){ 
					$fgambar = ",image";
					$vgambar = ",'$namagambars'";
				}
            }

            $perintah = "insert into $nama_tabel(templateid,templatename,plainmail,htmlmail,create_date,create_userid $fgambar) 
				values ('$new','$templatename','$plainmail','$htmlmail','$date','$cuserid' $vgambar)";
			$hasil = sql($perintah);

            if ($hasil) {
                $msg = base64_encode("Berhasil ditambahkan Data baru");
                header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
                exit();
            } else {
                $error = base64_encode("Data tidak dapat dimasukkan dan silahkan coba kembali");
                header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
                exit();
            }
        }
    }

    //Tambah
    if ($aksi == "tambah") {
        if (!$oto['add']) {
            echo $error['add'];
        } else {
            $mainmenu[] = array("Kembali", "back", "$alamat&aksi=view");
            mainaction($mainmenu, $param);
            ?>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <script>
                                $(document).ready(function() {
                                    $("#menufrm").validationEngine()
                                });

            </script>
            <form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
                <input type="hidden" name="aksi" value="savetambah">
                <table border="0" class="tabel-cms" width="100%">
                    <tr>
                        <th colspan="2">Tambah Data</th>
                    </tr>
                    <tr>
                        <td colspan="2">Untuk menambahkan variable pada email bisa digunakan beberapa variable berikut: Nama Subcriber <strong>{subcribername}</strong>, 
                        Nama Referensi <strong>{contactname}</strong>, Nomor Handphone Referensi <strong>{contactphone}</strong> dan Nama Member <strong>{userfullname}</strong></td>
                    </tr>
                    <tr> 
                        <td width="176">Template Name</td>
                        <td width="471"><input name="templatename" type="text" size="70" value="" id="nama" class="validate[required]" /></td>
                    </tr>
                    <tr> 
                        <td >Plain Newsletter</td>
                        <td ><textarea name="plainmail" cols="70" rows="10" id="lengkap" class="validate[required]" ></textarea></td>
                    </tr>
                    <tr> 
                        <td >HTML Newsletter</td>
                        <td ><textarea name="htmlmail" cols="70" rows="10" id="lengkap" class="ckeditor validate[required]" ></textarea></td>
                    </tr>
                    <tr> 
                        <td >Gambar</td>
                        <td><input name="image" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" />
                            <em>Ukuran gambar minimal <?php echo "$gambarl_maxw x $gambarl_maxh pixel"; ?></em></td>
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

    if ($aksi == "saveedit") {

        if (!$oto['edit']) {
            echo $error['edit'];
        } else {
            $id = $_POST['id'];
            $templatename = cleaninsert($_POST['templatename']);
			$subject = cleaninsert($_POST['subject']);
			$plainmail = addslashes($_POST['plainmail']);
			$htmlmail = addslashes($_POST['htmlmail']);

            //Upload Gambar
            if (!file_exists("$pathfile/$kanal"))
                mkdir("$pathfile/$kanal");

            if ($_FILES['image']['size'] > 0) {
                $ext = getimgext($_FILES['image']);
                $namagambars = "$kanal-$alias-$id.$ext";
                $gambars = resizeimg($_FILES['image']['tmp_name'], "$pathfile/$kanal/$namagambars", $gambars_maxw, $gambars_maxh);
                
                if($gambars){ 
					$vimage = ",image='$namagambars'";
				}
			}

            $perintah = "update $nama_tabel set templatename='$templatename',plainmail='$plainmail',htmlmail='$htmlmail', update_date='$date',update_userid='$cuserid' $vimage where templateid='$id'";
            $hasil = sql($perintah);
	

            if ($hasil) 
			{
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

    if ($aksi == "edit") {
        if (!$oto['edit']) {
            echo $error['edit'];
        } else {
            $id = $_GET['id'];
            $mainmenu[] = array("Kembali", "back", "$alamat&aksi=view");
            mainaction($mainmenu, $param);

            $sql	= "select templateid,subject,plainmail,htmlmail,templatename,image from $nama_tabel where templateid='$id'";
			$query	= sql($sql);
			$row = sql_fetch_data($query);
			
			$templatename		= $row['templatename'];
			$subject		= $row['subject'];
			$from_email		= $row['from_email'];
			$from_name		= $row['from_name'];
			$templatelabels		= $row['templatelabels'];
			$plainmail		= stripslashes($row['plainmail']);
			$htmlmail		= stripslashes($row['htmlmail']);
			$gambar        = $row['image'];
        
        	if(!empty($gambar)) $gambar = "<img src=\"../gambar/$kanal/$gambar\" alt=\"\" />"; else $gambar = "Masih kosong";
            ?>
            <script>
                $(document).ready(function() {
                    $("#menufrm").validationEngine()
                });
            </script>
            <script src="librari/ckeditor/ckeditor.js"></script>
            <form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
                <input type="hidden" name="aksi" value="saveedit">
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <table border="0" class="tabel-cms" width="100%">
                    <tr>
                        <th colspan="2">Edit Data</th>
                    </tr>
                    <tr> 
                        <td width="176">Template Name</td>
                        <td width="471"><input name="templatename" type="text" size="70" value="<?php= $templatename ?>" id="nama" class="validate[required]" /></td>
                    </tr>
                    <tr> 
                        <td >Plain Newsletter</td>
                        <td ><textarea name="plainmail" cols="70" rows="10" id="lengkap" class="validate[required]" ><?php= $plainmail ?></textarea></td>
                    </tr>
                    <tr> 
                        <td >HTML Newsletter</td>
                        <td ><textarea name="htmlmail" cols="70" rows="10" id="lengkap" class="ckeditor validate[required]" ><?php= $htmlmail ?>
                            </textarea></td>
                    </tr>
                    <tr> 
                        <td >Gambar</td>
                        <td><input name="image" type="file" size="20" value="" id="gambar" title="Pilih Gambar Dari Drive" class="file" />
                            <em>Ukuran gambar minimal <?php echo "$gambarl_maxw x $gambarl_maxh pixel"; ?></td>
                    </tr>
                    <tr> 
                        <td valign="top">&nbsp;</td>
                        <td align="left">
                            <input type="submit" name="Submit" value="Simpan" />
                            <input type="button" onclick="javascript:window.location = ('<?php echo $alamat ?>')" value="Batal">
                        </td>
                    </tr>
                </table>
            </form>

            <?php
        }
    }
}
?>