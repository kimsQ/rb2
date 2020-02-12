<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if ($moduleid)
{
	getDbUpdate($table['s_module'],"name='".trim($name)."',hidden='$hidden',mobile='$mobile',icon='".trim($icon)."',lang='$modulelang'","id='".$moduleid."'");
}

getLink('reload','parent.','','');
?>