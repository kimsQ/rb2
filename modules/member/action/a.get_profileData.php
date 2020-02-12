<?php
if(!defined('__KIMS__')) exit;

require_once $g['path_core'].'function/sys.class.php';
require_once $g['dir_module'].'lib/base.class.php';
require_once $g['dir_module'].'lib/module.class.php';

$g['memberVarForSite'] = $g['path_var'].'site/'.$_HS['id'].'/member.var.php'; // 사이트 회원모듈 변수파일
$_varfile = file_exists($g['memberVarForSite']) ? $g['memberVarForSite'] : $g['dir_module'].'var/var.php';
include_once $_varfile; // 변수파일 인클루드

$result=array();
$result['error']=false;

$mbruid = $_POST['mbruid'];
$type = $_POST['type'];

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['member']['theme_mobile'];
} else {
  $theme = $d['member']['theme_main'];
}

$member = new Member();
$member->theme_name = $theme;

$_MH = getUidData($table['s_mbrid'],$mbruid);
$_MD = getDbData($table['s_mbrdata'],"memberuid='".$mbruid."'",'*');
$_isFollowing = getDbRows($table['s_friend'],'my_mbruid='.$my['uid'].' and by_mbruid='.$mbruid);

$TMPL['id'] = $_MH['id'];
$TMPL['nic'] = $_MD['nic'];
$TMPL['name'] = $_MD['name'];
$TMPL['mbruid'] = $mbruid;
$TMPL['cover'] = getCoverSrc($mbruid,'800','500');
$TMPL['avatar'] = getAvatarSrc($mbruid,'136');
$TMPL['grade'] = $g['grade']['m'.$_MD['level']];
$TMPL['point'] = number_format($_MD['point']);
$TMPL['level'] = $_MD['level'];
$TMPL['bio'] = $_MD['bio'];
$TMPL['d_regis'] = getDateFormat($_MD['d_regis'],'Y.m.d');
$TMPL['num_follower'] = number_format($_MD['num_follower']);
$TMPL['bio'] = $_MD['bio'];
$TMPL['hit_post'] = number_format($_MD['hit_post']);
$TMPL['isFollowing'] = $_isFollowing ?'active':'';
$TMPL['profile_setting'] = $mbruid==$my['uid']?$member->getHtml('profile_setting'):'';
$TMPL['profile_follow'] = $my['uid']!=$mbruid?$member->getHtml('profile_follow'):'';

// 작업필요
$_isFollowing = getDbRows($table['s_friend'],'my_mbruid='.$my['uid'].' and by_mbruid='.$mbruid);

if ($type=='popover') {
  $markup_file = 'profile-popover'; // 기본 마크업 페이지 전달 (테마 내부 _html/profile-popover.html)
}


//최근 동영상
$postque = 'mbruid='.$mbruid.' and site='.$s.' and format=2';
if ($my['uid']) $postque .= ' and display > 3';  // 회원공개와 전체공개 포스트 출력
else $postque .= ' and display = 5'; // 전체공개 포스트만 출력
$_RCD=getDbArray($table['postmember'],$postque,'*','gid','asc',3,1);
while($_R = db_fetch_array($_RCD)) $RCD[] = getDbData($table['postdata'],'gid='.$_R['gid'],'*');
$NUM = getDbRows($table['postmember'],$postque);
$newPost = '';

if ($NUM) {
  foreach ($RCD as $POST) {
    $TMPL['post_uid']=$POST['uid'];
    $TMPL['post_cid']=$POST['cid'];
    $TMPL['post_format']=$POST['format'];
    $TMPL['post_subject']=getContents($POST['subject'],$R['html']);
    $TMPL['post_featured_16by9'] = getPreviewResize(getUpImageSrc($POST),'640x360');
    $TMPL['post_featured_16by9_sm'] = getPreviewResize(getUpImageSrc($POST),'320x180');
    $TMPL['post_has_featured'] = $POST['featured_img']?'':'d-none';
    $TMPL['post_provider']=getFeaturedimgMeta($POST,'provider');
    $TMPL['post_videoId']=getFeaturedimgMeta($POST,'provider')=='YouTube'?getFeaturedimgMeta($POST,'name'):'';
    $TMPL['post_hit']=$POST['hit'];
    $TMPL['post_d_modify'] = getDateFormat($POST['d_modify']?$POST['d_modify']:$POST['d_regis'],'c');
    $TMPL['post_nic'] = getProfileInfo($POST['mbruid'],'nic');
    $TMPL['post_time'] = getUpImageTime($POST);
    $skin_newPost=new skin('_postList');
    $newPost.=$skin_newPost->make();
  }
}
if (!$_NUM) $newList = '<div>자료가 없습니다.</div>';
$TMPL['newPost'] = $newPost;

//최근 리스트
$listque = 'mbruid='.$mbruid.' and site='.$s;
if ($my['uid']) $listque .= ' and display > 3';  // 회원공개와 전체공개 포스트 출력
else $listque .= ' and display = 5'; // 전체공개 포스트만 출력
$LCD=getDbArray($table['postlist'],$listque,'*','gid','asc',3,1);
$_NUM = getDbRows($table['postlist'],$listque);

$newList = '';
if ($_NUM) {
  foreach ($LCD as $LIST) {
    $TMPL['list_name']=stripslashes($LIST['name']);
    $TMPL['list_uid']=$LIST['uid'];
    $TMPL['list_id']=$LIST['id'];
    $TMPL['list_num']=$LIST['num'];
    $TMPL['list_featured_16by9_sm'] = getPreviewResize(getListImageSrc($LIST['uid']),'480x270');
    $TMPL['list_d_modify'] = getDateFormat($LIST['d_modify']?$LIST['d_modify']:$LIST['d_regis'],'c');
    $TMPL['list_nic'] = getProfileInfo($LIST['mbruid'],'nic');
    $skin_newList=new skin('_listList');
    $newList.=$skin_newList->make();
  }
}
if (!$_NUM) $newList = '<div>자료가 없습니다.</div>';
$TMPL['newList'] = $newList;

if (!$type || $type=='modal' || $type=='page') {
  $markup_file = 'profile'; // 기본 마크업 페이지 전달 (테마 내부 _html/profile.html)
}

// 최종 결과값 추출 (sys.class.php)
$skin=new skin($markup_file);
$result['profile']=$skin->make();
$result['nic'] = $_MD['nic'];

echo json_encode($result);
exit;
?>
