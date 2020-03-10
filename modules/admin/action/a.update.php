<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$mbruid	= $my['uid'];
$command_reset	= 'git reset --hard';
$command_pull	= 'git pull origin master';
$d_regis	= $date['totime'];
$version = $current_version.'->'.$lastest_version;

$output_reset = shell_exec($command_reset.'; echo $?');
$output_pull = shell_exec($command_pull.'; echo $?');
$command	= $command_reset.' '.$command_pull;

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $msg_type = 'default';
} else {
  $msg_type = 'success';
}

if(strpos($output_pull, 'Already up-to-date.') !== false) {
  $msg = '이미 최신버전 입니다.|'.$msg_type;
} else {
  getDbInsert($table['s_gitlog'],'mbruid,remote,command,version,output,d_regis',"'$mbruid','$remote','$command','$version','$output_pull','$d_regis'");
  $msg = '업데이트가 완료-브라우저 재시작 필요|'.$msg_type;
}
$_SESSION['current_version'] = $lastest_version;
setrawcookie('system_update_result', rawurlencode($msg));  // 알림처리를 위한 로그인 상태 cookie 저장
getLink('reload','parent.','','');
?>
