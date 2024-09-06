<?php 
$userid = $_GET['userid'];

if(isset($userid))
{
	$notif = sql_get_var_row("select count(*) as jml,pvemail,pvphonegsm,pvaddress,pvnotif from tbl_member where userid='$userid'");
	$pvemail=$notif['pvemail'];
	$pvphonegsm=$notif['pvtelp'];
	$pvnotif = $notif['pvnotif'];
	$pvaddress = $notif['pvaddress'];
	$jml = $notif['jml'];
	
	if($jml==1)
	{
		$result['status']="OK";
		$result['message']="Data berhasil di load";
		$result['pvemail']=$pvemail;
		$result['pvphonegsm']=$pvphonegsm;
		$result['pvaddress']=$pvaddress;
		$result['pvnotif']=$pvnotif;
	}
	else
	{
		$result['status']="ERROR";
		$result['message']="Pengaturan privacy belum ada";
		$result['pvemail']=0;
		$result['pvphonegsm']=0;
		$result['pvnotif']=0;
		$result['pvaddress']=0;
	}
}
else
{
	$result['status']="ERROR";
	$result['message']="Member tidak terdaftar";
	$result['pvemail']=0;
	$result['pvphonegsm']=0;
	$result['pvnotif']=0;
}
echo json_encode($result);
exit;
?>