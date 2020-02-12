<?php
if(!defined('__KIMS__')) exit;

$NUM = getDbRows($table['postday'],$que);
$RCD=getDbArray($table['postday'],$que,'*',$sort,'desc',$_NUM,1);
while($_R = db_fetch_array($RCD)) $_RCD[] = getDbData($table['postdata'],'uid='.$_R['data'],'*');

require_once $g['path_core'].'function/sys.class.php';
include_once $g['dir_module'].'lib/action.func.php';
include_once $g['dir_module'].'var/var.php';

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['post']['skin_mobile'];
} else {
  $theme = $d['post']['skin_main'];
}

$result=array();
$result['error'] = false;

$list='';

$i=1;foreach ($_RCD as $R) {
  if (!strpos('_'.$R['member'],'['.$my['uid'].']')) continue;
  $TMPL['link']=getPostLink($R,1);
  $TMPL['subject']=stripslashes($R['subject']);
  $TMPL['uid']=$R['uid'];
  $TMPL['hit']=$R['hit'];
  $TMPL['comment']=$R['comment'].($R['oneline']?'+'.$R['oneline']:'');
  $TMPL['likes']=$R['likes'];
  $TMPL['featured_img'] = checkPostPerm($R) ?getPreviewResize(getUpImageSrc($R),'100x56'):getPreviewResize('/files/noimage.png','100x56');
  $TMPL['time'] = checkPostPerm($R)?getUpImageTime($R):'';
  $TMPL['d_modify'] = getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c');

  $skin=new skin($markup_file);
  $list.=$skin->make();

  if ($i==$limit) break;
  $i++;
}

$result['list'] = $list;
$result['num'] = $i;

echo json_encode($result);
exit;
?>
