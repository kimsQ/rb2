<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
$result=array();
$result['error']=false;

include $g['path_module'].$m.'/var/var.php';
$g['marketvar'] = $g['path_var'].'/market.var.php';
if (file_exists($g['marketvar'])) include_once $g['marketvar'];

if ($d['market']['url']) {
  include $g['path_core'].'function/rss.func.php';

  $packageData = getUrlData($d['market']['url'].'&iframe=Y&page=client.get_packageData&_clientu='.$g['s'].'&_clientr='.$r.'&package='.$package.'&id='.$d['market']['userid'].'&key='.$d['market']['key'].'&version=2&host='.$_SERVER['HTTP_HOST'].'&ip='.$_SERVER['REMOTE_ADDR'],10);

  $_extData = explode('[LIST:',$packageData);
  $_extData = explode(':LIST]',$_extData[1]);
  $_extList = $_extData[0];

} else {
  $result['error']='마켓 접속정보를 확인해주세요.';
  echo json_encode($result);
  exit;
}


$result['list'] = $_extList;

echo json_encode($result);
exit;
?>
