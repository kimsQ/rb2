<?php
if(!defined('__KIMS__')) exit;

$p		= $p ? $p : 1;
$recnum	= $recnum && $recnum < 200 ? $recnum : 20;
$sort	= $sort		? $sort		: 'hit';
$orderby= $orderby	? $orderby	: 'desc';
$query = 'site='.$s.' and ';

$_WHERE1= $query.'date >= '.$d_start.' and '.$sort.'>0';

if ($sort=='hit') $_WHERE2= 'data,sum(hit) as hit';
if ($sort=='likes') $_WHERE2= 'data,sum(likes) as likes';
if ($sort=='dislikes') $_WHERE2= 'data,sum(dislikes) as dislikes';
if ($sort=='comment') $_WHERE2= 'data,sum(comment) as comment';

$RCD	= getDbSelect($table[$m.'day'],$_WHERE1.' group by data order by '.$sort.' '.$orderby.' limit 0,'.$recnum,$_WHERE2);
while($_R = db_fetch_array($RCD)) $_RCD[] = getDbData($table[$m.'data'],'uid='.$_R['data'],'*');

$NUM = getDbRows($table[$m.'day'],$_WHERE1.' group by data');
$TPG = getTotalPage($NUM,$recnum);

require_once $g['path_core'].'function/sys.class.php';
include_once $g['dir_module'].'lib/action.func.php';
include_once $g['dir_module'].'var/var.php';

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['post']['skin_mobile'];
  $TMPL['start']=$start;
} else {
  $theme = $d['post']['skin_main'];
}

include_once $g['dir_module'].'themes/'.$theme.'/_var.php';
$formats = explode(',', $d['theme']['format']);array_unshift($formats,'');
$mbruid = $my['uid'];

$result=array();
$result['error'] = false;

$list='';

if (!empty($_RCD)) {
  $i=1;foreach ($_RCD as $R) {
    if ($dashboard=='Y' && !strpos('_'.$R['member'],'['.$my['uid'].']')) continue;
    $_markup_file = $markup_file.'-'.$formats[$R['format']];
    $TMPL['link']=getPostLink($R,1);
    $TMPL['edit_link']=RW('m=post&mod=write&cid='.$R['cid']);
    $TMPL['subject']=getContents($R['subject'],$R['html']);
    $TMPL['has_content']=$R['content']?'d-block':'d-none';
    $TMPL['format'] = $R['format'];
    $TMPL['uid']=$R['uid'];
    $TMPL['mbruid']=$R['mbruid'];
    $TMPL['post_url']=getPostLink($R,0);
    $TMPL['profile_url']=getProfileLink($R['mbruid']);
    $TMPL['hit']=$R['hit'];
    $TMPL['comment']=$R['comment'].($R['oneline']?'+'.$R['oneline']:'');
    $TMPL['likes']=$R['likes'];
    $TMPL['dislikes']=$R['dislikes'];
    $TMPL['provider']=getFeaturedimgMeta($R,'provider');
    $TMPL['videoId']=getFeaturedimgMeta($R,'provider')=='YouTube'?getFeaturedimgMeta($R,'name'):'';
    $TMPL['featured_16by9'] = checkPostPerm($R)?getPreviewResize(getUpImageSrc($R),'640x360'):getPreviewResize('/files/noimage.png','640x360');
    $TMPL['featured_16by9_sm'] = checkPostPerm($R) ?getPreviewResize(getUpImageSrc($R),'300x168'):getPreviewResize('/files/noimage.png','300x168');
    $TMPL['has_featured'] = !$R['featured_img']?'d-none':'';
    $TMPL['time'] = checkPostPerm($R)?getUpImageTime($R):'';
    $TMPL['d_modify'] = getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c');
    $TMPL['avatar'] = getAvatarSrc($R['mbruid'],'68');
    $TMPL['nic'] = getProfileInfo($R['mbruid'],'nic');

    $check_like_qry    = "mbruid='".$mbruid."' and module='".$m."' and entry='".$R['uid']."' and opinion='like'";
    $check_dislike_qry = "mbruid='".$mbruid."' and module='".$m."' and entry='".$R['uid']."' and opinion='dislike'";
    $check_saved_qry   = "mbruid='".$mbruid."' and module='".$m."' and entry='".$R['uid']."'";
    $is_post_liked    = getDbRows($table['s_opinion'],$check_like_qry);
    $is_post_disliked = getDbRows($table['s_opinion'],$check_dislike_qry);
    $is_post_saved    = getDbRows($table['s_saved'],$check_saved_qry);
    $TMPL['is_post_liked'] = $is_post_liked?'active':'';
    $TMPL['is_post_disliked'] = $is_post_disliked?'active':'';
    $TMPL['is_post_saved'] = $is_post_saved?'true':'false';

    if ($sort=='hit') $TMPL['num']=$R['hit']?'조회 '.$R['hit']:'';
    if ($sort=='likes') $TMPL['num']=$R['likes']?'좋아요 '.$R['likes']:'';
    if ($sort=='dislikes') $TMPL['num']=$R['dislikes']?'싫어요 '.$R['dislikes']:'';
    if ($sort=='comment') $TMPL['num']=$R['comment']?'댓글 '.$R['comment']:'';

    $skin=new skin($_markup_file);
    $list.=$skin->make();

    if ($i==$limit) break;
    $i++;
  }
}

$result['list'] = $list;
$result['num'] = $NUM;
$result['tpg'] = $TPG;

echo json_encode($result);
exit;
?>
