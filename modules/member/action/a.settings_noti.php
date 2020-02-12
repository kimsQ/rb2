<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) {
	getLink('','','정상적인 접근이 아닙니다.','');
}

//환경설정 저장
if ($act=='save_config') {

	if (!$email_noti) {  // 이메일이 없을 때, 알림이메일 수신을 비활성 처리함
		$NT_DATA = explode('|',$my['noticeconf']);
		$NT_STRING = $NT_DATA[0].'||'.$NT_DATA[2].'|'.$NT_DATA[3].'|'.$NT_DATA[4].'|';
		getDbUpdate($table['s_mbrdata'],"noticeconf='".$NT_STRING."'",'memberuid='.$my['uid']);
	}

	getDbUpdate($table['s_mbrdata'],'email_noti="'.$email_noti.'"','memberuid='.$my['uid']);  //회원정보 저장

	if ($mobile) {
		echo '<script type="text/javascript">';
		echo 'parent.$.notify({message: "설정이 저장되었습니다."},{type: "default"});';
		echo 'parent.$(".js-submit").prop("disabled",false).focusout();';
		echo '</script>';
		exit;
	} else {
		setrawcookie('member_settings_result', rawurlencode('설정이 저장 되었습니다.|success'));  // 처리여부 cookie 저장
		getLink('reload','parent.','','');
	}
}

exit();
?>
