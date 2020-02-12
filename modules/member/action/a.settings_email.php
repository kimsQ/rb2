<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) {
	getLink('','','정상적인 접근이 아닙니다.','');
}

$R = getUidData($table['s_mbremail'],$uid);

// 이메일 추가
if ($act=='add') {

	if (!$email) getLink('','','정상적인 접근이 아닙니다.','');

	$isId = getDbRows($table['s_mbremail'],"email='".$email."'");

	$numEmails = getDbRows($table['s_mbremail'],"mbruid='".$my['uid']."'");

	if ($numEmails>4) {
		getLink('reload','parent.','더 이상 이메일을 추가할 수 없습니다.','');
	}

	if ($isId) {
		echo '<script type="text/javascript">';
		echo 'parent.$("#emailsForm").find("[name=email]").addClass("is-invalid");';
		echo 'parent.$("#emailsForm").find(".invalid-feedback").text("이미 추가되거나 가입된 이메일입니다");';
		echo 'parent.$("#emailsForm").find("[type=submit]").attr("disabled",false);';
		echo '</script>';
	} else {
		$d_regis	= $date['totime'];
		getDbInsert($table['s_mbremail'],'mbruid,email,d_regis,d_verified',"'".$my['uid']."','".trim($email)."',$d_regis,''");
		setrawcookie('member_settings_result', rawurlencode('이메일이 추가 되었습니다.|success'));  // 처리여부 cookie 저장
		getLink('reload','parent.','','');
	}
}

//이메일 삭제
if ($act=='del') {
	if (!$uid || !$R['uid']) getLink('','','정상적인 접근이 아닙니다.','');
	getDbDelete($table['s_mbremail'],'uid='.$uid.' and mbruid='.$my['uid']);
	getDbDelete($table['s_code'],'entry='.$uid.' and mbruid='.$my['uid'].' and name="settings_email" and email=1');

	if ($R['backup']==1) {  //삭제한 이메일이 기본 이메일 일 경우
		getDbUpdate($table['s_mbrdata'],'email_backup=1','memberuid='.$my['uid']);  //백업이메일 설정을 본인확인된 전체메일로 설정
	}

	if ($R['backup']==1) {  //삭제한 이메일이 백업 이메일 경우
		getDbUpdate($table['s_mbrdata'],'email_backup=1','memberuid='.$my['uid']);  //백업이메일 설정을 본인확인된 전체메일로 설정
	}

	setrawcookie('member_settings_result', rawurlencode('이메일이 삭제 되었습니다.|success'));  // 처리여부 cookie 저장
	getLink('reload','parent.','','');

}

//인증번호 발송
if ($act=='send_code') {

	$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php';
	$_tmpvfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].$m.'/var/var.php';
	include_once $_tmpvfile;

	$verify_code = date('His');
	$code_name	= 'settings_email';
	$d_regis = $date['totime'];
	$mbruid = $my['uid'];

	$email_from = $d['member']['join_email']?$d['member']['join_email']:$d['admin']['sysmail'];

	if (!$email_from) {
		getLink('','','죄송합니다. 발신 이메일 주소가 등록되지 않았습니다. 관리자에게 문의해 주세요.','');
	}

	if (!$R['email']) {
		getLink('','','등록된 이메일이 아닙니다.','');
	}

	include_once $g['path_core'].'function/email.func.php';
	$content = implode('',file($g['path_module'].'/admin/var/email.header.txt'));  //이메일 헤더 양식
	$content .= implode('',file($g['dir_module'].'doc/email/_settings.auth.email.txt'));  //이메일 본문 양식
	$content .= implode('',file($g['path_module'].'/admin/var/email.footer.txt')); // //이메일 풋터 양식
	$content = str_replace('{NAME}',$my['name'],$content);
	$content = str_replace('{NICK}',$my['nic'],$content);
	$content = str_replace('{EMAIL_MAIN}',$email_from,$content); //대표 이메일
	$content = str_replace('{TEL_MAIN}',$d['member']['join_tel']?$d['member']['join_tel']:$d['admin']['sms_tel'],$content); // 대표 전화
	$content = str_replace('{SITE}',$_HS['name'],$content); //사이트명
	$content = str_replace('{CODE}',$verify_code,$content); //인증번호
	$content = str_replace('{TIME}',$d['member']['settings_keyexpire'],$content); //인증제한시간

	//$content.= '<p>'.$R['email'].' 본인확인 인증번호  : '.$verify_code.'</p>';

	$result = getSendMail($R['email'].'|'.$my['name'], $email_from.'|'.$_HS['name'], '['.$R['email'].'] 본인확인용 인증번호가 발급되었습니다.', $content, 'HTML');

	if (!$result) {
		getLink('reload','parent.','죄송합니다. 이메일서버가 응답하지 않아 이메일을 보내드리지 못했습니다.','');
	}

	$has_code_query = 'mbruid='.$my['uid'].' and name="settings_email"  and entry='.$uid.' and email=1';
	$has_code=getDbRows($table['s_code'],$has_code_query);  // 코드 발급여부

	getDbDelete($table['s_code'],$has_code_query); 		//재발급시 기존 인증코드 삭제

	// 신규 인증코드 저장
	$_QKEY = "mbruid,name,entry,code,sms,email,d_regis";
	$_QVAL = "'$mbruid','$code_name','$uid','$verify_code','0','1','$d_regis'";
	getDbInsert($table['s_code'],$_QKEY,$_QVAL);

	//코드발급시점 저장(갱신)
	getDbUpdate($table['s_mbremail'],'d_code='.$d_regis,'uid='.$R['uid']);

	setrawcookie('member_settings_result', rawurlencode('요청하신 이메일로 인증번호가 전송 되었습니다.|success'));  // 처리여부 cookie 저장
	//setrawcookie('settings_email_code_'.$uid, rawurlencode(''));  // 처리여부 cookie 저장
	getLink('reload','parent.','','');

}

