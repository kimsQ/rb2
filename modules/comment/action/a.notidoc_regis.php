<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$fdset = array('noti_title','noti_body','noti_button');
$gfile= $g['dir_module'].'var/noti/'.$type.'.php';  // 알림메시지 양식

$fp = fopen($gfile,'w');
fwrite($fp, "<?php\n");
fwrite($fp, "\$d['comment']['noti_title'] = \"".$noti_title."\";\n");
fwrite($fp, "\$d['comment']['noti_body'] = \"".$noti_body."\";\n");
fwrite($fp, "\$d['comment']['noti_button'] = \"".$noti_button."\";\n");
fwrite($fp, "?>");
fclose($fp);
@chmod($gfile,0707);

setrawcookie('notidoc_result', rawurlencode('수정 되었습니다.|success'));
getLink('reload','parent.','','');
?>
