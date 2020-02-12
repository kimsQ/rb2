<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if ($deltype == 'all')
{
	getDbDelete($table['s_notice'],'mbruid='.$my['uid']);
	getDbUpdate($table['s_mbrdata'],'num_notice=0','memberuid='.$my['uid']);
}
else if ($deltype == 'read')
{
	getDbDelete($table['s_notice'],'mbruid='.$my['uid']." and d_read<>''");
	getDbUpdate($table['s_mbrdata'],'num_notice='.getDbRows($table['s_notice'],'mbruid='.$my['uid']." and d_read=''"),'memberuid='.$my['uid']);
}
else {
	// 관리자모드 선택삭제
	foreach($noti_members as $val)
	{
		$NT=getDbData($table['s_notice'],"uid='".$val."'",'uid,mbruid,d_read');
		getDbDelete($table['s_notice'],"uid='".$NT['uid']."'");
		if(!$NT['d_read']) getDbUpdate($table['s_mbrdata'],'num_notice='.getDbRows($table['s_notice'],'mbruid='.$NT['mbruid']." and d_read=''"),'memberuid='.$NT['mbruid']);
	}
}
setrawcookie('result_noti_main', rawurlencode('알림이 삭제 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
