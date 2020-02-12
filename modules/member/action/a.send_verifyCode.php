<?php
if(!defined('__KIMS__')) exit;

$value		= trim($value);

if (!$value) getLink('','','정상적인 접근이 아닙니다.','');

$g['memberVarForSite'] = $g['path_var'].'site/'.$r.'/member.var.php';
$_tmpvfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['path_module'].$module.'/var/var.php';
include_once $_tmpvfile;

$verify_code = date('His');

if ($type=='email') {
	if (!$d['member']['join_email'])
	{
		getLink('','','죄송합니다. 대표 이메일이 등록되지 않았습니다. 관리자에게 문의해 주세요.','');
	}

	$M = getDbData($table['s_mbrdata'],"email='".$value."'",'*');
	if (!$M['email'])
	{
		getLink('','','등록된 이메일이 아닙니다.','');
	}
	$R = getUidData($table['s_mbrid'],$M['memberuid']);



	include_once $g['path_core'].'function/email.func.php';
	$content = implode('',file($g['dir_module'].'doc/_verify.txt'));
	$content = str_replace('{NAME}',$M['name'],$content);
	$content = str_replace('{NICK}',$M['nic'],$content);
	$content = str_replace('{ID}',$R['id'],$content);
	$content = str_replace('{EMAIL}',$M['email'],$content);
	$content.= '<p>인증번호  : '.$verify_code.'</p>';
	$content.= implode('',file($g['dir_module'].'doc/_sign.txt'));

	$result = getSendMail($M['email'].'|'.$M['name'], $d['member']['join_email'].'|'.$_HS['name'], '['.$_HS['name'].'] 본인확인용 인증코드가 발급되었습니다.', $content, 'HTML');

	if (!$result)
	{
		getLink('','','죄송합니다. 이메일서버가 응답하지 않아 이메일을 보내드리지 못했습니다.','');
	}

}



// 인증코드 저장
// getDbUpdate($table['s_mbrdata'],"last_pw='".$date['today']."',tmpcode='".getCrypt($auth_pw,$M['d_regis'])."'",'memberuid='.$my['uid']);

echo '<script type="text/javascript">';
echo 'parent.$("#verify_email_area").removeClass("d-none");';
echo 'parent.$("#send_verifyCode").attr("disabled",false);';
echo 'parent.$("[name=email_code]").focus();';
echo '</script>';

exit();

?>