//기본 이메일 저장
if ($act=='save_primary') {

	$email = $R['email'];

	getDbUpdate($table['s_mbremail'],'base=0','mbruid='.$my['uid']); // 기본 이메일 초기화
	getDbUpdate($table['s_mbremail'],'base=1','uid='.$R['uid'].' and mbruid='.$my['uid']); // 기본 이메일 지정
	getDbUpdate($table['s_mbrdata'],'email="'.$email.'"','memberuid='.$my['uid']);  //회원정보 저장

	setrawcookie('member_settings_result', rawurlencode('기본 이메일이 설정 되었습니다.|success'));  // 처리여부 cookie 저장
	getLink('reload','parent.','','');

}

//백업 이메일 저장
if ($act=='save_backup') {

	getDbUpdate($table['s_mbremail'],'backup=0','mbruid='.$my['uid']); // 백업 이메일 초기화

	if ($uid=='none') {  // 기본 이메일만(사용안함)
		$backup_type = 0;
	} else if ($uid=='all') { //본인확인된 전체메일
		$backup_type = 1;
	} else {
		$backup_type = 2;
		getDbUpdate($table['s_mbremail'],'backup=1','uid='.$R['uid'].' and mbruid='.$my['uid']); // 백업 이메일 지정
	}

	getDbUpdate($table['s_mbrdata'],'email_backup='.$backup_type,'memberuid='.$my['uid']);  //회원정보 백업 이메일 설정 저장

	setrawcookie('member_settings_result', rawurlencode('백업 이메일이 설정 되었습니다.|success'));  // 처리여부 cookie 저장
	getLink('reload','parent.','','');

}

//인증코드 확인
if ($act=='confirm_code') {

	$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php';
	$_tmpvfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].$module.'/var/var.php';
	include_once $_tmpvfile;

	$L=getValid($R['d_code'],$d['member']['settings_keyexpire']);
	$CD = getDbData($table['s_code'],'entry='.$uid,'code');

	if (!$code) getLink('reload','parent.','인증번호를 입력해 주세요.','');
	if (!$L) getLink('reload','parent.','인증번호가 만료 되었습니다.','');
	if ($CD['code']!=$code) {

		echo '<script type="text/javascript">';
		echo 'parent.$("#item-'.$uid.'").find("[data-act=confirm_code]").attr("disabled",false);';
		echo 'parent.$("#item-'.$uid.'").find(".invalid-tooltip").text("인증번호를 확인해 주세요.");';
		echo 'parent.$("#item-'.$uid.'").find("[type=number]").focus().addClass("is-invalid");';
		echo '</script>';
		exit();
	}

	$d_regis	= $date['totime'];
	$_QVAL = "d_verified='$d_regis',d_code=''";
	getDbUpdate($table['s_mbremail'],$_QVAL,'uid='.$uid);  // 본인확인 처리
	getDbDelete($table['s_code'],'mbruid='.$my['uid'].' and name="settings_email"  and entry='.$uid.' and email=1'); //인증코드 삭제

	// 기본 이메일이 없을 경우, 기본 이메일로 지정
	if (!$my['email']) {
		getDbUpdate($table['s_mbremail'],'base=1','uid='.$uid.' and mbruid='.$my['uid']); // 기본 휴대폰 지정
		getDbUpdate($table['s_mbrdata'],'email="'.$R['email'].'"','memberuid='.$my['uid']);  //회원정보 저장
	}

	setrawcookie('member_settings_result', rawurlencode('본인인증이 성공 하였습니다.|success'));  // 처리여부 cookie 저장
	getLink('reload','parent.','','');
}

//환경설정 저장
if ($act=='save_config') {
	getDbUpdate($table['s_mbrdata'],'mailing='.$mailing,'memberuid='.$my['uid']);  //회원정보 저장
	setrawcookie('member_settings_result', rawurlencode('설정이 변경 되었습니다.|success'));  // 처리여부 cookie 저장
	getLink('reload','parent.','','');
}

exit();
?>
