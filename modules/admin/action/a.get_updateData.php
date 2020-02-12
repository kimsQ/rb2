<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$result=array();
$result['error'] = false;

$R = getUidData($table['s_gitlog'],$uid);
$M = getDbData($table['s_mbrdata'],'memberuid='.$R['mbruid'],'*');
$M1	= getUidData($table['s_mbrid'],$M['memberuid']);

$result['version'] = $R['version'];
$result['output'] = $R['output'];
$result['name'] = $M['name'].' ('.$M1['id'].')';
$result['d_regis'] = getDateFormat($R['d_regis'],'Y년 m월 d일 H시 i분');

echo json_encode($result);
exit;
?>
