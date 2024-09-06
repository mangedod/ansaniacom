<?php 
function sql($sql)
{
	global $connect;
	$res = mysqli_query($connect,$sql);
	if(!$res)
	{
		$uri = $_SERVER['REQUEST_URI'];
		$post = serialize($_POST);
		$data = date('Y-m-d H:i:s')." | $ip | $uri ".mysqli_error($connect)." SQL: $sql\r\n";
		$file = "sql-error.txt";
		$open = fopen($file, "a+"); 
		fwrite($open, "$data"); 
		fclose($open);
	} 
	return $res;
}
function sql_result($res,$arr,$field)
{
	$res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
}
function sql_fetch_object($res)
{
	$res = mysqli_fetch_object($res);
	return $res;
}
function sql_fetch_array($res)
{
	$res = mysqli_fetch_array($res);
	return $res;
}
function sql_fetch_data($res)
{
	if($res)
	{
		$res = mysqli_fetch_assoc($res);
		return $res;
	}
}
function sql_fetch_assoc($res)
{
	$res = mysqli_fetch_assoc($res);
	return $res;
}

function sql_num_rows($res)
{
	$res = mysqli_num_rows($res);
	return $res;
}
function sql_free_result($res)
{
	if($res)
	{
	$res = mysqli_free_result($res);
	return $res;
	}
}

function sql_real_escape_str($str)
{
	global $connect;

	return mysqli_real_escape_string($connect, $str);
}

function input($input)
{
	global $connect;
	
	//Anti CrossSite Scripting
	if(preg_match("/script/i",$input))
	{
		http_response_code(403);
		die();
	}
	if(preg_match("/1=1/i",$input))
	{
		http_response_code(403);
		die();
	}
	if(preg_match('/(union|select|delete)/i',$input))
	{
		http_response_code(403);
		die();
	}
	if(preg_match("/\"\"=\"\"/i",$input))
	{
		http_response_code(403);
		die();
	}
	if(preg_match("/prompt/i",$input))
	{
		http_response_code(403);
		die();
	}
	
	if(is_array($input))
	{
		 $arr = array();
		 foreach($input as $key => $val){
		   $vals = mysqli_real_escape_string($connect,$val);
		   $arr[] = array($key=>$vals);
		 }
		 return $arr;
	}
	else
	{
		$input = mysqli_real_escape_string($connect,$input);
		return $input;
	}
}
function sql_get_var_row($query)
{
	$res = sql($query);
	$row = mysqli_fetch_assoc($res);

	return $row;
	sql_free_result($res);
}
function newid($field,$tbl)
{
	$perintah	= "select max($field) as jml from $tbl";
	$query		= sql($perintah);
	$row		= sql_fetch_data($query);
	if($query) $newid = ($row['jml']) + 1; else $newid = 1;
	
	return $newid;
	sql_free_result($query);
}
function tanggal($tanggal)
	{
		global $site;
		$tahun = substr("$tanggal",0,4); 
		$bulan = substr("$tanggal", 5, 2); 
		$tgl = substr("$tanggal", 8, 2); 
		$jam = substr("$tanggal", 11, 2); 
		$mnt = substr("$tanggal", 14, 2); 
		if ($bulan=="01") { $bulan1="Januari"; }
		if ($bulan=="02"){ $bulan1="Februari"; }
		if ($bulan=="03"){ $bulan1="Maret"; }
		if ($bulan=="04"){ $bulan1="April"; }
		if ($bulan=="05"){ $bulan1="Mei"; }
		if ($bulan=="06"){ $bulan1="Juni"; }
		if ($bulan=="07"){ $bulan1="Juli"; }
		if ($bulan=="08"){ $bulan1="Agustus"; }
		if ($bulan=="09"){ $bulan1="September"; }
		if ($bulan=="10"){ $bulan1="Oktober"; }
		if ($bulan=="11"){ $bulan1="November"; }
		if ($bulan=="12") {$bulan1="Desember"; }
		
		if(!empty($bulan))
		{
			$time = mktime(0,0,0,$bulan,$tgl,$tahun);
			$hari = getdate($time);
			$array_hari = array("Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis",
								"Friday" => "Jum'at", "Saturday" => "Sabtu", "Sunday" => "Minggu");
			$hari = $array_hari[$hari['weekday']];
			
			if($site=="m")
			{
				$tgl="$hari, $tgl/$bulan/$tahun $jam:$mnt WIB ";
			}
			else
			{
				$tgl="$hari, $tgl $bulan1 $tahun $jam:$mnt WIB ";
			}
			return $tgl;
		}
		
	}
function tanggaltok($tanggal)
	{
		$tahun = substr("$tanggal",0,4); 
		$bulan = substr("$tanggal", 5, 2); 
		$tgl = substr("$tanggal", 8, 2); 
		$jam = substr("$tanggal", 11, 2); 
		$mnt = substr("$tanggal", 14, 2); 
		if ($bulan=="01") { $bulan1="Januari"; }
		if ($bulan=="02"){ $bulan1="Februari"; }
		if ($bulan=="03"){ $bulan1="Maret"; }
		if ($bulan=="04"){ $bulan1="April"; }
		if ($bulan=="05"){ $bulan1="Mei"; }
		if ($bulan=="06"){ $bulan1="Juni"; }
		if ($bulan=="07"){ $bulan1="Juli"; }
		if ($bulan=="08"){ $bulan1="Agustus"; }
		if ($bulan=="09"){ $bulan1="September"; }
		if ($bulan=="10"){ $bulan1="Oktober"; }
		if ($bulan=="11"){ $bulan1="November"; }
		if ($bulan=="12") {$bulan1="Desember"; }
		
		if(!empty($bulan))
		{
			$time = mktime(0,0,0,$bulan,$tgl,$tahun);
			$hari = getdate($time);
			$array_hari = array("Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis",
								"Friday" => "Jum'at", "Saturday" => "Sabtu", "Sunday" => "Minggu");
			$hari = $array_hari[$hari['weekday']];
			$tgl="$hari, $tgl $bulan1 $tahun ";			
			return $tgl;
		}
	}
