<?php
//Variable halaman ini
$nama_tabel = "tbl_newsletter";
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
if (isset($_POST['id']))
    $id = $_POST['id'];
else
    $id = $_GET['id'];
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
            $mainmenu[] = array("View Newsletter", "lihat", "$alamat&aksi=view");
            $mainmenu[] = array("Add Newsletter", "tambah", "$alamat&aksi=tambah");
            mainaction($mainmenu, $pageparam);

            //Search Paramater Fungsi namafield,Label,
            $cari[] = array("newslettername", "Name", "str", "text", "$data");
            $cari[] = array("create_date", "Create Date", "date", "date", "$data");
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

            $sql = "select newsletterid,newslettername, create_date, senddate from $nama_tabel  where 1 $where $parorder limit $ord, $judul_per_hlm";
            $hsl = sql($sql);
            $i = 1;
            $a = 1;

            print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
            print("<tr><th width=5%>No</th>\n");
            print("<th width=60%><a href=\"$urlorder&order=newslettername\" title=\"Urutkan\">Newsletter Name</a></th>\n");
            print("<th width=20%><a href=\"$urlorder&order=senddate\" title=\"Urutkan\">Send Time</a></th>\n");
            print("<th width=5% align=center><b>Action</b></th></tr></thead>");

            while ($row = sql_fetch_data($hsl)) {
                $id = $row['newsletterid'];
                $nama = $row['newslettername'];
                $senddate = date("d-m-Y H:i:s",strtotime($row['senddate']));

                $subaccount = sql_get_var("Select count(*) as jml from tbl_newsletter_subcriber where newsletterid='$id'");

                print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top >$nama</td>\n
					<td  valign=top >$senddate</td>");

                print("<td>");
                $acc[] = array("Detail", "detail", "$alamat&aksi=detail&id=$id&hlm=$hlm");
				$acc[] = array("Subcribers", "detail", "$alamat&aksi=viewsubcribers&id=$id&hlm=$hlm");
                $acc[] = array("Edit", "edit", "$alamat&aksi=edit&id=$id&hlm=$hlm");
                $acc[] = array("Delete", "delete", "$alamat&aksi=hapus&id=$id&hlm=$hlm");

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
		$mainmenu[] = array("Back", "back", "$alamat&aksi=view");
		mainaction($mainmenu, $param);

		$sql = "select newsletterid,subject,plainmail,htmlmail,newslettername,senderid from $nama_tabel  where newsletterid ='$id'";
		$hsl = sql($sql);
		$row = sql_fetch_data($hsl);

		$id = $row['newsletterid'];
		$nama = $row['newslettername'];
		$plainmail = stripslashes($row['plainmail']);
		$htmlmail = stripslashes($row['htmlmail']);
		$tags = $row['tags'];
		$subject = $row['subject'];
		$senderid = $row['senderid'];
		
		$sql = "select sender,senderemail from tbl_newsletter_sender  where senderid ='$senderid'";
		$hsl = sql($sql);
		$row = sql_fetch_data($hsl);
		
		$sendername = $row['sender'];
		$senderemail = $row['senderemail'];
		
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
					<td class="tdinfo">Plain Newsletter</td>
					<td><?php echo $plainmail ?></td>
				</tr>

				<tr> 
					<td class="tdinfo">HTML Newsletter</td>
					<td><iframe width="100%" height="700" style="border:1px solid #CCCCCC" src="<?php echo ('../panel/komponen/newsletter_list/preview2.php?id='.$id) ?>"></iframe></td>
				</tr>
                <tr> 
					<td class="tdinfo"></td>
					<td><a href="<?php echo "$alamat&aksi=edit&id=$id&hlm=$hlm"; ?>" class="btn btn-primary"> Edit Newsletter</a></td>
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
			$msg = base64_encode("Data has been successfully removed with ID $id");
			header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
			exit();
		} else {
			$error = base64_encode("Data can't be deleted and please try again");
			header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
			exit();
		}
	}
}
}

