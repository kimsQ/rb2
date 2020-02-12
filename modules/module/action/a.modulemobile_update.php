<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$mobile = $mobile ? 0 : 1;
getDbUpdate($table['s_module'],'mobile='.$mobile,"id='".$moduleid."'");

getLink('reload','parent.','','');
?>