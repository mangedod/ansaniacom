#!/usr/bin/php
<?php 
include("../setingan/web.config.inc.php");

$lokasiweb = str_replace("/bin","",$lokasiweb);

//GET Configuration
$sql	= "select id, smtphost, smtpport, smtpuser, apikey from tbl_konfigurasi_newsletter";
$query	= sql($sql);
$row = sql_fetch_data($query);

$smtphost = $row['smtphost'];
$smtpport = $row['smtpport'];
$smtpuser = $row['smtpuser'];
$apikey = $row['apikey'];
$id = $row['id'];

require_once '../librari/mandrill/src/Mandrill.php'; 


$date = date("Y-m-d H:i:s");

while($i<251)
{

	
	$sql = "select id,newsletterid,useremail,mandrillid from tbl_newsletter_subcriber where mandrillid!='' and cek='0' order by id limit 1";
	$hsl = sql($sql);
	
	while($data = sql_fetch_data($hsl))
	{
		$id = $data['id'];
		$mandrillid = $data['mandrillid'];
		$useremail = $data['useremail'];
	
		if(!empty($mandrillid))
		{
		
			try
			{
				$mandrill = new Mandrill($apikey);
				
				$result = $mandrill->messages->info($mandrillid);
				
				$status = $result['state'];
				$opens = $result['opens'];
				$clicks = $result['clicks'];
				
				echo "$status\r\n";
				
				if($status=="sent")
				{
					$update = "update tbl_newsletter_subcriber set status='1',open='$opens',click='$clicks',cek='1',state='$status' where mandrillid='$mandrillid'";
					$hasil = sql($update);
					
					echo "sent\r\n";
				}
				elseif($status=="bounced" || $status=="spam" || $status=="invalid")
				{
					$update = "update tbl_newsletter_subcriber set status='2',bounce='1',open='$opens',click='$clicks',cek='1',state='$status' where mandrillid='$mandrillid'";
					$hasil = sql($update);
					
					//set bounce
					$update = "update tbl_subcriber set status='1' where useremail='$useremail'";
					$hasil = sql($update);
					echo "bounce\r\n";
				}
				elseif($status=="soft-bounced")
				{
					$update = "update tbl_newsletter_subcriber set status='2',bounce='1',open='$opens',click='$clicks',cek='1',state='$status' where mandrillid='$mandrillid'";
					$hasil = sql($update);
					
				}
				else if($status=="deferred")
				{
					$update = "update tbl_newsletter_subcriber set cek='1',state='$status' where mandrillid='$mandrillid'";
					$hasil = sql($update);
					echo "Deferred\r\n";
				}
				
				unset($result);
				
			}
			catch(Mandrill_Error $e)
			{
				$error = $e->getMessage();
				
				if(preg_match("/No message exists/i",$error))
				{
					$update = "update tbl_newsletter_subcriber set cek='1' where mandrillid='$mandrillid'";
					$hasil = sql($update);
				}
				
				echo "$error\r\n";
				
			}
			
			
			
		
		}
		
		unset($mandrillid);
	}
	$i++;
	
}
sql_free_result($hsl);
exit();
?>
