<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

include $g['path_core'].'function/rss.func.php';
include $g['path_module'].$m.'/var/var.php';
$g['marketvar'] = $g['path_var'].'/market.var.php';
if (file_exists($g['marketvar'])) include_once $g['marketvar'];

$result=array();
$result['error']=false;

if(!$uid) {
	$result['error']='잘못된 접근 입니다.';
	echo json_encode($result);
	exit;
}

if ($d['market']['url']) {
	$returnData = getUrlData($d['market']['url'].'&iframe=Y&page=_client.getGoods&uid='.$uid.'&id='.$d['market']['userid'].'&key='.$d['market']['key'].'&version=2&host='.$_SERVER['HTTP_HOST'],10);

	$remoteData = explode('[REMOTE:',$returnData);
	$remoteData = explode(':REMOTE]',$remoteData[1]);
	$remote = $remoteData[0];

	$privateData = explode('[PRIVATE:',$returnData);
	$privateData = explode(':PRIVATE]',$privateData[1]);
	$private = $privateData[0];

	$tokenData = explode('[TOKEN:',$returnData);
	$tokenData = explode(':TOKEN]',$tokenData[1]);
	$token = $tokenData[0];

	if ($remote) {
		// code..


		.
	} else {
		// code...
	}



} else {
	$result['error']='마켓 접속정보를 확인해주세요.';
	echo json_encode($result);
	exit;
}





//git 업데이트
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


	$returnData = getUrlData($d['market']['url'].'&iframe=Y&page=_client.update&uid='.$uid.'&id='.$d['market']['userid'].'&key='.$d['market']['key'].'&version=2&host='.$_SERVER['HTTP_HOST'],10);
	$returnData = explode('[RESULT:',$returnData);
	$returnData = explode(':RESULT]',$returnData[1]);
	$return = $returnData[0];

	if ($return != 'OK') {
		$result['error']=' 다시 시도해주세요.'.$return;
	} else {
		setrawcookie('market_action_result', rawurlencode($msg));
	}

}

echo json_encode($result);
exit;

?>
