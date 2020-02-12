<?php
if(!defined('__KIMS__')) exit;

if(!strpos('_score1,score2',$f)) exit;
$R = getUidData($table[$m.'data'],$uid);
if (!$R['uid']) exit;
getDbUpdate($table[$m.'data'],$f.'='.$f.'+1','uid='.$R['uid']);
exit;
?>