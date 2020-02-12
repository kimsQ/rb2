<?php
if(!defined('__KIMS__')) exit;

$_SESSION['pcmode'] = '';

getLink($referer ? urldecode($referer) : $_SERVER['HTTP_REFERER'],'','','');
?>