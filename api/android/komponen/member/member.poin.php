<?php
$subaksi = $var[4];
$batas_paging = 5;
$start = $var[6];
$limit = $var[7];
$userid = $var[5];


$datamember = sql_get_var_row("select userfullname,userid,username from tbl_member where userid='$userid'");
$username = $datamember['username'];

if($username)
{
		//notifikasi sudah dibaca
		$hlm 			= $hlm;
		$judul_per_hlm 	= 10;
		$batas_paging 	= 5;
		
		$sql = "select count(*) as jml from tbl_member_point_history where userid='$userid' and status='1'";
		$hsl =sql($sql);
		$tot = sql_result($hsl, 0, jml);
		$hlm_tot = ceil($tot / $judul_per_hlm);		
		if (empty($hlm)){
			$hlm = 1;
			}
		if ($hlm > $hlm_tot){
			$hlm = $hlm_tot;
			}
		
		$ord = ($hlm - 1) * $judul_per_hlm;
		if ($ord < 0 ) $ord=0;
	
		//Notifikasi
		$perintah = "select id, ordernumber,redeemnumber,point, status, create_date,balancetotal,tipe,activity from tbl_member_point_history where userid='$userid' order by id desc limit $start, $limit";
		$hasil =sql($perintah);
		$jml = sql_num_rows($hasil);
		if($jml>0)
		{
			$notifikasi = array();
			while($row = sql_fetch_data($hasil))
			{
					$id				= $row['id'];
					$ordernumber 	= $row['ordernumber'];
					$point		 	= $row['point'];
					$tanggal	 	= tanggal($row['create_date']);
					$status		 	= $row['status'];
					$tipe		 	= $row['tipe'];
					$balance		 	= $row['balancetotal'];
					$activity = $row['activity'];
					
					$aktifitas = sql_get_var("select nama from tbl_poin_config where alias='$activity'");
				
					$pointt	 = number_format($point,0,".",".");
					$balancet	 = number_format($balance,0,".",".");
				

					if($tipe == 'CR')
					{
						$tipe = "<span class=\"label label-success\">Earn</span>";
						$ketstatus = "Earning <strong>$point point</strong> from Activity $aktifitas";
						
					}
					elseif($tipe == 'DB')
					{
						if($activity!="delete-status")
						{
							$redeemnumber 	= $row['redeemnumber'];
							$tipe = "<span class=\"label label-danger\">Redeem</span>";
							$ketstatus = "Redeem <strong>$point point</strong> for Transaction";
						}
						else
						{
							$redeemnumber 	= $row['redeemnumber'];
							$tipe = "<span class=\"label label-warning\">Minus</span>";
							$ketstatus = "Minus <strong>$point poin</strong> because from activity $aktifitas";
						}
					}
					
					$pesan = "$ketstatus<br><small>$tanggal</small>";
				
					$listpoin[]	= array("id"=>$id,"pesan"=>$pesan,"tanggal"=>$tanggal);
				
			}
			sql_free_result($hasil);
			$result['status']="OK";
			$result['message']="Notifikasi terbaru berhasil di load";
			$result['listpoin']=$listpoin;
			$result['jumlahnotifikasi']=$jml;
			
			//Paging 
			$batas_page =5;
			
			$stringpage = array();
			$pageid =0;
			
			if ($hlm > 1){
				$prev = $hlm - 1;
				$stringpage[$pageid] = array("nama"=>"Awal","link"=>"$domainfull/$kanal/$aksi/1");
				$pageid++;
				$stringpage[$pageid] = array("nama"=>"&laquo;","link"=>"$domainfull/$kanal/$aksi/$prev");
		
			}
			else {
				$stringpage[$pageid] = array("nama"=>"Awal","link"=>"");
				$pageid++;
				$stringpage[$pageid] = array("nama"=>"&laquo;","link"=>"");
			}
			
			$hlm2 = $hlm - (ceil($batas_page/2));
			$hlm4= $hlm+(ceil($batas_page/2));
			
			if($hlm2 <= 0 ) $hlm3=1;
			   else $hlm3 = $hlm2;
			$pageid++;
			for ($ii=$hlm3; $ii <= $hlm_tot and $ii<=$hlm4; $ii++){
				if ($ii==$hlm){
					$stringpage[$pageid] = array("nama"=>"$ii","link"=>"","class"=>"active"	);
				}else{
					$stringpage[$pageid] = array("nama"=>"$ii","link"=>"$domainfull/$kanal/$aksi/$ii");
				}
				$pageid++;
			}
			if ($hlm < $hlm_tot){
				$next = $hlm + 1;
				$stringpage[$pageid] = array("nama"=>"&raquo;","link"=>"$domainfull/$kanal/$aksi/$next");
				$pageid++;
				$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"$domainfull/$kanal/$aksi/$hlm_tot");
			}
			else
			{
				$stringpage[$pageid] = array("nama"=>"&raquo;","link"=>"");
				$pageid++;
				$stringpage[$pageid] = array("nama"=>"Akhir","link"=>"");
			}
			$result['stringpage']=$stringpage;
		}
		else
		{
			$result['status']="ERROR";
			$result['message']="Tidak ada Notifikasi untuk Anda.";
		}
	
	echo json_encode($result);
	exit;
}
else
{
	$result['status'] = "Error"; 
	$result['message']="Tidak ada data dikirim";
	echo json_encode($result);
	exit;
}


?>