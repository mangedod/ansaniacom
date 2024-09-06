<?
include("../setingan/web.config.inc.php");

$where = $_GET[where];
$where = str_replace(" ","+",$where);
$where = base64_decode($where); 

echo "<chart caption='Grafik Member by Province' subcaption='' lineThickness='2' showValues='0' formatNumberScale='0' anchorRadius='2' divLineAlpha='20' divLineColor='CC3300' divLineIsDashed='1' showAlternateHGridColor='1' alternateHGridAlpha='5' alternateHGridColor='CC3300' shadowAlpha='40' labelStep='1' numvdivlines='5' chartRightMargin='35' bgColor='FFFFFF,CC3300' bgAngle='270' bgAlpha='10,10'>\n";

echo "<categories>";
$sql	= "select id,namapropinsi from tbl_propinsi";
$query	= mysql_query($sql);
$no		= 1;
while($row = mysql_fetch_object($query))
{
	$id			= $row->id;
	$namakota	= $row->namapropinsi;
	
	if($no < 10)
		$no	= "0".$no;
	
	echo"<category label='$no'/>";
	$no++;
}	

mysql_free_result($query);
echo"<category label='$no'/>";
echo "</categories>";

echo "-";

echo "<dataset seriesName='Jumlah Member' color='006600' anchorBorderColor='006600' anchorBgColor='006600'>\n";
$sql	= "select id,namapropinsi from tbl_propinsi";
$query	= mysql_query($sql);
while($row = mysql_fetch_object($query))
{
	$id			= $row->id;
	$namakota	= $row->namapropinsi;
	
	$sql1	= "select count(*) as jml from tbl_member where propinsiId='$id' $where";
	$query1	= mysql_query($sql1);
	$dt = mysql_fetch_object($query1);	
	$num1 = $dt->jml;
	$total	= $total+$num1;
	
	echo "<set value='$num1'/>\n";
}
mysql_free_result($query);
	
// tidak diketahui
$sql2	= "select userId from tbl_member where propinsiId=''";
$query2	= mysql_query($sql2);
$num2	= mysql_num_rows($query2);
echo "<set value='$num2'/>\n";

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