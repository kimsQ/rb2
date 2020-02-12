<?php
if(!defined('__KIMS__')) exit;

$recnum = $_POST['recnum'];

require_once $g['path_core'].'function/sys.class.php';
// include_once $g['dir_module'].'mod/_post.php';

$g['postVarForSite'] = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
$svfile = file_exists($g['postVarForSite']) ? $g['postVarForSite'] : $g['dir_module'].'var/var.php';
include_once $svfile;

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['post']['skin_mobile'];
  $TMPL['start']=$start;
} else {
  $theme = $d['post']['skin_main'];
}

// include_once $g['dir_module'].'themes/'.$theme.'/_var.php';

$mbruid = $my['uid'];

$result=array();
$result['error'] = false;
$list=$keyword.'검색결과';

$result['list'] = $list;
$result['num'] = $NUM;

echo json_encode($result);
exit;
?>
