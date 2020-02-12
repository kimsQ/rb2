<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

include $g['path_core'].'function/sms.func.php';

$content = '['.$_HS['name'].'] SMS 전송 테스트입니다.';
$result = getSendSMS($testsms,$chk_sms,'',$content,'sms');

if ($result == 'OK') {
  getLink('reload','parent.','SMS가 전송 되었습니다. 확인해 보세요.','');
} else {
  getLink('reload','parent.',$result,'');
}
?>
