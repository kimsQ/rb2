<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

require $g['path_core'].'function/dir.func.php';
DirCopy('./_package/modules/'.$module,'./modules/'.$module);

getLink($g['s'].'/?r='.$r.'&m='.$m.'&a=module_setting&module='.$module,'','','');
?>