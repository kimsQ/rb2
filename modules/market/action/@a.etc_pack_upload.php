<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$folder		= './';
$tmpname	= $_FILES['upfile']['tmp_name'];
$realname	= $_FILES['upfile']['name'];
$fileExt	= strtolower(getExt($realname));
$extPath	= $g['path_tmp'].'app';
$extPath1	= $extPath.'/';
$saveFile	= $extPath1.$date['totime'].'.zip';

if (is_uploaded_file($tmpname))
{
	if (substr($realname,0,7) != 'rb_etc_')
	{
		getLink('','','기타자료 패키지가 아닙니다.','');
	}
	if ($fileExt != 'zip')
	{
		getLink('','','패키지는 반드시 zip압축 포맷이어야 합니다.','');
	}

	move_uploaded_file($tmpname,$saveFile);

	require $g['path_core'].'opensrc/unzip/ArchiveExtractor.class.php';
	require $g['path_core'].'function/dir.func.php';
	
	$extractor = new ArchiveExtractor();
	$extractor -> extractArchive($saveFile,$extPath1);
	unlink($saveFile);
	DirCopy($extPath1,$folder);
	DirDelete($extPath);
	mkdir($extPath,0707);
	@chmod($extPath,0707);
}



getLink('reload','parent.','자료가 정상적으로 등록되었습니다.','');

?>