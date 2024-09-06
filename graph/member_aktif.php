<?
include "../setingan/global.inc.php";
header('Content-Type: text/xml');
echo "<?xml version='1.0'?>";


$tgl_awal 	= date('Y-m-d');							
$date1 		= strtotime($tgl_awal);

//1bulan
$tgl_akhir 	= date('Y-m-d',strtotime('-30'.' days', $date1));

$sql1		= "select count(*) as jumaktif from tbl_member where (date(`userLastLoggedIn`)<='$tgl_awal') and (date(`userLastLoggedIn`)>='$tgl_akhir')";
$query1		= mysql_query($sql1);
$jumaktif	= mysql_result($query1,0,jumaktif);

$sql2		= "select count(*) as jumnonaktif from tbl_member where date(`userLastLoggedIn`) < '$tgl_akhir'";
$query2		= mysql_query($sql2);
$jumnonaktif=  mysql_result($query2,0,jumnonaktif);	

//6bulan
$tgl_akhir6 = date('Y-m-d',strtotime('-60'.' days', $date1));

$sql3		= "select count(*) as jumaktif6 from tbl_member where (date(`userLastLoggedIn`)<='$tgl_awal') and (date(`userLastLoggedIn`)>='$tgl_akhir6')";
$query3		= mysql_query($sql3);
$jumaktif6	= mysql_result($query3,0,jumaktif6);	

$sql4		= "select count(*) as jumnonaktif6 from tbl_member where date(`userLastLoggedIn`) < '$tgl_akhir6'";
$query4		= mysql_query($sql4);
$jumnonaktif6=  mysql_result($query4,0,jumnonaktif6);	

//12bulan	
$tgl_akhir12= date('Y-m-d',strtotime('-365'.' days', $date1));

$sql5		= "select count(*) as jumaktif12 from tbl_member where (date(`userLastLoggedIn`)<='$tgl_awal') and (date(`userLastLoggedIn`)>='$tgl_akhir12')";
$query5		= mysql_query($sql5);
$jumaktif12	= mysql_result($query5,0,jumaktif12);	

$sql6		= "select count(*) as jumnonaktif12 from tbl_member where date(`userLastLoggedIn`) < '$tgl_akhir12'";
$query6		= mysql_query($sql6);
$jumnonaktif12=  mysql_result($query6,0,jumnonaktif12);	

	echo "<chart caption='' subcaption='' lineThickness='2' showValues='0' formatNumberScale='0' anchorRadius='2' divLineAlpha='20' divLineColor='CC3300' divLineIsDashed='1' showAlternateHGridColor='1' alternateHGridAlpha='5' alternateHGridColor='CC3300' shadowAlpha='40' labelStep='1' numvdivlines='5' chartRightMargin='35' bgColor='FFFFFF,CC3300' bgAngle='270' bgAlpha='10,10'>\n";

	echo "<categories>";
		echo"<category label='1 Bulan Terakhir'/>";
		echo"<category label='6 Bulan Terakhir'/>";
		echo"<category label='12 Bulan Terakhir'/>";
	echo "</categories>";
	
	echo "-";
	
	echo "<dataset seriesName='Jumlah Member Aktif' color='FF0000' anchorBorderColor='006699' anchorBgColor='006600'>\n";
		echo "<set value='$jumaktif'/>\n";	
		echo "<set value='$jumaktif6'/>\n";	
		echo "<set value='$jumaktif12'/>\n";	
	echo "</dataset>";
	
	
	echo "<dataset seriesName='Jumlah Member Tidak Aktif' color='FFFF00' anchorBorderColor='006699' anchorBgColor='006600'>\n";
		echo "<set value='$jumnonaktif'/>\n";	
		echo "<set value='$jumnonaktif6'/>\n";	
		echo "<set value='$jumnonaktif12'/>\n";	
	echo "</dataset>";
	
	echo "-";
	
	echo "<styles>";
	echo "-";
	echo "<definition>
	<style name='CaptionFont' type='font' size='12'/>
	</definition>";
	echo "-";
	echo "<application>
	<apply toObject='CAPTION' styles='CaptionFont'/>
	<apply toObject='SUBCAPTION' styles='CaptionFont'/>
	</application>";
	echo "</styles>";
	echo "</chart>";

?>