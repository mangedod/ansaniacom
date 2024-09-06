<?
include("../setingan/web.config.inc.php");

$where = $_GET[where];
$where = str_replace(" ","+",$where);
$where = base64_decode($where); 

/*$numL	= sql_get_var("select count(*) as jml from tbl_member where userGender='laki-laki' $where");
echo "select count(*) as jml from tbl_member where userGender='laki-laki' $where<br> $numL"; die();*/

$numL	= sql_get_var("select count(*) as jml from tbl_member where userGender='laki-laki' $where");
	
$numP	= sql_get_var("select count(*) as jml from tbl_member where userGender='perempuan' $where");

$numM	= sql_get_var("select count(*) as jml from tbl_member where userGender!='laki-laki' and userGender!='perempuan' $where");


echo "<chart palette='4' decimals='0' enableSmartLabels='1' enableRotation='0' bgColor='99CCFF,FFFFFF' bgAlpha='40,100' bgRatio='0,100' bgAngle='360' showBorder='1' startingAngle='70' >";
	

echo "
	<set label='Laki-laki' value='$numL' /> 
	<set label='Perempuan' value='$numP' /> 
	<set label='Tidak Diketahui' value='$numM' /> 
";

echo "</chart>";
?>