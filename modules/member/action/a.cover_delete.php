<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) getLink('','','정상적인 접근이 아닙니다.','');

//원본삭제
if (is_file($g['path_file'].'cover/'.$my['cover']))
{
	unlink($g['path_file'].'cover/'.$my['cover']);
}

getDbUpdate($table['s_mbrdata'],"cover=''",'memberuid='.$my['uid']);

setrawcookie('member_settings_result', rawurlencode('커버 이미지가 삭제되었습니다..|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
