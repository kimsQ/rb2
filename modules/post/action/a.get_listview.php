<?php
if(!defined('__KIMS__')) exit;

$recnum = $_POST['recnum'];

require_once $g['path_core'].'function/sys.class.php';

$LIST=getDbData($table[$m.'list'],"id='".$listid."'",'*');
include_once $g['dir_module'].'mod/_list.php';

$g['postVarForSite'] = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
$svfile = file_exists($g['postVarForSite']) ? $g['postVarForSite'] : $g['dir_module'].'var/var.php';
include_once $svfile;

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['post']['skin_mobile'];
} else {
  $theme = $d['post']['skin_main'];
}

include_once $g['dir_module'].'themes/'.$theme.'/_var.php';
$formats = explode(',', $d['theme']['format']);array_unshift($formats,'');

$result=array();
$result['error'] = false;
$box='';
$list='';

$TMPL['avatar'] = getAvatarSrc($LIST['mbruid'],'64');
$TMPL['mbruid'] = $LIST['mbruid'];
$TMPL['nic'] = getProfileInfo($LIST['mbruid'],'nic');
$TMPL['name'] = $LIST['name'];
$TMPL['num']=$LIST['num'];
$TMPL['list']=$LIST['id'];
$TMPL['cover']=getListImageSrc($LIST['uid']);
$TMPL['review']=$LIST['review'];

foreach ($RCD as $R) {
  $TMPL['subject']=checkPostPerm($R)?stripslashes($R['subject']):'[비공개 포스트]';
  $TMPL['uid']=$R['uid'];
  $TMPL['cid']=$R['cid'];
  $TMPL['format'] = $formats[$R['format']];
  $TMPL['time']=checkPostPerm($R)?getUpImageTime($R):'';
  $TMPL['provider']=getFeaturedimgMeta($R,'provider');
  $TMPL['videoId']=getFeaturedimgMeta($R,'provider')=='YouTube'?getFeaturedimgMeta($R,'name'):'';
  $TMPL['featured_16by9_sm'] = checkPostPerm($R)?getPreviewResize(getUpImageSrc($R),'480x270'):getPreviewResize('/files/noimage.png','480x270');
  $TMPL['featured_16by9'] = checkPostPerm($R)?getPreviewResize(getUpImageSrc($R),'640x360'):getPreviewResize('/files/noimage.png','640x360');
  $TMPL['d_modify'] = getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c');
  $TMPL['nic'] = getProfileInfo($R['mbruid'],'nic');
  $skin_list=new skin('listview-row');
  $list.=$skin_list->make();
}

$TMPL['row'] = $list;

$skin=new skin($markup_file);
$box.=$skin->make();


$result['box'] = $box;
$result['num'] = $NUM;

echo json_encode($result);
exit;
?>
