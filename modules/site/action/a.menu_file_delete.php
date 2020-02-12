<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$R = getUidData($table['s_menu'],$cat);
if ($R['img'.$dtype])
{
	getDbUpdate($table['s_menu'],"img".$dtype."=''",'uid='.$R['uid']);
	unlink($g['path_var'].'menu/'.$R['img'.$dtype]);
}

getLink('reload','parent.','','');
?>