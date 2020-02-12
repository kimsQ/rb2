<?php
if(!defined('__KIMS__')) exit;

$recnum = $_POST['recnum'];

require_once $g['path_core'].'function/sys.class.php';
include_once $g['dir_module'].'mod/_list.php';

$g['postVarForSite'] = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
$svfile = file_exists($g['postVarForSite']) ? $g['postVarForSite'] : $g['dir_module'].'var/var.php';
include_once $svfile;

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['post']['skin_mobile'];
} else {
  $theme = $d['post']['skin_main'];
}

$result=array();
$result['error'] = false;
$list='';

foreach ($RCD as $R) {
  $TMPL['name']=stripslashes($R['name']);
  $TMPL['uid']=$R['uid'];
  $TMPL['id']=$R['id'];
  $TMPL['num']=$R['num'];
  $TMPL['featured_img'] = getPreviewResize(getListImageSrc($R['uid']),'480x270');
  $TMPL['d_modify'] = getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c');
  $TMPL['nic'] = getProfileInfo($R['mbruid'],'nic');
  $skin=new skin($markup_file);
  $list.=$skin->make();
}

$result['list'] = $list;
$result['num'] = $NUM;

echo json_encode($result);
exit;
?>
