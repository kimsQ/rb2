<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$isModule	= '';
$isUpload	= false;
$extPath	= $g['path_tmp'].'app';
$extPath1	= $extPath.'/';

if ($remote == 'Y')
{

	$saveFile	= $extPath.'/rb_module_app.zip';

	if (is_file($saveFile))
	{
		if (is_file($folder.$insfolder.'/main.php'))
		{
			unlink($saveFile);
			getLink('','','이미 동일한 아이디('.basename($insfolder).')의 모듈이 존재합니다.','');
		}
		require $g['path_core'].'opensrc/unzip/ArchiveExtractor.class.php';
		require $g['path_core'].'function/dir.func.php';
		
		$extractor = new ArchiveExtractor();
		$extractor -> extractArchive($saveFile,$extPath1);
		unlink($saveFile);

		$opendir = opendir($extPath1);
		while(false !== ($file = readdir($opendir)))
		{	
			if($file != '.' && $file != '..' && is_file($extPath1.$file.'/main.php'))
			{
				if(is_file($g['path_module'].$file.'/main.php'))
				{
					$isModule = $file;
					break;
				}
				
				mkdir($g['path_module'].$file,0707);
				@chmod($g['path_module'].$file,0707);
				DirCopy($extPath1.$file,$g['path_module'].$file);				
				$isUpload = true;
				break;
			}
		}
		closedir($opendir);

		DirDelete($extPath);
		mkdir($extPath,0707);
		@chmod($extPath,0707);
		
		if ($isModule)
		{
			getLink('','','이미 동일한 아이디('.$isModule.')의 모듈이 존재합니다.','');
		}
		if (!$isUpload)
		{
			getLink('','','패키지규격에 맞지 않는 파일입니다','');		
		}

		getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=pack&type=module','parent.','모듈설치 대기리스트에 등록되었습니다.','');
	}
	getLink('','','','');
}
else {

	$tmpname	= $_FILES['upfile']['tmp_name'];
	$realname	= $_FILES['upfile']['name'];
	$fileExt	= strtolower(getExt($realname));
	$saveFile	= $extPath1.$date['totime'].'.zip';

	if (is_uploaded_file($tmpname))
	{
		if (substr($realname,0,10) != 'rb_module_')
		{
			getLink('','','모듈 패키지가 아닙니다.','');
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

		$opendir = opendir($extPath1);
		while(false !== ($file = readdir($opendir)))
		{	
			if($file != '.' && $file != '..' && is_file($extPath1.$file.'/main.php'))
			{
				if(is_file($g['path_module'].$file.'/main.php'))
				{
					$isModule = $file;
					break;
				}
				
				mkdir($g['path_module'].$file,0707);
				@chmod($g['path_module'].$file,0707);
				DirCopy($extPath1.$file,$g['path_module'].$file);				
				$isUpload = true;
				break;
			}
		}
		closedir($opendir);

		DirDelete($extPath);
		mkdir($extPath,0707);
		@chmod($extPath,0707);
		
		if ($isModule)
		{
			getLink('','','이미 동일한 아이디('.$isModule.')의 모듈이 존재합니다.','');
		}
		if (!$isUpload)
		{
			getLink('','','패키지규격에 맞지 않는 파일입니다','');		
		}
	}

	getLink('reload','parent.','','');
}
?>