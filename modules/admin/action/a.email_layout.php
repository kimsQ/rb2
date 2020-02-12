<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$_email_header = $g['path_module'].$m.'/var/email.header.txt';
$fp = fopen($_email_header,'w');
fwrite($fp, trim(stripslashes($email_header)));
fclose($fp);
@chmod($_email_header,0707);

$_email_footer = $g['path_module'].$m.'/var/email.footer.txt';
$fp = fopen($_email_footer,'w');
fwrite($fp, trim(stripslashes($email_footer)));
fclose($fp);
@chmod($_email_footer,0707);

setrawcookie('admin_config_result', rawurlencode('이메일 양식이 저장 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
