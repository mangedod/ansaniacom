<?
include("../setingan/web.config.inc.php");

$where = $_GET[where];
$where = str_replace(" ","+",$where);
$where = base64_decode($where);

echo "<chart palette='4' decimals='0' enableSmartLabels='1' enableRotation='0' bgColor='99CCFF,FFFFFF' bgAlpha='40,100' bgRatio='0,100' bgAngle='360' showBorder='1' startingAngle='70' >";

$year	= date("Y");

$num1	= sql_get_var("select count(*) as jml from tbl_member where ('$year' - LEFT(userdob,4) < 20) $where");

$num2	= sql_get_var("select count(*) as jml from tbl_member where ('$year' - LEFT(userdob,4) >= 20) and ('$year' - LEFT(userdob,4) <= 30) $where");

$num5	= sql_get_var("select count(*) as jml from tbl_member where ('$year' - LEFT(userdob,4) >= 31) and ('$year' - LEFT(userdob,4) <= 40) $where");

$num3	= sql_get_var("select count(*) as jml from tbl_member where ('$year' - LEFT(userdob,4) > 40) and userdob!='0000-00-00' $where");

$num4	= sql_get_var("select count(*) as jml from tbl_member where userdob='0000-00-00' $where");

echo "
	<set label='(&lt; 20 tahun)' value='$num1' /> 
	<set label='(20 - 30 tahun)' value='$num2' /> 
	<set label='(31 - 40 tahun)' value='$num2' /> 
	<set label='(&gt; 40 tahun)' value='$num3' /> 
	<set label='Tidak Diketahui' value='$num4' /> 
";

echo "</chart>";
?>