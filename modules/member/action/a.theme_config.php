<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$fp = fopen($g['dir_module'].'themes/'.$theme.'/_var/var.php','w');
fwrite($fp,trim(stripslashes($theme_var)));
fclose($fp);
@chmod($g['dir_module'].'themes/'.$theme.'/_var/var.php',0707);

setrawcookie('result_member_theme', rawurlencode('저장 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
