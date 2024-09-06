<?php 
if(file_exists($lokasiweb."/komponen/$kanal/$kanal.$aksi.php")) include("$kanal.$aksi.php");
else{ $aksi = "simpan_konfirm";  include("$kanal.registrasi.php"); }

	$kodeinvoice = $var[3];
	$invoiceid   = base64_decode($kodeinvoice);
		
		if(!empty($kodeinvoice))
		{
			$sql1 	= "select transregisid,reginvoiceid,totaltagihan,namalengkap from tbl_transaksi_registrasi where reginvoiceid='$invoiceid'";
			$hsl1                    = sql($sql1);
			$row1                    = sql_fetch_data($hsl1);
			$transregisid            = $row1['transregisid'];
			$reginvoiceid            = $row1['reginvoiceid'];
			$totaltagihan            = $row1['totaltagihan'];
			$namalengkap            = $row1['namalengkap'];
			$bank_tujuan             = $row1['bank_tujuan'];
	
			$tpl->assign("invoicenya",$reginvoiceid);
			$tpl->assign("namalengkap",$namalengkap);
			$tpl->assign("subtotalnya",$totaltagihan);
			$tpl->assign("subtotal2","Rp. ".number_format($totaltagihan,0,".",".").",-");
		}
		
		/*if(!empty($bank_tujuan))
			 $where = "and id = '$bank_tujuan'";*/
		
		$perintah 	= "select * from tbl_norek where status='1' $where";
		$hasil 		= sql($perintah);
		while ($data=sql_fetch_data($hasil)) 
		{
			$id			= $data['id'];
			$id_bank	= $data['bank'];
			$norek		= $data['norek'];
			
			$sql8	= "select namabank from tbl_bank where bankid='$id_bank'";
			$res8	= sql($sql8);
			$row8	= sql_fetch_data($res8);
			$namabank	= $row8['namabank'];
			
			sql_free_result($res8);
			
			$nama = "$namabank ($norek)";
			
			$bank[$id] = array("id"=>$id, "nama"=>$nama, "id_bank"=>$id_bank);
		}
		sql_free_result($hasil);
		$tpl->assign("bank",$bank);
		$tpl->assign("now",date("Y-m-d"));
		
		// tampil bulan dan tahun
		$month	= array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		while(list($bln,$namabulan) = each($month))
		{
			$list_bulan[$bln]	= array("bln"=>$bln,"namabulan"=>$namabulan);
		}
		$tpl->assign("list_bulan",$list_bulan);
		
		for($thn=2015; $thn<=date("Y"); $thn++)
		{
			$list_tahun[$thn]	= array("thn"=>$thn);
		}
		$tpl->assign("list_tahun",$list_tahun);
		
		for($tgl=1; $tgl<=31; $tgl++)
		{
			$list_tanggal[$tgl]	= array("tgl"=>$tgl);
		}
		$tpl->assign("list_tanggal",$list_tanggal);

$tpl->display("$kanal.html");
?>