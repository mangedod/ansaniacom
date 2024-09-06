<?php 
//Variable halaman ini
$otoritas		= kodeoto($kanal);
$oto			= $otoritas[0];
if(!$oto['oto']) { echo $error['oto']; }
else
{
	$aksi = "alexa";
	
	//Vie Content
	if($aksi=="alexa")
	{
		if(!$oto['view']) { echo $error['view']; }
		else
        {
			$mainmenu[] = array("Lihat Performa Alexa","lihat","$alamat&aksi=alexa");
			mainaction($mainmenu,$pageparam);
			
			$domain = $_SERVER['HTTP_HOST'];

			print("<table border=0 class=\"tabel-cms\" width=100% cellpadding=1 cellspacing=1><thead>\n");
			print("<tr><th width=100%>Alexa Report untuk $domain</th></tr></thead>");
			print("<tr><td width=100%>
				<iframe style=\"width:100%; height:400px; border:1px solid #ccc\" src=\"http://www.alexa.com/siteinfo/$domain\"></iframe>
			</td></tr></thead>");
			
			
			print("</table><br clear='all'>");
			
		    
			
		}
	} //EndView 
	
	
}

?>