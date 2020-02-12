<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$widget = $_POST['widget'];

$result=array();
$result['error'] = false;

$readme_file = $g['path_widget'].$widget.'/readme.txt';
$readme_skin = @fopen($readme_file, 'r');
$readme = @fread($readme_skin, filesize($readme_file));

$result['readme'] = nl2br($readme);
$result['thumb'] = $g['path_widget'].$widget.'/thumb.png';

echo json_encode($result);
exit;
?>
