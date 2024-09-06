<?php
	include("../../setingan/web.config.inc.php");
	
	$q 		= strtolower($_GET["q"]);
	$sql	= "select username,userfullname from tbl_member where userfullname like '%$q%' and useractivestatus='1'";
	$query	= sql($sql);
	while($row = sql_fetch_data($query))
	{
		$username		= $row['username'];
		$userfullname	= $row['userfullname'];
		
		echo "$userfullname|$username\n";
	}
	sql_free_result($query);
?>