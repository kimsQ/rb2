<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$result=array();
$result['error']=false;

if(!is_dir($path)) {
	$result['error']=$path.' 추가할 경로를 확인해주세요.';
	echo json_encode($result);
	exit;
}

if(is_dir($path.'/'.$folder)) {
  $result['error']='이미 추가되어 있습니다.';
	echo json_encode($result);
	exit;
}

include $g['path_module'].$m.'/var/var.php';
$g['marketvar'] = $g['path_var'].'/market.var.php';
if (file_exists($g['marketvar'])) include_once $g['marketvar'];

if ($d['market']['url']) {
	include $g['path_core'].'function/rss.func.php';
	$repoData = getUrlData($d['market']['url'].'&iframe=Y&page=client.check_clone&_clientu='.$g['s'].'&_clientr='.$r.'&goods='.$goods.'&id='.$d['market']['userid'].'&key='.$d['market']['key'].'&version=2&host='.$_SERVER['HTTP_HOST'].'&ip='.$_SERVER['REMOTE_ADDR'],10);

	$ownerData = explode('[OWNER:',$repoData);
	$ownerData = explode(':OWNER]',$ownerData[1]);
	$owner = $ownerData[0];

	$nameData = explode('[NAME:',$repoData);
	$nameData = explode(':NAME]',$nameData[1]);
	$name = $nameData[0];

	$tokenData = explode('[TOKEN:',$repoData);
	$tokenData = explode(':TOKEN]',$tokenData[1]);
	$token = $tokenData[0];

} else {
	$result['error']='마켓 접속정보를 확인해주세요.';
	echo json_encode($result);
	exit;
}

if ($token) {
	$git = 'https://'.$token.'@github.com/'.$owner.'/'.$name.'.git';
} else {
	$git = 'https://github.com/'.$owner.'/'.$name.'.git';
}

$command	= 'cd '.$path.' && git clone '.$git.' '.$folder;

exec($command,$command_output,$command_return);

if ($command_return != 0) {
	$result['error']=$command.' 실패 했습니다.';
}

// 모듈일 경우 DB테이블 생성
if ($path=='modules') {

	$module		= $folder;
	$_tmptable2 = $table;
	$table		= array();
	$table_db	= $g['path_module'].$module.'/_setting/db.table.php';
	$table_sc	= $g['path_module'].$module.'/_setting/db.schema.php';
	if(is_file($table_db)) {
		$_tmptable1 = array();
		$_tmptfile  = $g['path_var'].'table.info.php';
		include $table_db;
		include $table_sc;

		$_tmptable1 = $table;
		rename($table_db,$table_db.'.done');

		$fp = fopen($_tmptfile,'w');
		fwrite($fp, "<?php\n");
		foreach($_tmptable2 as $key => $val) fwrite($fp, "\$table['$key'] = \"$val\";\n");
		foreach($_tmptable1 as $key => $val) fwrite($fp, "\$table['$key'] = \"$val\";\n");
		fwrite($fp, "?>");
		fclose($fp);
		@chmod($_tmptfile,0707);
	}
	else {
		if(is_file($table_db.'.done')) include $table_db.'.done';
	}

	$maxgid = getDbCnt($_tmptable2['s_module'],'max(gid)','');

	$QKEY = "gid,system,hidden,mobile,name,id,tblnum,icon,d_regis";
	$QVAL = "'".($maxgid+1)."','0','0','1','".getFolderName($g['path_module'].$module)."','$module','".count($table)."','kf-module','".$date['totime']."'";

	getDbInsert($_tmptable2['s_module'],$QKEY,$QVAL);
	setrawcookie('market_action_result', rawurlencode('모듈이 설치 되었습니다.'));
}

echo json_encode($result);
exit;

?>
