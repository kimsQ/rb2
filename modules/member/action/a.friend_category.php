<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid'])
{
	getLink('','','정상적인 접근이 아닙니다.','');
}

$category = trim($category);
foreach($members as $val)
{
	getDbUpdate($table['s_friend'],"category='".$category."'",'uid='.$val.' and my_mbruid='.$my['uid']);
}

getLink('reload','parent.','','');
?>