function tanggalonly($tanggal)
	{
		$tahun = substr("$tanggal",0,4); 
		$bulan = substr("$tanggal", 5, 2); 
		$tgl = substr("$tanggal", 8, 2); 
		$jam = substr("$tanggal", 11, 2); 
		$mnt = substr("$tanggal", 14, 2); 
		if ($bulan=="01") { $bulan1="Januari"; }
		if ($bulan=="02"){ $bulan1="Februari"; }
		if ($bulan=="03"){ $bulan1="Maret"; }
		if ($bulan=="04"){ $bulan1="April"; }
		if ($bulan=="05"){ $bulan1="Mei"; }
		if ($bulan=="06"){ $bulan1="Juni"; }
		if ($bulan=="07"){ $bulan1="Juli"; }
		if ($bulan=="08"){ $bulan1="Agustus"; }
		if ($bulan=="09"){ $bulan1="September"; }
		if ($bulan=="10"){ $bulan1="Oktober"; }
		if ($bulan=="11"){ $bulan1="November"; }
		if ($bulan=="12") {$bulan1="Desember"; }
		
		if(!empty($bulan))
		{
			$time = mktime(0,0,0,$bulan,$tgl,$tahun);
			$hari = getdate($time);
			$array_hari = array("Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis",
								"Friday" => "Jum'at", "Saturday" => "Sabtu", "Sunday" => "Minggu");
			$hari = $array_hari[$hari['weekday']];
			$tgl="$tgl $bulan1 $tahun ";			
			return $tgl;
		}
	}
function tanggalsingkat($tanggal)
	{
		$tahun = substr("$tanggal",0,4); 
		$bulan = substr("$tanggal", 5, 2); 
		$tgl = substr("$tanggal", 8, 2); 
		$jam = substr("$tanggal", 11, 2); 
		$mnt = substr("$tanggal", 14, 2); 
		if ($bulan=="01") { $bulan1="01"; }
		if ($bulan=="02"){ $bulan1="02"; }
		if ($bulan=="03"){ $bulan1="03"; }
		if ($bulan=="04"){ $bulan1="04"; }
		if ($bulan=="05"){ $bulan1="05"; }
		if ($bulan=="06"){ $bulan1="06"; }
		if ($bulan=="07"){ $bulan1="07"; }
		if ($bulan=="08"){ $bulan1="08"; }
		if ($bulan=="09"){ $bulan1="09"; }
		if ($bulan=="10"){ $bulan1="10"; }
		if ($bulan=="11"){ $bulan1="11"; }
		if ($bulan=="12") {$bulan1="12"; }

		if(!empty($bulan))
		{
		
			$time = mktime(0,0,0,$bulan,$tgl,$tahun);
			$hari = getdate($time);
			$array_hari = array("Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis",
								"Friday" => "Jum'at", "Saturday" => "Sabtu", "Sunday" => "Minggu");
			$hari = $array_hari[$hari['weekday']];
			$tgl="$bulan1/$tgl/$tahun ";			
			return $tgl;
		}
	}

function getbulan($bulan)
{
	if ($bulan=="01"){ $bulan1="Januari"; }
	if ($bulan=="02"){ $bulan1="Februari"; }
	if ($bulan=="03"){ $bulan1="Maret"; }
	if ($bulan=="04"){ $bulan1="April"; }
	if ($bulan=="05"){ $bulan1="Mei"; }
	if ($bulan=="06"){ $bulan1="Juni"; }
	if ($bulan=="07"){ $bulan1="Juli"; }
	if ($bulan=="08"){ $bulan1="Agustus"; }
	if ($bulan=="09"){ $bulan1="September"; }
	if ($bulan=="10"){ $bulan1="Oktober"; }
	if ($bulan=="11"){ $bulan1="November"; }
	if ($bulan=="12") {$bulan1="Desember"; }

	return $bulan1;
}

function tanggaltok_english($tanggal)
{
	$tahun = substr("$tanggal",0,4); 
	$bulan = substr("$tanggal", 5, 2); 
	$tgl = substr("$tanggal", 8, 2); 
	$jam = substr("$tanggal", 11, 2); 
	$mnt = substr("$tanggal", 14, 2); 
	
	if ($bulan=="01") { $bulan1="January"; }
	if ($bulan=="02"){ $bulan1="February"; }
	if ($bulan=="03"){ $bulan1="March"; }
	if ($bulan=="04"){ $bulan1="April"; }
	if ($bulan=="05"){ $bulan1="May"; }
	if ($bulan=="06"){ $bulan1="June"; }
	if ($bulan=="07"){ $bulan1="July"; }
	if ($bulan=="08"){ $bulan1="August"; }
	if ($bulan=="09"){ $bulan1="September"; }
	if ($bulan=="10"){ $bulan1="October"; }
	if ($bulan=="11"){ $bulan1="November"; }
	if ($bulan=="12") {$bulan1="December"; }

	if(!empty($bulan))
	{
	
		$time = mktime(0,0,0,$bulan,$tgl,$tahun);
		$hari = getdate($time);
		/*$array_hari = array("Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis",
							"Friday" => "Jum'at", "Saturday" => "Sabtu", "Sunday" => "Minggu");*/
		$hari2 = $hari['weekday'];
		$tgl="$hari2, $tgl $bulan1 $tahun ";	
		return $tgl;
	}
}
function tanggal_english($tanggal)
{
	$tahun = substr("$tanggal",0,4); 
	$bulan = substr("$tanggal", 5, 2); 
	$tgl = substr("$tanggal", 8, 2); 
	$jam = substr("$tanggal", 11, 2); 
	$mnt = substr("$tanggal", 14, 2); 
	
	if ($bulan=="01") { $bulan1="January"; }
	if ($bulan=="02"){ $bulan1="February"; }
	if ($bulan=="03"){ $bulan1="March"; }
	if ($bulan=="04"){ $bulan1="April"; }
	if ($bulan=="05"){ $bulan1="May"; }
	if ($bulan=="06"){ $bulan1="June"; }
	if ($bulan=="07"){ $bulan1="July"; }
	if ($bulan=="08"){ $bulan1="August"; }
	if ($bulan=="09"){ $bulan1="September"; }
	if ($bulan=="10"){ $bulan1="October"; }
	if ($bulan=="11"){ $bulan1="November"; }
	if ($bulan=="12") {$bulan1="December"; }

	if(!empty($bulan))
	{
	
		$time = mktime(0,0,0,$bulan,$tgl,$tahun);
		$hari = getdate($time);
		/*$array_hari = array("Monday" => "Senin", "Tuesday" => "Selasa", "Wednesday" => "Rabu", "Thursday" => "Kamis",
							"Friday" => "Jum'at", "Saturday" => "Sabtu", "Sunday" => "Minggu");*/
		$hari2 = $hari['weekday'];
		$tgl="$hari2, $tgl $bulan1 $tahun $jam : $mnt";	
		return $tgl;
	}
}	
function clean($text)
{
	global $connect;

	$text = strip_tags($text);
	$text = str_replace("' or 1=1--", "", $text);
	$text = str_replace('" or 1=1�', "", $text);
	$text = str_replace('or 0=0 --', "", $text);
	$text = str_replace("' or 1=1 #", "", $text);
	$text = str_replace('" or 1=1 #', "", $text);
	$text = str_replace('or 0=0 #', "", $text);
	$text = str_replace("' or 'x' = 'x", "", $text);
	$text = str_replace('" or "x" = "x', "", $text);
	$text = str_replace("') or ('x' = 'x", "", $text);
	$text = str_replace("' or 1=1--", "", $text);
	$text = str_replace('" or 1=1--', "", $text);
	$text = str_replace('or 1=1--', "", $text);
	$text = str_replace('" or a=a--', "", $text);
	$text = mysqli_escape_string($connect,$text);
	$text = htmlspecialchars($text);
    return $text;
}

