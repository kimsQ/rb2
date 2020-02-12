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
		getDbUpdate($table['s_paper'],'inbox=2','uid='.$val);
	}
}
else {
	foreach($members as $val)
	{
		getDbUpdate($table['s_paper'],'inbox=2','uid='.$val.' and my_mbruid='.$my['uid']);
	}
}

getLink('reload','parent.','','');
?>