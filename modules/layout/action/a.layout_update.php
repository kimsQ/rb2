<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$mbruid	= $my['uid'];

$command_reset	= 'cd '.$g['path_layout'].$layout.' && git reset --hard';
$command_pull	= 'cd '.$g['path_layout'].$layout.' && git pull origin master';
$d_regis	= $date['totime'];
$version = $current_version.'->'.$lastest_version;
$output_pull;
$return_pull;

shell_exec($command_reset.'; echo $?');
$output_pull = shell_exec($command_pull.'; echo $?');

$command	= $command_reset.' '.$command_pull;

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $msg_type = 'default';
} else {
  $msg_type = 'success';
}

// 임시-필드 없는 경우, 생성
$_tmp1 = db_query("SHOW COLUMNS FROM ".$table['s_gitlog']." WHERE `Field` = 'module'",$DB_CONNECT);
if(!db_num_rows($_tmp1)) {
	$_tmp1 = ("alter table ".$table['s_gitlog']." ADD module VARCHAR(30) DEFAULT '' NOT NULL");
	db_query($_tmp1, $DB_CONNECT);
}
$_tmp2 = db_query("SHOW COLUMNS FROM ".$table['s_gitlog']." WHERE `Field` = 'target'",$DB_CONNECT);
if(!db_num_rows($_tmp2)) {
	$_tmp2 = ("alter table ".$table['s_gitlog']." ADD target VARCHAR(100) DEFAULT '' NOT NULL");
	db_query($_tmp2, $DB_CONNECT);
}

if(strpos($output_pull, 'Already up-to-date.') !== false) {
  $msg = '이미 최신버전 입니다.|'.$msg_type;
} else {

  $module = $m;
  $target = $layout;
  getDbInsert($table['s_gitlog'],'module,target,mbruid,remote,command,version,output,d_regis',"'$module','$target','$mbruid','$remote','$command','$version','$output_pull','$d_regis'");
  $msg = '업데이트가 완료-브라우저 재시작 필요|'.$msg_type;
}
$_SESSION['current_version'] = $lastest_version;
setrawcookie('layout_action_result', rawurlencode($msg));  // 알림처리를 위한 로그인 상태 cookie 저장
getLink('reload','parent.','','');
?>
