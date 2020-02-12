<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if (!$layout) exit;

if ($imgfile)
{
	unlink($g['path_layout'].$layout.'/image/'.$imgfile);
	getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=main&layout='.$layout.'&type=image','parent.','','');
}


if($numSub)
{
	if ($numSub == 1)
	{
		include $g['path_core'].'function/dir.func.php';
		DirDelete($g['path_layout'].$layout);
		getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m,'parent.','','');
	}
	else
	{
		$cssfile = str_replace('.php','.css',$sublayout);
		$jsfile = str_replace('.php','.js',$sublayout);
		unlink($g['path_layout'].$layout.'/'.$sublayout);
		if(is_file($g['path_layout'].$layout.'/'.$cssfile)) unlink($g['path_layout'].$layout.'/'.$cssfile);
		if(is_file($g['path_layout'].$layout.'/'.$jsfile)) unlink($g['path_layout'].$layout.'/'.$jsfile);
		getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&layout='.$layout,'parent.','','');
	}
}
if($numCopy == 1)
{
	$cssfile = str_replace('.php','.css',$sublayout);
	$jsfile = str_replace('.php','.js',$sublayout);
	copy($g['path_layout'].$layout.'/'.$sublayout,$g['path_layout'].$layout.'/copy-'.$sublayout);
	if(is_file($g['path_layout'].$layout.'/'.$cssfile))
	{
		copy($g['path_layout'].$layout.'/'.$cssfile,$g['path_layout'].$layout.'/copy-'.$cssfile);
		@chmod($g['path_layout'].$layout.'/copy-'.$cssfile,0707);
	}
	if(is_file($g['path_layout'].$layout.'/'.$jsfile))
	{
		copy($g['path_layout'].$layout.'/'.$jsfile,$g['path_layout'].$layout.'/copy-'.$jsfile);
		@chmod($g['path_layout'].$layout.'/copy-'.$jsfile,0707);
	}
	getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&layout='.$layout.'&sublayout=copy-'.$sublayout,'parent.','','');
}
if($numCopy == 2)
{
	include $g['path_core'].'function/dir.func.php';
	@mkdir($g['path_layout'].'copy-'.$layout,0707);
	@chmod($g['path_layout'].'copy-'.$layout,0707);
	DirCopy($g['path_layout'].$layout,$g['path_layout'].'copy-'.$layout);
	getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&layout=copy-'.$layout,'parent.','','');
}
exit;
?>