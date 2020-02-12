<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) getLink('','','정상적인 접근이 아닙니다.','');

if ($deltype == 'delete_all')
{
	getDbDelete($table['s_notice'],'mbruid='.$my['uid']);
	getDbUpdate($table['s_mbrdata'],'num_notice=0','memberuid='.$my['uid']);
}
else if ($deltype == 'delete_read')
{
	getDbDelete($table['s_notice'],'mbruid='.$my['uid']." and d_read<>''");
	getDbUpdate($table['s_mbrdata'],'num_notice='.getDbRows($table['s_notice'],'mbruid='.$my['uid']." and d_read=''"),'memberuid='.$my['uid']);
}
else if ($deltype == 'delete_select') {
	foreach($noti_members as $val)
	{
		$exp = explode('|',$val);
		getDbDelete($table['s_notice'],"uid='".$exp[0]."' and mbruid=".$my['uid']);
	}
	getDbUpdate($table['s_mbrdata'],'num_notice='.getDbRows($table['s_notice'],'mbruid='.$my['uid']." and d_read=''"),'memberuid='.$my['uid']);
}
else if ($deltype == 'cut_member')
{
	$NT_DATA = explode('|',$my['noticeconf']);
	$nt_members = $NT_DATA[4];
	foreach($noti_members as $val)
	{
		$exp = explode('|',$val);
		if (!$exp[1]) continue;
		if ($exp[1] == $my['uid'])
		{
			$isMe = true;
			continue;
		}
		if (!strstr($nt_members,'['.$exp[1].']')) $nt_members = '['.$exp[1].']' . $nt_members;
	}
	$NT_STRING = $NT_DATA[0].'|'.$NT_DATA[1].'|'.$NT_DATA[2].'|'.$NT_DATA[3].'|'.$nt_members.'|'.$NT_DATA[5].'|';
	getDbUpdate($table['s_mbrdata'],"noticeconf='".$NT_STRING."'",'memberuid='.$my['uid']);
}
else if ($deltype == 'cut_module')
{

	$NT_DATA = explode('|',$my['noticeconf']);
	$nt_modules = $NT_DATA[3];
	foreach($noti_members as $val)
	{
		$exp = explode('|',$val);
		if ($exp[1] == $my['uid'])
		{
			$isMe = true;
			continue;
		}
		if (!strstr($nt_modules,'['.$exp[2].']')) $nt_modules = '['.$exp[2].']' . $nt_modules;
	}
	$NT_STRING = $NT_DATA[0].'|'.$NT_DATA[1].'|'.$NT_DATA[2].'|'.$nt_modules.'|'.$NT_DATA[4].'|'.$NT_DATA[5].'|';
	getDbUpdate($table['s_mbrdata'],"noticeconf='".$NT_STRING."'",'memberuid='.$my['uid']);
}
else if ($deltype == 'off_module')
{
	$NT_DATA = explode('|',$my['noticeconf']);
	$nt_modules = $NT_DATA[3];
	if (!strstr($nt_modules,'['.$module_id.']')) $nt_modules = '['.$module_id.']' . $nt_modules;
	$NT_STRING = $NT_DATA[0].'|'.$NT_DATA[1].'|'.$NT_DATA[2].'|'.$nt_modules.'|'.$NT_DATA[4].'|'.$NT_DATA[5].'|';
	getDbUpdate($table['s_mbrdata'],"noticeconf='".$NT_STRING."'",'memberuid='.$my['uid']);

	if ($mobile) {
		echo '<script type="text/javascript">';
		echo 'parent.$.notify({message: "알림이 해제되었습니다."},{type: "default"});';
		echo '</script>';
		exit();
	} else {
		setrawcookie('member_settings_result', rawurlencode('알림이 해제되었습니다.'));
	}

}
if ($deltype=='cut_member'||$deltype=='cut_module')
{
	if ($isMe) {
		setrawcookie('member_noti_result', rawurlencode('자기 자신은 차단할 수 없습니다.|danger'));
	} else {
		setrawcookie('member_noti_result', rawurlencode('차단 되었습니다.'));
	}
}
else {
	setrawcookie('member_noti_result', rawurlencode('처리 되었습니다.'));  // 처리여부 cookie 저장
}
	getLink('reload','parent.','','');
?>