function cleaninsert($text)
{
	$text = str_replace("' or 1=1--", "", $text);
	$text = str_replace('" or 1=1�', "", $text);
	$text = str_replace('or 0=0 --', "", $text);
	$text = str_replace("' or 1=1 #", "", $text);
	$text = str_replace('" or 1=1 #', "", $text);
	$text = str_replace('or 0=0 #', "", $text);
	$text = str_replace("' or 'x' = 'x", "", $text);
	$text = str_replace('" or "x" = "x', "", $text);
	$text = str_replace("') or ('x' = 'x", "", $text);
	$text = str_replace("' or 1=1--", "", $text);
	$text = str_replace('" or 1=1--', "", $text);
	$text = str_replace('or 1=1--', "", $text);
	$text = str_replace('" or a=a--', "", $text);
	// $text = str_replace("'", "&apos;", $text);
	$text = htmlspecialchars($text);
    return $text;
}
function desc($text)
{
	$text = str_replace("' or 1=1--", "", $text);
	$text = str_replace('" or 1=1�', "", $text);
	$text = str_replace('or 0=0 --', "", $text);
	$text = str_replace("' or 1=1 #", "", $text);
	$text = str_replace('" or 1=1 #', "", $text);
	$text = str_replace('or 0=0 #', "", $text);
	$text = str_replace("' or 'x' = 'x", "", $text);
	$text = str_replace('" or "x" = "x', "", $text);
	$text = str_replace("') or ('x' = 'x", "", $text);
	$text = str_replace("' or 1=1--", "", $text);
	$text = str_replace('" or 1=1--', "", $text);
	$text = str_replace('or 1=1--', "", $text);
	$text = str_replace('" or a=a--', "", $text);
	$text = str_replace("'", "&apos;", $text);
    return $text;
}

function getimgext($src)
{
	$jenis = $src['type'];
	if(preg_match("/jp/i",$jenis)) $ext = "jpg";
	if(preg_match("/gif/i",$jenis)) $ext = "gif";
	if(preg_match("/png/i",$jenis)) $ext = "png";
	return $ext;
}

function resizeimg($src, $dst, $width, $height, $crop=0){

  if(!list($w,$h,$jenis) = getimagesize($src)) return false;
  
  if($jenis==1) $type = "gif";
  if($jenis==2) $type = "jpg";
  if($jenis==3) $type = "png";
  if($jenis==6) $type = "bmp";
  
  
  switch($type){
    case 'bmp': $img = imagecreatefromwbmp($src); break;
    case 'gif': $img = imagecreatefromgif($src); break;
    case 'jpg': $img = imagecreatefromjpeg($src); break;
    case 'png': $img = imagecreatefrompng($src); break;
    default : return false;
  }

 if($crop){
    $ratio = max($width/$w, $height/$h);
    $h = $height / $ratio;
    $x = ($w - $width / $ratio) / 2;
    $w = $width / $ratio;
  }
  else{
    $ratio = min($width/$w, $height/$h);
    $width = $w * $ratio;
    $height = $h * $ratio;
    $x = 0;
  }



  $new = imagecreatetruecolor($width, $height);

  if($type == "gif" or $type == "png"){
    imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
    imagealphablending($new, false);
    imagesavealpha($new, true);
  }

  imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);

  switch($type){
    case 'bmp': imagewbmp($new, $dst); break;
    case 'gif': imagegif($new, $dst); break;
    case 'jpg': imagejpeg($new, $dst); break;
    case 'png': imagepng($new, $dst); break;
  }
  return true;
}

function sql_get_var($query)
{
	$res = sql($query);
	$row = mysqli_fetch_array($res);
	$rec = $row[0];
	return $rec;
	sql_free_result($res);
}

function getalias($string)
{
	$str = str_replace('-', ' ', $string);
	$str = trim(strtolower($str));
	$str = preg_replace('/(\s|[^A-Za-z0-9\-])+/', '-', $str);
	$str = trim($str, '-');
	return $str;
}

