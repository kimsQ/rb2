<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if (!$to || !$from || !$content) {
	getLink('','','정상적인 접근이 아닙니다.','');
}

$M = getDbData($table['s_mbrdata'],"memberuid='".$to_mbruid."'",'*');

$subject = trim($subject);
$content = trim($content);
$content = str_replace('{SITE}',$_HS['name'],$content); //사이트명 치환
$content = str_replace('{NAME}',$M['name'],$content); //회원명 치환
$content = str_replace('{PHONE}',$to,$content); //휴대폰 번호 치환
$content = str_replace('{EMAIL}',$M['email'],$content); //이메일 주소 치환

include $g['path_core'].'function/sms.func.php';

$result = getSendSMS($to,$from,'',$content,'sms'); // $result 가 OK 면 성공 그렇지 않으면 실패 메시지 출력

if ($result == 'OK') {

	//발송이력 저장
	$d_regis = $date['totime'];
	$from_mbruid = $my['uid'];
	$_QKEY = "site,module,to_mbruid,to_phone,from_mbruid,from_tel,type,subject,content,upload,d_regis";
	$_QVAL = "'$r','$m','$to_mbruid','$to','$from_mbruid','$from',1,'$subject','$content','','$d_regis'";
	getDbInsert($table['s_sms'],$_QKEY,$_QVAL);

	setrawcookie('result_member_main', rawurlencode('SMS가 전송 되었습니다.|success'));  // 처리여부 cookie 저장
  getLink('reload','parent.','','');
} else {
  getLink('reload','parent.',$result,'');  //실패 메시지 출력
}

?>
