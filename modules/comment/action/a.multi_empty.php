<?php
if(!defined('__KIMS__')) exit;


checkAdmin(0);

$referer = $g['s'].'/?r='.$r.'&iframe=Y&m=admin&module='.$m.'&front=movecopy&type='.$type;
$_SESSION['BbsPost'.$type] = '';

getLink($referer,'parent.','','');
?>