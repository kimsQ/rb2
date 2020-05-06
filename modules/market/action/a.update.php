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
	$returnData = getUrlData($d['market']['url'].'&iframe=Y&page=_client.gitinfo&uid='.$uid.'&id='.$d['market']['userid'].'&key='.$d['market']['key'].'&version=2&host='.$_SERVER['HTTP_HOST'],10);

	$ownerData = explode('[OWNER:',$returnData);
	$ownerData = explode(':OWNER]',$ownerData[1]);
	$owner = $ownerData[0];

	$nameData = explode('[NAME:',$returnData);
	$nameData = explode(':NAME]',$nameData[1]);
	$name = $nameData[0];

	$tokenData = explode('[TOKEN:',$returnData);
	$tokenData = explode(':TOKEN]',$tokenData[1]);
	$token = $tokenData[0];

	if ($owner && $name) {

		$dir = $path.'/'.$folder;

		if (!is_dir($dir)) {
			$result['error']='[에러] 경로를 확인해주세요.';
			echo json_encode($result);
			exit;
		}

		$command_reset	= 'cd '.$dir.' && git reset --hard';
		$command_pull	= 'cd '.$dir.' && git pull origin master';
		$d_regis	= $date['totime'];
		$version = $version_install.'->'.$version_goods;
		$output_pull;
		$return_pull;

		if ($token) {
			if (!$token) {
				$result['error']='[!TOKEN] 저장소연결에 실패했습니다.';
				echo json_encode($result);
				exit;
			}
			$remote = 'https://'.$token.'@github.com/'.$owner.'/'.$name.'.git';
			$command_remote	= 'cd '.$dir.' && git remote set-url origin '.$remote;
		} else {
			$remote = 'https://github.com/'.$owner.'/'.$name.'.git';
			$command_remote	= 'cd '.$dir.' && git remote set-url origin '.$remote;
		}

		// git 명령어 실행
		shell_exec($command_remote);
		shell_exec($command_reset);
		$output_pull = shell_exec($command_pull);

	} else {
		$result['error']='[!REMOTE] 저장소연결에 실패했습니다.';
		echo json_encode($result);
		exit;
	}

	//git 명령어 실행결과 log 저장
	$command	= $command_remote.' '.$command_reset.' '.$command_pull;
	$mbruid = $my['uid'];

	if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
	  $msg_type = 'default';
	} else {
	  $msg_type = 'success';
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

	if(strpos($output_pull, 'Already up-to-date.') !== false) {
		$output_pull = '변경사항이 없습니다.';
	}

	getDbInsert($table['s_gitlog'],'ext,target,mbruid,remote,command,version,output,d_regis',"'$path','$folder','$mbruid','$remote','$command','$version','$output_pull','$d_regis'");

	//마켓설치 정보 버전 및 갱신날짜 업데이트
	$returnData = getUrlData($d['market']['url'].'&iframe=Y&page=_client.update&uid='.$uid.'&id='.$d['market']['userid'].'&key='.$d['market']['key'].'&version=2&host='.$_SERVER['HTTP_HOST'],10);
	$returnData = explode('[RESULT:',$returnData);
	$returnData = explode(':RESULT]',$returnData[1]);
	$return = $returnData[0];

	if ($return != 'OK') {
		$result['error']=' 다시 시도해주세요.'.$return;
	} else {
		$msg = '업데이트 완료|'.$msg_type;
		setrawcookie('market_action_result', rawurlencode($msg));
	}

} else {
	$result['error']='마켓 접속정보를 확인해주세요.';
}

echo json_encode($result);
exit;
?>
