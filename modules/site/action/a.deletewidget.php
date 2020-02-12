<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$pwd = trim($pwd);

if (!$pwd || !strstr(substr($pwd,0,10),'widget')) exit;

include $g['path_core'].'function/dir.func.php';
DirDelete($pwd);

$newPwd = str_replace('/'.basename($pwd).'/','/',$pwd);
getLink($g['s'].'/?r='.$r.'&system=popup.widget&iframe=Y&isWcode=Y&pwd='.urlencode($newPwd),'parent.','','');
?>