<?php
if(!defined('__KIMS__')) exit;

$target		= str_replace('-','', $target);

// 인증코드 발송
if ($act=='send_code') {

	if (!$type || !$target) {
		getLink('','','정상적인 접근이 아닙니다.','');
	}

	if ($type=='email') $M = getDbData($table['s_mbrdata'],"email='".$target."'",'admin');
	else $M = getDbData($table['s_mbrdata'],"phone='".$target."'",'admin');

	if ($usertype=='admin' && !$M['admin']) {
		echo '<script type="text/javascript">';
		if ($type=='email') {
			echo 'parent.$("#modal-pwReset").find("[name=email]").addClass("is-invalid").focus();';
			echo 'parent.$("#modal-pwReset").find("[data-role=emailErrorBlock]").text("관리자 권한이 없는 계정입니다.");';
		} else {
			echo 'parent.$("#modal-pwReset").find("[name=phone]").addClass("is-invalid").focus();';
			echo 'parent.$("#modal-pwReset").find("[data-role=phoneErrorBlock]").text("관리자 권한이 없는 계정입니다.");';
		}
		echo 'parent.$("#modal-pwReset").find("[data-act=send_code]").attr("disabled",false);';  //데스크탑 버튼 로더 숨기기
		echo '</script>';
		exit();
	}

	$verify_code = date('His');
	$verify_token=genAccessToken(80);
	$d_regis = $date['totime'];
	$ip = $_SERVER['REMOTE_ADDR'];
	$today = substr($date['today'],0,8);
	$num_code=getDbRows($table['s_guestauth'],"ip='".$ip."' and left(d_regis,8)=".$today);  // 코드 발급수

	//인증번호 이메일 발송
	if ($type=='email') {

		$email_from = $d['member']['join_email']?$d['member']['join_email']:$d['admin']['sysmail'];


		// 이메일 중복여부 검사
		$isEmail = getDbRows($table['s_mbremail'],"email='".$target."'");

		if (!$isEmail) {
			echo '<script type="text/javascript">';
			echo 'parent.$("[name=email]").addClass("is-invalid").focus();';
			echo 'parent.$("[data-role=emailErrorBlock]").text("등록된 이메일이 없습니다.");';
			echo 'parent.$("#pane-email").find("[data-act=send_code]").prop("disabled",false);'; //데스크탑 전용
			if ($device=='mobile') echo 'parent.$("#page-pw-main").loader("hide");';  //모바일 전용 로더 숨기기
			if ($device=='desktop') echo 'parent.$("#modal-pwReset").find("[data-act=send_code]").attr("disabled",false);';  //데스크탑 버튼 로더 숨기기
			echo '</script>';
			exit();
		}

		if (!$email_from) {
			getLink('','','죄송합니다. 발신 이메일 주소가 등록되지 않았습니다. 관리자에게 문의해 주세요.','');
		}

		//이메일 인증코드 발송횟수 제한 5회
		if ($num_code>4) {
			if ($device=='mobile') {
				echo '<script type="text/javascript">';
				echo 'parent.$("#page-pw-code").page({ start: "#page-pw-main" });'; // 코드입력 액션페이지 호출
				echo 'parent.$("#page-pw-code").find("[data-role=emailCodeBlock]").text("이미 이메일로 발송된 인증번호를 참고해 주세요.");';
				echo 'parent.$("#page-pw-code").find("[data-role=confirm_email_code]").addClass("is-invalid");';
				echo 'parent.$("#page-pw-main").loader("hide");';  //로더 숨기기
				echo 'parent.$("#page-pw-code").find("[type=number]").focus();';  //코드입력폼 포커스
				echo 'parent.$("#page-pw-code").find("[name=target]").val("'.$target.'");';
				echo 'parent.$("#page-pw-code").find("[name=type]").val("'.$type.'");';
				echo '</script>';
				exit();
			} else {
				echo '<script type="text/javascript">';
				echo 'parent.$("#modal-pwReset").find("[data-act=send_code]").prop("disabled",false);';
				echo 'parent.$("#modal-pwReset").find("[data-role=emailCodeBlock]").text("이미 이메일로 발송된 인증번호를 참고해 주세요.");';
				echo 'parent.$("#modal-pwReset").find("[data-role=confirm_email_code]").addClass("is-invalid");';
				echo 'parent.$("#modal-pwReset").find("[data-role=verify_'.$type.'_area]").removeClass("d-none");';
				echo 'parent.$("#modal-pwReset").find("[data-role=confirm_'.$type.'_code]").focus();';
				echo 'parent.$("#modal-pwReset").find("[data-role=verify_'.$type.'_area]").find("[data-role=countdown]").text("");';
				echo 'parent.$("#modal-pwReset").find("[data-role=verify_'.$type.'_area]").find("[data-role=countdown]").attr("data-'.$type.'-countdown","'.$countdown.'");';
				echo 'parent.doPwCountdown("'.$type.'");';  //인증시간 카운트 다운
				echo 'parent.$("#modal-pwReset").find("[data-act=send_code]").prop("disabled",false);';
				echo 'parent.$("#modal-pwReset").find("[data-act=send_code] .not-loading").text("재발송");';
				echo 'parent.$("#modal-pwReset").find("[name=target]").val("'.$target.'");';
				echo 'parent.$("#modal-pwReset").find("[name=type]").val("'.$type.'");';
				echo '</script>';
				exit();
			}
		}

		include_once $g['path_core'].'function/email.func.php';

		$content = implode('',file($g['path_module'].'/admin/var/email.header.txt'));  //이메일 헤더 양식
		$content.= implode('',file($g['dir_module'].'doc/email/_pw.auth.txt')); //이메일 본문 양식
		$content.= implode('',file($g['path_module'].'/admin/var/email.footer.txt')); // //이메일 풋터 양식
		$content = str_replace('{EMAIL_MAIN}',$email_from,$content); //대표 이메일
		$content = str_replace('{TEL_MAIN}',$sms_tel,$content); // 대표 전화
		$content = str_replace('{SITE}',$_HS['name'],$content); //사이트명
		$content = str_replace('{EMAIL}',$target,$content); //계정 이메일
		$content = str_replace('{CODE}',$verify_code,$content); //인증번호
		$content = str_replace('{TIME}',$d['member']['settings_keyexpire'],$content); //인증제한시간

		$result = getSendMail($target,$email_from.'|'.$_HS['name'],'비밀번호 재설정 인증번호 - '.$verify_code, $content, 'HTML');

		if (!$result) {
			getLink('reload','parent.','죄송합니다. 이메일서버가 응답하지 않아 이메일을 보내드리지 못했습니다.','');
		}

		$_QKEY = "auth,email,phone,token,code,d_regis,ip";
		$_QVAL = "0,'$target','','$verify_token','$verify_code','$d_regis','$ip'";
	}


	if ($type=='phone') {

		$sms_tel = $d['member']['join_tel']?$d['member']['join_tel']:$d['admin']['sms_tel'];

		// 휴대폰 중복여부 검사
		$isPhone = getDbRows($table['s_mbrphone'],"phone='".$target."'");

		if (!$isPhone) {
			echo '<script type="text/javascript">';
			echo 'parent.$("[name=phone]").addClass("is-invalid").focus();';
			echo 'parent.$("[data-role=phoneErrorBlock]").text("등록된 휴대폰이 없습니다.");';
			if ($device=='mobile') echo 'parent.$("#page-pw-main").loader("hide");';  //모바일 전용 로더 숨기기
			if ($device=='desktop') echo 'parent.$("#modal-pwReset").find("[data-act=send_code]").attr("disabled",false);';  //데스크탑 전용 로더 숨기기
			echo 'parent.$("#pane-phone").find("[data-act=send_code]").prop("disabled",false);';  //데스크탑 전용
			echo '</script>';
			exit();
		}

		if (!$sms_tel) {
			getLink('','','죄송합니다. SMS발신 전화번호가 등록되지 않았습니다. 관리자에게 문의해 주세요.','');
		}

		//본인확인 SMS 일발송 제한- 회원모듈 > 환경설정 > 회원가입설정 참조
		if ($num_code>$d['member']['join_daysms']-1) {
			if ($device=='mobile') {
				echo '<script type="text/javascript">';
				echo 'parent.$("#page-pw-code").page({ start: "#page-pw-main" });'; // 코드입력 액션페이지 호출
				echo 'parent.$("#page-pw-code").find("[data-role=phoneCodeBlock]").text("이미 휴대폰으로 발송된 인증번호를 참고해 주세요.");';
				echo 'parent.$("#page-pw-code").find("[data-role=confirm_phone_code]").addClass("is-invalid");';
				echo 'parent.$("#page-pw-main").loader("hide");';  //로더 숨기기
				echo 'parent.$("#page-pw-code").find("[type=number]").focus();';  //코드입력폼 포커스
				echo 'parent.$("#page-pw-code").find("[name=target]").val("'.$target.'");';
				echo 'parent.$("#page-pw-code").find("[name=type]").val("'.$type.'");';
				echo '</script>';
				exit();
			} else {
				echo '<script type="text/javascript">';
				echo 'parent.$("#modal-pwReset").find("[data-act=send_code]").prop("disabled",true);';
				echo 'parent.$("#modal-pwReset").find("[data-role=phoneCodeBlock]").text("이미 휴대폰으로 발송된 인증번호를 참고해 주세요.");';
				echo 'parent.$("#modal-pwReset").find("[data-role=confirm_phone_code]").addClass("is-invalid");';
				echo 'parent.$("#modal-pwReset").find("[data-role=verify_'.$type.'_area]").removeClass("d-none");';
				echo 'parent.$("#modal-pwReset").find("[data-role=confirm_'.$type.'_code]").focus();';
				echo 'parent.$("#modal-pwReset").find("[data-role=verify_'.$type.'_area]").find("[data-role=countdown]").text("");';
				echo 'parent.$("#modal-pwReset").find("[data-role=verify_'.$type.'_area]").find("[data-role=countdown]").attr("data-'.$type.'-countdown","'.$countdown.'");';
				echo 'parent.doPwCountdown("'.$type.'");';  //인증시간 카운트 다운
				echo 'parent.$("#modal-pwReset").find("[data-act=send_code]").prop("disabled",false);';
				echo 'parent.$("#modal-pwReset").find("[data-act=send_code] .not-loading").text("재발송");';
				echo 'parent.$("#modal-pwReset").find("[name=target]").val("'.$target.'");';
				echo 'parent.$("#modal-pwReset").find("[name=type]").val("'.$type.'");';
				echo '</script>';
				exit();
			}
		}

		include_once $g['path_core'].'function/sms.func.php';
		$content = implode('',file($g['dir_module'].'doc/sms/_pw.auth.txt'));  // SMS메시지 양식
		$content = str_replace('{SITE}',$_HS['name'],$content); //사이트명
		$content = str_replace('{PHONE}',$target,$content); //계정 휴대폰
		$content = str_replace('{CODE}',$verify_code,$content); //인증번호
		$content = str_replace('{TIME}',$d['member']['settings_keyexpire'],$content); //인증제한시간

		$result = getSendSMS($target,$sms_tel,'',$content,'sms');

		if ($result != 'OK') {
			getLink('reload','parent.',$result,'');
		}

		$_QKEY = "auth,email,phone,token,code,d_regis,ip";
		$_QVAL = "0,'','$target','$verify_token','$verify_code','$d_regis','$ip'";
	}

	// 신규 인증코드 저장
	getDbInsert($table['s_guestauth'],$_QKEY,$_QVAL);
	$lastuid  = getDbCnt($table['s_guestauth'],'max(uid)','');
	$R = getUidData($table['s_guestauth'],$lastuid);

	//인증 제한시간
	$countdown = date("Y/m/d H:i:s",strtotime ("+".$d['member']['join_keyexpire']." minutes",strtotime($R['d_regis']))) ;

	if ($device=='mobile') {
		echo '<script type="text/javascript">';
		echo 'parent.$("#page-pw-code").page({ start: "#page-pw-main" });'; // 코드입력 액션페이지 호출
		echo 'setTimeout(function() {parent.$.notify({message: "인증번호가 발송되었습니다."},{type: "default"});}, 700);'; // 알림메시지 출력
		echo 'parent.$("#page-pw-main").loader("hide");';  //로더 숨기기
		echo 'parent.$("#page-pw-code").find("[type=number]").focus();';  //코드입력폼 포커스
		echo 'parent.$("#page-pw-code").find("[name=target]").val("'.$target.'");';
		echo 'parent.$("#page-pw-code").find("[name=type]").val("'.$type.'");';
		echo 'parent.$("#page-pw-code").find("[data-role=countdown]").attr("data-'.$type.'-countdown","'.$countdown.'");';
		echo 'parent.doPwCountdown("'.$type.'");';  //인증시간 카운트 다운
		echo '</script>';
	} else {
		echo '<script type="text/javascript">';
		echo 'parent.$.notify({message: "인증번호가 발송되었습니다."},{type: "success"});';
		echo 'parent.$("#modal-pwReset").find("[data-role=verify_'.$type.'_area]").removeClass("d-none");';
		echo 'parent.$("#modal-pwReset").find("[data-role=confirm_'.$type.'_code]").focus();';
		echo 'parent.$("#modal-pwReset").find("[data-role=verify_'.$type.'_area]").find("[data-role=countdown]").text("");';
		echo 'parent.$("#modal-pwReset").find("[data-role=verify_'.$type.'_area]").find("[data-role=countdown]").attr("data-'.$type.'-countdown","'.$countdown.'");';
		echo 'parent.doPwCountdown("'.$type.'");';  //인증시간 카운트 다운
		echo 'parent.$("#modal-pwReset").find("[data-act=send_code]").prop("disabled",false);';
		echo 'parent.$("#modal-pwReset").find("[data-act=send_code] .not-loading").text("재발송");';
		echo 'parent.$("#modal-pwReset").find("[name=target]").val("'.$target.'");';
		echo 'parent.$("#modal-pwReset").find("[name=type]").val("'.$type.'");';
		echo '</script>';
	}

}

