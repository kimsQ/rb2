<?php
if(!defined('__KIMS__')) exit;

if ($my['uid'])
{
	getDbUpdate($table['s_mbrdata'],"now_log=0,sns=''",'memberuid='.$my['uid']);
	$_SESSION['mbr_logout'] = '1';
	unset($_SESSION['mbr_uid']);
	unset($_SESSION['SL']); //소셜로그인  세션 삭제
	setAccessToken($my['uid'],'logout'); // 토큰 데이타 삭제 및 쿠키 초기화
}

$referer = $referer ? urldecode($referer) : $_SERVER['HTTP_REFERER'];
$referer = explode('&_admpnl_',$referer);
$referer = $referer[0];

setrawcookie('site_common_result', rawurlencode('로그아웃 되었습니다.'));  // 처리여부 cookie 저장
getLink($referer,'top.','','');
?>
