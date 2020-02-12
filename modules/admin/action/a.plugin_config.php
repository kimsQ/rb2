<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if ($isdelete)
{
	include $g['path_core'].'function/dir.func.php';
	foreach($pluginmembers as $plg)
	{
		if($isdelete == '1')
		{
			DirDelete($g['path_plugin'].$plg);
		}
		if($isdelete == '2')
		{
			if(is_file($g['path_plugin'].$plg.'/size.txt'))
			{
				unlink($g['path_plugin'].$plg.'/size.txt');
			}
			DirDelete($g['path_plugin'].$plg.'/'.$ov[$plg]);
		}
	}

	getLink($g['s'].'/?r='.$r.'&m='.$m.'&module='.$m.'&front=plugin&resave=Y','parent.','','');
}
else {
	$_tmpdfile = $g['path_var'].'plugin.var.php';
	$fp = fopen($_tmpdfile,'w');
	fwrite($fp, "<?php\n");
	foreach ($ov as $_key_ => $_val_)
	{
		fwrite($fp, "\$d['ov']['".$_key_."'] = '".trim($_val_)."';\n");
	}
	fwrite($fp, "?>");
	fclose($fp);
	@chmod($_tmpdfile,0707);
	
	getLink($g['s'].'/?r='.$r.'&m='.$m.'&module='.$m.'&front=plugin','parent.','','');
}
?>