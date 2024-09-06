<?php 
// Wishlist Produk
	$produkpostid	= $var[4];
	echo $produkpostid;

	if($_SESSION['username'])
	{
		// Input kedalam database
		$id = sql_get_var("select id from tbl_wishlist where userid='$_SESSION[userid]' and produkpostid='$produkpostid'");
		$date = date("Y-m-d H:i:s");
		
		if (empty($id))
		{
			$new = newid("id","tbl_wishlist");
			
			$query	= ("insert into tbl_wishlist (`id`,`produkpostid`,userid,create_date) 
						values ('$new','$produkpostid','$_SESSION[userid]','$date')");
			$hasil = sql($query);
			
			
			header("location: $fulldomain/user/wishlist");
		}
		else
			header("location: $fulldomain/product");
	}
	else
	{
		$last = "$fulldomain/product/wishlist/$produkpostid";
		$_SESSION['last']	= $last;
		$tpl->assign("last",$last);
		header("location: $fulldomain/user");
	}

?>
