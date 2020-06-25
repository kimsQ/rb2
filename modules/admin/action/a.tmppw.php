<?php
if(!defined('__KIMS__')) exit;

if ($_SESSION['_pwemail_'] > 2) exit;
$_SESSION['_pwemail_'] = $_SESSION['_pwemail_'] + 1;

include $g['path_core'].'function/email.func.php';

$tmpPw = rand(0,999999);
$content = '<h4>'.$tmpPw.'</h4><br><b>임시 패스워드로 로그인 하신 후 반드시 패스워드를 변경해 주세요.</b>';

$firstadmin = getDbData($table['s_mbrdata'],'memberuid=1','name,email,d_regis');
$tmpUpdate = getDbUpdate($table['s_mbrdata'],"tmpcode='".password_hash($tmpPw, PASSWORD_DEFAULT)."'",'memberuid=1');

$to = $firstadmin['email'].'|'.$firstadmin['name'];
$from = $d['admin']['sysmail'];

$result = getSendMail($to,$from,'['.$_HS['name'].'] 요청하신 임시 패스워드입니다.',$content,'HTML');

if ($result)
{
	getLink('reload','parent.',$firstadmin['email'].'로 임시 패스워드가 전송 되었습니다.','');
}
else {
	getLink('','','이메일이 전송되지 못했습니다.','');
}
?>
