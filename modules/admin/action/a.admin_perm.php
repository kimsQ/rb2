<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
if ($my['uid'] != 1 || $memberuid == 1) getLink('','','권한이 없습니다.','');

$perm = '';
foreach($module_members as $mds)
{
	$perm .= '['.$mds.']';
}

getDbUpdate($table['s_mbrdata'],"adm_view='".$perm."'",'memberuid='.$memberuid);
setrawcookie('admin_admin_result', rawurlencode('반영 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
