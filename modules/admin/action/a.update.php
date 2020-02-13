<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$mbruid	= $my['uid'];
$command1	= 'git reset --hard';
$command2	= 'git pull origin master';
$d_regis	= $date['totime'];
$version = $current_version.'->'.$lastest_version;

shell_exec($command1.'; echo $?');
$output = shell_exec($command2.'; echo $?');
$command	= $command1.'  '.$command2;

if(strpos($output, 'Already up-to-date.') !== false) {
  $msg = '이미 최신버전 입니다.|default';
} else {
  getDbInsert($table['s_gitlog'],'mbruid,remote,command,version,output,d_regis',"'$mbruid','$remote','$command','$version','$output','$d_regis'");
  $msg = '업데이트가 완료 되었습니다.|default';
}
$_SESSION['current_version'] = $lastest_version;
setrawcookie('system_update_result', rawurlencode($msg));  // 알림처리를 위한 로그인 상태 cookie 저장
getLink('reload','parent.','','');
?>
