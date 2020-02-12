<?php
if(!defined('__KIMS__')) exit;

if ($check) $_SESSION[$name] = $_SESSION[$name] ? '' : $value;
else $_SESSION[$name] = $value;

if ($target)
{
	getLink('reload',$target,'','');
}
exit;
?>