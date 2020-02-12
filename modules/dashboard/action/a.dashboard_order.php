<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$_mywidget = $g['dir_module'].'var/'.$my['uid'].'.php';
if($widget) include $_mywidget;

$fp = fopen($_mywidget,'w');
fwrite($fp, "<?php\n");

if ($widget)
{
	foreach ($d['admwidget'] as $_key => $_val)
	{
		fwrite($fp, "\$d['admwidget']['".$_key."'] = '".($_key==$widget?'false':$_val)."';\n");
	}
}
else {
	$_i = 0;
	$_s = explode(',',$flag);
	foreach ($dashboard_widgets_order as $val)
	{
		fwrite($fp, "\$d['admwidget']['".$val."'] = '".$_s[$_i]."';\n");
		$_i++;
	}
}

fwrite($fp, "?>");
fclose($fp);
@chmod($_mywidget,0707);

if ($reaction == 'Y')
{
	getLink('reload','parent.parent.','','');
}
else {
	getLink('reload','parent.','','');
}
?>
