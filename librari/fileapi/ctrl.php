<?php
/**
 * FileAPI upload controller (example)
 */

include ("../../setingan/web.config.inc.php");
include ("./FileAPI.class.php");
include("./resize/class.upload.php");

if( !empty($_SERVER['HTTP_ORIGIN']) ){
	// Enable CORS
	header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
	header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Range, Content-Disposition, Content-Type');
}


if( $_SERVER['REQUEST_METHOD'] == 'OPTIONS' ){
	exit;
}


if( strtoupper($_SERVER['REQUEST_METHOD']) == 'POST' ){
	$files	= FileAPI::getFiles(); // Retrieve File List
	$images	= array();

	$memberid = $_REQUEST['memberid'];
	$dir      = base64_decode($_REQUEST['loc']);

	$field    = $files['filedata'] ? $files['filedata'] : $files['files'][0];

	$handle = new Upload($field);

	if ($handle->uploaded) {
		$handle->image_resize          = true;
        $handle->image_ratio_crop      = true;
        $handle->image_y               = 300;
        $handle->image_x               = 300;
        $handle->file_new_name_body    = "avatar-$memberid-f";

        $handle->Process($dir);
		
		//$namagambar = "avatar-$memberid-f.jpg";

        if ($handle->processed) {
            // everything was fine !
			
			$filetmpname	= "$dir".$handle->file_dst_name;
			
			$yearm	= date("Ym");
			$folderalbum = "$lokasimember/avatars/$yearm";
			if(!file_exists($folderalbum)){	mkdir($folderalbum,0777); }
			
			$folderalbum2 = "$lokasimember/avatar";
			if(!file_exists($folderalbum2)){	mkdir($folderalbum2,0777); }
			
			$imageinfo = getimagesize($filetmpname);
			$imagewidth = $imageinfo[0];
			$imageheight = $imageinfo[1];
			$imagetype = $imageinfo[2];
			
			switch($imagetype)
			{
				case 1: $imagetype="gif"; break;
				case 2: $imagetype="jpg"; break;
				case 3: $imagetype="png"; break;
			}
			
			$photofull = "avatar-".$memberid."-f.".$imagetype;
			resizeimg($filetmpname,"$folderalbum/$photofull",250,250);
			
			$photolarge = "avatar-".$memberid."-l.".$imagetype;
			resizeimg($filetmpname,"$folderalbum/$photolarge",150,150);
			
			$photomedium = "avatar-".$memberid."-m.".$imagetype;
			resizeimg($filetmpname,"$folderalbum/$photomedium",100,100);
			
			$photomedium2 = $memberid.'.jpg';
			resizeimg($filetmpname,"$folderalbum2/$photomedium2",250,250);
			
			$photosmall = "avatar-".$memberid."-s.".$imagetype;
			resizeimg($filetmpname,"$folderalbum/$photosmall",50,50);
			
			
			
			if(file_exists("$folderalbum/$photomedium"))
			{ 
				$query	= "update tbl_member set avatar='$yearm/$photomedium' where userid='$memberid'";
				$hasil 	= sql($query);
			}
			
            /*$sql	= "update tbl_member set avatar='$handle->file_dst_name' where userid='$memberid'";
			$res	= sql($sql);*/

        	$msg = "File Uploaded successfully !";
           	echo json_encode($msg);

        } else {
            // one error occured
            $msg .='<p class="result">';
            $msg .='  <b>File not uploaded to the wanted location</b><br />';
            $msg .='  Error: ' . $handle->error . '';
            $msg .='</p>';
            echo json_encode($msg);
        }

	}
	else {
        // if we're here, the upload file failed for some reasons
        // i.e. the server didn't receive the file
        echo '<p class="result">';
        echo '  <b>File not uploaded on the server</b><br />';
        echo '  Error: ' . $handle->error . '';
        echo '</p>';
    }
}
?>
