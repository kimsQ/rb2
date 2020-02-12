<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid'])
{
	getLink('','','정상적인 접근이 아닙니다.','');
}

if ($my['admin'])
{
	foreach($members as $val)
	{
		getDbDelete($table['s_saved'],'uid='.$val);
	}
}
else {
	foreach($members as $val)
	{
		getDbDelete($table['s_saved'],'uid='.$val.' and mbruid='.$my['uid']);
	}
}

getLink('reload','parent.','','');
?>
