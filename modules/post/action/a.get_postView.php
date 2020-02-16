<?php
if(!defined('__KIMS__')) exit;

require_once $g['path_core'].'function/sys.class.php';
include_once $g['dir_module'].'lib/action.func.php';
require_once $g['dir_module'].'lib/base.class.php';
require_once $g['dir_module'].'lib/module.class.php';

$g['postVarForSite'] = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
$svfile = file_exists($g['postVarForSite']) ? $g['postVarForSite'] : $g['dir_module'].'var/var.php';
include_once $svfile;

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['post']['skin_mobile'];
} else {
  $theme = $d['post']['skin_main'];
}

$post = new Post();
$post->theme_name = $theme;

include_once $g['dir_module'].'themes/'.$theme.'/_var.php';

$mbruid = $my['uid'];

$_IS_POSTMBR=getDbRows($table[$m.'member'],'mbruid='.$my['uid'].' and data='.$uid);
$_IS_POSTOWN=getDbRows($table[$m.'member'],'mbruid='.$my['uid'].' and data='.$uid.' and level=1');

$_perm['post_member'] = $my['admin'] || $_IS_POSTMBR ? true : false;
$_perm['post_owner'] = $my['admin'] || $_IS_POSTOWN  ? true : false;

$check_like_qry    = "mbruid='".$mbruid."' and module='".$m."' and entry='".$uid."' and opinion='like'";
$check_dislike_qry = "mbruid='".$mbruid."' and module='".$m."' and entry='".$uid."' and opinion='dislike'";
$check_saved_qry   = "mbruid='".$mbruid."' and module='".$m."' and entry='".$uid."'";

$is_post_liked    = getDbRows($table['s_opinion'],$check_like_qry);
$is_post_disliked = getDbRows($table['s_opinion'],$check_dislike_qry);
$is_post_saved    = getDbRows($table['s_saved'],$check_saved_qry);

$formats = explode(',', $d['theme']['format']);array_unshift($formats,'');

$result=array();

$uid = $_POST['uid']; // 포스트 고유번호
$R = getUidData($table[$m.'data'],$uid);
$mod = 'view';
$d['post']['isperm'] = true;

include_once $g['dir_module'].'mod/_view.php';

if ($list) {
  $LIST=getDbData($table[$m.'list'],"id='".$list."'",'*');
  $_WHERE = 'site='.$s;
  $_WHERE .= ' and list="'.$LIST['uid'].'"';
  $TCD = getDbArray($table[$m.'list_index'],$_WHERE,'*','gid','asc',11,1);
  $NUM = getDbRows($table[$m.'list_index'],$_WHERE);
  while($_R = db_fetch_array($TCD)) $LCD[] = getDbData($table[$m.'data'],'uid='.$_R['data'],'*');

  $TMPL['list_name'] = $LIST['name'];
  $TMPL['list_num'] = $LIST['num'];
  $TMPL['list_id'] = $LIST['id'];
  $TMPL['list_mbrnic'] = getProfileInfo($LIST['mbruid'],'nic');

  $listPost = '';

  foreach ($LCD as $_L) {
    $TMPL['L_active']=$_L['uid']==$uid?'table-view-active':'';
    $TMPL['L_uid']=$_L['uid'];
    $TMPL['L_cid']=$_L['cid'];
    $TMPL['L_subject']=checkPostPerm($_L)?stripslashes($_L['subject']):'[비공개 포스트]';
    $TMPL['L_featured_16by9_sm'] = checkPostPerm($_L)?getPreviewResize(getUpImageSrc($_L),'240x134'):getPreviewResize('/files/noimage.png','240x134');
    $TMPL['L_featured_16by9'] = checkPostPerm($_L)?getPreviewResize(getUpImageSrc($_L),'640x360'):getPreviewResize('/files/noimage.png','640x360');
    $TMPL['L_time'] = checkPostPerm($_L)?getUpImageTime($_L):'';
    $TMPL['L_provider']=getFeaturedimgMeta($_L,'provider');
    $TMPL['L_videoId']=getFeaturedimgMeta($_L,'provider')=='YouTube'?getFeaturedimgMeta($_L,'name'):'';
    $TMPL['L_format']=$formats[$_L['format']];
    $skin_listPost=new skin('view_listPost');
    $listPost.=$skin_listPost->make();
  }
  $TMPL['listPost'] = $listPost;
  $skin_listCollapse=new skin('view_list-collapse');
  $result['listCollapse']=$skin_listCollapse->make();
}

$TMPL['list_name'] = $LIST['name'];
$TMPL['list_num'] = $LIST['num'];

$TMPL['uid'] = $R['uid'];
$TMPL['cid'] = $R['cid'];
$TMPL['mbruid'] = $R['mbruid'];
$TMPL['profile_url']=getProfileLink($R['mbruid']);
$TMPL['post_url']=getPostLink($R,0);
$TMPL['featured_16by9'] = checkPostPerm($R)?getPreviewResize(getUpImageSrc($R),'640x360'):getPreviewResize('/files/noimage.png','640x360');
$TMPL['num_follower'] = number_format(getProfileInfo($R['mbruid'],'num_follower'));
$TMPL['avatar'] = getAvatarSrc($R['mbruid'],'150');
$TMPL['nic'] = getProfileInfo($R['mbruid'],'nic');

