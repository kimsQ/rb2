<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) {
	getLink('reload','parent.','정상적인 접근이 아닙니다.','');
}

if (!$pw1 || !$pw2) {
	echo '<script type="text/javascript">';
	echo 'parent.$("#page-settings-pw").find("[data-act=changePW]").attr("disabled",false);';
	echo 'setTimeout(function() {parent.$.notify({message: "정상적인 접근이 아닙니다."},{type: "default"});}, 300);'; // 알림메시지 출력
	echo '</script>';
	exit();
}

// if (getCrypt($pw,$my['d_regis']) != $my['pw'] && $my['tmpcode'] != getCrypt($pw,$my['d_regis'])) {
// 	getLink('','','현재 패스워드가 일치하지 않습니다.','');
// }
//
// if ($pw == $pw1) {
// 	getLink('','','현재 패스워드와 변경할 패스워드가 같습니다.','');
// }

getDbUpdate($table['s_mbrid'],"pw='".password_hash($pw1, PASSWORD_DEFAULT)."'",'uid='.$my['uid']);
getDbUpdate($table['s_mbrdata'],"last_pw='".$date['today']."',tmpcode=''",'memberuid='.$my['uid']);

$_SESSION['mbr_pw'] =  password_hash($pw1, PASSWORD_DEFAULT);

echo '<script type="text/javascript">';
echo 'parent.$("#page-settings-pw").find("[data-act=changePW]").attr("disabled",false);';
echo 'parent.history.back();';
echo 'setTimeout(function() {parent.$.notify({message: "비밀번호가 변경되었습니다."},{type: "default"});}, 500);'; // 알림메시지 출력
echo '</script>';

exit();

?>
