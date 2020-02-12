<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

/* 알림을 보내는 방법 ************************************************************

- 다음의 함수를 실행합니다.
putNotice($rcvmember,$sendmodule,$sendmember,$message,$referer,$target);

$rcvmember	: 받는회원 UID
$sendmodule	: 보내는모듈 ID
$sendmember	: 보내는회원 UID (시스템으로 보낼경우 0)
$message	: 보내는 메세지 (관리자 및 허가된 사용자는 HTML태그 사용가능 / 일반 회원은 불가)
$referer	: 연결해줄 URL이 있을 경우 http:// 포함하여 지정
$target		: 연결할 URL의 링크 TARGET (새창으로 연결하려면 _blank)

********************************************************************************/

putNotice($my['uid'],$m,$my['uid'],'실시간 테스트 알림입니다. 관리자는 <code>html</code> 태그를 사용할 수 있습니다. 자세한 전송방법은 매뉴얼을 참고하세요.','','');

getLink('reload','parent.','','');
?>
