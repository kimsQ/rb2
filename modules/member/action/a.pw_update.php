<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid'])
{
	getLink('','','정상적인 접근이 아닙니다.','');
}

if (!$pw || !$pw1 || !$pw2)
{
	getLink('','','정상적인 접근이 아닙니다.','');
}

if (getCrypt($pw,$my['d_regis']) != $my['pw'] && $my['tmpcode'] != getCrypt($pw,$my['d_regis']))
{
	getLink('','','현재 패스워드가 일치하지 않습니다.','');
}

if ($pw == $pw1)
{
	getLink('','','현재 패스워드와 변경할 패스워드가 같습니다.','');	
}

//getDbUpdate($table['s_mbrid'],"pw='".md5($pw1)."'",'uid='.$my['uid']); 비번암호방식 변경
getDbUpdate($table['s_mbrid'],"pw='".getCrypt($pw1,$my['d_regis'])."'",'uid='.$my['uid']);
getDbUpdate($table['s_mbrdata'],"last_pw='".$date['today']."',tmpcode=''",'memberuid='.$my['uid']);

$_SESSION['mbr_pw'] =  getCrypt($pw1,$my['d_regis']);

getLink('reload','parent.','변경되었습니다.','');

?>