<?php
function cmspage($tot,$hlm_tot,$jml_per_hlm,$param)
{
	global $hlm,$alamat,$aksi,$pop,$pageparam;
	
	if(empty($hlm)) $hlm = 1;
	
	if(!empty($pageparam) && empty($param))
	{
	  for($i=0;$i<count($pageparam);$i++)
	  {
	  	$f = $pageparam[$i][0];
		$v = $pageparam[$i][1];
		$parampage .= "&$f=$v";
	   }
	}
	
	$alamats = $alamat."&aksi=$aksi".$param.$parampage;
	$hlm = intval($hlm);
	$tot = intval($tot);
	$jml_per_hlm = intval($jml_per_hlm);
	$hlm_tot = intval($hlm_tot);

	if($hlm==1 && $tot==0)	$datake = 0;
	else $datake = $jml_per_hlm *($hlm-1)+1;
	
	$datasampai = ($jml_per_hlm*($hlm-1))+$jml_per_hlm;
	

	if($pop)
	{
		if($tot<$datasampai && $tot>$jml_per_hlm && $tot!=0)
		{
			$datasampai = $tot;
			$dt = "Menampilkan <strong>$datake</strong> sampai <strong>$datasampai</strong> dari<strong> $tot</strong> data";
		}
		elseif($tot<$jml_per_hlm  && $tot!=0)
		{
			 $datasampai = $tot;
			 $dt = "Menampilkan <strong>$datake</strong> sampai <strong>$datasampai</strong> dari<strong> $tot</strong> data";
		}
		elseif($tot==0)
		{
			//$dt = "Data kosong atau tidak ditemukan";
		}
		else
		{
			$dt = "Menampilkan <strong>$datake</strong> sampai <strong>$datasampai</strong> dari<strong> $tot</strong> data";
		}
		$depop = "&pop=1";
	}
	else
	{
	
		
		if($tot<$datasampai && $tot>$jml_per_hlm && $tot!=0)
		{
			$datasampai = $tot;
			 $dt = "Menampilkan <strong>$datake</strong> sampai <strong>$datasampai</strong> dari<strong> $tot</strong> data";
		}
		elseif($tot<$jml_per_hlm  && $tot!=0)
		{
			 $datasampai = $tot;
			 $dt = "Menampilkan <strong>$datake</strong> sampai <strong>$datasampai</strong> dari<strong> $tot</strong> data";
		}
		elseif($tot==0)
		{
			//$dt = "Data kosong atau tidak ditemukan";
		}
		else
		{
			 $dt = "Menampilkan <strong>$datake</strong> sampai <strong>$datasampai</strong> dari<strong> $tot</strong> data";
		}

	}
	

	echo "<div class=\"col-md-6 "; if($pop){ echo "setengah"; } echo "\">
       	  <ul class=\"pagination\">";
			$batas_page =10;
			if($hlm_tot>1)
			{
				if ($hlm > 1){
					$prev = $hlm - 1;
				//	print("<li class=\"prev\"><a href=$alamats&hlm=1>&lt;&lt;</a></li>");
					print("<li class=\"pageitem\"><a href=$alamats&hlm=$prev$depop><i class=\"fal fa-arrow-left\"></i></a></li>");
					
				}
				else {
				//print("<span class=\"pageitem\">Awal</span> ");
				//print("<span class=\"pageitem\">Sebelumnya</span>");
				}
				
				$hlm2 = $hlm - (ceil($batas_page/2));
				$hlm4= $hlm+(ceil($batas_page/2));
				
				if($hlm2 <= 0 ) $hlm3=1;
				   else $hlm3 = $hlm2;
				
				if($hlm_tot==1) echo"<li>&nbsp;</li>";
				for ($ii=$hlm3; $ii <= $hlm_tot and $ii<=$hlm4; $ii++){
					if ($ii==$hlm){
						print("<li class=\"pageitem\"><a href=#><b>$ii</b></a></li>");
					}else{
						print("<li class=\"pageitem\"><a href=$alamats&hlm=$ii$depop>$ii</a></li>");
					}
				}
				if($hlm_tot==1) echo"<li>&nbsp;</li>";
				echo"</li>";
				if ($hlm < $hlm_tot){
					$next = $hlm + 1;
					print("<li class=\"pageitem\"><a href=$alamats&hlm=$next$depop><i class=\"fal fa-arrow-right\"></i></a></li>");
					//print("<li class=\"next\"><a href=$alamats&hlm=$hlm_tot>&gt;&gt;</a></li>");
				}
				else
				{
				}
			}
	echo "</ul>";		
	echo "</div><div class=\"col-md-6 col-md-6 "; if($pop){ echo "setengah"; } echo " text-right dataTables_info\" >$dt</div><br clear=all>";
}

