<?php 
$namasub	= $_POST[namasub];
$ket		= bersihHTML($_POST[ket]);
$alias		=getAlias($namasub);

//cek jumlah album
$qry="select subid from tbl_content_sub where userId='$_SESSION[useridresel]'";
$rslt=mysql_query($qry);
$dta=mysql_num_rows($rslt);

	if ($dta < $maxalbum)
	{
		$perintah1 = "insert into tbl_content_sub(namasub,alias,ket,userId)
					 values('$namasub','$alias','$ket','$_SESSION[useridresel]')";
		$hasil1 = mysql_query($perintah1);
		if($hasil1)
		{	
			$pesanhasil = "Album Anda telah bertambah.";
			$berhasil = "1";
		}
		else 
		{
			$pesanhasil = "Pembuatan Album Gagal dilakukan ada beberapa kesalahan yang harus Anda perbaiki";
			$berhasil = "0";
		}
	}
	else
	{
		$pesanhasil="Anda tidak dapat menambah album batas maksimal penambahan album sebanyak $max buah.";
	}

$tpl->assign("pesanhasil",$pesanhasil);
$tpl->assign("berhasil",$berhasil);
?>
