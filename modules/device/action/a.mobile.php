<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$agentlist = trim($agentlist);

$QKEY = "usemobile,startsite,startdomain";
$QVAL = "'$usemobile','$startsite','$startdomain'";

getDbDelete($table['s_mobile'],'');
getDbInsert($table['s_mobile'],$QKEY,$QVAL);

$mfile = $g['path_var'].'mobile.agent.txt';
$fp = fopen($mfile,'w');
fwrite($fp,stripslashes($agentlist));
fclose($fp);
@chmod($mfile,0707);

getLink('reload','parent.','','');
?>