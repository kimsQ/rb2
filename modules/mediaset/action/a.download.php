<?php
if(!defined('__KIMS__')) exit;
$R=getUidData($table['s_upload'],$uid);
if (!$R['uid']) getLink('','','정상적인 요청이 아닙니다.','');
$filename = $R['name'];
$filetmpname = $R['tmpname'];

if ($R['host']) $filepath = $R['src'];
else $filepath = $R['folder'].'/'.$filetmpname;

$filesize = $R['size'];

if (!strstr($_SERVER['HTTP_REFERER'],'module='.$m) && !$my['admin']) {
	//동기화
	$syncArr = getArrayString($R['sync']);
	$fdexp = explode(',',$syncArr['data'][2]);
	if($fdexp[0]&&$fdexp[1]&&$syncArr['data'][3]) {
		$syncQue = $fdexp[1].'='.$fdexp[1].'+1';
		getDbUpdate($syncArr['data'][3],$syncQue,$fdexp[0].'='.$syncArr['data'][1]);
	}
	getDbUpdate($table['s_upload'],'down=down+1','uid='.$R['uid']);
	getDbUpdate($table['s_numinfo'],'download=download+1',"date='".$date['today']."' and site=".$s);
}

header("Content-Type: application/octet-stream");
header("Content-Length: " .$filesize);
header('Content-Disposition: attachment; filename="'.$filename.'"');
header("Cache-Control: private, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if ($R['fserver']) {

	$_filepath = $g['path_tmp'].'session/'.$filetmpname;
	$fp = fopen($_filepath, "rb");

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $filepath);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_FILE, $fp);
	$file = curl_exec($ch);
	if(!$file) {
	 echo "에러 :- ".curl_error($ch);
	}

	if (!fpassthru($fp)) fclose($fp);
	unlink($_filepath);

} else {

	$fp = fopen($filepath, 'rb');
	if (!fpassthru($fp)) fclose($fp);
}

exit;
?>
