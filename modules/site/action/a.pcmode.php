<?php
if(!defined('__KIMS__')) exit;

$_SESSION['pcmode'] = 'Y';

getLink($referer ? urldecode($referer) : ($_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:$g['s'].'/?r='.$r.'&m=admin'),'','','');
?>