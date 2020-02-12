<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$_switchset = array('start','top','head','foot','end');

$_ufile = $g['path_var'].'switch.var.php';
$fp = fopen($_ufile,'w');
fwrite($fp, "<?php\n");

foreach ($_switchset as $_key)
{
	foreach (${'switchmembers_'.$_key} as $_val)
	{
		fwrite($fp, "\$d['switch']['".$_key."']['".$_val."'] = \"".$d['switch'][$_key][$_val]."\";\n");
	}
}
fwrite($fp, "?>");
fclose($fp);
@chmod($_ufile,0707);

getLink('reload','parent.',$auto?'':'스위치 정보가 갱신되었습니다.','');
?>
