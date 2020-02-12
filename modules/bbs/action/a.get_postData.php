<?php
if(!defined('__KIMS__')) exit;

$result=array();
$result['error']=false;

$uid = $_POST['uid'];
$mod = $_POST['mod'];

$R = getUidData($table['bbsdata'],$uid);
$B = getUidData($table['bbslist'],$R['bbs']);

//게시판 공통설정 변수
$g['bbsVarForSite'] = $g['path_var'].'site/'.$r.'/bbs.var.php';
include_once file_exists($g['bbsVarForSite']) ? $g['bbsVarForSite'] : $g['path_module'].'bbs/var/var.php';

if ($bid) include_once $g['path_var'].'bbs/var.'.$bid.'.php';

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme_attachFile= $d['bbs']['a_mskin']?$d['bbs']['a_mskin']:$d['bbs']['attach_mobile'];
} else {
  $theme_attachFile= $d['bbs']['a_skin']?$d['bbs']['a_skin']:$d['bbs']['attach_main'];
}

include_once $g['dir_module'].'lib/action.func.php';

$mbruid = $my['uid'];
$result['uid'] = $R['uid'];

if ($mod=='view') {

  require_once $g['path_core'].'function/sys.class.php';

  if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
    $theme = $d['bbs']['m_skin']?$d['bbs']['m_skin']:$d['bbs']['skin_mobile'];
    $device = 'mobile';
  } else {
    $theme = $d['bbs']['skin']?$d['bbs']['skin']:$d['bbs']['skin_main'];
    $device = 'desktop';
  }

  include_once $g['dir_module'].'themes/'.$theme.'/_var.php';

  $check_like_qry    = "mbruid='".$mbruid."' and module='".$m."' and entry='".$uid."' and opinion='like'";
  $check_dislike_qry = "mbruid='".$mbruid."' and module='".$m."' and entry='".$uid."' and opinion='dislike'";
  $check_saved_qry   = "mbruid='".$mbruid."' and module='".$m."' and entry='".$uid."'";

  $is_post_liked    = getDbRows($table['s_opinion'],$check_like_qry);
  $is_post_disliked = getDbRows($table['s_opinion'],$check_dislike_qry);
  $is_post_saved    = getDbRows($table['s_saved'],$check_saved_qry);

  $TMPL['s']=$rooturl;
  $TMPL['r']=$raccount;
  $TMPL['m']=$m;
  $TMPL['bid']=$B['id'];
  $TMPL['uid']=$uid;
  $TMPL['subject'] = $R['subject'];
  $TMPL['category'] = $R['category'];
  $TMPL['article'] = getContents($R['content'],$R['html']);
  $TMPL['date'] = getDateFormat($R['d_regis'],$d['theme']['date_viewf']);
  $TMPL['avatar'] = getAvatarSrc($R['mbruid'],'150');
  $TMPL['name'] = $R[$_HS['nametype']];

  $result['content'] = getContents($R['content'],$R['html']);

  $TMPL['featured_img'] = getPreviewResize(getUpImageSrc($R),'480x270');
  $result['featured_img_sm'] = getPreviewResize(getUpImageSrc($R),'240x180');
  $result['featured_img'] = getPreviewResize(getUpImageSrc($R),'480x270');
  $result['featured_img_lg'] = getPreviewResize(getUpImageSrc($R),'686x386');
  $result['featured_img_sq_200'] = getPreviewResize(getUpImageSrc($R),'200x200');
  $result['featured_img_sq_300'] = getPreviewResize(getUpImageSrc($R),'300x300');
  $result['featured_img_sq_600'] = getPreviewResize(getUpImageSrc($R),'600x600');

  $TMPL['hit'] = $R['hit'];
  $TMPL['likes'] = $R['likes'];
  $TMPL['dislikes'] = $R['dislikes'];
  $TMPL['tag'] = getPostTag($R['tag'],$bid);

  if ($is_post_liked) $result['is_post_liked'] = 1;
  if ($is_post_disliked) $result['is_post_disliked'] = 1;
  if ($is_post_saved) $result['is_post_saved'] = 1;
  if ($R['tag']) $result['is_post_tag'] = 1;

  if($R['upload']) {
    if ($AttachListType == 'object') {
      $result['photo'] = getAttachObjectArray($R,'photo');
    } else {
      $result['attachNum'] = _getAttachNum($R['upload'],'view');
      //$result['linkNum'] = getLinkNum($R['upload'],'view');
    }
    $result['theme_attachFile'] = $theme_attachFile;
  }

  if($my['admin'] || $my['uid']==$R['mbruid']) {  // 수정,삭제 버튼 출력여부를 위한 참조
    $result['mypost'] = 1;
  }

  //개별 게시판 설정
  $result['bbs_c_hidden'] = $d['bbs']['c_hidden'];

  // 테마설정
  $result['theme'] = $theme;
  $result['theme_use_reply'] = $d['theme']['use_reply'];
  $result['theme_show_tag'] = $d['theme']['show_tag'];
  $result['theme_show_upfile'] = $d['theme']['show_upfile'] ;
  $result['theme_show_saved'] = $d['theme']['show_saved'];
  $result['theme_show_like'] = $d['theme']['show_like'];
  $result['theme_show_dislike'] = $d['theme']['show_dislike'];
  $result['theme_show_share'] = $d['theme']['show_share'];

  $markup_file = $markup_file?$markup_file:'view'; // 기본 마크업 페이지 전달 (테마 내부 _html/view.html)

  if ($R['hidden']) {  // 비밀글의 경우
    if ($my['uid'] != $R['mbruid'] && $my['uid'] != $R['pw'] && !$my['admin']) {
      $markup_file = 'lock'; //잠김페이지 전달 (테마 내부 _html/lock.html)
      $result['hidden'] = 1;
    }
  }

  //게시물 보기 권한체크
  if (!$my['admin'] && !strstr(','.($d['bbs']['admin']?$d['bbs']['admin']:'.').',',','.$my['id'].',')) {
  	if ($d['bbs']['perm_l_view'] > $my['level'] || strpos('_'.$d['bbs']['perm_g_view'],'['.$my['mygroup'].']')) {
      $markup_file = 'permcheck'; //잠김페이지 전달 (테마 내부 _html/permcheck.html)
      $result['hidden'] = 1;
  	}
  }

  //첨부파일 권한체크
  if (!$my['admin'] && !strstr(','.($d['bbs']['admin']?$d['bbs']['admin']:'.').',',','.$my['id'].',')) {
  	if ($d['bbs']['perm_l_down'] > $my['level'] || (strpos($d['bbs']['perm_g_down'],'['.$my['mygroup'].']')!== false)) {
      $result['hidden_attach'] = 1;
  	}
  }

  $d['bbs']['isperm'] = true;

  if ($d['bbs']['isperm'] && ($d['bbs']['hitcount'] || !strpos('_'.$_SESSION['module_'.$m.'_view'],'['.$uid.']')))
  {
  	if ($R['point2'])
  	{
  		// $g['main'] = $g['dir_module'].'mod/_pointcheck.php';
      $markup_file = 'pointcheck';
  		$d['bbs']['isperm'] = false;
  	}
  	else {
  		getDbUpdate($table[$m.'data'],'hit=hit+1','uid='.$uid);
  		$_SESSION['module_'.$m.'_view'] .= '['.$uid.']';
  	}
  }

  // 최종 결과값 추출 (sys.class.php)
  $skin=new skin($markup_file);
  $result['article']=$skin->make();

} else {

  //글쓰기 수정모드 일때

  $result['subject'] = $R['subject'];
  $result['content'] = getContents($R['content'],$R['html']);
  $result['hidden'] = $R['hidden'];
  $result['notice'] = $R['notice'];
  $result['category'] = $R['category'];
  $result['tag'] = $R['tag'];
  $result['adddata'] = $R['adddata'];
  $result['theme'] = $theme;

  if($R['upload']) {
    $result['attachNum'] = _getAttachNum($R['upload'],'modify');
    $result['theme_attachFile'] = $theme_attachFile;
  }

}

if ($R['oneline']) {
  $TMPL['comment'] = $R['comment'].'+'.$R['oneline'];
  $result['total_comment'] = $R['comment'].'+'.$R['oneline']; // 댓글,한줄의견 등록시 현재댓글수를 내려주기 위함
} else {
  $TMPL['comment'] = $R['comment'];
  $result['total_comment'] = $R['comment']; // 댓글,한줄의견 등록시 현재댓글수를 내려주기 위함
}

$result['bname']=$B['name'];

echo json_encode($result);
exit;
?>