// 인증코드 확인
if ($act=='confirm_code') {

	if (!$type || !$code) {
		getLink('','','정상적인 접근이 아닙니다.','');
	}

	$R = getDbData($table['s_guestauth'],"code='".$code."'",'*');

	if ($type=='email') {

		// 코드 검사
		if ($code != $R['code']) {
			if ($device=='mobile') {
				echo '<script type="text/javascript">';
				echo 'parent.$("#page-pw-code").loader("hide");';  //로더 숨기기
				echo 'parent.$("[name=confirm_email_code]").addClass("is-invalid").focus();';
				echo 'parent.$("[data-role=emailCodeBlock]").text("인증번호를 확인해 주세요");';
				echo '</script>';
				exit();
			} else {
				echo '<script type="text/javascript">';
				echo 'parent.$("[name=confirm_email_code]").addClass("is-invalid").focus();';
				echo 'parent.$("[data-role=emailCodeBlock]").text("인증번호를 확인해 주세요");';
				echo 'parent.$("#modal-pwReset").find("[data-act=confirm_code]").prop("disabled",false);'; //데스크탑 버튼 로더 숨기기
				echo '</script>';
				exit();
			}
		}
	}

	if ($type=='phone') {

		// 코드 검사
		if ($code != $R['code']) {
			if ($device=='mobile') {
				echo '<script type="text/javascript">';
				echo 'parent.$("#page-pw-code").loader("hide");';  //로더 숨기기
				echo 'parent.$("[name=confirm_phone_code]").addClass("is-invalid").focus();';
				echo 'parent.$("[data-role=phoneCodeBlock]").text("인증번호를 확인해 주세요");';
				echo '</script>';
				exit();
			} else {
				echo '<script type="text/javascript">';
				echo 'parent.$("[name=confirm_phone_code]").addClass("is-invalid").focus();';
				echo 'parent.$("[data-role=phoneCodeBlock]").text("인증번호를 확인해 주세요");';
				echo 'parent.$("#modal-pwReset").find("[data-act=confirm_code]").prop("disabled",false);';
				echo '</script>';
				exit();
			}
		}
	}

	getDbUpdate($table['s_guestauth'],'auth=1','code='.$R['code']);  // 인증완료상태 처리

	if ($device=='mobile') {
		echo '<script type="text/javascript">';
		echo 'parent.$("#page-pw-code").loader("hide");';  //로더 숨기기
		echo 'parent.$("#page-pw-code").find("[data-role=confirm_code]").addClass("d-none");';
		echo 'parent.$("#page-pw-code").find("[data-role=change_pw]").removeClass("d-none");';
		echo 'parent.$("#page-pw-code").find("[name=code]").val("'.$code.'");';
		echo 'setTimeout(function() {parent.$("#page-pw-code").find("[name=pw1]").focus();}, 700);'; // 알림메시지 출력
		echo 'setTimeout(function() {parent.$.notify({message: "인증번호가 확인 되었습니다."},{type: "default"});}, 1100);'; // 알림메시지 출력
		echo '</script>';
	} else {
		echo '<script type="text/javascript">';
		echo 'parent.$.notify({message: "인증번호가 확인 되었습니다."},{type: "success"});';
		echo 'parent.$("#modal-pwReset").find("[data-role=confirm_code]").addClass("d-none");';
		echo 'parent.$("#modal-pwReset").find("[data-role=change_pw]").removeClass("d-none");';
		echo 'parent.$("#modal-pwReset").find("[name=code]").val("'.$code.'");';
		echo 'setTimeout(function() {parent.$("#modal-pwReset").find("[data-role=pw1]").focus();}, 700);'; // 알림메시지 출력
		echo '</script>';
	}

}

