<?php
if(!defined('__KIMS__')) exit;

$RCD = explode(',',$posts);

require_once $g['path_core'].'function/sys.class.php';

$g['postVarForSite'] = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
$svfile = file_exists($g['postVarForSite']) ? $g['postVarForSite'] : $g['dir_module'].'var/var.php';
include_once $svfile;

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['post']['skin_mobile'];
  $TMPL['start']=$start;
} else {
  $theme = $d['post']['skin_main'];
}

$mbruid = $my['uid'];

include_once $g['dir_module'].'themes/'.$theme.'/_var.php';

$formats = explode(',', $d['theme']['format']);
array_unshift($formats,'');

$result=array();
$result['error'] = false;
$list='';

if (!empty($RCD)) {
  foreach ($RCD as $_R) {
    $R = getDbData($table[$m.'data'],"cid='".$_R."'",'*');
    if (!$R['uid']) continue;
    $_markup_file = $markup_file.'-'.$formats[$R['format']];
    $comment = $R['comment'].($R['oneline']?'+'.$R['oneline']:'');
    $_comment =  $comment==0?'':$comment;
    $TMPL['link']=getPostLink($R,1);
    $TMPL['subject']=stripslashes($R['subject']);
    $TMPL['review']=stripslashes($R['review']);
    $TMPL['format'] = $R['format'];
    $TMPL['uid']=$R['uid'];
    $TMPL['cid']=$R['cid'];
    $TMPL['mbruid']=$R['mbruid'];
    $TMPL['post_url']=getPostLink($R,0);
    $TMPL['profile_url']=getProfileLink($R['mbruid']);
    $TMPL['hit']=$R['hit'];
    $TMPL['comment']=$_comment;
    $TMPL['likes']=$R['likes'];
    $TMPL['dislikes']=$R['dislikes'];
    $TMPL['provider']=getFeaturedimgMeta($R,'provider');
    $TMPL['videoId']=getFeaturedimgMeta($R,'provider')=='YouTube'?getFeaturedimgMeta($R,'name'):'';
    $TMPL['featured_16by9'] = checkPostPerm($R)?getPreviewResize(getUpImageSrc($R),'640x360'):getPreviewResize('/files/noimage.png','640x360');
    $TMPL['featured_1by1'] = checkPostPerm($R)?getPreviewResize(getUpImageSrc($R),'640x640'):getPreviewResize('/files/noimage.png','640x640');
    $TMPL['time'] = checkPostPerm($R)?getUpImageTime($R):'';
    $TMPL['d_modify'] = getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c');
    $TMPL['avatar'] = getAvatarSrc($R['mbruid'],'68');
    $TMPL['nic'] = getProfileInfo($R['mbruid'],'nic');
    $TMPL['has_goodslink']=$R['goods']?'':'d-none';

    $check_like_qry    = "mbruid='".$mbruid."' and module='".$m."' and entry='".$R['uid']."' and opinion='like'";
    $check_dislike_qry = "mbruid='".$mbruid."' and module='".$m."' and entry='".$R['uid']."' and opinion='dislike'";
    $check_saved_qry   = "mbruid='".$mbruid."' and module='".$m."' and entry='".$R['uid']."'";
    $is_post_liked    = getDbRows($table['s_opinion'],$check_like_qry);
    $is_post_disliked = getDbRows($table['s_opinion'],$check_dislike_qry);
    $is_post_saved    = getDbRows($table['s_saved'],$check_saved_qry);
    $TMPL['is_post_liked'] = $is_post_liked?'active':'';
    $TMPL['is_post_disliked'] = $is_post_disliked?'active':'';
    $TMPL['is_post_saved'] = $is_post_saved?'true':'false';

    $skin=new skin($_markup_file);
    $list.=$skin->make();
  }
}

$result['list'] = $list;

echo json_encode($result);
exit;
?>
