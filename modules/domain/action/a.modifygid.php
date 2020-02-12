<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$i = 0;
foreach($menumembers as $val) getDbUpdate($table['s_domain'],'gid='.($i++),'uid='.$val);

getLink('reload','parent.','','');
?>