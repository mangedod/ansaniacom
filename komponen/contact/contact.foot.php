<?php 
	$sql = "select id,nama,ringkas,lengkap,alamat,oleh,alias,telp,gsm,bbm,instagram,youtube,email,email_support,gambar,gambar1 from tbl_static where alias='kontak'";
	$hsl = sql($sql);
	$row = sql_fetch_data($hsl);
	
		$id       = $row['id'];
		$nama     = $row['nama'];
		$ringkas  = $row['ringkas'];
		$lengkap  = $row['lengkap'];
		$oleh     = $row['oleh'];
		$alias    = $row['alias'];
		$gambar   = $row['gambar'];
		$gambar1  = $row['gambar1'];

		$alamat11            = $row['alamat'];
		$telp                = $row['telp'];
		$gsm                 = $row['gsm'];
		$kontakinstagram     = $row['instagram'];
		$konakyoutube        = $row['youtube'];
		$kontakemail         = $row['email'];
		$kontakemail_support = $row['email_support'];
	
	sql_free_result($hsl);
	
	$tpl->assign("contactnama",$nama);
	$tpl->assign("contactalamat11",$alamat11);
	$tpl->assign("contacttelp",$telp);
	$tpl->assign("contactgsm",$gsm);
	$tpl->assign("contactig",$kontakinstagram);
	$tpl->assign("contactyoutube",$konakyoutube);
	$tpl->assign("contactemail",$kontakemail);
	$tpl->assign("contactemail_support",$kontakemail_support);
	$tpl->assign("contactringkas",$ringkas);
	$tpl->assign("contactlengkap",$lengkap);
?>