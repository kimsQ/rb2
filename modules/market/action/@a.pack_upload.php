<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$isPack		= '';
$isUpload	= false;
$extPath	= $g['path_tmp'].'app';
$extPath1	= $extPath.'/';
$typeset	= array('layout'=>'레이아웃이','widget'=>'위젯이','switch'=>'스위치가','bbstheme'=>'게시판테마가');

if ($remote == 'Y')
{
	$saveFile	= $extPath.'/rb_'.$type.'_app.zip';

	if (is_file($saveFile))
	{
		if (!is_dir($folder.$subfolder))
		{
			unlink($saveFile);
			getLink('','','설치경로 정보가 맞지않아 설치가 중단되었습니다. 직접 다운로드 받아 설치하세요.','');			
		}
		if (is_file($folder.$insfolder.'/main.php'))
		{
			unlink($saveFile);
			getLink('','','이미 동일한 폴더명('.basename($insfolder).')의 패키지가 존재합니다.','');
		}

		require $g['path_core'].'opensrc/unzip/ArchiveExtractor.class.php';
		require $g['path_core'].'function/dir.func.php';
		
		$extractor = new ArchiveExtractor();
		$extractor -> extractArchive($saveFile,$extPath1);
		unlink($saveFile);

		$opendir = opendir($extPath1);
		while(false !== ($file = readdir($opendir)))
		{
			if($file != '.' && $file != '..' && is_file($extPath1.$file.'/name.txt'))
			{
				if(is_file($folder.$subfolder.$file.'/name.txt'))
				{
					$isPack = $file;
					break;
				}
				
				mkdir($folder.$subfolder.$file,0707);
				@chmod($folder.$subfolder.$file,0707);
				DirCopy($extPath1.$file,$folder.$subfolder.$file);				
				$isUpload = true;
				break;
			}
		}
		closedir($opendir);

		DirDelete($extPath);
		mkdir($extPath,0707);
		@chmod($extPath,0707);
		
		if ($isPack)
		{
			getLink('','','이미 동일한 폴더명('.$isPack.')의 '.$typeset[$type].' 존재합니다.','');
		}
		if (!$isUpload)
		{
			getLink('','','패키지규격에 맞지 않는 파일입니다','');		
		}
	}

	getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=pack&type='.($type=='bbstheme'?'theme':$type).'&insfolder='.$insfolder.($mobile?'&mobile='.$mobile:''),'parent.','['.(getFolderName($folder.$insfolder)).'] '.$typeset[$type].' 정상적으로 설치되었습니다.','');
}
else {

	$tmpname	= $_FILES['upfile']['tmp_name'];
	$realname	= $_FILES['upfile']['name'];
	$fileExt	= strtolower(getExt($realname));
	$saveFile	= $extPath1.$date['totime'].'.zip';

	if (is_uploaded_file($tmpname))
	{
		if ($type == 'layout')
		{
			if (substr($realname,0,10) != 'rb_layout_')
			{
				getLink('','','레이아웃 패키지가 아닙니다.','');
			}
		}
		if ($type == 'widget')
		{
			if (substr($realname,0,10) != 'rb_widget_')
			{
				getLink('','','위젯 패키지가 아닙니다.','');
			}
		}
		if ($type == 'switch')
		{
			if (substr($realname,0,10) != 'rb_switch_')
			{
				getLink('','','스위치 패키지가 아닙니다.','');
			}
		}
		if ($type == 'bbstheme')
		{
			if (substr($realname,0,12) != 'rb_bbstheme_')
			{
				getLink('','','게시판테마 패키지가 아닙니다.','');
			}
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
			if($file != '.' && $file != '..' && is_file($extPath1.$file.'/name.txt'))
			{
				if(is_file($folder.$subfolder.$file.'/name.txt'))
				{
					$isPack = $file;
					break;
				}
				
				mkdir($folder.$subfolder.$file,0707);
				@chmod($folder.$subfolder.$file,0707);
				DirCopy($extPath1.$file,$folder.$subfolder.$file);				
				$isUpload = true;
				break;
			}
		}
		closedir($opendir);

		DirDelete($extPath);
		mkdir($extPath,0707);
		@chmod($extPath,0707);
		
		if ($isPack)
		{
			getLink('','','이미 동일한 폴더명('.$isPack.')의 '.$typeset[$type].' 존재합니다.','');
		}
		if (!$isUpload)
		{
			getLink('','','패키지규격에 맞지 않는 파일입니다','');		
		}
	}



	getLink('reload','parent.','패키지가 정상적으로 등록되었습니다.','');
}
?>