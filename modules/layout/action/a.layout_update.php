<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if(!$layout) exit;

$name = trim(stripslashes($name));
if ($name)
{
	$nameFile = $g['path_layout'].$layout.'/name.txt';
	$fp = fopen($nameFile,'w');
	fwrite($fp,$name);
	fclose($fp);
	@chmod($nameFile,0707);
}

$codeFile = $g['path_layout'].$layout.'/'.$editfile;
$fp = fopen($codeFile,'w');
fwrite($fp,trim(stripslashes($code))."\n");
fclose($fp);
@chmod($codeFile,0707);

$_layout = $layout;
$_sublayout = $sublayout;

$sublayout = str_replace('.php','',trim($sublayout));
$newSLayout= str_replace('.php','',trim($newSLayout));
$newLayout = trim($newLayout);

if ($newSLayout && $newSLayout != $sublayout && !is_file($g['path_layout'].$layout.'/'.$newSLayout.'.php'))
{
	if (is_file($g['path_layout'].$layout.'/'.$sublayout.'.css'))
	{
		rename($g['path_layout'].$layout.'/'.$sublayout.'.css',$g['path_layout'].$layout.'/'.$newSLayout.'.css');
		@chmod($g['path_layout'].$layout.'/'.$newSLayout.'.css',0707);
	}
	if (is_file($g['path_layout'].$layout.'/'.$sublayout.'.js'))
	{
		rename($g['path_layout'].$layout.'/'.$sublayout.'.js',$g['path_layout'].$layout.'/'.$newSLayout.'.js');
		@chmod($g['path_layout'].$layout.'/'.$newSLayout.'.js',0707);
	}
	rename($g['path_layout'].$layout.'/'.$sublayout.'.php',$g['path_layout'].$layout.'/'.$newSLayout.'.php');
	@chmod($g['path_layout'].$layout.'/'.$newSLayout.'.php',0707);

	$_sublayout = $newSLayout.'.php';
}

if ($newLayout && $newLayout != $layout && !is_dir($g['path_layout'].$newLayout))
{
	rename($g['path_layout'].$layout,$g['path_layout'].$newLayout);
	$_layout = $newLayout;
}

getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&layout='.$_layout.'&sublayout='.$_sublayout,'parent.',sprintf('[%s] 파일이 수정되었습니다.',$codeFile),'');
?>
