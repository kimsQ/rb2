<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$mfile = $g['path_var'].'rbl.key.txt';
$fp = fopen($mfile,'w');
fwrite($fp,stripslashes($key));
fclose($fp);
@chmod($mfile,0707);

setrawcookie('admin_config_result', rawurlencode('라이센스 키가 변경 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
