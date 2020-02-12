<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) getLink('','','잘못된 요청입니다.','');

$R = getUidData($table[$m.'data'],$uid);
if (!$R['uid']) exit;

if (!$my['admin'] && $my['uid'] != $R['mbruid'])
{
	if ($my['point'] < $R['point2'])
	{
		getLink('','','회원님의 보유포인트가 열람포인트보다 적습니다.','');
	}

	getDbInsert($table['s_point'],'my_mbruid,by_mbruid,price,content,d_regis',"'".$my['uid']."','0','-".$R['point2']."','게시물열람(".getStrCut($R['subject'],15,'').")','".$date['totime']."'");
	getDbUpdate($table['s_mbrdata'],'point=point-'.$R['point2'].',usepoint=usepoint+'.$R['point2'],'memberuid='.$my['uid']);

	getDbUpdate($table[$m.'data'],'hit=hit+1','uid='.$R['uid']);
	$_SESSION['module_'.$m.'_view'] .= '['.$R['uid'].']';

	getLink('reload','parent.','결제되었습니다.','');
}
else {
	getDbUpdate($table[$m.'data'],'hit=hit+1','uid='.$R['uid']);
	$_SESSION['module_'.$m.'_view'] .= '['.$R['uid'].']';
	
	if ($my['uid'] == $R['mbruid'])
	{
		getLink('reload','parent.','게시물 등록회원님으로 인증되셨습니다.','');
	}
	else 
	{
		getLink('reload','parent.','관리자님으로 인증되셨습니다.','');
	}
}
?>