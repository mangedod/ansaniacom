<?php
$userid = $var[4];
$id = $var[5];

$datamember = sql_get_var_row("select userfullname,userid,username from tbl_member where userid='$userid'");
$username = $datamember['username'];

$last = sql_get_var("select point from tbl_member where userid='$userid'");
	
$perintah = "select id,nama,oleh,ringkas,lengkap,gambar1,gambar,poin,alias,views from tbl_redeem where id='$id'";
$hasil = sql($perintah);
$data =  sql_fetch_data($hasil);

$idcontent = $data['id'];
$nama=$data['nama'];
$oleh = $data['oleh'];
$lengkap= $data['lengkap'];
$tanggal = tanggal($data['create_date']);
$gambar = $data['gambar1'];
$gambarshare = $data['gambar'];
$ringkas = $data['ringkas'];
$alias = $data['alias'];
$poin = $data['poin'];



//Last Redeem
$lastd = sql_get_var("select create_date from tbl_member_redeem where userid='$userid' order by id desc limit 1");
$lastlogin = date("Y-m-d H:i:s"); 
			
$date1 = new DateTime($lastlogin);
$date2 = new DateTime($lastd);

$diff = $date2->diff($date1);

$days = $diff->days;
$hours = $diff->h;
$hours = $hours;


if($hours<2 && $days==0)
{
	
	$msg = "Redeem poin anda gagal karena melakukan redeem berulang dalam jangka waktu yang cepat. Silahkan tunggu satu jam kembali untuk melakukan redeem.
	Silahkan lihat di daftar redeem yang telah anda lakukan";
	$cukup = "0";
	
	$result['status']="ERROR";
	$result['message']="$msg";
	echo json_encode($result);
	exit();
}

if($last<$poin)
{
	$msg = "Poin anda tidak cukup untuk melakukan penukaran poin untuk paket redeem $nama yang mengharuskan anda memiliki poin sebanyak $poin poin. Silahkan kumpulkan poin lagi dan tukarkan poin anda dengan banyak paket redeem yang tersedia";
	$cukup = "0";
	
	$result['status']="ERROR";
	$result['message']="$msg";
	echo json_encode($result);
	exit();

}
else
{
		$vouchercode = generateCode(6);
		$vouchercode = strtoupper($vouchercode);
		
		$expiredate = date('Y-m-d H:i:s', strtotime("+30 days"));
		$expiredate = tanggal($expiredate);
		
		$email = '<table style="border:2px solid #666; font-family: Arial; padding:10px; background:#FFF" width="609" border="0" cellspacing="5" cellpadding="5">
	  <tr>
		<td width="225" height="256"><img src="https://www.dfunstation.com/images/img.logo.dfun.jpg"></td>
		<td width="349" align="center" style="font-size:20px"><p>VOUCHER PENUKARAN POIN<br>
		  MEMBER DFUN STATION</p>
		  <p><span style="font-size:40px; font-weight:bold">'.$vouchercode.'</span><br>
			<br>
			'.$nama.'      </p>
		  <p  style="font-size:14px">Berlaku hingga<br> '.$expiredate.'</p>
		  <p>&nbsp;</p></td>
	  </tr>
	</table>';
	
		
		//Data User
		$sqlm = "select username,userfullname,useremail,userphonegsm from tbl_member where userid='$userid'";
		$hslm = sql($sqlm);
		$datam = sql_fetch_data($hslm);
		
		$userfullname = $datam['userfullname'];
		$useremail = $datam['useremail'];
		$userhandphone = $datam['userphonegsm'];
		$memberid = $datam['memberid'];
		sql_free_result($hslm);	
		
		
		$date = date("Y-m-d H:i:s");
		$newredeeimd = newid("id","tbl_member_redeem");
		$sql = "insert into tbl_member_redeem(id,create_date,userid,poin,vouchercode,nama,redeemid)
					values('$newredeeimd','$date','$userid','$poin','$vouchercode','$nama','$idcontent')";
		$hsl = sql($sql);
		
		if($hsl)
		{
			$pesansms = "Penukaran $poin Poin anda berhasil untuk $nama, VoucherCode anda $vouchercode. dfunStation";
			$emailjudul  = "Voucher Penukaran Poin Member dfun Station";
			
			kirimSMS($userhandphone,$pesansms);
			sendmail($userfullname,$useremail,$emailjudul,$email,$email);
			
			$date = date("Y-m-d H:i:s");
			$expiredate = date('Y-m-d H:i:s', strtotime("+$pointexpire months"));
			
			$totpoint = $last-$poin;
		
			$sql = "insert into tbl_member_pointredeem(create_date,userid,transid,point,status,conversion,balance)
					values('$date','$userid','$newredeeimd','$poin','1','$redeempoint','$totpoint')";
			$hsl = sql($sql);
			
		
			$sql = "insert into tbl_member_point_history(create_date,userid,transid,ordernumber,redeemnumber,point,tipe,balancetotal,activity)
								values('$date','$userid','$newredeeimd','$earnordernumber','$ordernumber','$poin','DB','$totpoint','redeem')";
			$hsl = sql($sql);
			
			
			$update = sql("update tbl_member set point=$totpoint where userid='$userid'");
			
			$msg = "Penukaran poin anda untuk paket $nama berhasil dilakukan, anda bisa membuka email anda untuk melihat
			voucher yang telah kami kirimkan. Terima kasih";
			$cukup = "1";
		
		$result['status']="OK";
		$result['message']="$msg";
		
		echo json_encode($result);
	}
	else
	{
		$msg = "Mohon maaf redeem poin anda gagal dikarenakan kesalahan sistem. Silahkan coba kembali di lain waktu";
		$result['status']="ERROR";
		$result['message']="$msg";
		
		echo json_encode($result);
	}
}



?>
