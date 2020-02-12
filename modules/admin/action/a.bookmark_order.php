<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$i = 0;
foreach ($bookmark_pages_order as $val)
{
	$i++;
	getDbUpdate($table['s_admpage'],'gid='.$i,'uid='.$val.' and memberuid='.$my['uid']);
}

getLink('','','','');
?>