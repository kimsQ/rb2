<?php
if(!defined('__KIMS__')) exit;

$result=array();
$result['error'] = false;

$uid = $_POST['uid'];
$d_read = $date['totime'];
$R = getUidData($table['s_notice'],$uid);

$result['referer'] = $R['referer'];
$result['button'] = $R['button'];
$result['d_regis'] = getDateFormat($R['d_regis'],'Y.m.d H:i');
$result['title'] = $R['title'];
$result['message'] = getContents($R['message'],'TEXT');
echo json_encode($result);

 // 읽음처리
if ($my['num_notice'] > 0 && !$R['d_read']) {
  getDbUpdate($table['s_mbrdata'],'num_notice='.$my['num_notice'].'-1','memberuid='.$my['uid']);
}
getDbUpdate($table['s_notice'],'d_read='.$d_read,'uid='.$uid);

exit;
?>