//SaveTambah
if ($aksi == "savetambah") {
	if (!$oto['add']) { echo $error['add'];	} else {
	
		$newslettername = cleaninsert($_POST['newslettername']);
		$subject = cleaninsert($_POST['subject']);
		$plainmail = addslashes($_POST['plainmail']);
		$htmlmail = addslashes($_POST['htmlmail']);
		$tags = cleaninsert($_POST['tags']);
		$senderid = $_POST['senderid'];
		$sendername = cleaninsert($_POST['sendername']);
	
		$senddate = $_POST['date'];
	
		$new = newid('newsletterid', $nama_tabel);
	
	
		$query = "insert into $nama_tabel(newsletterid,newslettername,subject,plainmail,htmlmail,senddate,create_date,create_userid) 
				values ('$new','$newslettername','$subject','$plainmail','$htmlmail','$senddate', '$date','$cuserid')";
		$hasil = sql($query);
	
		if ($hasil) {
		
			$sql 	= "select userid,userfullname,useremail,usercreateddate from tbl_member";
			$res	= sql($sql);
			while ($row = sql_fetch_data($res))
			{
				$userid				= $row['userid'];
				$userfullname		= $row['userfullname'];
				$useremail			= $row['useremail'];
				$usercreateddate	= $row['usercreateddate'];
				$lastIp				= $row['lastIp'];
				
				$perintah	= "insert into tbl_newsletter_subcriber (`newsletterid`,`userid`,`userfullname`,`useremail`,`senddate`) 
							values ('$new','$userid','$userfullname','$useremail','$senddate')";
				$hasil		= sql($perintah);
			}
			sql_free_result($res);
				
			$msg = base64_encode("Data successfully added");
			header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
			exit();
		} else {
			$error = base64_encode("Data can't be added and please try again");
			header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
			exit();
		}
	}
}

//Tambah
if ($aksi == "tambah") {
	if (!$oto['add']) {	echo $error['add']; } else {

		$mainmenu[] = array("Back", "back", "$alamat&aksi=view");
		mainaction($mainmenu, $param);
		date_default_timezone_set("Asia/Jakarta");
		?>
		<script src="librari/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="template/javascript/jquery-ui-timepicker-addon.js"></script>
        <script language="javascript">
			$(document).ready(function() {
				$("#menufrm").validationEngine()
			});
			$(function() {
				$( "#date" ).datetimepicker({
				  showOn: "button",
				  buttonImage: "template/images/calendar.gif",
				  buttonImageOnly: true,
				  timeFormat: "HH:mm"
				});
			});
        </script>
		<form method="post" name="menufrm" id="menufrm" enctype="multipart/form-data">
			<input type="hidden" name="aksi" value="savetambah">
			<table border="0" class="tabel-cms" width="100%">
				<tr>
					<th colspan="2">Add Data</th>
				</tr>
				<tr> 
					<td width="15%">Newsletter Name</td>
					<td ><input name="newslettername" type="text" size="70" value="" id="newslettername" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td>Send Date</td>
					<td><input type="text" name="date" id="date" value=""></td>
				</tr>
				<tr> 
					<td>Newsletter Subject</td>
					<td><input name="subject" type="text" size="20" value="" id="subject" class="validate[required]" /></td>
				</tr>
				<tr> 
					<td>Plain Newsletter</td>
					<td><textarea name="plainmail" cols="76" rows="10" id="plainmail" class="validate[required]"></textarea></td>
				</tr>
				<tr> 
					<td>HTML Newsletter</td>
					<td><textarea name="htmlmail" cols="70" rows="10" id="htmlmail" class="ckeditor validate[required]" ></textarea></td>
				</tr>
				<tr> 
					<td valign="top">&nbsp;</td>
					<td align="left">
						<input type="submit" name="Submit" value="Save" />
						<input type="button" onclick="javascript:history.back();" value="Cancel">
					</td>
				</tr>
			</table>
		</form>
		<?php
	}
}

