<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) getLink('','','정상적인 접근이 아닙니다.','');

include_once $g['path_core'].'function/fcm.func.php';
$rcvmember = $mbruid;
$TKD = getDbArray($table['s_iidtoken'],'mbruid='.$rcvmember,'token','uid','asc',0,1);

$g['notiIconForSite'] = $g['path_var'].'site/'.$r.'/homescreen.png';
$g['url_notiIcon'] = $g['s'].'/_var/site/'.$r.'/homescreen-192x192.png';
$avatar = file_exists($g['notiIconForSite']) ? $g['url_notiIcon'] : $g['img_core'].'/touch/homescreen-192x192.png';
$tokenArray = array();
$referer ='';
$tag = '';
while ($row = db_fetch_array($TKD)) {
  array_push($tokenArray,$row['token']);
}

getSendFCM($tokenArray,$title,$message,$avatar,$referer,$tag);

$result['error']=false;
echo json_encode($result);
exit;
?>