function cmsaction($acc)
{
	echo"<div class=\"btn-group\">
			<button data-toggle=\"dropdown\" class=\"btn dropdown-toggle\"><span class=\"caret\"></span></button>
			<ul class=\"dropdown-menu pull-right\">";
			
			if(!is_array($acc)) $acc = array();

			for($i=0;$i<count($acc);$i++)
			{
				$url = $acc[$i][2];
				$icon = $acc[$i][1];
				$str = $acc[$i][0];
				
				if($icon=="delete"){  $del ="onclick=\"return confirmDelete(this);\""; $fa = "trash-alt"; }
				if($icon=="lihat"){ $fa = "list"; }
				if($icon=="detail"){ $fa = "list"; }
				if($icon=="edit"){ $fa = "edit"; }
				if($icon=="tambah"){ $fa = "plus-circle"; }
				if($icon=="back"){ $fa = "arrow-circle-left"; }
				if($icon=="category"){ $fa = "folders"; }
				if($icon=="push"){ $fa = "toggle-on"; }
								
				echo"<li><a href=\"$url\" style=\"padding-left: 10px;\" $del>
						<i class=\"fal fa-$fa\"></i> $str</a>
				</li>";
				unset($del);
			}
	echo"  </ul>
		</div>";
}

function mainaction($acc,$param)
{
	global $aksi,$alamat,$topurl;
	
	if(!is_array($param)) $param = array();

	for($i=0;$i<count($param);$i++)
	{
		$pars = $param[$i];
		$par = $pars[0]."='".$pars[1]."'";
		$par2 = urlencode($pars[0])."=".urlencode($pars[1]);
		$params .=" and $par ";
		$urlparams .="&$par2";
	}
	
	$topurl = str_replace("&showfilter=hide","",$topurl);
	$topurl = str_replace("&showfilter=show","",$topurl);
	
	$aksis = ucwords($aksi);
	
	//Font Awesome
	
	
	echo"";
	
	echo"<div class=\"panel-toolbar text-right \">
		<div class=\"panel-toolbar-wrapper\">
		<div class=\"panel-body \">
		<div class=\"btn-group\">
			";

			if(preg_match("/view/i",$aksi))
			{
				if($_SESSION['showfilter']=="show"){ echo"<a class=\"btn btn-default\" href=\"$topurl$urlparams&showfilter=hide\"  $del><i class=\"fal fa-search\"></i> &nbsp;&nbsp;Hide Filter</a>";	}
				else { echo"<a class=\"btn btn-default\" href=\"$topurl$urlparams&showfilter=show\"  $del><i class=\"fal fa-search\"></i> &nbsp;&nbsp;Show Filter</a>";	}
			}	
			
			for($i=0;$i<count($acc);$i++)
			{
				$url = $acc[$i][2];
				$icon = $acc[$i][1];
				$str = $acc[$i][0];
				
				if($icon=="delete"){  $del ="onclick=\"return confirmDelete(this);\""; $fa = "trash-alt"; }
				if($icon=="lihat"){ $fa = "list"; }
				if($icon=="tambah"){ $fa = "plus-circle"; }
				if($icon=="back"){ $fa = "arrow-circle-left"; }
				if($icon=="category"){ $fa = "folders"; }
				
				echo"<a class=\"btn btn-default\" href=\"$url$urlparams\"  $del><i class=\"fal fa-$fa\"></i>&nbsp;&nbsp;$str</a>";
				unset($icon);
			}
		echo"</div></div></div>
		</div>";
}



