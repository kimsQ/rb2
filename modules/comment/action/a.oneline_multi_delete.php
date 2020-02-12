<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

foreach ($oneline_members as $val)
{
	$R = getUidData($table['s_oneline'],$val);
	if (!$R['uid']) continue;

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
	$syncArr = getArrayString($C['sync']);
	$fdexp = explode(',',$syncArr['data'][2]);
	if ($fdexp[0]&&$fdexp[2]&&$syncArr['data'][3]) getDbUpdate($syncArr['data'][3],$fdexp[2].'='.$fdexp[2].'-1',$fdexp[0].'='.$syncArr['data'][1]);

}
setrawcookie('comment_oneline_result', rawurlencode('의견이 삭제 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
