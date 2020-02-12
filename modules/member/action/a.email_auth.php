<?php
if(!defined('__KIMS__')) exit;

if (!$tmpuid || !$tmpcode)
{
	getLink($g['r'].'/','','정상적인 접근이 아닙니다.','');
}

$R = getDbData($table['s_mbrdata'],'memberuid='.$tmpuid." and d_regis='".$tmpcode."'",'*');

if (!$R['memberuid'] || $R['auth'] == 2)
{
	getLink(RW(0),'','잘못된 요청입니다.','');
}

if ($R['auth'] == 1)
{
	getLink(RW(0),'','이미 승인된 요청입니다. 로그인해 주세요.','');
}

if ($R['auth'] == 3)
{
	getDbUpdate($table['s_mbrdata'],'auth=1,verify_email='.$date['totime'],'memberuid='.$R['memberuid']);

	$d_regis	= $date['totime'];
	$_QVAL = "d_verified='$d_regis',d_code=''";
	getDbUpdate($table['s_mbremail'],$_QVAL,'mbruid='.$R['memberuid']);  // 이메일 본인확인 처리
}

$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php';
$_tmpvfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].$module.'/var/var.php';
include_once $_tmpvfile;
include_once $g['path_core'].'function/email.func.php';

if ($d['member']['join_email_send']&&$d['member']['join_email'])
{
	$M = getUidData($table['s_mbrid'],$R['memberuid']);
	$content = implode('',file($g['dir_module'].'doc/_join.txt'));
	$content = str_replace('{NAME}',$R['name'],$content);
	$content = str_replace('{NICK}',$R['nic'],$content);
	$content = str_replace('{ID}',$M['id'],$content);
	$content = str_replace('{EMAIL}',$R['email'],$content);

	getSendMail($R['email'].'|'.$R['name'], $d['member']['join_email'].'|'.$_HS['name'], '['.$_HS['name'].']회원가입을 축하드립니다.', $content, 'HTML');
}

getLink(RW(0),'','인증이 완료되었습니다. 로그인해 주세요.','');
?>
