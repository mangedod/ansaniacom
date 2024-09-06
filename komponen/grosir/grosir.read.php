<?php 

		$aliasprod    = $var[5];
		
		$sql           = "select produkid, secid, subid, kodeproduk, title, content, ringkas, misc_harga, cart, misc_diskon, create_date, misc_matauang, brandid, tag from tbl_product where status='1' and alias='$aliasprod' and published='1'";
		$query         = sql($sql);
		$row           = sql_fetch_data($query);
		$produkid      = $row["produkid"];
		$secid         = $row["secid"];
		$subid         = $row["subid"];
		$namaprod      = $row["title$lang"];
		$content       = $row["content"];
		$ringkas       = bersihHTML($row["ringkas"]);
		$cart          = $row['cart'];
		$misc_diskon   = $row['misc_diskon'];
		$postTime      = tanggaltok($row['create_date']);
		$brandidnya    = $row['brandid'];
		$misc_matauang = $row['misc_matauang'];
		$jenisvideo    = $row['jenisvideo'];
		$screenshot    = $row['screenshot'];
		$urlyoutube    = $row['urlyoutube'];
		$kodeproduk    = $row['kodeproduk'];
		$misc_harga    = $row['misc_harga'];
		$tag           = $row['tag'];

		$totalrating = 0;
		$jmlrating   = sql_get_var("select SUM(score) as jmlscore from tbl_product_comment where userid='$_SESSION[userid]' and produkid='$produkid'");
		$jmlorang    = sql_get_var("select count(*) as jml from tbl_product_comment where userid='$_SESSION[userid]' and produkid='$produkid'");
		if($jmlorang>0) $totalrating = $totalrating + $jmlrating/$jmlorang;

		if(!empty($subid))
		{
			$nama_sub = getNamaSub($subid,$lang);
			$aliasSub = getAliasSub($nama_sub);
			$tpl->assign("namasub",$nama_sub);
		}
		if(!empty($secid))
		{
			$nama_cat = getNamaSec($secid,$lang);
			$aliasSec = getAliasSec($secid);
			$tpl->assign("link_sec","$fulldomain/product/list/$aliasSec.html");
			$tpl->assign("namasec",$nama_cat);
		}

		$sDiskon		= 0;
		$hDiskon		= 0;
		if($misc_diskon!=0)
		{
			//$sDiskon		= ceil(($misc_diskon/100)*$misc_harga);
			$hDiskon		= $misc_diskon;
			$sDiskon		= $misc_harga - $misc_diskon;
		}

		$misc_harga1    = number_format($misc_harga,0,".",".");
		$misc_harga2    = "$misc_matauang $misc_harga1";
		$misc_diskonnya = "$misc_matauang ". number_format($hDiskon,0,".",".");
		$savenya        = "$misc_matauang ". number_format($sDiskon,0,".",".");
		
		//Data Brand
			$brand     = sql("select brandid,nama from tbl_product_brand where brandid='$brandidnya'");
			$dtb       = sql_fetch_data($brand);
			$namabrand = $dtb['nama'];
			$tpl->assign("namabrand",$namabrand);
		
		sql_free_result($query);
		
		$sql	= "update tbl_product set numviews=numviews+1 where kodeproduk='$kodeproduk' and produkid='$produkid'";
		$query	= sql($sql);

		$sqlpost = "select produkpostid,nomor,sizeid,body_weight,body_dimension from tbl_product_post where kodeproduk='$kodeproduk' order by produkpostid asc";
		$hslpost = sql($sqlpost);
		$itemprod = array();		
		$i = 0;
		$jmltotalstok	= 0;
		$jmlstokonh		= 0;
		$a = 1;
		while ($dtitem =  sql_fetch_data($hslpost)) 
		{	
			$produkpostid    = $dtitem['produkpostid'];
			$nomor         = $dtitem['nomor'];
			$sizeid          = $dtitem['sizeid'];
			$body_weight     = $dtitem['body_weight'];
			$body_weight     = $body_weight/1000;
			$body_dimension  = $dtitem['body_dimension'];

			$totalstok       = sql_get_var("select totalstok from tbl_product_total where produkpostid='$produkpostid'");
			$totalstokonhold = sql_get_var("select jumlah from tbl_product_stokonhold where produkpostid='$produkpostid'");
			$jmltotalstok    = $jmltotalstok+$totalstok;
			$jmlstokonh      = $jmlstokonh+$jmlstokonh;
			
			$stok = $totalstok-$totalstokonhold;
				
			$itemprod[$produkpostid] = array("produkpostid"=>$produkpostid,"no"=>$a,"nomor"=>$nomor,"stok"=>$stok,"warnaid"=>$warnaid,"sizeid"=>$sizeid,"size"=>$size);
			$i++;
			$a++;
			unset($stok);
				
		}
		sql_free_result($hslpost);
		$tpl->assign("itemprod",$itemprod);
		$tpl->assign("body_dimension",$body_dimension);
		$tpl->assign("body_weight",$body_weight);
		$tpl->assign("totalstok",$jmltotalstok-$jmlstokonh);
					

		// Gambar
		$sql3		= "select albumid,nama,gambar_m,gambar_s,gambar_l,gambar_f,produkpostid from tbl_product_image where produkid='$produkid' order by produkpostid asc";
		$query3		= sql($sql3);
		$list_image	= array();
		$ii			= 1;
		$albumarr 	= array();
		while($row3		= sql_fetch_data($query3))
		{
			$albumid	= $row3['albumid'];
			$nama_image	= $row3['nama'];
			$gambar_s	= $row3['gambar_s'];
			$gambar_m	= $row3['gambar_m'];
			$gambar_l	= $row3['gambar_l'];
			$gambar_f	= $row3['gambar_f'];
			$produkpostids = $row3['produkpostid'];
			
			if(!empty($gambar_m))
				$image_m	= "$fulldomain/gambar/produk/$gambar_m";
			else
				$image_m	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
				
			if(!empty($gambar_s))
				$image_s	= "$fulldomain/gambar/produk/$gambar_s";
			else
				$image_s	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
			
			if(!empty($gambar_l))
				$image_l	= "$fulldomain/gambar/produk/$gambar_l";
			else
				$image_l	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
				
			if(!empty($gambar_f))
				$image_f	= "$fulldomain/gambar/produk/$gambar_f";
			else
				$image_f	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
				
			if(($s=="m" or $s=="f") and ($var[7]))
			{
				if($albumid==$var[7])
				{
					$nama_image		= $nama_image;
					$firstImageId	= $albumid;
					$tpl->assign("detailgambar",$image_m);
				}
			}
			else if($ii == 1)
			{
				$image_besar	= $image_f;
				$image_mm		= $image_m;
				$image_ss 		= $image_s;
				$image_ll		= $image_l;
				$nama_image		= $nama_image;
				
				$firstImageId	= $albumid;
			}
			
			$list_image[$albumid]	= array("index"=>$ii,"albumid"=>$albumid,"nama_image"=>$nama_image,"image_m"=>$image_m,"image_s"=>$image_s,"image_l"=>$image_l,"image_f"=>$image_f);
			$albumarr[$ii] 			= $albumid;
			$ii++;
		}
		sql_free_result($query3);
		$tpl->assign("list_image",$list_image);
		
		
	
		$detailalias		= getAlias($namaprod);
		
		//produk wishlist 
		if($_SESSION['userid'])
		{
			$cekwl	= sql_get_var("select count(*) as jml from tbl_wishlist where userid='$_SESSION[userid]' and produkpostid='$produkpostid'");
			
			if($cekwl>0)
				$wishlist = 1;
			else
				$wishlist = 0;
			
			$cekrv	= sql_get_var("select count(a.transaksidetailid) as jml from tbl_transaksi_detail a, tbl_transaksi b where b.userid='$_SESSION[userid]' and a.produkpostid='$produkpostid' and b.status='4' and a.transaksiid=b.transaksiid");
			
			if($cekrv>0)
				$review = 1;
			else
				$review = 0;
		}

		//TAMPIL STOCK UPDATE PERGUDANG
		$querygdg = "select produkwhid,warehouseid,totalstok from tbl_product_wh where produkpostid='$produkpostid' order by produkwhid  asc";
		$hslgdg   = sql( $querygdg);

		$stockgdg = array();		
		$i = 0;
		while ($dtgdg =  sql_fetch_data($hslgdg)) 
		{	
			$warehouseid = $dtgdg['warehouseid'];
			$produkwhid  = $dtgdg['produkwhid'];
			$totalstok   = $dtgdg['totalstok'];
			$namagdg     = sql_get_var("select nama from tbl_warehouse where warehouseid='$warehouseid'");
				
			$stockgdg[$produkwhid] = array("produkwhid"=>$produkwhid,"warehouseid"=>$warehouseid,"totalstok"=>$totalstok,"namagdg"=>$namagdg);
			$i++;
		}
		sql_free_result($hslgdg);
		$tpl->assign("stockgdg",$stockgdg);

		session_start();
		
		$tpl->assign("secId",$secId);
		$tpl->assign("subId",$subId);
		$tpl->assign("produkpostid",$produkpostid);
		$tpl->assign("detailnama",$namaprod);
		$tpl->assign("detailtotalrating",$totalrating);
		
		$tpl->assign("price",$misc_harga2);
		$tpl->assign("savenya",$savenya);
		$tpl->assign("misc_diskonn",$sDiskon);
		$tpl->assign("misc_diskon",$misc_diskonnya);
		$tpl->assign("hargares",$misc_hargares2);
		
		$tpl->assign("tags",$tag);
		$tpl->assign("image_m",$image_mm);
		$tpl->assign("image_s",$image_ss);
		$tpl->assign("image_l",$image_ll);
		$tpl->assign("namaprod",$namaprod);
		$tpl->assign("detailringkas",$ringkas);
		$tpl->assign("detaillengkap",$content);
		$tpl->assign("cart",$cart);
		$tpl->assign("detailalias",$detailalias);
		$tpl->assign("secid1",$var[3]);
		$tpl->assign("subid1","$var[4]/$var[5]");
		$tpl->assign("detailtanggal",$postTime);
		$tpl->assign("detailgambar",$image_ll);
		$tpl->assign("image_besar",$image_besar);
		$tpl->assign("stock",$stock);
		$tpl->assign("link_cat","$fulldomain/product/list/$aliasSec");
		$tpl->assign("gambarproduk",$gambarproduk);
		$tpl->assign("videoproduk",$videoproduk);
		$tpl->assign("jenisvideo",$jenisvideo);
		$tpl->assign("link_buy","$fulldomain/quickbuy/addpost/$produkpostid/$detailalias.html");
		$tpl->assign("detailkode",$kodeproduk);
		$tpl->assign("wishlist",$wishlist);
		$tpl->assign("review",$review);
		$tpl->assign("icon",$icons);
			
		// komentar
		if($_POST[aksi] == "simpan")
		{
			if(preg_match("/href/i",$_POST[komentar]))
			{
				header("location: http://".$_SERVER['HTTP_HOST']."");
			}
			
			$produkpostid = $_POST['produkpostid'];
			$produkid     = $_POST['produkid'];
			$userid       = $_POST['userid'];
			$nama         = $_POST['name'];
			$email        = $_POST['email'];
			$score        = $_POST['score'];
			$komentar     = str_replace("'","`",$_POST['pesan']);
			$komentar     = str_replace("<!--","",$komentar);
			$ip           = $_SERVER['REMOTE_ADDR'];
			
			if($_POST[callback]) $callback		= "/?callback=$_POST[callback]";
							 
			if (!$_SESSION['userid'])
			{
				$salah .= ("You have to login first<br>\n");
				$benar = 2;
			}
			if (empty($komentar))
			{
				$salah .= ("Comment you haven't input<br>\n");
				$benar = 2;
			}
			
			if ($benar == 2)
			{
				
				$error = "Sorry there is a mistake entering your data or lacking in filling out the form provided
						<br>$salah ";
				$tpl->assign("error",$error); 
				$tpl->assign("style","error"); 
			}	 
			else
			{
				
				$perintah	= "insert into tbl_product_comment (produkpostid,produkid,userid,nama,email,score,komentar,ip,published,via,create_date,create_userid) 
							values ('$produkpostid','$produkid','$userid','$_SESSION[userfullname]','$_SESSION[useremail]','$score','$komentar','$ip','1','".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."','$date','$cuserid')";
							/*
				$perintah	= "insert into tbl_product_comment (produkpostid,userid,nama,email,komentar,ip,published,via,create_date,create_userid) 
							values ('$produkpostid','$userid','$_SESSION[userfullname]','$_SESSION[useremail]','$komentar','$ip','1','".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."','$date','$cuserid')";*/
				$hasil		= sql($perintah);
				
				// setlog
				/*if ($_SESSION['userid'] != $userid)
					setlog($nama,$Username,"Mengomentari Produk Anda.","$fulldomain/grosir/read/$aliasSec/$aliasSub/$produkpostid","commentproduct");*/
				
				if($hasil)
					header("location: $fulldomain/grosir/read/$aliasSec/$aliasSub/$produkpostid$callback");
			}
		}
		
		// list comment
		$sqlc	= "select commentid,nama,komentar,create_date,userid,score from tbl_product_comment where produkid='$produkid' and published='1' order by create_date desc";//produkpostid='$produkpostid' and 
		$queryc	= sql($sqlc);
		$numc	= sql_num_rows($queryc);
		$list_comment	= array();
		$no		= 1;
		while($rowc = sql_fetch_data($queryc))
		{
			$commentid = $rowc['commentid'];
			$nama      = $rowc['nama'];
			$userid    = $rowc['userid'];
			$komentar  = $rowc['komentar'];
			$score     = $rowc['score'];

			if($s!="m") $tanggal	= tanggal_english($rowc['create_date']);
			else $tanggal	= tanggal_english($rowc['create_date']);
			
			$useremail = sql_get_var("select useremail from tbl_member where userid='$userid'");

			$gambar		= get_gravatar($useremail);
			
			$list_comment[$commentid]	= array("commentid"=>$commentid,"nama"=>$nama,"komentar"=>$komentar,"tanggal"=>$tanggal,"no"=>$no,"gambar"=>$gambar,"score"=>$score);
			$no++;
		}
		sql_free_result($queryc);
		$tpl->assign("numc",$numc);
		$tpl->assign("list_comment",$list_comment);
		
		//Related Products/ Produk Lainnya
		$sql2	= "select kodeproduk,produkid,secid,subid,title,misc_harga,ringkas, misc_matauang,misc_diskon from tbl_product where status='1' 
				and published='1' and produkid!='$produkid' order by update_date desc limit 8";// and secid='$secId' and subid='$subId'
		$query2	= sql($sql2);
		$numprod= sql_num_rows($query2);
		$produklain	= array();
		while($row2 = sql_fetch_data($query2))
		{
			$kodeproduk    = $row2['kodeproduk'];
			$produkid1     = $row2['produkid'];
			$secId1        = $row2['secid'];
			$subId1        = $row2['subid'];
			$aliasSecc1    = getAliasSec($secId1);
			$aliasSubb1    = getAliasSub($subId1);
			$namaprod      = $row2["title"];
			// $misc_harga    = number_format($row2['misc_harga']);
			$content       = bersih(substr($row2["ringkas"],0,50));
			$aliasprod     = getAlias($namaprod);
			$misc_matauang = $row2['misc_matauang'];
			$misc_diskon   = $row2['misc_diskon'];
			$jenisvideo    = $row2['jenisvideo'];
			$screenshot    = $row2['screenshot'];
			$misc_harga    = $row2['misc_harga'];
			$produkpostid1 = sql_get_var("select produkpostid from tbl_product_post where kodeproduk='$kodeproduk'");
		
			$sDiskon		= 0;
			$hDiskon		= 0;
			if($misc_diskon!=0)
			{
				//$sDiskon		= ceil(($misc_diskon/100)*$misc_harga);
				$hDiskon		= $misc_diskon;
				$sDiskon		= $misc_harga - $misc_diskon;
			}
			
			$misc_harga		= $misc_matauang." ". number_format($misc_harga,0,".",".");
			$misc_diskonnya	= $misc_matauang." ". number_format($hDiskon,0,".",".");
			$savenya		= $misc_matauang." ". number_format($sDiskon,0,".",".");

			$sql3	= "select albumid,gambar_s,gambar_m from tbl_product_image where produkid='$produkid1' order by albumid asc limit 1";// and produkid='$produkid'
			$query3	= sql($sql3);
			$row3	= sql_fetch_data($query3);
			$albumid	= $row3['albumid'];
			$gambar_s	= $row3['gambar_s'];
			$gambar_m	= $row3['gambar_m'];
			sql_free_result($query3);

			if(!empty($gambar_m))
				$image_m	= "$fulldomain/gambar/produk/$gambar_m";
			else
				$image_m	= $fulldomain.$lokasiwebtemplate."images/no_photo.gif";
			
			// $link_detail	= "$fulldomain/grosir/read/$aliasSecc1/$aliasSubb1/$produkpostid1/$aliasprod.html";
			$link_detail	= "$fulldomain/grosir/read/$produkpostid1/$aliasprod.html";
			$link_buy 		= "$fulldomain"."quickbuy/addpost/$produkpostid1/$aliasprod.html";
			
			$produklain[$produkid1]	= array("produkid1"=>$produkid1,"produkpostid"=>$produkpostid1,"namaprod"=>$namaprod,"image_m"=>$image_m,"link_buy"=>$link_buy,
												"link_detail"=>$link_detail,"misc_matauang"=>$misc_matauang,"cekdiskon"=>$hDiskon,"hargaasli"=>$misc_harga,
												"hargadiskon"=>$misc_diskonnya,"savenya_related"=>$savenya,"save_related"=>$sDiskon,"misc_diskon"=>$misc_diskon,
												"hargares"=>$misc_hargares2);
		}
		sql_free_result($query2);//print_r($produklain);
		$tpl->assign("numprod",$numprod);
		$tpl->assign("produklain",$produklain);


?>
