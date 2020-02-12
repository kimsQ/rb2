<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$hidden = $hidden ? 0 : 1;
getDbUpdate($table['s_module'],'hidden='.$hidden,"id='".$moduleid."'");

getLink('reload','parent.','','');
?>