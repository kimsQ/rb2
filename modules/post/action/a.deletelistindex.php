<?php

if(!defined('__KIMS__')) exit;

if (!$my['uid']) getLink('','','정상적인 접근이 아닙니다.','');

$LIST = getDbData($table[$m.'list'],"id='".$listid."'",'*');
if (!$LIST['uid']) getLink('','','삭제되었거나 존재하지 않는 리스트 입니다.','');
if ($my['uid']!=$LIST['mbruid']) getLink('','','정상적인 접근이 아닙니다.','');

$R = getUidData($table[$m.'data'],$uid);
if (!$R['uid']) getLink('','','삭제되었거나 존재하지 않는 포스트 입니다.','');

getDbDelete($table[$m.'list_index'],'list='.$LIST['uid'].' and data='.$R['uid']);//인덱스삭제
getDbUpdate($table[$m.'list'],'num=num-1','uid='.$LIST['uid']);  // 리스트 포스트수 조정

getLink('reload'.$parent,'parent.','','');
?>
