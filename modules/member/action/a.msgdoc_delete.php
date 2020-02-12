<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

unlink($g['dir_module'].'doc/'.$doc.'/'.$type.'.txt');

setrawcookie('msgdoc_result', rawurlencode('삭제 되었습니다.|success'));
getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=msgdoc&doc='.$doc,'parent.','','');
?>
