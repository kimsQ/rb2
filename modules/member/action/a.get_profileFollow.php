<?php
if(!defined('__KIMS__')) exit;

require_once $g['path_core'].'function/sys.class.php';
include_once $g['dir_module'].'lib/action.func.php';

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

//팔로우(구독) 목록
$sort	= 'uid';
$orderby= 'desc';
$recnum	= 15;
$mbrque	= 'my_mbruid='.$mbruid;

if ($where && $keyword) $mbrque .= getSearchSql($where,$keyword,$ikeyword,'or');
$RCD = getDbArray($table['s_friend'],$mbrque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['s_friend'],$mbrque);
$TPG = getTotalPage($NUM,$recnum);

$followList = '';

if ($NUM) {
  foreach ($RCD as $R) {
    $num_follower = getProfileInfo($R['by_mbruid'],'num_follower');
    $num_post = getProfileInfo($R['by_mbruid'],'num_post');
    $_isFollowing = getDbRows($table['s_friend'],'my_mbruid='.$my['uid'].' and by_mbruid='.$R['by_mbruid']);
    $TMPL['avatar']=getAvatarSrc($R['by_mbruid'],'130');
    $TMPL['nic']=getProfileInfo($R['by_mbruid'],'nic');
    $TMPL['mbruid']=$R['by_mbruid'];
    $TMPL['profile_url']=getProfileLink($R['by_mbruid']);
    $TMPL['num_follower']=number_format($num_follower);
    $TMPL['num_post']=number_format($num_post);
    $skin_followList=new skin('_followList');
    $followList.=$skin_followList->make();
  }
} else {
  $TMPL['none_txt'] = '구독중인 채널이 없습니다.';
  $skin_followList=new skin('_none');
  $followList.=$skin_followList->make();
}

$result['list']=$followList;
$result['num']=$NUM;

echo json_encode($result);
exit;
?>
