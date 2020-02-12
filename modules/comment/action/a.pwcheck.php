<?php
if(!defined('__KIMS__')) exit;

if (!$pw) getLink('','','비밀번호를 입력해 주세요.','');
$R = getUidData($table[$m.'data'],$uid);
if (!$R['uid']) getLink('reload','parent.','존재하지 않거나 삭제된 글입니다.','');

if (md5($pw) != $R['pw']) getLink('reload','parent.','비밀번호가 일치하지 않습니다.','');


$_SESSION['module_'.$m.'_pwcheck'] .= '['.$R['uid'].']';

getLink('reload','parent.','','');
?>