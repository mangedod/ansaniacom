<?php
$users=array(
 0=>array(
  "Subin Siby",
  "http://open.subinsb.com/data/1/img/avatar",
  "subinsiby"
 ),
 1=>array(
  "Anandu",
  "http://open.subinsb.com/data/3/img/avatar",
  "anandu"
 )
);
 $frs=array();
  foreach($users as $k=>$v){
   
    $frs[$k]['id']=$v[2];
    $frs[$k]['name']=$v[2];
    $frs[$k]['avatar']=$v[1];
  }
 echo json_encode($frs);
?>
