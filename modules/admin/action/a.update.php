<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$ext = '';
$mbruid	= $my['uid'];
$command_reset	= 'git reset --hard';
$command_pull	= 'git pull origin master';
$d_regis	= $date['totime'];
$version = $current_version.'->'.$lastest_version;

$output_reset = shell_exec($command_reset);
$output_pull = shell_exec($command_pull.' 2>&1');
$command	= $command_reset.' '.$command_pull;

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $msg_type = 'default';
} else {
  $msg_type = 'success';
}

if(strpos($output_pull, 'Already up-to-date.') !== false) {
  $msg = '이미 최신버전 입니다.|'.$msg_type;
} else {

  if (strpos($output_pull, 'error') !== false) {
    $msg = '에러발생! 로그를 확인해주세요.|danger';
    $error = 1;
  } else {
    $msg = '실행완료! 브라우저 재시작해주세요.|success';
    $error = 0;
    getDbUpdate($table['s_gitlog'],'error=0','uid>0');
  }

  // 임시-필드 없는 경우, 생성
	$_tmp1 = db_query("SHOW COLUMNS FROM ".$table['s_gitlog']." WHERE `Field` = 'ext'",$DB_CONNECT);
	if(!db_num_rows($_tmp1)) {
		$_tmp1 = ("alter table ".$table['s_gitlog']." ADD ext VARCHAR(30) DEFAULT '' NOT NULL");
		db_query($_tmp1, $DB_CONNECT);
	}

	$_tmp2 = db_query("SHOW COLUMNS FROM ".$table['s_gitlog']." WHERE `Field` = 'target'",$DB_CONNECT);
	if(!db_num_rows($_tmp2)) {
		$_tmp2 = ("alter table ".$table['s_gitlog']." ADD target VARCHAR(100) DEFAULT '' NOT NULL");
		db_query($_tmp2, $DB_CONNECT);
	}

  $_tmp3 = db_query("SHOW COLUMNS FROM ".$table['s_gitlog']." WHERE `Field` = 'error'",$DB_CONNECT);
  if(!db_num_rows($_tmp3)) {
    $_tmp3 = ("alter table ".$table['s_gitlog']." ADD error TINYINT DEFAULT '0' NOT NULL");
    db_query($_tmp3, $DB_CONNECT);
  }

  getDbInsert($table['s_gitlog'],'error,ext,target,mbruid,remote,command,version,output,d_regis',"'$error','$ext','$target','$mbruid','$remote','$command','$version','$output_pull','$d_regis'");
}

$_SESSION['current_version'] = $lastest_version;
setrawcookie('system_update_result', rawurlencode($msg));
getLink('reload','parent.','','');
?>
