<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) {
	getLink('','','정상적인 접근이 아닙니다.','');
}

$R = getUidData($table['s_mbrsns'],$uid);


//sns 삭제
if ($act=='del') {

	if (!$uid || !$R['uid']) getLink('','','정상적인 접근이 아닙니다.','');

	$num_connected=getDbRows($table['s_mbrsns'],'uid<>'.$uid.' and mbruid='.$my['uid']);  // 연결된 SNS 수량

	if (!$num_connected && !$my['last_pw']) { //소셜미디어 단독계정인 경우 연결헤제시 접속 방법이 없기 때문에 비밀번호 등록을 유도함
		getLink($g['s'].'?r='.$r.'&mod=settings&page=account','parent.','연결을 끊을수 없습니다. 비밀번호 등록후 진행해 주세요.','');
	}

	getDbDelete($table['s_mbrsns'],'uid='.$uid.' and mbruid='.$my['uid']);

	if ($R['backup']==1) {  //삭제한 이메일이 백업 이메일 경우
		getDbUpdate($table['s_mbrdata'],'email_backup=1','memberuid='.$my['uid']);  //백업이메일 설정을 본인확인된 전체메일로 설정
	}

	setrawcookie('member_settings_result', rawurlencode('연결이 해제 되었습니다.|success'));  // 처리여부 cookie 저장
	getLink('reload','parent.','','');

}


exit();
?>