function cmsformcari($cari,$parameter)
{
	global $alamat,$pop;
	
	if($_SESSION['showfilter'] || $pop)
	{
	
	$param = "";
	if(!is_array($parameter)) $parameter = array();

	for($i=0;$i<count($parameter);$i++) 
	{
		$pars = $parameter[$i];
		$par = $pars[0]."='".$pars[1]."'";
		$par2 = urlencode($pars[0])."=".urlencode($pars[1]);
		$params .=" and $par ";
		$param .="&$par2";
	}
	
	$jml = count($cari);
	$sisa = $jml%2;
	if($sisa=="1") $jml=$jml+1;
	else $jml= $jml;
	
	
	echo "<div class=\"panel-body\"><div class=\"panel\"><div class=\"panel-body\"><form action=\"\" method=\"post\">
		  <table width=\"100%\" class=\"tabel-cms\">";
	echo "<tr><th colspan=\"4\" align=\"\">Filter Data <input type=\"submit\" value=\"Filter Data\" style=\"float:right\" class=\"btn btn-default\" /></th></tr>";
	$a = 1;
	$where = "";
	for($i=0;$i<$jml;$i++)
	{
		$data = $cari[$i];
		$field = $cari[$i][0];
		if($a==1) echo "<tr>";
			
			if(empty($field)) echo "<td>&nbsp;</td><td>&nbsp;</td>";
			else
			{
			  if(isset($_POST[$field])) $in = $_POST[$field];
			  else $in = $_GET[$field];
			  
			  if($in != "")
			  {
				  $param .= "&$data[0]=".urlencode($in);
				  if($data[2]=="str")
				  {
					$where .= " and $data[0] like '%$in%'";
					
				  }
				  elseif($data[2]=="date")
				  {
					$where .= " and substring($data[0],1,10)='$in'";
					
				  }
				  else
				  {
					$where .= " and $data[0]='$in'"; 
				  }
			   }
			   if($data[2]=="date")
			   {
			   		echo "<script type=\"text/javascript\">
					$(function() {
						$( \"#$data[0]\" ).datepicker({
						  showOn: \"button\",
						  buttonImage: \"template/images/calendar.gif\",
						  buttonImageOnly: true
						});
					  });</script>";
					echo "<td>$data[1]</td><td><input type=\"text\" width=\"100%\" value=\"$in\" name=\"$data[0]\" id=\"$data[0]\" /> </td>";
			   }
			   else if($data[2]=="select")
			   {
					$opsi = $cari[$i][4];
					echo "<td>$data[1]</td><td><select name=\"$data[0]\" id=\"$data[0]\" />";
					echo "<option value=\"\"> - Pilih $data[1] -</option>";
					for($o=0;$o<count($opsi);$o++)
					{
						if($in==$opsi[$o][0]) echo "<option value=\"".$opsi[$o][0]."\" selected=selected>".$opsi[$o][1]."</option>";
						 else echo "<option value=\"".$opsi[$o][0]."\">".$opsi[$o][1]."</option>";
					}
					echo "</select></td>";
					unset($opsi);
			   }
			   else if($data[2]=="find")
			   {
					$urls = $cari[$i][4];
					$isitext = "$data[0]_text";
					if(isset($_POST[$isitext])) $ins = $_POST[$isitext];
			 			 else $ins = $_GET[$isitext];
			  		echo "
					<script>	
						function pop$data[0]()
						{
							 var res = window.showModalDialog(\"$urls\",\"\", \"dialogWidth:600px;dialogHeight:500px;dialogTop:200px;\")
								if (res != null) {
									document.getElementById(\"$data[0]\").value = res.$data[0];
									document.getElementById(\"$data[0]_text\").value = res.$data[0]_text;
								}
								return false;
						}
					</script>
            		<td>$data[1]</td><td>
					<input type=\"hidden\" value=\"$in\" name=\"$data[0]\" id=\"$data[0]\" />
					<input type=\"text\" width=\"100%\" value=\"$ins\" name=\"$data[0]_text\" id=\"$data[0]_text\" /> 
					<a href=\"#\" class=\"apop\" onclick=\"pop$data[0]()\">..</a>
					</td>";
			   }
			   else
				{
					echo "<td>$data[1]</td><td><input type=\"text\" width=\"100%\" value=\"$in\" name=\"$data[0]\" id=\"$data[0]\" /> </td>";
				}
			}
			
					
		if($a==2) echo "</tr>";
		
		$a %= 2;
		$a++;
	}
	echo "<tr><th colspan=\"4\" align=\"right\"></th></tr>
	</table><br clear=\"all\" /></form></div></div>
		<div class=\"table-responsive\">";
	
	$where .= $params;

	$dt[] = array("where"=>$where,"param"=>$param);
	return $dt;
	
	}
	
}