if ($aksi == "saveedit") {

	if (!$oto['edit']) { echo $error['edit'];} 
	else 
	{
		$id = $_POST['id'];
		$newslettername = cleaninsert($_POST['newslettername']);
		$subject = cleaninsert($_POST['subject']);
		$plainmail = addslashes($_POST['plainmail']);
		$htmlmail = addslashes($_POST['htmlmail']);
		$tags = cleaninsert($_POST['tags']);
		$senderid = $_POST['senderid'];
		$sendername = cleaninsert($_POST['sendername']);
	
		$senddate = $_POST['date'];
	
		$perintah = "update $nama_tabel set newslettername='$newslettername',subject='$subject',plainmail='$plainmail',"
				. "htmlmail='$htmlmail', update_date='$date', update_userid='$cuserid',"
				. "senddate='$senddate' where newsletterid='$id'";
		$hasil = sql($perintah);
	
		if ($hasil) {
			$msg = base64_encode("Data successfully edited with ID $id");
			header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
			exit();
		} else {
			$error = base64_encode("Data can't be edited and please try again");
			header("location: $alamat&aksi=view&hlm=$hlm&error=$error");
			exit();
		}
	}
}

if($aksi == "edit") {
	if (!$oto['edit']) { echo $error['edit'];} else {
	
	$id = $_GET['id'];
	$mainmenu[] = array("Back", "back", "$alamat&aksi=view");
	mainaction($mainmenu, $param);

	$sql = "select newsletterid,subject,plainmail,htmlmail,newslettername,senddate  from $nama_tabel where newsletterid='$id'";
	$query = sql($sql);
	$row = sql_fetch_data($query);

	$newslettername = $row['newslettername'];
	$subject = $row['subject'];
	$plainmail = stripslashes($row['plainmail']);
	$htmlmail = stripslashes($row['htmlmail']);
	$senddate = $row['senddate'];
	?>
    <script type="text/javascript" src="template/javascript/jquery-ui-timepicker-addon.js"></script>
	<script>
		$(document).ready(function() {
			$("#menufrm").validationEngine()
		});
			$(function() {
				$( "#date" ).datetimepicker({
				  showOn: "button",
				  buttonImage: "template/images/calendar.gif",
				  buttonImageOnly: true,
				  timeFormat: "HH:mm"
				});
			});
        </script>
	<script src="librari/ckeditor/ckeditor.js"></script>
	<form method="post" name="menufrm" id="menufrm">
		<input type="hidden" name="aksi" value="saveedit">
		<input type="hidden" name="id" value="<?php echo $id ?>">
		<table border="0" class="tabel-cms" width="100%">
			<tr>
				<th colspan="2">Edit Data</th>
			</tr>
			<tr> 
				<td width="15%">Newsletter Name</td>
				<td ><input name="newslettername" type="text" size="70" value="<?php echo $newslettername ?>" id="nama" class="validate[required]" /></td>
			</tr>
			<tr> 
				<td>Sender Date</td>
				<td><input type="text" name="date" id="date" value="<?php echo $senddate ?>"></td>
			</tr>
			<tr> 
				<td>Newsletter Subject</td>
				<td><input name="subject" type="text" size="70" value="<?php echo $subject ?>" id="oleh" class="validate[required]" /></td>
			</tr>
			<tr> 
				<td>Plain Newsletter</td>
				<td><textarea name="plainmail" cols="76" rows="10" id="plainmail" class="validate[required]"><?php echo $plainmail ?></textarea></td>
			</tr>
			<tr> 
				<td>HTML Newsletter</td>
				<td><textarea name="htmlmail" cols="70" rows="10" id="htmlmail" class="ckeditor validate[required]" ><?php echo $htmlmail ?></textarea></td>
			</tr>
			<tr> 
				<td valign="top">&nbsp;</td>
				<td align="left">
					<input type="submit" name="Submit" value="Save" />
					<input type="button" onclick="javascript:window.location = ('<?php echo $alamat ?>')" value="Cancel">
				</td>
			</tr>
		</table>
	</form>

	<?php
	}
}

