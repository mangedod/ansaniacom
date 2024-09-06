<?php 
$lokasixml = "komponen/$kanal/$kanal.xml";
if(file_exists($lokasixml))
{
	$file = file_get_contents($lokasixml);
	$xml = simplexml_load_string($file); 
	
	$jitem = count($xml);
	
	echo "<div class=\"tabbable\">";
	echo "<ul class=\"nav nav-tabs\">";
	for($i=0;$i<$jitem;$i++)
	{
		$c = $i+1;
		$item = $xml->item[$i];
		$name = $item->name;
		if($i==0) echo"<li class=\"active\"><a href=\"#pane$c\" data-toggle=\"tab\">$name</a></li>";
		 else echo"<li><a href=\"#pane$c\" data-toggle=\"tab\">$name</a></li>";
	}
	echo "</ul>";
	
	echo "<div class=\"tab-content\" style=\"padding:0px 15px; margin:0px 0px; float:left;\">";
	for($i=0;$i<$jitem;$i++)
	{
		$c = $i+1;
		$item = $xml->item[$i];
		$name = $item->name;
		$alias = $item->alias;
		
		if($i==0) $ac = "active";
		else $ac = "";
		
		echo"<div id=\"pane$c\" class=\"tab-pane $ac\">";
		
		
		if($alias=="deskripsi")
		{
			$desc = $item->desc;
			echo $desc;

		}
		elseif($alias=="manual")
		{
		}
		elseif($alias=="workflow")
		{
		}
		elseif($alias=="dependensi")
		{
		}
		elseif($alias=="changelog")
		{
			$changelog = $item->changelog->changeitem;
			$jchange = count($changelog);
			
		
			echo "<table width=\"100%\">";
			
			echo "<tr>";
					echo "<th width=20%>Tanggal</th>";
					echo "<th width=20%>Author</th>";
					echo "<th width=60%>Change</th>";
				echo "</tr>";
			
			for($d=0;$d<$jchange;$d++)
			{
				$changes = $changelog[$d];
				$author = $changes->author;
				$changedate = $changes->changedate;
				$change = $changes->change;
				
				echo "<tr>";
					echo "<td width=20%>$changedate</td>";
					echo "<td width=20%>$author</td>";
					echo "<td width=60%>$change</td>";
				echo "</tr>";
			}
			echo "</table><br clear=\"all\" />";
			
		}
		
		
		 
		echo"</div>";
	}
	echo "</div><br clear=\"all\" />";
	
	
	echo "<br clear=\"all\" /></div>";
	
}
else
{
	//echo "<div class=\"isa_error\"> Informasi Modul Belum Tersedia <a href=\"#\" onclick=\"login()\" class=\"aerror\"> Tutup </a></div>";
}
?>