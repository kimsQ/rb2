<?php
if(!defined('__KIMS__')) exit;

$g['referer'] = $_SERVER['HTTP_REFERER'];
if (!$g['referer'] || !strpos($g['referer'],'&m=admin&'))
{
	$_filterSet = array('nic','name','id');
	foreach ($_filterSet as $_ft)
	{
		${$_ft} = preg_replace("(\.|\;|\\\)",'',strip_tags(${$_ft}));
	}
}

if (strpos(',join,',$a))
{
	if (!$g['referer'] || !strpos($g['referer'],$_SERVER['HTTP_HOST'])) exit;
}

$g['act_module0'] = $g['dir_module'].$a.'.php';
$g['act_module1'] = $g['dir_module'].'action/'.(strpos($a,'/')?str_replace('/','/a.',$a):'a.'.$a).'.php';
$g['act_module2'] = $g['dir_module'].'action/a.'.$a.'.php';
$g['act_module3'] = $g['referer'] && strpos($g['referer'],'&m=admin&') ? ($_HMD['lang']?$_HMD['lang']:$d['admin']['syslang']) : ($_HS['lang']?$_HS['lang']:$d['admin']['syslang']);

include getLangFile($g['dir_module'].'language/',$g['act_module3'],'/lang.action.php');

if (is_file($g['act_module0'])) include $g['act_module0'];
if (is_file($g['act_module1'])) include $g['act_module1'];
if (is_file($g['act_module2'])) include $g['act_module2'];
?>