<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid'])
{
	getLink('','','정상적인 접근이 아닙니다.','');
}

$category = trim($category);

if ($my['admin'])
{
	foreach($members as $val)
	{
		getDbUpdate($table['s_saved'],"category='".$category."'",'uid='.$val);
	}
}
else {
	foreach($members as $val)
	{
		getDbUpdate($table['s_saved'],"category='".$category."'",'uid='.$val.' and mbruid='.$my['uid']);
	}
}

getLink('reload','parent.','','');
?>
