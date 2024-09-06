<?php
header('Content-type: text/javascript; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type');

include("../../setingan/web.config.inc.php");

$username = $_GET['uname'];

$uid = sql_get_var("select userid from tbl_member where username='$username'");

$perintah	= "select userid from tbl_follow where fid='$uid' order by id desc";
$hasil		= sql($perintah);
$jumfollower	= sql_num_rows($hasil);
$datateman	= array();
$id	= 1;
while($data	= sql_fetch_data($hasil))
{
	$approveId	= $data['userid'];
	
	$dataapprove	= getProfileId($approveId);
	$approve	= $dataapprove['username'];
	$namateman	= $dataapprove['userfullname'];
	$gambar		= $dataapprove['avatar'];
		
	if(preg_match("/\</i",$namateman) and !preg_match("/>/i",$namateman)) $namateman = $namateman.">";
		$namateman = bersih($namateman);
				
	$datafollower[] =array("id"=>$approveId,"uname"=>"@".$approve,"name"=>$namateman,"avatar"=>$gambar,"type"=>"contact");
	$id++;
}
echo json_encode($datafollower);


/*[
							{ id:1, name:'Kenneth Auchenberg', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' },
							{ id:2, name:'Jon Froda', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' },
							{ id:3, name:'Anders Pollas', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' },
							{ id:4, name:'Kasper Hulthin', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' },
							{ id:5, name:'Andreas Haugstrup', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' },
							{ id:6, name:'Pete Lacey', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' },
							{ id:7, name:'kenneth@auchenberg.dk', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' },
							{ id:8, name:'Pete Awesome Lacey', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' },
							{ id:9, name:'Kenneth Hulthin', 'avatar':'http://cdn0.4dots.com/i/customavatars/avatar7112_1.gif', 'type':'contact' }
							]*/
?>