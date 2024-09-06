<?php
//Variable halaman ini
$nama_tabel = "tbl_basic_newsletter";
$nama_tabel1 = "tbl_newsletter_template";
$judul_per_hlm = 25;
$otoritas = kodeoto($kanal);
$oto = $otoritas[0];
$gambars_maxw = 350;
$gambars_maxh = 300;
$gambarl_maxw = 800;
$gambarl_maxh = 600;


//Variable Umum
if (isset($_POST['newsletterid']))
    $newsletterid = $_POST['newsletterid'];
else
    $newsletterid = $_GET['newsletterid'];
if (isset($_POST['userid']))
    $userid = $_POST['userid'];
else
    $userid = $_GET['userid'];

if (!$oto['oto']) {
    echo $error['oto'];
} else {
    //Vie Content
    if ($aksi == "view") {
        if (!$oto['view']) {
            echo $error['view'];
        } else {
            $mainmenu[] = array("Lihat Newsletter", "lihat", "$alamat&aksi=view");
            $mainmenu[] = array("Tambah Newsletter", "tambah", "$alamat&aksi=tambah");
            $mainmenu[] = array("Tambah Dari Template", "tambah", "$alamat&aksi=pilihtemplate");
            mainaction($mainmenu, $pageparam);

            //Search Paramater Fungsi namafield,Label,
            $cari[] = array("newslettername", "Nama", "str", "text", "$data");

            $sql = "select newsletterid,newslettername from $nama_tabel order by newslettername asc";
            $hsl = sql($sql);
            while ($data = sql_fetch_data($hsl)) {
                $secid1 = $data['newsletterid'];
                $namasec = $data['newslettername'];
                $katselect[] = array("$secid1", "$namasec");
            }
            sql_free_result($hsl);
            $cari[] = array("create_date", "Tanggal Upload", "date", "date", "$data");
            $formcari = cmsformcari($cari, $pageparam);
            $where = $formcari[0]['where'];
            $param = $formcari[0]['param'];

            //Orderring
            $order = getorder("newsletterid", "desc", $pageparam, $param);
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

            $sql = "select newsletterid,newslettername, create_date, senddate,days_to from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
            $hsl = sql($sql);
            $i = 1;
            $a = 1;

            print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
            print("<tr><th width=5%>Nomor</th>\n");
            print("<th width=5%><a href=\"$urlorder&order=newsletterid\" title=\"Urutkan\">ID</a></th>\n");
            print("<th width=70%><a href=\"$urlorder&order=newslettername\" title=\"Urutkan\">Newsletter Name</a></th>\n");
            print("<th width=10%><a href=\"$urlorder&order=senddate\" title=\"Urutkan\">Send Date</a></th>\n");
            print("<th width=10%><a href=\"$urlorder&order=days_to\" title=\"Urutkan\">Days To</a></th>\n");
            print("<th width=5% align=center><b>Action</b></th></tr></thead>");

            while ($row = sql_fetch_data($hsl)) {
                $id = $row['newsletterid'];
                $nama = $row['newslettername'];
                $senddate = $row['senddate'];
                $days_to = $row['days_to'];

                $subaccount = sql_get_var("Select count(*) as jml from tbl_newsletter_subcriber where newsletterid='$id'");

                print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td width=5% height=20 valign=top>&nbsp;<b>$id</b></td>
					<td  valign=top >$nama</td>\n
					<td  valign=top >$senddate</td>
					<td  valign=top >Hari Ke-$days_to</td>");
                print("<td>");
                $acc[] = array("Detail", "detail", "$alamat&aksi=detail&id=$id&hlm=$hlm");
                $acc[] = array("Edit", "edit", "$alamat&aksi=edit&id=$id&hlm=$hlm");
                $acc[] = array("Hapus", "delete", "$alamat&aksi=hapus&id=$id&hlm=$hlm");

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

            $sql = "select newsletterid,subject,plainmail,htmlmail, newslettername, tags, sender, sendername,days_to from $nama_tabel  where newsletterid ='$id'";
            $hsl = sql($sql);
            $row = sql_fetch_data($hsl);

            $id = $row['newsletterid'];
            $nama = $row['newslettername'];
            $plainmail = stripslashes($row['plainmail']);
            $htmlmail = stripslashes($row['htmlmail']);
            $tags = $row['tags'];
            $subject = $row['subject'];
            $sender = $row['sender'];
            $sendername = $row['sendername'];
            $days_to = $row['days_to'];
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
                        <td align="left"><?php echo $nama ?></td>
                    </tr>
                    <tr> 
                        <td valign="top" width="20%" class="tdinfo">Newsletter Tags</td> 
                        <td align="left"><?php echo $tags ?></td>
                    </tr>
                    <tr> 
                        <td class="tdinfo" >Newsletter Sender Name</td>
                        <td ><?php echo $sendername ?></td>
                    </tr>
                    <tr> 
                        <td class="tdinfo">Newsletter Sender</td>
                        <td><?php echo $sender ?></td>
                    </tr>
                    <tr> 
                        <td class="tdinfo">Days To</td>
                        <td>Hari Ke-<?php echo $days_to ?></td>
                    </tr>
                    <tr> 
                        <td class="tdinfo">Newsletter Subject</td>
                        <td><?php echo $subject ?></td>
                    </tr>
                    <tr> 
                        <td class="tdinfo">Plain Newsletter</td>
                        <td><?php echo $plainmail ?></td>
                    </tr>

                    <tr> 
                        <td class="tdinfo">HTML Newsletter</td>
                        <td><iframe width="100%" height="700" style="border:1px solid #CCCCCC" src="<?php= ('../komponen/newsletter/preview2.php?id='.$id) ?>"></iframe></td>
                    </tr>
                </table>
            </form>

            <?php
        }
    }

    //Hapus
    if ($aksi == "hapus") {

        if (!$oto['delete']) {
            echo $error['delete'];
        } else {

            $id = $_GET['id'];

            $perintah = "select image from $nama_tabel where id='$id'";
            $hasil = sql($perintah);
            $row = sql_fetch_data($hasil);

            $gambar = $row['image'];

            if (!empty($gambar))
                unlink("$pathfile$kanal/$gambar");

            $perintah = "delete from $nama_tabel where newsletterid='$id'";
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
}

//SaveTambah
if ($aksi == "savetambah") {
    if (!$oto['add']) {
        echo $error['add'];
    } else {

        $newslettername = cleaninsert($_POST['newslettername']);
        $subject = cleaninsert($_POST['subject']);
        $plainmail = addslashes($_POST['plainmail']);
        $htmlmail = addslashes($_POST['htmlmail']);
        $tags = cleaninsert($_POST['tags']);
        $sender = $_POST['sender'];
        $sendername = cleaninsert($_POST['sendername']);
        $days_to = cleaninsert($_POST['hari']);

        $senddate = $_POST['date'];

        $new = newid('newsletterid', $nama_tabel);


        $query = "insert into $nama_tabel(newsletterid,newslettername,subject,plainmail,htmlmail,tags,sender,sendername,senddate,create_date,create_userid,days_to) 
				values ('$new','$newslettername','$subject','$plainmail','$htmlmail','$tags','$sender','$sendername','$senddate', '$date','$cuserid','$days_to')";
        $hasil = sql($query);

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
        date_default_timezone_set("Asia/Jakarta");
        ?>
        <script src="librari/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<!--Load Script and Stylesheet -->
	<script type="text/javascript" src="librari/datepicker/jquery.simple-dtpicker.js"></script>
	<link type="text/css" href="librari/datepicker/jquery.simple-dtpicker.css" rel="stylesheet" />
	<!---->
        <form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
            <input type="hidden" name="aksi" value="savetambah">
            <table border="0" class="tabel-cms" width="100%">
                <tr>
                    <th colspan="2">Tambah Data</th>
                </tr>
                <tr> 
                    <td width="15%">Newsletter Name</td>
                    <td ><input name="newslettername" type="text" size="70" value="" id="newslettername" class="validate[required]" /></td>
                </tr>
                <tr> 
                    <td>Newsletter Tags</td>
                    <td><input name="tags" type="text" size="90" value="" id="tags" class="validate[required]" /></td>
                </tr>
                <tr> 
                    <td>Newsletter Sender Name</td>
                    <td><input name="sendername" type="text" size="20" value="" id="sendername" class="validate[required]" /></td>
                </tr>
                <tr> 
                    <td>Newsletter Sender</td>
                    <td><select name="sender" class="validate[required]">
                            <option><-- Pilih Sender --></option>
                            <?php
                            $sql = "select senderemail from tbl_sender  order by senderemail";
                            $hsl = sql($sql);
                            while ($data = sql_fetch_data($hsl)) {
                                $namasec = $data['senderemail'];
                                echo "<option value=\"$namasec\">$namasec</option>";
                            }
                            sql_free_result($hsl);
                            ?>
                        </select></td>
                </tr>
                <tr> 
                    <td>Send Date</td>
                    <td><input type="text" name="date" value="">
	<script type="text/javascript">
		$(function(){
			$('*[name=date]').appendDtpicker();
		});
	</script></td>
                </tr>
                <tr> 
                    <td>Days To</td>
                    <td><select name="hari">
                            <option><-- Pilih Hari Ke --></option>
                        <?php for($i=1; $i<=31; $i++): ?>
                            <option value="<?php= $i?>">Hari <?php= $i ?> </option>
                            <?php endfor; ?>
                        </select></td>
                </tr>
                <tr> 
                    <td>Newsletter Subject</td>
                    <td><input name="subject" type="text" size="20" value="" id="subject" class="validate[required]" /></td>
                </tr>
                <tr> 
                    <td>Plain Newsletter</td>
                    <td><textarea name="plainmail" cols="76" rows="5" id="plainmail" class="validate[required]"></textarea></td>
                </tr>
                <tr> 
                    <td>HTML Newsletter</td>
                    <td><textarea name="htmlmail" cols="70" rows="10" id="htmlmail" class="ckeditor validate[required]" ></textarea></td>
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
        $newslettername = cleaninsert($_POST['newslettername']);
        $subject = cleaninsert($_POST['subject']);
        $plainmail = addslashes($_POST['plainmail']);
        $htmlmail = addslashes($_POST['htmlmail']);
        $tags = cleaninsert($_POST['tags']);
        $sender = $_POST['sender'];
        $sendername = cleaninsert($_POST['sendername']);
        $days_to = cleaninsert($_POST['hari']);

        $senddate = $_POST['date'];

        $perintah = "update $nama_tabel set newslettername='$newslettername',subject='$subject',plainmail='$plainmail',"
                . "htmlmail='$htmlmail', update_date='$date', update_userid='$cuserid',"
                . "tags='$tags', sender='$sender', sendername='$sendername',"
                . "senddate='$senddate', days_to = '$days_to' where newsletterid='$id'";
        $hasil = sql($perintah);

        if ($hasil) {
            $msg = base64_encode("Berhasil mengubah data dengan ID $id");
            header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
            exit();
        } else {
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

        $sql = "select newsletterid,subject,plainmail,htmlmail,newslettername,senddate,tags,sender,sendername,days_to from $nama_tabel where newsletterid='$id'";
        $query = sql($sql);
        $row = sql_fetch_data($query);

        $newslettername = $row['newslettername'];
        $subject = $row['subject'];
        $plainmail = stripslashes($row['plainmail']);
        $htmlmail = stripslashes($row['htmlmail']);
        $senddate = $row['senddate'];
        $tags = $row['tags'];
        $sender = $row['sender'];
        $sendername = $row['sendername'];
        $days_to = $row['days_to'];
        ?>
        <script>
            $(document).ready(function() {
                $("#menufrm").validationEngine()
            });
        </script>
        <script src="librari/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<!--Load Script and Stylesheet -->
	<script type="text/javascript" src="librari/datepicker/jquery.simple-dtpicker.js"></script>
	<link type="text/css" href="librari/datepicker/jquery.simple-dtpicker.css" rel="stylesheet" />
	<!---->
        <form method="post" name="menufrm" id="menufrm">
            <input type="hidden" name="aksi" value="saveedit">
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <table border="0" class="tabel-cms" width="100%">
                <tr>
                    <th colspan="2">Edit Data</th>
                </tr>
                <tr> 
                    <td width="15%">Newsletter Name</td>
                    <td ><input name="newslettername" type="text" size="70" value="<?php= $newslettername ?>" id="nama" class="validate[required]" /></td>
                </tr>
                <tr> 
                    <td>Newsletter Tags</td>
                    <td><input name="tags" type="text" size="90" value="<?php= $tags ?>" id="tags" class="validate[required]" /></td>
                </tr>
                <tr> 
                    <td>Newsletter Sender Name</td>
                    <td><input name="sendername" type="text" size="20" value="<?php= $sendername ?>" id="oleh" class="validate[required]" /></td>
                </tr>
                <tr> 
                    <td>Newsletter Sender</td>
                    <td><select name="sender" class="validate[required]">
                            <option><?php= $sender ?></option>
                            <?php
                            $sql = "select senderemail from tbl_sender  order by senderemail";
                            $hsl = sql($sql);
                            while ($data = sql_fetch_data($hsl)) {
                                $namasec = $data['senderemail'];
                                echo "<option value=\"$namasec\">$namasec</option>";
                            }
                            sql_free_result($hsl);
                            ?>
                        </select></tr>
                <tr> 
                    <td>Sender Date</td>
                    <td><input type="text" name="date" value="<?php= $senddate ?>">
	<script type="text/javascript">
		$(function(){
			$('*[name=date]').appendDtpicker();
		});
	</script></td>
                </tr>
                <tr> 
                    <td>Days To</td>
                    <td><select name="hari">
                            <option><-- Pilih Hari Ke --></option>
                        <?php for($i=1; $i<=31; $i++): ?>
                            <option <?php if($days_to == $i):?> selected="" <?php endif; ?> value="<?php= $i?>">Hari <?php= $i ?> </option>
                            <?php endfor; ?>
                        </select></td>
                </tr>
                <tr> 
                    <td>Newsletter Subject</td>
                    <td><input name="subject" type="text" size="20" value="<?php= $subject ?>" id="oleh" class="validate[required]" /></td>
                </tr>
                <tr> 
                    <td>Plain Newsletter</td>
                    <td><textarea name="plainmail" cols="76" rows="5" id="plainmail" class="validate[required]"><?php= $plainmail ?></textarea></td>
                </tr>
                <tr> 
                    <td>HTML Newsletter</td>
                    <td><textarea name="htmlmail" cols="70" rows="10" id="htmlmail" class="ckeditor validate[required]" ><?php= $htmlmail ?></textarea></td>
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

if ($aksi == "pilihtemplate") {
        if (!$oto['view']) {
            echo $error['view'];
        } else {
            
        $mainmenu[] = array("Kembali", "back", "$alamat&aksi=view");
        mainaction($mainmenu, $param);

            //Search Paramater Fungsi namafield,Label,
            $cari[] = array("templatename", "Template Name", "str", "text", "$data");


            $sql = "select templateid,templatename from $nama_tabel1  order by templatename asc";
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


            $sql = "select count(*) as jml from $nama_tabel1 where 1 $where $parorder";
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

            $sql = "select templateid,templatename,create_date,image from $nama_tabel1 where 1 $where order by templateid desc limit $ord, $judul_per_hlm";
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
                    $image = "<img src=\"../gambar/newsletter_template/$image\" style=\"width:200px\" alt=\"\" />";

                print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td width=5% height=20 valign=top>&nbsp;<b>$id</b></td>
					<td  valign=top >$nama</td>
					<td  valign=top >$image</td>");

                print("<td>");

                $acc[] = array("Preview", "preview", "$alamat&aksi=preview&id=$id");
                $acc[] = array("Select", "tambah", "$alamat&aksi=select&id=$id");

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
    }
    
    //Detail
    if ($aksi == "preview") {
        if (!$oto['view']) {
            echo $error['view'];
        } else {
            $id = $_GET['id'];
            $mainmenu[] = array("Kembali", "back", "$alamat&aksi=pilihtemplate");
            mainaction($mainmenu, $pageparam);

            $sql	= "select templateid,subject,plainmail,htmlmail,templatename from $nama_tabel1 where templateid='$id'";
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
    
    
//SaveTambah
if ($aksi == "saveselect") {
    if (!$oto['add']) {
        echo $error['add'];
    } else {

        $newslettername = cleaninsert($_POST['newslettername']);
        $subject = cleaninsert($_POST['subject']);
        $plainmail = addslashes($_POST['plainmail']);
        $htmlmail = addslashes($_POST['htmlmail']);
        $tags = cleaninsert($_POST['tags']);
        $sender = $_POST['sender'];
        $sendername = cleaninsert($_POST['sendername']);
        $days_to = cleaninsert($_POST['hari']);

        $senddate = $_POST['date'];

        $new = newid('newsletterid', $nama_tabel);


        $query = "insert into $nama_tabel(newsletterid,newslettername,subject,plainmail,htmlmail,tags,sender,sendername,senddate,create_date,create_userid,days_to) 
				values ('$new','$newslettername','$subject','$plainmail','$htmlmail','$tags','$sender','$sendername','$senddate', '$date','$cuserid','$days_to')";
        $hasil = sql($query);

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
if ($aksi == "select") {
    if (!$oto['add']) {
        echo $error['add'];
    } else {
        $mainmenu[] = array("Kembali", "back", "$alamat&aksi=view");
        mainaction($mainmenu, $param);
        date_default_timezone_set("Asia/Jakarta");
        
        
        $id = $_GET['id'];

        $sql = "select templateid,subject,plainmail,htmlmail from $nama_tabel1 where templateid='$id'";
        $query = sql($sql);
        $row = sql_fetch_data($query);
        
        $subject = $row['subject'];
        $plainmail = stripslashes($row['plainmail']);
        $htmlmail = stripslashes($row['htmlmail']);
        ?>
        <script src="librari/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<!--Load Script and Stylesheet -->
	<script type="text/javascript" src="librari/datepicker/jquery.simple-dtpicker.js"></script>
	<link type="text/css" href="librari/datepicker/jquery.simple-dtpicker.css" rel="stylesheet" />
	<!---->
        <form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
            <input type="hidden" name="aksi" value="saveselect">
            <table border="0" class="tabel-cms" width="100%">
                <tr>
                    <th colspan="2">Tambah Data</th>
                </tr>
                <tr> 
                    <td width="15%">Newsletter Name</td>
                    <td ><input name="newslettername" type="text" size="70" value="" id="newslettername" class="validate[required]" /></td>
                </tr>
                <tr> 
                    <td>Newsletter Tags</td>
                    <td><input name="tags" type="text" size="90" value="" id="tags" class="validate[required]" /></td>
                </tr>
                <tr> 
                    <td>Newsletter Sender Name</td>
                    <td><input name="sendername" type="text" size="20" value="" id="sendername" class="validate[required]" /></td>
                </tr>
                <tr> 
                    <td>Newsletter Sender</td>
                    <td><select name="sender" class="validate[required]">
                            <option><-- Pilih Sender --></option>
                            <?php
                            $sql = "select senderemail from tbl_sender  order by senderemail";
                            $hsl = sql($sql);
                            while ($data = sql_fetch_data($hsl)) {
                                $namasec = $data['senderemail'];
                                echo "<option value=\"$namasec\">$namasec</option>";
                            }
                            sql_free_result($hsl);
                            ?>
                        </select></td>
                </tr>
                <tr> 
                    <td>Send Date</td>
                    <td><input type="text" name="date" value="">
	<script type="text/javascript">
		$(function(){
			$('*[name=date]').appendDtpicker();
		});
	</script></td>
                </tr>
                <tr> 
                    <td>Days To</td>
                    <td><select name="hari">
                            <option><-- Pilih Hari Ke --></option>
                        <?php for($i=1; $i<=31; $i++): ?>
                            <option value="<?php= $i?>">Hari <?php= $i ?> </option>
                            <?php endfor; ?>
                        </select></td>
                </tr>
                <tr> 
                    <td>Newsletter Subject</td>
                    <td><input name="subject" type="text" size="20" value="<?php= $subject ?>" id="subject" class="validate[required]" /></td>
                </tr>
                <tr> 
                    <td>Plain Newsletter</td>
                    <td><textarea name="plainmail" cols="76" rows="5" id="plainmail" class="validate[required]"><?php= $plainmail ?></textarea></td>
                </tr>
                <tr> 
                    <td>HTML Newsletter</td>
                    <td><textarea name="htmlmail" cols="70" rows="10" id="htmlmail" class="ckeditor validate[required]" ><?php= $htmlmail ?></textarea></td>
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

?>