if ($aksi == "viewsubcribers") {
        if (!$oto['view']) {
            echo $error['view'];
        } else {
            $mainmenu[] = array("View Newsletter", "lihat", "$alamat&aksi=view");
            mainaction($mainmenu, $pageparam);

            //Search Paramater Fungsi namafield,Label,
            $cari[] = array("userfullname", "Name", "str", "text", "$data");
			$cari[] = array("useremail", "Email", "str", "text", "$data");
            $formcari = cmsformcari($cari, $pageparam);
            $where = $formcari[0]['where']." and newsletterid='$id'";
            $param = $formcari[0]['param'];

            //Orderring
            $order = getorder("userfullname", "asc", $pageparam, $param);
            $parorder = $order[0];
            $urlorder = $order[1];


            $sql = "select count(*) as jml from tbl_newsletter_subcriber where 1 $where $parorder";
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

            $sql = "select id,newsletterid,userfullname, useremail, senddate, status from tbl_newsletter_subcriber  where 1 $where $parorder limit $ord, $judul_per_hlm";
            $hsl = sql($sql);
            $i = 1;
            $a = 1;

            print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
            print("<tr><th width=5%>No</th>\n");
            print("<th width=20%><a href=\"$urlorder&order=newslettername\" title=\"Urutkan\">Name</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=newslettername\" title=\"Urutkan\">Email</a></th>\n");
            print("<th width=20%><a href=\"$urlorder&order=senddate\" title=\"Urutkan\">Send Time</a></th>\n");
			print("<th width=20%><a href=\"$urlorder&order=senddate\" title=\"Urutkan\">Status</a></th>\n");
            print("</tr></thead>");

            while ($row = sql_fetch_data($hsl)) {
                $id = $row['id'];
                $nama = $row['userfullname'];
				$email = $row['useremail'];
				$status = $row['status'];
                $senddate = date("d-m-Y H:i:s",strtotime($row['senddate']));
				
				if($status == 1)
					$ket = "Sent";
				else
					$ket = "Not Sent";


                print("<tr class=\"row$i\"><td width=5% height=20 valign=top>&nbsp;$a</td>
					<td  valign=top >$nama</td>\n
					<td  valign=top >$email</td>\n
					<td  valign=top >$senddate</td>
					<td  valign=top >$ket</td>");

                print("</tr>");

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
					<td ><iframe width="100%" height="700" style="border:1px solid #CCCCCC" src="<?php echo ('../komponen/newsletter_list/preview.php?id='.$id) ?>"></iframe></td>
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

        $senddate = $_POST['date'];

        $new = newid('newsletterid', $nama_tabel);


        $query = "insert into $nama_tabel(newsletterid,newslettername,subject,plainmail,htmlmail,tags,sender,sendername,senddate,create_date,create_userid) 
				values ('$new','$newslettername','$subject','$plainmail','$htmlmail','$tags','$sender','$sendername','$senddate', '$date','$cuserid')";
        $hasil = sql($query);

        if ($hasil) {
            $msg = base64_encode("Data successfully added");
            header("location: $alamat&aksi=view&hlm=$hlm&msg=$msg");
            exit();
        } else {
            $error = base64_encode("Data can't be added and please try again");
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
        $mainmenu[] = array("Back", "back", "$alamat&aksi=view");
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
                    <th colspan="2">Add Data</th>
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
                            <option><-- Select Sender --></option>
                            <?php
                            $sql = "select sender,senderemail from tbl_sender  order by sender";
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
                    <td>Newsletter Subject</td>
                    <td><input name="subject" type="text" size="20" value="<?php echo $subject ?>" id="subject" class="validate[required]" /></td>
                </tr>
                <tr> 
                    <td>Plain Newsletter</td>
                    <td><textarea name="plainmail" cols="76" rows="5" id="plainmail" class="validate[required]"><?php echo $plainmail ?></textarea></td>
                </tr>
                <tr> 
                    <td>HTML Newsletter</td>
                    <td><textarea name="htmlmail" cols="70" rows="10" id="htmlmail" class="ckeditor validate[required]" ><?php echo $htmlmail ?></textarea></td>
                </tr>
                <tr> 
                    <td valign="top">&nbsp;</td>
                    <td align="left">
                        <input type="submit" name="Submit" value="Save" />
                        <input type="button" onclick="javascript:history.back();" value="Cancel">
                    </td>
                </tr>
            </table>
        </form>
        <?php
    }
}

?>