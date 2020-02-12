<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) getLink('','','로그인해 주세요.','');

$m = 'project';
$_PROJECT = getDbData($table[$m.'list'],"id='".$project."'",'*');

if (!$_PROJECT['uid']) exit;

$_isStar = getDbRows($table[$m.'star'],'mbruid='.$my['uid'].' and project='.$_PROJECT['uid']);


if ($_isStar)
{
	getDbDelete($table[$m.'star'],'mbruid='.$my['uid'].' and project='.$_PROJECT['uid']);
	getDbUpdate($table[$m.'list'],'num_star=num_star-1','uid='.$_PROJECT['uid']);
}
else {
	$QKEY = 'mbruid,project,gid,d_regis';
	$QVAL = "".$my['uid'].",".$_PROJECT['uid'].",'',".$date['totime']."";
	getDbInsert($table[$m.'star'],$QKEY,$QVAL);
	getDbUpdate($table[$m.'list'],'num_star=num_star+1','uid='.$_PROJECT['uid']);
}

exit;
?>
