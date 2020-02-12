<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$g['layoutPageVarForSite'] = $g['path_var'].'site/'.$r.'/layout.'.$layout.'.'.$page.'.php';
$_tmpdfile = is_file($g['layoutPageVarForSite']) ? $g['layoutPageVarForSite'] : $g['path_layout'].$layout.'/_var/_var.'.$page.'.php';
include $_tmpdfile;

$result['list'] = getWidgetListEdit($d['layout']['main_widgets']);

if (is_file($g['layoutPageVarForSite'])) {
  $result['layoutPageVarForSite'] = true;
} else {
  $result['layoutPageVarForSite'] = false;
}

echo json_encode($result);
exit;
?>
