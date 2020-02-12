<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

foreach ($bbs_members as $val)
{
	$R = getUidData($table[$m.'list'],$val);
	if (!$R['uid']) continue;
	getDbUpdate($table[$m.'list'],"name='".trim(${'name_'.$R['uid']})."'",'uid='.$R['uid']);
}
getLink('reload','parent.','수정되었습니다.','');
?>