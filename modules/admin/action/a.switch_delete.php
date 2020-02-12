<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
if (is_file($g['path_switch'].$switch.'/main.php'))
{
	include $g['path_core'].'function/dir.func.php';
	DirDelete($g['path_switch'].$switch);

	$_switchset = array('start','top','head','foot','end');

	$_ufile = $g['path_var'].'switch.var.php';
	$fp = fopen($_ufile,'w');
	fwrite($fp, "<?php\n");

	foreach ($_switchset as $_key)
	{
		foreach ($d['switch'][$_key] as $name => $sites)
		{
			if($switch == $_key.'/'.$name) continue;
			fwrite($fp, "\$d['switch']['".$_key."']['".$name."'] = \"".$sites."\";\n");
		}
	}
	fwrite($fp, "?>");
	fclose($fp);
	@chmod($_ufile,0707);

}

getLink($g['s'].'/?r='.$r.'&m=admin&module=admin&front=switch','parent.','삭제 되었습니다.','');
?>
