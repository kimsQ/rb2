<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

getDbDelete($table['s_mbrgroup'],'uid='.$uid);

getLink('reload','parent.','','');
?>
