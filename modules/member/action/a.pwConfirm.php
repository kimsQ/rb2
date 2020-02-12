<?php
if(!defined('__KIMS__')) exit;

$id	= trim($_POST['id']);
$pw	= trim($_POST['pw']);

if (!$id || !$pw) getLink('reload','parent.','패스워드를 입력해 주세요.','-1');

if (strpos($id,'@') && strpos($id,'.'))
{
	$M1 = getDbData($table['s_mbrdata'],"email='".$id."'",'*');
	$M	= getUidData($table['s_mbrid'],$M1['memberuid']);
}
else {
	$M = getDbData($table['s_mbrid'],"id='".$id."'",'*');
	$M1 = getDbData($table['s_mbrdata'],'memberuid='.$M['uid'],'*');
}

if (!$M['uid'] || $M1['auth'] == 4) {
	echo "<script>";
	echo "parent.$('".$form."').removeClass('was-validated');";
	echo "parent.$('".$form."').find('[type=submit]').prop('disabled', false);";
	echo "parent.$('".$form."').find('[data-role=idErrorBlock]').text('존재하지 않는 계정입니다.');";
	echo "parent.$('".$form."').find('[name=id]').focus().addClass('is-invalid');";
	echo "</script>";
	exit();
}
if ($M1['auth'] == 2) getLink('reload','parent.','회원님은 인증보류 상태입니다.','-1');
if ($M1['auth'] == 3) getLink('reload','parent.','회원님은 인증대기 상태입니다.','-1');
if ($M['pw'] != getCrypt($pw,$M1['d_regis']) && $M1['tmpcode'] != $pw) {
  echo "<script>";
	echo "parent.$('".$form."').removeClass('was-validated');";
	echo "parent.$('".$form."').find('[type=submit]').prop('disabled', false);";
	echo "parent.$('".$form."').find('[data-role=passwordErrorBlock]').text('패스워드가 일치하지 않습니다.');";
	echo "parent.$('".$form."').find('[name=pw]').val('').focus().addClass('is-invalid');";
	echo "</script>";
	exit();
}

getDbUpdate($table['s_mbrdata'],"tmpcode='',now_log=1,last_log='".$date['totime']."'",'memberuid='.$M['uid']);

setrawcookie('member_settings_result', rawurlencode('본인확인 되었습니다.'));  // 알림처리를 위한 로그인 상태 cookie 저장
getLink('reload','parent.','','');
?>
