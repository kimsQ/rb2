<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
getLink('','','죄송합니다. 이 기능은 현재 지원하지 않습니다.','');

require $g['path_core'].'function/dir.func.php';

$_upath = str_replace('./','',$extension_path);
$_ufile = $extension_path.'update/'.$ufile.'.txt';
$_ufileexp = explode('.',$ufile);

if ($type == 'delete')
{
	unlink($_ufile);
	//여기에 실제 테마 삭제처리
	DirDelete($extension_path.'themes/'.$_ufileexp[0]);
	getLink('reload','parent.','테마가 제거되었습니다.','');
}
else if ($type == 'download')
{
	//여기에 다운로드 처리
	getLink('','','다운로드 처리','');
}
else {
	require $g['path_core'].'opensrc/unzip/ArchiveExtractor.class.php';
	include $g['path_core'].'function/rss.func.php';
	include $g['path_module'].'market/var/var.php';
	$_serverinfo = explode('/',$d['update']['url']);
	$_updatedate = getUrlData('http://'.$_serverinfo[2].'/__update/market/'.$_upath.'theme.txt',10);
	$_updatelist = explode("\n",$_updatedate);
	$_updateleng = count($_updatelist)-1;
	$_includeup = false;
	for($i=$_updateleng;$i>=0;$i--)
	{
		$_upx = explode(',',trim($_updatelist[$i]));
		if ($_upx[5]==$_ufileexp[1])
		{
			$_includeup = true;
			break;
		}
	}
	if(!$_includeup) getLink('','','테마가 존재하지 않습니다.','');
	$_updatefile = getUrlData('http://'.$_serverinfo[2].'/__update/market/'.$_upath.$_ufileexp[1].'.zip',10);
	$folder		= './';
	$extPath  = $g['path_tmp'].'app';
	$extPath1 = $extPath.'/';
	$saveFile = $extPath1.'rb_update_app.zip';

	$fp = fopen($saveFile,'w');
	fwrite($fp,$_updatefile);
	fclose($fp);
	@chmod($saveFile,0707);

	$extractor = new ArchiveExtractor();
	$extractor -> extractArchive($saveFile,$extPath1);
	unlink($saveFile);

	$_updateFile = $extPath1.'/_update.php';
	if (is_file($_updateFile))
	{
		include $_updateFile;
		unlink($_updateFile);
	}

	DirCopy($extPath1,$folder);
	DirDelete($extPath);
	mkdir($extPath,0707);
	@chmod($extPath,0707);



	// 테스트용
	mkdir($extension_path.'themes',0707);
	@chmod($extension_path.'themes',0707);
	mkdir($extension_path.'themes/'.$_ufileexp[0],0707);
	@chmod($extension_path.'themes/'.$_ufileexp[0],0707);



	$fp = fopen($_ufile,'w');
	fwrite($fp,$date['today']);
	fclose($fp);
	@chmod($_ufile,0707);

	getLink('reload','parent.','테마가 설치되었습니다.','');
}
?>
