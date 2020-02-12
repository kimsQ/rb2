<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid'])
{
	getLink('','','정상적인 접근이 아닙니다.','');
}

$memberuid	= $my['admin'] && $memberuid ? $memberuid : $my['uid'];
$mailing	= $remail;

$_QVAL.= "mailing='$mailing'";
getDbUpdate($table['s_mbrdata'],$_QVAL,'memberuid='.$memberuid);

getLink('/join/customize','parent.','','');
?>
