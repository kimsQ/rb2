<?php
if(!defined('__KIMS__')) exit;

$U=getDbData($table['s_upload'],"src='".$src."'",'tag');

$result=array();
$result['error'] = false;
$result['tag'] = stripslashes($U['tag']);

echo json_encode($result);
exit;
?>