function getVar($url,$jenis)
{
	$url  = str_replace("index.php?","",$url);
	$url  = str_replace(".html","",$url);
	
	$variable	= explode("/",$url);
	$kanal		= sql_real_escape_str($variable[1]);
	
	$perintah	= "select count(*) as jumlah from tbl_kanal where nama='$kanal'";
	 
	$hasil		= sql($perintah);
	$data		= sql_fetch_data($hasil);
	$jumlah		= $data['jumlah'];
	sql_free_result($hasil);



	if($jumlah > 0)
	{
		$perintah	= "select id,nama,rubrik,include from tbl_kanal where nama='$kanal' limit 1";
		$hasil		= sql($perintah);
		$data		= sql_fetch_data($hasil);
		$include	= $data['include'];
		
		$include	= "komponen/$include/$include.controller.php";
		$rubrik		= $data['rubrik'];
		sql_free_result($hasil);
		
		$jmlvar = count($variable);
		$var = "$include~~$rubrik~~";
		for($i=1;$i<=$jmlvar;$i++)
		{
			if($i==1) $var .="$kanal~~";
			else $var .= $variable[$i]."~~";
		}
		$var = substr($var,0,-2);
		$var = explode("~~",$var);
		return $var;
	}
	else
	{
		
				$perintah	= "select id,nama,rubrik,include from tbl_kanal where nama='home' limit 1";
				$hasil		= sql($perintah);
				$data		= sql_fetch_data($hasil);
				$include	= $data['include'];

				$include	= "komponen/$include/$include.controller.php";
				$rubrik		= $data['rubrik'];
				sql_free_result($hasil);
				
				$jmlvar = count($variable);
				$var = "$include~~$rubrik~~";
				for($i=1;$i<=$jmlvar;$i++)
				{
					if($i==1) $var .="home~~";
					else $var .= $variable[$i]."~~";
				}
				$var = substr($var,0,-2);
				$var = explode("~~",$var);
				return $var;
		
	}
}
function getNamaLengkap($username)
{
	global $database;
	$perintah = "select userfullname from tbl_member where username='$username'";
	$hasil = sql( $perintah);
	$data = sql_fetch_data($hasil);
	$userFullName = $data['userfullname'];
	sql_free_result($hasil);
	return $userFullName;
}
function getNamalengkapId($userid)
{
	global $database;
	$perintah = "select userfullname from tbl_member where userid='$userid'";
	$hasil = sql( $perintah);
	$data = sql_fetch_data($hasil);
	$userFullName = $data['userfullname'];
	sql_free_result($hasil);
	return $userFullName;
}
function generateCode($characters) {
      $possible = '23456789bcdfghjknpqrstvwxyz';
      $code = '';
      $i = 0;
      while ($i < $characters) { 
         $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
         $i++;
      }
      return $code;
   }

