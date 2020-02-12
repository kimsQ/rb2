<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid']) echo '[RESULT:로그인해 주세요.:RESULT]';

$R = getUidData($table['s_oneline'],$uid);
if (!$R['uid']) echo '[RESULT:존재하지 않는 한줄 의견입니다.:RESULT]';

if (!strstr($_SESSION['module_comment_osingo'],'['.$R['uid'].']'))
{
	getDbUpdate($table['s_oneline'],'report=report+1','uid='.$R['uid']);
	$_SESSION['module_comment_osingo'] .= '['.$R['uid'].']';
	echo '[RESULT:신고처리 되었습니다.:RESULT]';
}
else {
	echo '[RESULT:이미 신고하신 한줄의견입니다.:RESULT]';
}
exit;
?>