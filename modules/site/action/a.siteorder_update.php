<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$i=0;
foreach($sitemembers as $val) getDbUpdate($table['s_site'],'gid='.($i++),'uid='.$val);

getLink('','','','');
?>