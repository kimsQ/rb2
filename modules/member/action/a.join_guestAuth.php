<?php
if(!defined('__KIMS__')) exit;

$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php';
$_tmpvfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].$module.'/var/var.php';
include_once $_tmpvfile;

// 인증코드 발송
if ($act=='send_code') {

	if (!$type || !$target) {
		getLink('','','정상적인 접근이 아닙니다.','');
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

		// 가입제한 이메일
		if (strstr(','.$d['member']['join_cutemail'].',',','.$target.',')) {
			echo '<script type="text/javascript">';
			echo 'parent.$("[name=email]").addClass("is-invalid").focus();';
			echo 'parent.$("[data-role=emailErrorBlock]").text("가입이 제한된 이메일 입니다.");';
			if ($device=='mobile') echo 'parent.$("#page-join-form").loader("hide");';  //모바일 전용 로더 숨기기
			echo 'parent.$("#pane-email").find("[data-act=send_code]").prop("disabled",false);';  //데스크탑 전용
			echo '</script>';
			exit();
		}

		// 이메일 중복여부 검사
		$isEmail = getDbRows($table['s_mbremail'],"email='".$target."'");

		if ($isEmail) {
			echo '<script type="text/javascript">';
			echo 'parent.$("[name=email]").addClass("is-invalid").focus();';
			echo 'parent.$("[data-role=emailErrorBlock]").text("이미 등록된 이메일 입니다.");';
			echo 'parent.$("#pane-email").find("[data-act=send_code]").prop("disabled",false);'; //데스크탑 전용
			if ($device=='mobile') echo 'parent.$("#page-join-form").loader("hide");';  //모바일 전용 로더 숨기기
			echo '</script>';
			exit();
		}

		//본인확인 미설정시 가입화면으로 이동
		if (!$d['member']['join_verify']) {
			$_SESSION['JOIN']['email']	= $target; // 이메일 세션저장
			setrawcookie('site_login_result', rawurlencode('가입정보를 입력해 주세요|success'));  // 알림처리를 위한 로그인 상태 cookie 저장
			getLink('reload','parent.','','');
		}

		if (!$email_from) {
			getLink('','','죄송합니다. 발신 이메일 주소가 등록되지 않았습니다. 관리자에게 문의해 주세요.','');
		}

		//이메일 인증코드 발송횟수 제한 5회
		if ($num_code>4) {
			if ($device=='mobile') {
				echo '<script type="text/javascript">';
				echo 'parent.$("#page-join-code").page({ start: "#page-join-form" });'; // 코드입력 액션페이지 호출
				echo 'parent.$("#page-join-code").find("[data-role=emailCodeBlock]").text("이미 이메일로 발송된 인증번호를 참고해 주세요.");';
				echo 'parent.$("#page-join-code").find("[data-role=confirm_email_code]").addClass("is-invalid");';
				echo 'parent.$("#page-join-form").loader("hide");';  //로더 숨기기
				echo 'parent.$("#page-join-code").find("[type=number]").focus();';  //코드입력폼 포커스
				echo '</script>';
				exit();
			} else {
				echo '<script type="text/javascript">';
				echo 'parent.$("#pane-email").find("[data-act=send_code]").prop("disabled",false);';
				echo 'parent.$("#pane-email").find("[data-role=emailCodeBlock]").text("이미 이메일로 발송된 인증번호를 참고해 주세요.");';
				echo 'parent.$("#pane-email").find("[data-role=confirm_email_code]").addClass("is-invalid");';
				echo 'parent.$("[data-role=verify_'.$type.'_area]").removeClass("d-none");';
				echo 'parent.$("[data-role=confirm_'.$type.'_code]").focus();';
				echo 'parent.$("[data-role=verify_'.$type.'_area]").find("[data-role=countdown]").text("");';
				echo 'parent.$("[data-role=verify_'.$type.'_area]").find("[data-role=countdown]").attr("data-'.$type.'-countdown","'.$countdown.'");';
				echo 'parent.doCountdown("'.$type.'");';  //인증시간 카운트 다운
				echo 'parent.$("[data-act=send_code]").prop("disabled",false);';
				echo 'parent.$("[data-act=send_code] .not-loading").text("재발송");';
				echo '</script>';
				exit();
			}
		}

		include_once $g['path_core'].'function/email.func.php';

		$content = implode('',file($g['path_module'].'/admin/var/email.header.txt'));  //이메일 헤더 양식
		$content.= implode('',file($g['dir_module'].'doc/email/_join.auth.txt')); //이메일 본문 양식
		$content.= '<p><a href="'.$g['url_root'].'/'.$r.'/auth/join?token='.$verify_token.'"  style="display:block;font-size:15px;color:#fff;text-decoration:none;padding: 15px;background:#007bff;width: 200px;text-align: center;margin: 38px auto;" target="_blank">회원가입 계속하기</a></p>';
		$content.= implode('',file($g['path_module'].'/admin/var/email.footer.txt')); // //이메일 풋터 양식
		$content = str_replace('{EMAIL_MAIN}',$email_from,$content); //대표 이메일
		$content = str_replace('{TEL_MAIN}',$sms_tel,$content); // 대표 전화
		$content = str_replace('{SITE}',$_HS['name'],$content); //사이트명
		$content = str_replace('{EMAIL}',$target,$content); //계정 이메일
		$content = str_replace('{CODE}',$verify_code,$content); //인증번호
		$content = str_replace('{TIME}',$d['member']['settings_keyexpire'],$content); //인증제한시간

		$result = getSendMail($target,$email_from.'|'.$_HS['name'], '['.$_HS['name'].'] 가입 인증번호', $content, 'HTML');

		if (!$result) {
			getLink('reload','parent.','죄송합니다. 이메일서버가 응답하지 않아 이메일을 보내드리지 못했습니다.','');
		}

		$_QKEY = "auth,email,phone,token,code,d_regis,ip";
		$_QVAL = "0,'$target','','$verify_token','$verify_code','$d_regis','$ip'";
	}


	if ($type=='phone') {

		$sms_tel = $d['member']['join_tel']?$d['member']['join_tel']:$d['admin']['sms_tel'];

		// 가입제한 휴대폰
		$_target = str_replace('-','', $target);
		if (strstr(','.$d['member']['join_cutphone'].',',','.$_target.',')) {
			echo '<script type="text/javascript">';
			echo 'parent.$("[name=phone]").addClass("is-invalid").focus();';
			echo 'parent.$("[data-role=phoneErrorBlock]").text("가입이 제한된 휴대폰 입니다.");';
			if ($device=='mobile') echo 'parent.$("#page-join-form").loader("hide");';  //모바일 전용 로더 숨기기
			echo 'parent.$("#pane-phone").find("[data-act=send_code]").prop("disabled",false);';
			echo '</script>';
			exit();
		}

		// 휴대폰 중복여부 검사
		$isPhone = getDbRows($table['s_mbrphone'],"phone='".$target."'");

		if ($isPhone) {
			echo '<script type="text/javascript">';
			echo 'parent.$("[name=phone]").addClass("is-invalid").focus();';
			echo 'parent.$("[data-role=phoneErrorBlock]").text("이미 등록된 휴대폰 입니다.");';
			if ($device=='mobile') echo 'parent.$("#page-join-form").loader("hide");';  //모바일 전용 로더 숨기기
			echo 'parent.$("#pane-phone").find("[data-act=send_code]").prop("disabled",false);';  //데스크탑 전용
			echo '</script>';
			exit();
		}

		//본인확인 미설정시 가입화면으로 이동
		if (!$d['member']['join_verify']) {
			$_SESSION['JOIN']['phone']	= $target; // 휴대폰 세션저장
			setrawcookie('site_login_result', rawurlencode('가입정보를 입력해 주세요|success'));  // 알림처리를 위한 로그인 상태 cookie 저장
			getLink('reload','parent.','','');
		}

		if (!$sms_tel) {
			getLink('','','죄송합니다. SMS발신 전화번호가 등록되지 않았습니다. 관리자에게 문의해 주세요.','');
		}

		//본인확인 SMS 일발송 제한- 회원모듈 > 환경설정 > 회원가입설정 참조
		if ($num_code>$d['member']['join_daysms']-1) {
			if ($device=='mobile') {
				echo '<script type="text/javascript">';
				echo 'parent.$("#page-join-code").page({ start: "#page-join-form" });'; // 코드입력 액션페이지 호출
				echo 'parent.$("#page-join-code").find("[data-role=phoneCodeBlock]").text("이미 휴대폰으로 발송된 인증번호를 참고해 주세요.");';
				echo 'parent.$("#page-join-code").find("[data-role=confirm_phone_code]").addClass("is-invalid");';
				echo 'parent.$("#page-join-form").loader("hide");';  //로더 숨기기
				echo 'parent.$("#page-join-code").find("[type=number]").focus();';  //코드입력폼 포커스
				echo '</script>';
				exit();
			} else {
				echo '<script type="text/javascript">';
				echo 'parent.$("#pane-phone").find("[data-act=send_code]").prop("disabled",true);';
				echo 'parent.$("#pane-phone").find("[data-role=phoneCodeBlock]").text("이미 휴대폰으로 발송된 인증번호를 참고해 주세요.");';
				echo 'parent.$("#pane-phone").find("[data-role=confirm_phone_code]").addClass("is-invalid");';
				echo 'parent.$("[data-role=verify_'.$type.'_area]").removeClass("d-none");';
				echo 'parent.$("[data-role=confirm_'.$type.'_code]").focus();';
				echo 'parent.$("[data-role=verify_'.$type.'_area]").find("[data-role=countdown]").text("");';
				echo 'parent.$("[data-role=verify_'.$type.'_area]").find("[data-role=countdown]").attr("data-'.$type.'-countdown","'.$countdown.'");';
				echo 'parent.doCountdown("'.$type.'");';  //인증시간 카운트 다운
				echo 'parent.$("[data-act=send_code]").prop("disabled",false);';
				echo 'parent.$("[data-act=send_code] .not-loading").text("재발송");';
				echo '</script>';
				exit();
			}
		}

		include_once $g['path_core'].'function/sms.func.php';
		$content = implode('',file($g['dir_module'].'doc/sms/_join.auth.txt'));  // SMS메시지 양식
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
		echo 'parent.$("#page-join-code").page({ start: "#page-join-form" });'; // 코드입력 액션페이지 호출
		// echo 'setTimeout(function() {parent.$.notify({message: "인증번호가 발송되었습니다."},{type: "default"});}, 700);'; // 알림메시지 출력
		echo 'parent.$("#page-join-form").loader("hide");';  //로더 숨기기
		echo 'parent.$("#page-join-code").find("[type=number]").focus();';  //코드입력폼 포커스
		echo 'parent.$("#page-join-code").find("[data-act=confirm_code]").attr("data-type","'.$type.'");';
		echo 'parent.$("#page-join-code").find("[type=number]").attr("data-role","confirm_'.$type.'_code").attr("name","confirm_'.$type.'_code");';
		echo 'parent.$("#page-join-code").find(".invalid-tooltip").attr("data-role","'.$type.'CodeBlock");';
		echo 'parent.$("#page-join-code").find("[data-role=countdown]").text("");';
		echo 'parent.$("#page-join-code").find("[data-role=countdown]").attr("data-'.$type.'-countdown","'.$countdown.'");';
		echo 'parent.doCountdown("'.$type.'");';  //인증시간 카운트 다운
		echo '</script>';
	} else {
		echo '<script type="text/javascript">';
		echo 'parent.$.notify({message: "인증번호가 발송되었습니다."},{type: "success"});';
		echo 'parent.$("[data-role=verify_'.$type.'_area]").removeClass("d-none");';
		echo 'parent.$("[data-role=confirm_'.$type.'_code]").focus();';
		echo 'parent.$("[data-role=verify_'.$type.'_area]").find("[data-role=countdown]").text("");';
		echo 'parent.$("[data-role=verify_'.$type.'_area]").find("[data-role=countdown]").attr("data-'.$type.'-countdown","'.$countdown.'");';
		echo 'parent.doCountdown("'.$type.'");';  //인증시간 카운트 다운
		echo 'parent.$("[data-act=send_code]").prop("disabled",false);';
		echo 'parent.$("[data-act=send_code] .not-loading").text("재발송");';
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
				echo 'parent.$("#page-join-code").loader("hide");';  //로더 숨기기
				echo 'parent.$("[name=confirm_email_code]").addClass("is-invalid").focus();';
				echo 'parent.$("[data-role=emailCodeBlock]").text("인증번호를 확인해 주세요");';
				echo '</script>';
				exit();
			} else {
				echo '<script type="text/javascript">';
				echo 'parent.$("[name=confirm_email_code]").addClass("is-invalid").focus();';
				echo 'parent.$("[data-role=emailCodeBlock]").text("인증번호를 확인해 주세요");';
				echo 'parent.$("#pane-email").find("[data-act=confirm_code]").prop("disabled",false);';
				echo '</script>';
				exit();
			}
		}

		$_SESSION['JOIN']['email']	= $R['email']; // 이메일 세션저장

	}

	if ($type=='phone') {

		// 코드 검사
		if ($code != $R['code']) {
			if ($device=='mobile') {
				echo '<script type="text/javascript">';
				echo 'parent.$("#page-join-code").loader("hide");';  //로더 숨기기
				echo 'parent.$("[name=confirm_phone_code]").addClass("is-invalid").focus();';
				echo 'parent.$("[data-role=phoneCodeBlock]").text("인증번호를 확인해 주세요");';
				echo '</script>';
				exit();
			} else {
				echo '<script type="text/javascript">';
				echo 'parent.$("[name=confirm_phone_code]").addClass("is-invalid").focus();';
				echo 'parent.$("[data-role=phoneCodeBlock]").text("인증번호를 확인해 주세요");';
				echo 'parent.$("#pane-phone").find("[data-act=confirm_code]").prop("disabled",false);';
				echo '</script>';
				exit();
			}
		}
		$_SESSION['JOIN']['phone']	= $R['phone']; // 휴대폰 세션저장
	}

	getDbUpdate($table['s_guestauth'],'auth=1','code='.$R['code']);  // 인증완료상태 처리
	setrawcookie('site_login_result', rawurlencode('인증번호가 확인 되었습니다.|success'));  // 알림처리를 위한 로그인 상태 cookie 저장
	getLink('reload','parent.','','');
}

exit();

?>
