<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$_HS = getDbData($table['s_site'],"id='".$r."'",'*');

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
	$layout = dirname($_HS['m_layout']);
} else {
  $layout = dirname($_HS['layout']);
}

include_once $g['path_layout'].$layout.'/_var/_var.php';

$fdset = array($d['layout']['site_code']);

$svfile = $g['path_var'].'sitephp/'.$s.'.php';
include_once $svfile;

$result=array();
$result['error'] = false;

foreach ($fdset as $val) {
	$result[$val] = $d['site'][$val];
}

echo json_encode($result);
exit;
?>