function emailhtml($content)
{
	$email = '<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>$title</title>
   <style type="text/css">
   	a {color: #4A72AF;}
	body, #header h1, #header h2, p {margin: 0; padding: 0; font-size: 12px; font-family: Arial, Helvetica, sans-serif; color: #3f4042; line-height:22px;}
	#main {border: 1px solid #cfcece;}
	img {display: block;}
	#top-message p, #bottom-message p {color: #3f4042; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
	#header h1 {color: #ffffff !important; font-family: Arial, sans-serif; font-size: 24px; margin-bottom: 0!important; padding-bottom: 0; }
	#header h2 {color: #ffffff !important; font-family: Arial, Helvetica, sans-serif; font-size: 24px; margin-bottom: 0 !important; padding-bottom: 0; }
	#header p {color: #ffffff !important; font-family: Arial, sans-serif; font-size: 12px;  }
	h1, h2, h3, h4, h5, h6 {margin: 0 0 0.8em 0;}
	h3 {font-size: 28px; color: #444444 !important; font-family: Arial, Helvetica, sans-serif; }
	h4 {font-size: 22px; color: #4A72AF !important; font-family: Arial, Helvetica, sans-serif; }
	h5 {font-size: 18px; color: #444444 !important; font-family: Arial, Helvetica, sans-serif; }
	p {font-size: 12px; color: #444444 !important; font-family: Arial, sans-serif; }
   .style1 {color: #FFFFFF;	font-weight: bold; }
   .notif{ font-size:14px; line-height:24px; }
   </style>
</head>

<body>
<table width="100%" cellpadding="0" cellspacing="0" bgcolor="e4e4e4"><tr><td><!-- top message -->
<br />
	<table id="main" width="600" align="center" cellpadding="0" cellspacing="15" bgcolor="ffffff">
		<tr>
			<td colspan="2">
				<table id="header" cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td width="570"><h1><img src="http://www.ansania.com/images/img.mail.jpg" width="570" height="329" alt=""></h1></td>
					</tr>
				</table><!-- header -->			</td>
		</tr><!-- header -->
		
		<tr>
			<td colspan="2"></td>
		</tr>
		<tr>
			<td colspan="2"><!-- content 1 -->			<table width="100%" border="0" cellspacing="8" cellpadding="8">
              <tr>
                <td width="77%" valign="top" class="notif">
                  '.$content.'</td>
              </tr>
              
            </table></td>
		</tr><!-- content 1 -->
		
		<tr>
			<td width="292" height="30"></td>
	      <td width="263"><br>
	       <p> Temukan kami di Social Media</p>
	          <table width="100%" border="0" cellspacing="5" cellpadding="5">
            <tr>
              <td align="center" bgcolor="#0099FF"><span class="style1">Follow Twitter</span></td>
              <td align="center" bgcolor="#003366"><span class="style1">Like Facebook</span></td>
            </tr>
          </table>
          <br></td>
		</tr>
	</table>
	<!-- main -->
	<table id="bottom-message" cellpadding="20" cellspacing="0" width="600" align="center">
		<tr>
			<td align="center"><p>Anda bisa mengatur atau unsubcribe notifikasi dengan melakukan setting notifikasi dibagian menu setting akun. <a href="#">Setting Email Notifikasi </a> | <a href="#">Forward to a friend</a></p>
				</td>
		</tr>
	</table><!-- top message -->
</td></tr></table><!-- wrapper -->

</body>
</html>';
return $email; 
}

function sendmail($namapenerima,$emailpenerima,$subject,$isi,$isihtml)
{
	global $title,$smtphost,$support,$smtpuser,$smtppass,$smtpport,$issmtp;
	
	$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
	$mail->SMTPDebug = 0; 
	$mail->SMTPAuth = true; 
	//$mail->SMTPSecure = 'tls'; 

	$mail->Host     = $smtphost;
	$mail->Port     = $smtpport;
	$mail->Username = $smtpuser;
	$mail->Password = $smtppass;
	$mail->From     = $smtpuser;
	$mail->FromName = $support;
	$mail->Subject  = $subject;
	$mail->Body     = $isihtml;
	$mail->AltBody  = $isi;
	$mail->AddAddress("$emailpenerima","$namapenerima");
	$mail->IsHTML(true);
	if(!$mail->Send())
	{
		return false;
	}
	else
	{
		return true;
	}
}

function bersihHTML($text) {

	$text = str_replace("<strong>","--strong--",$text);
	$text = str_replace("</strong>","--/strong--",$text);
	$text = str_replace("</strong>","--/strong--",$text);
	$text = str_replace("<b>","--b--",$text);
	$text = str_replace("</b>","--/b--",$text);
	$text = str_replace("<i>","--i--",$text);
	$text = str_replace("</i>","--/i--",$text);
	$text = str_replace("<em>","--em--",$text);
	$text = str_replace("</em>","--/em--",$text);
	$text = str_replace("<u>","--u--",$text);
	$text = str_replace("</u>","--/u--",$text);
	$text = str_replace("<br />","--br--",$text);
	$text = str_replace("</p>","--br-- --br--",$text);

	$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out HTML tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace HTML entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i");                    // evaluate as php

	$replace = array ("",
					  "",
					  "\\1",
					  "\"",
					  "&",
					  "<",
					  ">",
					  " ",
					  chr(161),
					  chr(162),
					  chr(163),
					  chr(169));
	
	$text = preg_replace($search, $replace, $text);
		
	$text = str_replace("--strong--","<b>",$text);
	$text = str_replace("--/strong--","</b>",$text);
	$text = str_replace("--b--","<b>",$text);
	$text = str_replace("--/b--","</b>",$text);
	$text = str_replace("--i--","<i>",$text);
	$text = str_replace("--/i--","</i>",$text);
	$text = str_replace("--br--","\n",$text);
	$text = str_replace("--em--","<i>",$text);
	$text = str_replace("--/em--","</i>",$text);
	$text = str_replace("--u--","<u>",$text);
	$text = str_replace("--/u--","</u>",$text);
	$text = str_replace("<br />","\n",$text);
	$text = str_replace("<br>","\n",$text);
	$text = str_replace("'","`",$text);
	
	return $text;


}
function bersihPDF($text) {

	$text = str_replace("<strong>","--strong--",$text);
	$text = str_replace("</strong>","--/strong--",$text);
	$text = str_replace("</strong>","--/strong--",$text);
	$text = str_replace("<b>","--b--",$text);
	$text = str_replace("</b>","--/b--",$text);
	$text = str_replace("<i>","--i--",$text);
	$text = str_replace("</i>","--/i--",$text);
	$text = str_replace("<em>","--em--",$text);
	$text = str_replace("</em>","--/em--",$text);
	$text = str_replace("<u>","--u--",$text);
	$text = str_replace("</u>","--/u--",$text);
	$text = str_replace("<br />","--br--",$text);
	$text = str_replace("</p>","--br-- --br--",$text);

	$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out HTML tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace HTML entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // evaluate as php

	$replace = array ("",
					  "",
					  "\\1",
					  "\"",
					  "&",
					  "<",
					  ">",
					  " ",
					  chr(161),
					  chr(162),
					  chr(163),
					  chr(169),
					  "chr(\\1)");
	
	$text = preg_replace($search, $replace, $text);
		
	$text = str_replace("--strong--","<b>",$text);
	$text = str_replace("--/strong--","</b>",$text);
	$text = str_replace("--b--","<b>",$text);
	$text = str_replace("--/b--","</b>",$text);
	$text = str_replace("--i--","<i>",$text);
	$text = str_replace("--/i--","</i>",$text);
	$text = str_replace("--br--","\n",$text);
	$text = str_replace("--em--","<i>",$text);
	$text = str_replace("--/em--","</i>",$text);
	$text = str_replace("--u--","<u>",$text);
	$text = str_replace("--/u--","</u>",$text);
	$text = str_replace("<br />","\n",$text);
	$text = str_replace("<br>","\n",$text);
	$text = str_replace("'","`",$text);
	
	return $text;


}
function bersih($text) {

	$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out HTML tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace HTML entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i");                    // evaluate as php

	$replace = array ("",
					  "",
					  "\\1",
					  "\"",
					  "&",
					  "<",
					  ">",
					  " ",
					  chr(161),
					  chr(162),
					  chr(163),
					  chr(169));
	
	$text = preg_replace($search, $replace, $text);
	$text = str_replace("'","`",$text);
	$text = strip_tags($text);
	$text = nl2br($text);
	return $text;

}
function getProfileName($userName)
{
		global $database,$domain,$lokasiwebmember,$lokasiweb;
		$perintah1	= "select userid,username,userfullname,avatar,userdirname from tbl_member where username='$userName'";
		$hasil1		= sql($perintah1);
		$data1	= sql_fetch_data($hasil1);
		

		$userdirname = $data1['userdirname'];
		$avatar		= $data1['avatar'];
		$userid = $data1['userid'];
		$nama	= ucwords($data1['userfullname']);
		$username = $data1['username'];
		$profileurl = "$domain/$username";
			
			if(empty($avatar)){ $gambar = "$domain/images/no_pic.jpg"; }
			else
			{				
				$gambar = "$lokasiwebmember/avatars/$avatar";
			}
	
		$data = array("userid"=>$userid,"username"=>$username,"userfullname"=>$nama,"avatar"=>$gambar,"url"=>$profileurl);
		return $data;

}
function getProfileId($userid)
{
		global $database,$domain,$lokasiwebmember,$lokasiweb;
		$perintah1	= "select userid,username,userfullname,avatar,userdirname from tbl_member where userid='$userid'";
		$hasil1		= sql($perintah1);
		$data1	= sql_fetch_data($hasil1);
		

		$userdirname = $data1['userdirname'];
		$avatar		= $data1['avatar'];
		$userid = $data1['userid'];
		$nama	= ucwords($data1['userfullname']);
		$username = $data1['username'];
		$profileurl = "$domain/$username";
			
			if(empty($avatar)){ $gambar = "$domain/images/no_pic.jpg"; }
			else
			{
				$gambar = "$lokasiwebmember/avatars/$avatar";
			}
	
		$data = array("userid"=>$userid,"username"=>$username,"userfullname"=>$nama,"avatar"=>$gambar,"url"=>$profileurl);
		return $data;

}
function tanggalLahir($tanggal)
	{
		$tahun = substr("$tanggal",0,4); 
		$bulan = substr("$tanggal", 5, 2); 
		$tgl = substr("$tanggal", 8, 2); 
		$jam = substr("$tanggal", 11, 2); 
		$mnt = substr("$tanggal", 14, 2); 
		if ($bulan=="01") { $bulan1="January"; }
		if ($bulan=="02"){ $bulan1="February"; }
		if ($bulan=="03"){ $bulan1="March"; }
		if ($bulan=="04"){ $bulan1="April"; }
		if ($bulan=="05"){ $bulan1="May"; }
		if ($bulan=="06"){ $bulan1="June"; }
		if ($bulan=="07"){ $bulan1="July"; }
		if ($bulan=="08"){ $bulan1="August"; }
		if ($bulan=="09"){ $bulan1="September"; }
		if ($bulan=="10"){ $bulan1="October"; }
		if ($bulan=="11"){ $bulan1="November"; }
		if ($bulan=="12") {$bulan1="December"; }
		
		$tgl="$bulan1 $tgl, $tahun";			
		return $tgl;
	}

/*video youtube*/

//Fungsi mendapatkan Title
function getTitle($str)
{
	$final=array();
	$returnArray=array();
	$pattern="/<title type='text'>(.*)\<\/title\>/Uis";
	preg_match_all($pattern, $str, $returnArray, PREG_SET_ORDER);
	if(isset($returnArray[0][1]))
	{
		return $returnArray[0][1];
	}
	else {
		return "NA";
	}
}

//Fungsi mendapatkan Desk
function getDesc($str)
{
	$final=array();
	$returnArray=array();
	$pattern="/<content type='text'>(.*)\<\/content\>/Uis";
	preg_match_all($pattern, $str, $returnArray, PREG_SET_ORDER);
	if(isset($returnArray[0][1])) {
		return $returnArray[0][1];
	}
	else {
		return "NA";
	}
}

//Fungsi Mendapatkan URL Video
function getFlvUrl($str) 
{
	$final=array();
	$returnArray=array();
	$pattern="/<media:player url='(.*)'/Uis";
	//$pattern="/<media:content url='(.*)' type='application\/x-shockwave-flash'/Uis";
	preg_match_all($pattern, $str, $returnArray, PREG_SET_ORDER);

	if(isset($returnArray[0][1])) {
		return $returnArray[0][1];
	}
	else {
		return "#";
	}
}

//Fungsi Mendapatkan Thumbnail
function getThumbnailUrl($str,$returnAllThumbsAsArray=false) 
{
	$final=array();
	$returnArray=array();
	$imgArray=array();
	$imgPattern="/<media:thumbnail url='(.*)'/Uis";
	preg_match_all($imgPattern, $str, $tmp, PREG_SET_ORDER);
	
	$c=count($tmp);
	$l=-1;
	foreach($tmp as $key=>$value){
		$value=$value[1];
		$imgArray[]=$value;
	}
	if($returnAllThumbsAsArray===true){
		return $imgArray;
	}
	else{
		return $imgArray[1];
	}
}
function save_image($inPath,$outPath)
{ //Download images from remote server
    $in=    fopen($inPath, "rb");
    $out=   fopen($outPath, "wb");
    while ($chunk = fread($in,8192))
    {
        fwrite($out, $chunk, 8192);
    }
    fclose($in);
    fclose($out);
}
function setlog($from,$to,$pesan,$url)
{
	global $database;
	$perintah = "insert into tbl_notifikasi(fromusername,tousername,pesan,url) values ('$from','$to','$pesan','$url')";
	$hasil = sql( $perintah);
	
	//Pengirim
	$sql = "select username,userfullname,pvnotif,useremail,bounching from tbl_member where username='$from'";
	$hsl = sql($sql);
	$data = sql_fetch_data($hsl);
	$fromuserfullname = $data['userfullname'];
	sql_free_result($hsl);
	
	//Kirim Email
	$sql = "select username,userfullname,pvnotif,useremail,bounching from tbl_member where username='$to'";
	$hsl = sql($sql);
	$data = sql_fetch_data($hsl);
	$username = $data['username'];
	$userfullname = $data['userfullname'];
	$pvnotif = $data['pvnotif'];
	$useremail = $data['useremail'];
	$bounching = $data['bounching'];
	sql_free_result($hsl);

	$sqlf            = "select * from tbl_konfigurasi where webid='1'";
	$hslf            = sql($sqlf);
	$row            = sql_fetch_data($hslf);
	$title          = $row['title'];
	$domain         = $row['domain'];
	
	if($bounching==0 && $pvnotif==0)
	{
		if($pesan=="mengomentari status anda")
		{
			$isi = "
$fromuserfullname Mengomentari Kiriman Anda di $title
=========================================================================

Yth. $userfullname,

$fromuserfullname telah mengomentari sebuah kiriman anda di $domain
Silahkan login untuk membalas komentar yang diberikan atau klik url dibawah
ini:

$url

Terima Kasih
$owner
___________________________________________________________
Jika anda tidak ingin menerima email pemberitahuan ini
silahkan login ke www.ansania.com dan update notifikasi setting
";

$isihtml = "<br>
$fromuserfullname Mengomentari Kiriman Anda di $domain<br>
=========================================================================<br><br>

Yth. $userfullname,<br>
$fromuserfullname telah mengomentari sebuah kiriman anda di $domain
Silahkan login untuk membalas komentar yang diberikan atau klik url dibawah
ini:<br>
<br>

<a href=\"$url\">Lihat Komentar</a>
<br>
<br>
Terima Kasih<br>

$owner<br />
___________________________________________________________<br />
Jika sahabat tidak ingin menerima email pemberitahuan ini
silahkan login ke www.ansania.com dan update notifikasi setting
<br />";

$subject = "$fromuserfullname Mengomentari Kiriman Anda di $title";

sendmail($userfullname,$useremail,$subject,$isi,emailhtml($isihtml));
		}
		

		
		if($pesan=="menulis status didinding anda")
		{
			$isi = "
$fromuserfullname  Menulis Sesuatu di Profile Anda di $title
=========================================================================

Yth. $userfullname,

$fromuserfullname telah memberikan sebuah kiriman di $domain, untuk
membalas kirimannya silahkan login atau dengan mengklik url dibawah ini:

$url

Terima Kasih
$owner
___________________________________________________________
Jika sahabat tidak ingin menerima email pemberitahuan ini
silahkan login ke www.ansania.com dan update notifikasi setting";

$isihtml = "<br>
$fromuserfullname Menulis Sesuatu di Profile Anda di $title<br>
=========================================================================<br><br>

Yth. $userfullname,<br>
$fromuserfullname telah memberikan sebuah kiriman di $domain, untuk
membalas sapaannya silahkan login atau dengan mengklik url dibawah ini:<br>
<br>

<a href=\"$url\">Lihat Kiriman</a>
<br>
<br>
Terima Kasih<br>

$owner<br />
___________________________________________________________<br />
Jika sahabat tidak ingin menerima email pemberitahuan ini
silahkan login ke www.ansania.com dan update notifikasi setting
<br />
";

$subject = "$fromuserfullname  Menulis Sesuatu di Profile Anda";

sendmail($userfullname,$useremail,$subject,$isi,emailhtml($isihtml));
		}
		
		if($pesan=="mengirim pesan kepada anda")
		{
			$isi = "
$fromuserfullname  mengirim pesan kepada anda
=========================================================================

Yth. $userfullname,

$fromuserfullname telah memberikan pesan $domain, untuk
membalas kirimannya silahkan login atau dengan mengklik url dibawah ini:

$url

Terima Kasih
$owner
___________________________________________________________
Jika sahabat tidak ingin menerima email pemberitahuan ini
silahkan login ke www.ansania.com dan update notifikasi setting";

$isihtml = "<br>
$fromuserfullname Mengirim Pesan Kepada Anda di $title<br>
=========================================================================<br><br>

Yth. $userfullname,<br>
$fromuserfullname telah memberikan sebuah pesan di $domain, untuk
membalas sapaannya silahkan login atau dengan mengklik url dibawah ini:<br>
<br>

<a href=\"$url\">Lihat Kiriman</a>
<br>
<br>
Terima Kasih<br>

$owner<br />
___________________________________________________________<br />
Jika sahabat tidak ingin menerima email pemberitahuan ini
silahkan login ke www.ansania.com dan update notifikasi setting
<br />
";

$subject = "$fromuserfullname mengirim pesan kepada anda di $domain";

sendmail($userfullname,$useremail,$subject,$isi,emailhtml($isihtml));
		}
		
	}
	
	
}
function multisort (&$array, $key) 
{
	$valsort	= array();
	$ret		= array();
	reset($array);
	foreach ($array as $ii => $va) 
	{
		$valsort[$ii] = $va[$key];
	}
	
	arsort($valsort);
	
	foreach ($valsort as $ii => $va) 
	{
		$ret[$ii]=$array[$ii];
	}
	$array = $ret;
	
	return $array;
}

function geturl($text)
{
	$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	if(preg_match($reg_exUrl, $text, $url)) 
	{
		$urls = $url[0];
		$urls = strip_tags($urls);
		$text =  preg_replace($reg_exUrl, "<a href=\"$urls\" target=\"_blank\">$urls</a> ", $text);
	} else {
		   $text = $text;
	}
	return $text;
}

function confirmUser($username, $password){

   global $conn;

   /* Add slashes if necessary (for query) */

   if(!get_magic_quotes_gpc()) {

	$username = addslashes($username);

   }

/* Verify that user is in database */
   $q = "select userpassword from tbl_member where username = '$username'";
  
   $result = sql($q);
   $num = sql_num_rows($result);
   if(!$result or  ( $num< 1)){

      return 1; //Indicates username failure

   }

/* Retrieve password from result, strip slashes */
   $dbarray = sql_fetch_data($result);

   $dbarray['userpassword']  = stripslashes($dbarray['userpassword']);

   $password = stripslashes($password);

/* Validate that password is correct */
   if($password == $dbarray['userpassword']){

      return 0; //Success! Username and password confirmed

   }

   else{

      return 2; //Indicates password failure

   }

}



function checkLogin(){

   /* Check if user has been remembered */

   if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){

      $_SESSION['username'] = $_COOKIE['cookname'];

      $_SESSION['password'] = $_COOKIE['cookpass'];

   }

/* Username and password have been set */
   if(isset($_SESSION['username']) && isset($_SESSION['password'])){

      /* Confirm that username and password are valid */

      if(confirmUser($_SESSION['username'], $_SESSION['password']) != 0){

         /* Variables are incorrect, user not logged in */

         unset($_SESSION['username']);

         unset($_SESSION['password']);

         return false;

      }

      return true;

   }

   /* User not logged in */

   else{

      return false;

   }

}

function getemoticon($string)
{
	global $domain,$database;
	
	$string = str_replace("'","",$string);
	
	$string = explode(" ",$string);
	$jstring = count($string);
	$string2 = "";
	for($i=0;$i<$jstring;$i++)
	{
		$kata = $string[$i];
		
		$perintah = "select gambar_emoticon,kode from tbl_emoticon where kode='$kata'";
		$hasil = sql($perintah);
		$data = sql_fetch_data($hasil);
		sql_free_result($hasil);
		
		$gambar = $data['gambar_emoticon'];
		if(!empty($gambar))
		{
			$string2 .=" <img src=\"$domain/images/emoticon/$gambar\" alt=\"\" border=\"0\" /> ";
		}
		else
		{
			$string2 .= "$kata ";
		}	
		
	}
	
	$perintah = "select gambar_emoticon,kode from tbl_emoticon";
	$hasil = sql($perintah);
	while($data = sql_fetch_data($hasil))
	{
		$gambar = $data['gambar_emoticon'];
		$kode = $data['kode'];
		$img = " <img src=\"$domain/images/emoticon/$gambar\" alt=\"$kode\" border=\"0\" /> ";
		$string2 = str_replace($kode,"$img",$string2);
	}
	sql_free_result($hasil);
	
	return $string2;
}

function kirimSMS($dest,$pesan)
{
	global $lokasiweb;
	
	$kiriman = "http://sms.ansania.com/api/sms.php";
	
	$post = array('apikey'=>'b1smillah','msisdn'=>$dest,'pesan'=>$pesan);
	
	$ch = curl_init("$kiriman");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	$output = curl_exec($ch);       
	curl_close($ch);
	
	
	$data = date('Y-m-d H:i:s')." | $ip | $kiriman | $output\r\n";
	$file = "$lokasiweb/api/backlog.txt";
	$open = fopen($file, "a+"); 
	fwrite($open, "$data"); 
	fclose($open);
	
	if(preg_match("/Sukses/i",$output))
	{
		
		$sql = "insert into tbl_smsc_smskeluar(msisdn,pesan,tanggal,status) values ('$dest','$pesan',now(),'1')";
		$hsl = sql($sql);
		
		$berhasil = true;
	}
	else
	{
		$berhasil = false;
	}
}




/* PRODUCT */
function getTipeId($alias)
{
	global $database;
	
	$sql 		= "select tipeid from tbl_product_tipe where alias='$alias'";
	$query 		= sql($sql);
	$row 		= sql_fetch_data($query);
	$tipeid	 	= $row['tipeid'];
	sql_free_result($query);
	
	return $tipeid;
}
function getNamaSec($secid,$lang)
{
	global $database;
	
	$sql 		= "select namasec$lang from tbl_product_sec where secid='$secid'";
	$query 		= sql($sql);
	$row 		= sql_fetch_data($query);
	$namasec 	= $row["namasec$lang"];
	sql_free_result($query);
	
	return $namasec;
}
function getAliasSec($secid)
{
	global $database;
	
	$sql 		= "select alias from tbl_product_sec where secid='$secid'";
	$query 		= sql($sql);
	$row 		= sql_fetch_data($query);
	$alias	 	= $row['alias'];
	sql_free_result($query);
	
	return $alias;
}
function getSecId($alias)
{
	global $database;
	
	$sql 		= "select secid from tbl_product_sec where alias='$alias'";
	$query 		= sql($sql);
	$row 		= sql_fetch_data($query);
	$secid	 	= $row['secid'];
	sql_free_result($query);
	
	return $secid;
}
function getNamaSub($subid,$lang)
{
	global $database;
	
	$sql 		= "select namasub$lang from tbl_product_sub where subid='$subid'";
	$query 		= sql($sql);
	$row 		= sql_fetch_data($query);
	$namasub 	= $row["namasub$lang"];
	sql_free_result($query);
	
	return $namasub;
}
function getAliasSub($subid)
{
	global $database;
	
	$sql 		= "select alias from tbl_product_sub where subid='$subid'";
	$query 		= sql($sql);
	$row 		= sql_fetch_data($query);
	$alias	 	= $row['alias'];
	sql_free_result($query);
	
	return $alias;
}
function getSubId($alias)
{
	global $database;
	
	$sql 		= "select subid from tbl_product_sub where alias='$alias'";
	$query 		= sql($sql);
	$row 		= sql_fetch_data($query);
	$subid	 	= $row['subid'];
	sql_free_result($query);
	
	return $subid;
}

function rupiah($rupiah)
{
	return number_format($rupiah,0,",",".");
}
function getfileext($src)
{
	$jenis 	= $src['name'];
	$exp	= explode(".",$jenis);
	$ext	= $exp[count($exp)-1];

	return $ext;
}

function get_gravatar( $email, $s = 80, $d = 'identicon', $r = 'g', $img = false, $atts = array() ) {
	$url = 'http://www.gravatar.com/avatar/';
	$url .= md5( strtolower( trim( $email ) ) );
	$url .= "?s=$s&d=$d&r=$r";
	if ( $img ) {
		$url = '<img src="' . $url . '"';
		foreach ( $atts as $key => $val )
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= ' />';
	}
	return $url;
}

function waktu_lalu($timestamp)
{
    $selisih = time() - strtotime($timestamp) ;
 
    $detik = $selisih ;
    $menit = round($selisih / 60 );
    $jam = round($selisih / 3600 );
    $hari = round($selisih / 86400 );
    $minggu = round($selisih / 604800 );
    $bulan = round($selisih / 2419200 );
    $tahun = round($selisih / 29030400 );
 
    if ($detik <= 60) {
        $waktu = $detik.' detik yang lalu';
    } else if ($menit <= 60) {
        $waktu = $menit.' menit yang lalu';
    } else if ($jam <= 24) {
        $waktu = $jam.' jam yang lalu';
    } else if ($hari <= 7) {
        $waktu = $hari.' hari yang lalu';
    } else if ($minggu <= 4) {
        $waktu = $minggu.' minggu yang lalu';
    } else if ($bulan <= 12) {
        $waktu = $bulan.' bulan yang lalu';
    } else {
        $waktu = $tahun.' tahun yang lalu';
    }
    
    return $waktu;
}

function cekspam($email){
	global $spam;
	$s = explode(",",$spam);
	
	for($i=0;$i<count($s);$i++)
	{
		$key = $s[$i];
		if(preg_match("/$key/i",$email))
		{
			die("Your Email is detected as spam");
			exit();
		}
	}
	
}
function ringkas($text,$q)
{
	$ex = explode(" ",$text);
	$new = "";
	for($i=0;$i<$q;$i++)
	{
		$new .= "$ex[$i] ";
	}
	return $new;
}
function kirimwa($userphonegsm,$html,$blastid)
{
	
	$userphonegsm = trim($userphonegsm);
	$userphonegsm = str_replace(" ","",$userphonegsm);
	$userphonegsm = str_replace("-","",$userphonegsm);
	$userphonegsm = str_replace("+","",$userphonegsm);
	
	if(substr($userphonegsm,0,1)=="0"){ $userphonegsm = "62".substr($userphonegsm,1,12); }
	
	if(strlen($userphonegsm)>5)
	{
	
	$html = str_replace("<br>","\r\n",$html);
	$html = str_replace("\r\n","\r\n",$html);
	$html = str_replace("</strong>","*",$html);
	$html = str_replace("<strong>","*",$html);
	$html = str_replace("<b>","*",$html);
	$html = str_replace("</b>","*",$html);
	
	$html = $html;

    $date = date("Y-m-d H:i:s");
	$pesan = sql_escape_string($html);
	$sql = "insert into tbl_wa(create_date,userphonegsm,pesan,blastid,customerid) values('$date','$userphonegsm','$pesan','$blastid','$customerid')";
	$h = sql($sql);
	}


}
function sendwa($userphonegsm,$html)
{
	
	$token = 'cflmcESp58g8Y4o8AGgpVRdgfpWeE8fDJZwLUrfUqFhezQNG3b';
	$phone = $userphonegsm;
	$message = $html;
	$url = 'http://ruangwa.com/v2/api/send-message.php';
	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($curl, CURLOPT_TIMEOUT,30);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, array(
		'token'    => $token,
		'phone'     => $phone,
		'message'   => $message,
	));
	$response = curl_exec($curl);
	curl_close($curl); 
	


}


?>