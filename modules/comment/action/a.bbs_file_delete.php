<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$R = getDbData($table[$m.'list'],"id='".$bid."'",'*');

if ($R['img'.$dtype])
{
	getDbUpdate($table[$m.'list'],"img".$dtype."=''",'uid='.$R['uid']);
	unlink($g['dir_module'].'var/files/'.$R['img'.$dtype]);
}

getLink('reload','parent.','','');
?>