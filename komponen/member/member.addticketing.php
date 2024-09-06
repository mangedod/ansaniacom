<?php
	if($_SESSION['userid'])
	{
	$fileallowed	= "jpg, jpeg, png, gif, pdf, doc, docx, txt, xls, xlsx, ppt, pptx, zip, rar";
	$tpl->assign('fileallowed',$fileallowed);
	$secid			= $_POST['secid'];
	$tpl->assign('secid',$secid);
	
	if($_POST['aksi']=="save")
	{
		$secid			= $_POST['secid'];
		$judul			= $_POST['judul'];
		$alias			= getAlias($judul);
		$isipertanyaan	= $_POST['isipertanyaan'];
		
		if(empty($judul) || empty($isipertanyaan) || !$_SESSION['userid'])
		{
			$error 		= "The form you fill in incomplete or you are not logged in, please repeat it again.";
			$style		= "alert-danger";
			$backlink	= "<a href='javascript:history.back()'>Back</a>";

			if(!empty($uri)) {
				$message = base64_encode($error);
				header("location: $uri/error/$message");
				exit();
			}
		}
		
		$newid			= newid("ticketingid","tbl_ticketing");
		
		$fileallow		= $fileallowed;
		$folderalbum	= "$pathfile"."ticketing/";
			
		if(!file_exists($folderalbum)){	mkdir($folderalbum,0777); }
			
		if($_FILES['files']['size']>0)
		{
			$ext = getfileext($_FILES['files']);

			if(preg_match("/$ext/i",$fileallow))
			{
				$namafile 	= "ticketing-$alias-$newid"."."."$ext";
				
				copy($_FILES['files']['tmp_name'],"$folderalbum/"."$namafile");
				if(file_exists("$folderalbum/"."$namafile"))
				{
					$vfield = ",filetanya";
					$vval 	= ",'$namafile'";
				}
				$cekfile = true;
			}
			else
			{
				$error =  "The file is not permitted to be uploaded, please file with extension $fileallow";
				$cekfile = false;
			}
		}
		
		$cek = sql_get_var("select count(ticketingid) as jum from tbl_ticketing where userid='$_SESSION[userid]' and judul='$judul' and isipertanyaan='$isipertanyaan'");
		
		if($cek)
		{
			$error 		= "The data entered has already been asked before. Please check back to your question.";
			$style		= "alert-danger";
			$backlink	= "$fulldomain"."/member/addticketing";
		}
		else
		{
		
			$query	= "INSERT INTO tbl_ticketing (ticketingid, secid, userid, create_date, judul, isipertanyaan $vfield) 
					VALUES ('$newid', '$secid', '$_SESSION[userid]', '$date', '$judul', '$isipertanyaan' $vval)";
			$hasil 	= sql($query);
			if($hasil)
			{
				$userFullName = sql_get_var("SELECT userfullname from tbl_member where userid='$_SESSION[userid]'");
				$useremail = sql_get_var("SELECT useremail from tbl_member where userid='$_SESSION[userid]'");
				
				$contentemail	= sql_get_var("select keterangan from tbl_wording where alias='ticketing-baru' and jenis = 'email' limit 1");
				$contentemail	= str_replace("[userfullname]","$userFullName",$contentemail);
				$contentemail	= str_replace("[title]","$title",$contentemail);
				$contentemail	= str_replace("[judul]","$judul",$contentemail);
				$contentemail	= str_replace("[pertanyaan]","$isipertanyaan",$contentemail);
				$contentemail	= str_replace("[owner]","$owner",$contentemail);
				$contentemail	= str_replace("[fulldomain]","$fulldomain",$contentemail);
				
				//kirim email ke admin
				$to 		= "$support_email";
				$from 		= "$support_email";
				$subject 	= "New Ticketing, $judul";
				$message 	= "$contentemail";
				$headers 	= "From : $owner";
				
			
				$sendmail	= sendmail($title,$to,$subject,$message,$message,1);
				$sendmail	= sendmail($userFullName,$useremail,$subject,$message,$message,1);
				//Setlog kedalam Sistem
				//setsyslog($userid,"0","$userFullName membuat ticketing baru di $title","index.php?tab=18&tabsub=98&kanal=ticketing&aksi=view&status=0");
	
				//header("location: $fulldomain/member/ticketing");
				
				$error 		= "The addition of ticketing data successfully. Please wait for an answer from the Admin $title. Thank you.";
				$style		= "alert-success";
				$backlink	= "$fulldomain"."/member/ticketing";
			}
			else
			{
				if(!$cekfile)
					$error 		= "Data storage failed there are some errors that must be repaired, please check back. The file is not permitted to be uploaded, please file with extension $fileallow";
				else
					$error 		= "Data storage failed there are some errors that must be repaired, please check back.";
				$style		= "alert-danger";
				$backlink	= "$fulldomain"."/member/addticketing";
			}
		}

		$tpl->assign("error",$error);
		$tpl->assign("style",$style);
		$tpl->assign("backlink",$backlink);
	}
	
	// Kategori Produk
	$sql1		= "select secid,namasec,alias from tbl_ticketing_sec order by secid asc";
	$query1		= sql($sql1);
	$ticket_sec	= array();
	while($row1 = sql_fetch_data($query1))
	{
		$secid		= $row1['secid'];
		$nama		= $row1["namasec"];
		$aliassec	= $row1['alias'];
		
		$ticket_sec[$secid]	= array("secid"=>$secid,"nama"=>$nama);
	}
	sql_free_result($query1);
	$tpl->assign("ticket_sec",$ticket_sec);
	
	

	$tpl->assign("namarubrik","Add Ticketing");
	}
?>