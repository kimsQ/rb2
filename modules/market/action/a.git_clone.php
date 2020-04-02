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

	$privateData = explode('[PRIVATE:',$repoData);
	$privateData = explode(':PRIVATE]',$privateData[1]);
	$private = $privateData[0];

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

if ($private) {
	$git = 'https://'.$token.'@github.com/'.$owner.'/'.$name.'.git';
} else {
	$git = 'https://github.com/'.$owner.'/'.$name.'.git';
}

$command	= 'cd '.$path.' && git clone '.$git.' '.$folder;

exec($command,$command_output,$command_return);

if ($command_return != 0) {
	$result['error']=$command.'실패 했습니다.';
}

echo json_encode($result);
exit;

?>
