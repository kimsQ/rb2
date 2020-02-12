<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) echo '[RESULT:정상적인 접근이 아닙니다.:RESULT]';
$R = getUidData($table['s_oneline'],$uid);
if (!$R['uid']) echo '[RESULT:존재하지 않는 한줄 의견입니다.:RESULT]';
if ($R['id']!=$my['id']&&!$my['admin']) echo '[RESULT:삭제권한이 없습니다.:RESULT]';

$C = getUidData($table['s_comment'],$R['parent']);

getDbDelete($table['s_oneline'],'uid='.$R['uid']);
getDbUpdate($table['s_comment'],'oneline=oneline-1','uid='.$C['uid']);
getDbUpdate($table['s_numinfo'],'oneline=oneline-1',"date='".substr($R['d_regis'],0,8)."' and site=".$R['site']);

if ($R['point']&&$R['mbruid'])
{
	getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$R['mbruid']."','0','-".$R['point']."','한줄의견삭제(".getStrCut(str_replace('&amp;',' ',strip_tags($R['content'])),15,'').")환원','".$date['totime']."'");
	getDbUpdate($table['s_mbrdata'],'point=point-'.$R['point'],'memberuid='.$R['mbruid']);
}

//동기화
$cyncArr = getArrayString($C['cync']);
$fdexp = explode(',',$cyncArr['data'][2]);
if ($fdexp[0]&&$fdexp[2]&&$cyncArr['data'][3]) getDbUpdate($cyncArr['data'][3],$fdexp[2].'='.$fdexp[2].'-1',$fdexp[0].'='.$cyncArr['data'][1]);
echo '[RESULT:ok:RESULT]';
exit;
?>
