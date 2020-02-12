<?php
if(!defined('__KIMS__')) exit;

$result=array();

if ($my['uid'] && $token) {

  $agent= $_SERVER['HTTP_USER_AGENT'];
  $deviceKind=isMobileConnect($agent);
  $deviceType=getDeviceKind($agent,$deviceKind);
  $d_regis	= $date['totime'];

  $is_token=getDbRows($table['s_iidtoken'],'mbruid='.$my['uid'].'  and device="'.$deviceType.'"');  // 기존 토큰저장 여부

  if (!$is_token) {
    getDbInsert($table['s_iidtoken'],'mbruid,token,device,browser,version,d_regis',"'".$my['uid']."','".$token."','".$deviceType."','".$browser."','".$version."','".$d_regis."'");
  } else {
    $_QVAL = "token='$token',browser='$browser',version='$version',d_update='$d_regis'";
    getDbUpdate($table['s_iidtoken'],$_QVAL,'mbruid='.$my['uid'].' and device="'.$deviceType.'"');  //토큰 갱신저장
  }

  $result['is_token'] = $is_token;
  $result['mbruid'] = $my['uid'];
  $result['agent'] = $agent;
  $result['error'] = false;

} else {
  $result['is_token'] = '';
  $result['mbruid'] = '';
  $result['agent'] = '';
  $result['error'] = ture;
}

echo json_encode($result);
exit;
?>
