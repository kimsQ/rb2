<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$result=array();
$result['error']=false;



if(!$uid) {
	$result['error']='잘못된 접근 입니다.';
	echo json_encode($result);
	exit;
}

include $g['path_module'].$m.'/var/var.php';
$g['marketvar'] = $g['path_var'].'/market.var.php';
if (file_exists($g['marketvar'])) include_once $g['marketvar'];

if ($d['market']['url']) {
	include $g['path_core'].'function/rss.func.php';

	$returnData = getUrlData($d['market']['url'].'&iframe=Y&page=client.delete_install&uid='.$uid.'&id='.$d['market']['userid'].'&key='.$d['market']['key'].'&version=2&host='.$_SERVER['HTTP_HOST'],10);

	$pathData = explode('[PATH:',$returnData);
	$pathData = explode(':PATH]',$pathData[1]);
	$path = $pathData[0];

	$returnData = explode('[RESULT:',$returnData);
	$returnData = explode(':RESULT]',$returnData[1]);
	$return = $returnData[0];

} else {
	$result['error']='마켓 접속정보를 확인해주세요.';
	echo json_encode($result);
	exit;
}

if ($return != 'OK') {
	$result['error']=' 다시 시도해주세요.'.$return;
} else {

	// 폴더삭제
	$command_delete	= 'rm -rf '.$path;
	shell_exec($command_delete.'; echo $?');

}

echo json_encode($result);
exit;

?>
