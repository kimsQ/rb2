<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$pointType = $pointType ? $pointType : 'point';
foreach($point_members as $val)
{
	$P = getUidData($table['s_'.$pointType],$val);
	if (!$P['uid']) continue;

	getDbDelete($table['s_'.$pointType],'uid='.$P['uid']);
	getDbUpdate($table['s_mbrdata'],$pointType.'='.$pointType.'-'.$P['price'],'memberuid='.$P['my_mbruid']);
}
setrawcookie('result_member_point', rawurlencode('항목이 삭제되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
