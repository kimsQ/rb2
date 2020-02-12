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
$_mbruid = $my['uid'];
$type = $_POST['type'];

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['member']['theme_mobile'];
} else {
  $theme = $d['member']['theme_main'];
}

//포스트 목록
$sort	= $sort ? $sort : 'gid';
$orderby= $orderby ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 15;
$postque = 'mbruid='.$mbruid.' and format='.$format.' and site='.$s;

if ($my['uid']) $postque .= ' and display > 3';  // 회원공개와 전체공개 포스트 출력
else $postque .= ' and display = 5'; // 전체공개 포스트만 출력

if ($sort == 'gid' && !$keyword) {

	$TCD = getDbArray($table['postmember'],$postque,'*',$sort,$orderby,$recnum,$p);
	while($_R = db_fetch_array($TCD)) $RCD[] = getDbData($table['postdata'],'gid='.$_R['gid'],'*');
	$NUM = getDbRows($table['postmember'],$postque);

} else {

	if ($where && $keyword) {
		if (strstr('[name][nic][id][ip]',$where)) $postque .= " and ".$where."='".$keyword."'";
		else if ($where == 'term') $postque .= " and d_regis like '".$keyword."%'";
		else $postque .= getSearchSql($where,$keyword,$ikeyword,'or');
	}

	$orderby = 'desc';
	$NUM = getDbRows($table['postdata'],$postque);
	$TCD = getDbArray($table['postdata'],$postque,'*',$sort,$orderby,$recnum,$p);
	while($_R = db_fetch_array($TCD)) $RCD[] = $_R;
}

$TPG = getTotalPage($NUM,$recnum);

switch ($sort) {
	case 'gid' : $sort_txt='생성순';break;
	case 'hit'     : $sort_txt='조회순';break;
	case 'likes'   : $sort_txt='추천순';break;
	case 'comment' : $sort_txt='댓글순';break;
	default        : $sort_txt='최신순';break;
}

$postList = '';

if ($NUM) {
  foreach ($RCD as $POST) {
    $TMPL['post_uid']=$POST['uid'];
    $TMPL['post_cid']=$POST['cid'];
    $TMPL['post_format']=$POST['format'];
    $TMPL['post_subject']=stripslashes($POST['subject']);
    $TMPL['post_featured_16by9'] = getPreviewResize(getUpImageSrc($POST),'640x360');
    $TMPL['post_featured_16by9_sm'] = getPreviewResize(getUpImageSrc($POST),'320x180');
    $TMPL['post_provider']=getFeaturedimgMeta($POST,'provider');
    $TMPL['post_videoId']=getFeaturedimgMeta($POST,'provider')=='YouTube'?getFeaturedimgMeta($POST,'name'):'';
    $TMPL['post_hit']=$POST['hit'];
    $TMPL['post_d_modify'] = getDateFormat($POST['d_modify']?$POST['d_modify']:$POST['d_regis'],'c');
    $TMPL['post_nic'] = getProfileInfo($POST['mbruid'],'nic');
    $TMPL['post_time'] = getUpImageTime($POST);

    $check_like_qry    = "mbruid='".$_mbruid."' and module='".$m."' and entry='".$POST['uid']."' and opinion='like'";
    $check_dislike_qry = "mbruid='".$_mbruid."' and module='".$m."' and entry='".$POST['uid']."' and opinion='dislike'";
    $check_saved_qry   = "mbruid='".$_mbruid."' and module='".$m."' and entry='".$POST['uid']."'";
    $is_post_liked    = getDbRows($table['s_opinion'],$check_like_qry);
    $is_post_disliked = getDbRows($table['s_opinion'],$check_dislike_qry);
    $is_post_saved    = getDbRows($table['s_saved'],$check_saved_qry);
    $TMPL['is_post_liked'] = $is_post_liked?'active':'';
    $TMPL['is_post_disliked'] = $is_post_disliked?'active':'';
    $TMPL['is_post_saved'] = $is_post_saved?'true':'false';

    $skin_postList=new skin('_postList');
    $postList.=$skin_postList->make();
  }
} else {
  $TMPL['none_txt'] = '게시된 포스트가 없습니다.';
  $skin_postList=new skin('_none');
  $postList.=$skin_postList->make();
}

$result['list']=$postList;
$result['num']=$NUM;
$result['tpg']=$TPG;

echo json_encode($result);
exit;
?>
