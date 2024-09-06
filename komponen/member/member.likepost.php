<?php
$postid		= $var[4];
if(!empty($postid))
{
	if($aksi=="like-post")
	{
		$perintah	= "select userid,touserid,type from tbl_post where postid='$postid'";
		$hasil		= sql($perintah);
		$data		= sql_fetch_data($hasil);
			$type		= $data['type'];
			$postuser	= $data['userid'];
			$postuser2	= $data['wall_id'];
			$tanggal	= date("Y-m-d H:i:s");
			
			//cek komen wall atau status
			if ($postuser!=$postuser2) $wall = true;
			else $wall = false;
			
		$query	= "insert into tbl_post_like (postid,username,tanggal) values ('$postid','$_SESSION[usernameresel]','$tanggal')";
		$hsl	= sql($query);
		if($hsl)
		{
			if ($postuser!=$_SESSION['usernameresel'])
			{
				if ($type=="photo")
					setlog($_SESSION['usernameresel'],$postuser,"menyukai foto Anda","$fulldomain/member/post/$postid","like");
				elseif ($type=="video")
					setlog($_SESSION['usernameresel'],$postuser,"menyukai video Anda","$fulldomain/member/post/$postid","like");
				elseif ($wall)
					setlog($_SESSION['usernameresel'],$postuser,"menyukai pesan dinding Anda","$fulldomain/member/post/$postid","like");
				else
					setlog($_SESSION['usernameresel'],$postuser,"menyukai status Anda","$fulldomain/member/post/$postid","like");
			}
				
			header("location: $fulldomain/member/post/$postid");
		}
	}
	else if($aksi=="unlike-post")
	{
		$query	= "delete from tbl_post_like where postid='$postid' and username='$_SESSION[usernameresel]'";
		$hsl	= sql($query);
		if($hsl)
		{
			header("location: $fulldomain/member/post/$postid");
		}
	}
}
?>