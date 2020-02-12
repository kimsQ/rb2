<?php
if(!defined('__KIMS__')) exit;
if (!$my['uid']) exit;

$result=array();
$result['error'] = false;

$num_notice = !$my['num_notice']?'':$my['num_notice'];
$result['num'] = $num_notice;
echo json_encode($result);

exit;
?>
