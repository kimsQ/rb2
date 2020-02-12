<?php
if(!defined('__KIMS__')) exit;

$result=array();
$attach = getArrayString($attachfiles);

$i = 0;
foreach($attach['data'] as $val) getDbUpdate($table['s_upload'],'gid='.($i++),'uid='.$val);

$result['error'] = false;
echo json_encode($result);
exit;
?>