if ($R['format']==2) $TMPL['subject'] = stripslashes($R['subject']);
else $TMPL['subject']=getContents($R['subject'],$R['html']);

$TMPL['review'] = stripslashes($R['review']);
$TMPL['content'] = getContents($R['content'],'HTML');
$TMPL['hit'] = $R['hit'];
$TMPL['likes'] = $R['likes'];
$TMPL['dislikes'] = $R['dislikes'];
$TMPL['comment'] = $R['comment']?number_format($R['comment']):'';
$TMPL['oneline'] = $R['oneline']?'+'.$R['oneline']:'';
$TMPL['tag'] = $R['tag']?getPostTag($R['tag']):'';
$TMPL['d_regis'] = getDateFormat($R['d_regis'],'Y.m.d H:i');
$TMPL['d_modify'] = getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c');
$TMPL['isFollowing'] = $_isFollowing ?'active':'';
$TMPL['view_follow'] = $my['uid']!=$R['mbruid']?$post->getHtml('view_follow'):'';
$TMPL['view_opinion'] = $my['uid']&&$R['likes']&&!$R['dis_like'] ?$post->getHtml('view_opinion'):'';

$result['subject'] = stripslashes($R['subject']);
$result['featured_16by9'] = checkPostPerm($R)?getPreviewResize(getUpImageSrc($R),'640x360'):getPreviewResize('/files/noimage.png','640x360');
$result['nic'] = getProfileInfo($R['mbruid'],'nic');
$result['dis_like'] = $R['dis_like']?$R['dis_like']:'';
$result['dis_rating'] = $R['dis_rating']?$R['dis_rating']:'';
$result['dis_comment'] = $R['dis_comment']?$R['dis_comment']:'';
$result['dis_listadd'] = $R['dis_listadd']?$R['dis_listadd']:'';
$result['goods'] = $R['goods'];

//최근 포스트
$postque = 'mbruid='.$R['mbruid'].' and site='.$s.' and data <>'.$R['uid'];
if ($my['uid']) $postque .= ' and display > 3';  // 회원공개와 전체공개 포스트 출력
else $postque .= ' and display = 5'; // 전체공개 포스트만 출력
$_RCD=getDbArray($table['postmember'],$postque,'*','gid','asc',6,1);
while($_R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['postdata'],'gid='.$_R['gid'],'*');
$_NUM = getDbRows($table['postmember'],$postque);
$newPost = '';

if ($_NUM) {
  foreach ($RCD as $POST) {
    $TMPL['newpost_uid']=$POST['uid'];
    $TMPL['newpost_cid']=$POST['cid'];
    $TMPL['newpost_format']=$formats[$POST['format']];
    $TMPL['newpost_subject']=stripslashes($POST['subject']);
    $TMPL['newpost_featured_16by9'] = getPreviewResize(getUpImageSrc($POST),'640x360');
    $TMPL['newpost_featured_16by9_sm'] = getPreviewResize(getUpImageSrc($POST),'320x180');
    $TMPL['newpost_has_featured'] = $POST['featured_img']?'':'d-none';
    $TMPL['newpost_provider']=getFeaturedimgMeta($POST,'provider');
    $TMPL['newpost_videoId']=getFeaturedimgMeta($POST,'provider')=='YouTube'?getFeaturedimgMeta($POST,'name'):'';
    $TMPL['newpost_hit']=$POST['hit'];
    $TMPL['newpost_d_modify'] = getDateFormat($POST['d_modify']?$POST['d_modify']:$POST['d_regis'],'c');
    $TMPL['newpost_nic'] = getProfileInfo($POST['mbruid'],'nic');
    $TMPL['newpost_time'] = getUpImageTime($POST);
    $skin_newPost=new skin('view_newPost');
    $newPost.=$skin_newPost->make();
  }
}

$TMPL['newPost'] = $newPost;

if (!checkPostPerm($R)){
  $markup_file = '_404';
  $result['isperm']  = false;
} else {
  $result['isperm']  = true;
  $result['linkurl']=getFeaturedimgMeta($R,'linkurl');
}

if ($is_post_liked) $result['is_post_liked'] = 1;
if ($is_post_disliked) $result['is_post_disliked'] = 1;
if ($is_post_saved) $result['is_post_saved'] = 1;

$markup_file = $markup_file?$markup_file:'view_doc_content';
$skin=new skin($markup_file);
$result['error'] = false;
$result['review']= stripslashes($R['review']);
$result['article']=$skin->make();
$result['theme'] = $theme;

//첨부링크 및 파일
$theme_attach= '_mobile/rc-post-file';
$theme_link= '_mobile/rc-post-link';
include_once $g['path_module'].'mediaset/themes/'.$theme_attach.'/main.func.php';
include_once $g['path_module'].'mediaset/themes/'.$theme_link.'/main.func.php';

if($R['upload']) {
  if ($AttachListType == 'object') {
    $result['photo'] = getAttachObjectArray($R,'photo');
  } else {
    $result['attachNum'] = getAttachNum($R['upload'],'view');
    $result['file'] = getAttachFileList($R,'view','file',$theme_attach);
    $result['photo'] = getAttachFileList($R,'view','photo',$theme_attach);
    $result['video'] = getAttachFileList($R,'view','video',$theme_attach);
    $result['link'] = getAttachPlatformList($R,'view','link');
  }
  $result['theme_attachFile'] = $theme_attach;
}

echo json_encode($result);
exit;
?>
