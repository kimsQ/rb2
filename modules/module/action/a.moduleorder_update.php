<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$i=0;
foreach($modulemembers as $val) getDbUpdate($table['s_module'],'gid='.($i++),"id='".$val."'");

getLink('reload','parent.','','');
?>