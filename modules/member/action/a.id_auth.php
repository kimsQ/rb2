<?php
if(!defined('__KIMS__')) exit;

$name		= trim($name);
$email		= trim($email);

if (!$name || !$email) getLink('','','정상적인 접근이 아닙니다.','');

$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php';
$_tmpvfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].$module.'/var/var.php';
include_once $_tmpvfile;

if (!$d['member']['join_email'])
{
	getLink('','','죄송합니다. 대표이메일이 등록되지 않았습니다. 관리자에게 문의해 주세요.','');
}

if ($d['member']['login_emailid'])
{
	$R = getDbData($table['s_mbrid'],"id='".$email."'",'*');
	if (!$R['uid'])
	{
		getLink('','','입력하신 정보로 일치하는 회원데이터가 없습니다.','');
	}
	$M = getDbData($table['s_mbrdata'],'memberuid='.$R['uid'],'*');
}
else {
	$M = getDbData($table['s_mbrdata'],"email='".$email."'",'*');
	if (!$M['email'])
	{
		getLink('','','입력하신 이메일 데이터가 없습니다.','');
	}
	$R = getUidData($table['s_mbrid'],$M['memberuid']);
}
//getLink('','',$name.'-'.$M['name'],'');
if ($M['name'] != $name)
{
	getLink('','','이름이 일치하지 않습니다.','');
}
if ($M['tmpcode'])
{
	getLink('','','이미 회원님의 이메일['.$M['email'].']로   \n임시 비밀번호를 발송해 드렸습니다.','');
}


$auth_pw = 'rb'.date('His');

include_once $g['path_core'].'function/email.func.php';
$content = implode('',file($g['dir_module'].'doc/_pw.txt'));
$content = str_replace('{NAME}',$M['name'],$content);
$content = str_replace('{NICK}',$M['nic'],$content);
$content = str_replace('{ID}',$R['id'],$content);
$content = str_replace('{EMAIL}',$M['email'],$content);
$content.= '<p>임시 비밀번호 : '.$auth_pw.'</p>';
$content.= implode('',file($g['dir_module'].'doc/_sign.txt'));

$result = getSendMail($M['email'].'|'.$M['name'], $d['member']['join_email'].'|'.$_HS['name'], '['.$_HS['name'].'] 임시 비밀번호가 발급되었습니다.', $content, 'HTML');

if (!$result)
{
	getLink('','','죄송합니다. 이메일서버가 응답하지 않아 이메일을 보내드리지 못했습니다.','');
}

getDbUpdate($table['s_mbrdata'],"last_pw='".$date['today']."',tmpcode='".password_hash($auth_pw,PASSWORD_DEFAULT)."'",'memberuid='.$M['memberuid']);

getLink('','','회원님의 이메일['.$M['email'].']로   \n임시 비밀번호를 발송해 드렸습니다.','');
?>