//비밀번호 변경저장
if ($act=='change_pw') {

	if (!$pw1 || !$pw2 || !$code || !$type || !$target) getLink('reload','parent.','정상적인 접근이 아닙니다.','');

	$R = getDbData($table['s_guestauth'],"code='".$code."'",'*');
	if ($code != $R['code']) getLink('reload','parent.','정상적인 접근이 아닙니다.','');

	if ($type=='email') $E = getDbData($table['s_mbremail'],"email='".$target."'",'mbruid');
	else $E = getDbData($table['s_mbrphone'],"phone='".$target."'",'mbruid');

	$M = getDbData($table['s_mbrdata'],"memberuid='".$E['mbruid']."'",'d_regis');
	$new_pw = password_hash($pw1, PASSWORD_DEFAULT);

	getDbUpdate($table['s_mbrid'],"pw='".$new_pw."'",'uid='.$E['mbruid']);
	getDbUpdate($table['s_mbrdata'],"last_pw='".$date['today']."',tmpcode=''",'memberuid='.$E['mbruid']);

	if ($my['uid']) $_SESSION['mbr_pw'] = $new_pw;

	if ($device=='mobile') {
		echo '<script type="text/javascript">';
		echo 'parent.$("#page-pw-code").loader("hide");';  //로더 숨기기
		echo 'parent.$("#modal-pwReset").removeClass("active");';  //모달 닫기
		echo 'parent.$("#modal-loginform").find("[data-role=input-'.$type.'] [name=id]").val("'.$target.'");';  //로그인 모달 >폼 아이디 입력
		echo 'parent.$("#modal-loginform").find("[name=id]").removeClass("is-invalid");';  //로그인 모달 >폼 아이디 입력폼 에러흔적제거
		echo 'parent.$("#modal-loginform").find("[name=pw]").removeClass("is-invalid").focus();';  //로그인 모달 >폼 비밀번호 입력폼 에러흔적제거, 포커스 처리
		echo 'setTimeout(function() {parent.$.notify({message: "비밀번호가 변경되었습니다."},{type: "default"});}, 900);'; // 알림메시지 출력
		echo '</script>';
	} else {
		echo '<script type="text/javascript">';
		echo 'parent.$("#modal-pwReset").modal("hide");';  //비밀번호 재설정 모달 닫기
		if (!$my['uid'] && $usertype!='admin') {
			echo 'setTimeout(function() {parent.$("#modal-login").modal("show");}, 400);'; //로그인 모달 열기
			echo 'setTimeout(function() {parent.$("#modal-login").find("[name=id]").val("'.$target.'");}, 1000);'; //로그인 모달 >폼 아이디 입력
			echo 'setTimeout(function() {parent.$("#modal-login").find("[name=pw]").focus();}, 1000);'; //로그인 모달 >폼 비밀번호 입력폼 포커스 처리
			echo 'setTimeout(function() {parent.$.notify({message: "비밀번호가 변경되었습니다."},{type: "success"});}, 1500);';
		} else {
			echo 'setTimeout(function() {parent.$.notify({message: "비밀번호가 변경되었습니다."},{type: "success"});}, 500);';
		}
		echo '</script>';
	}

}

exit();


?>
