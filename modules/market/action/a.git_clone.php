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

if ($visibility=='private') {
	$git = 'https://'.$token.'@github.com/'.$owner.'/'.$repo.'.git';
} else {
	$git = 'https://github.com/'.$owner.'/'.$repo.'.git';
}

$command	= 'cd '.$path.' && git clone '.$git.' '.$folder;

exec($command,$command_output,$command_return);

if ($command_return != 0) {
	$result['error']=$command.'실패 했습니다.';
}

echo json_encode($result);
exit;

?>
