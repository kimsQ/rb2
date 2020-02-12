<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) getLink('','','정상적인 접근이 아닙니다.','');

//원본삭제
if (is_file($g['path_file'].'avatar/'.$my['photo']))
{
	unlink($g['path_file'].'avatar/'.$my['photo']);
}

getDbUpdate($table['s_mbrdata'],"photo=''",'memberuid='.$my['uid']);

setrawcookie('member_settings_result', rawurlencode('이미지가 삭제되었습니다..|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
