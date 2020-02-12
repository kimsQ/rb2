<?php
if(!defined('__KIMS__')) exit;

require_once $g['path_core'].'function/sys.class.php';

$bbs = $_GET['bbs']; // 게시퍈 UID
$sort = $_GET['sort']; // 정렬 기준
$orderby = $_GET['orderby']; // 정렬순서
$recnum = $_GET['recnum']; // 출력갯수
$page = $_GET['page']; // 처음엔 무조건 1
$bbs_view = $_GET['bbs_view'];
$where = 'site='.$s.' and bbs='.$bbs.' and notice=0'; // 출력 조건

$B = getUidData($table[$m.'list'],$bbs);
include_once $g['path_module'].'bbs/var/var.php';
include_once $g['path_var'].'bbs/var.'.$B['id'].'.php';

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['bbs']['m_skin']?$d['bbs']['m_skin']:$d['bbs']['skin_mobile'];
} else {
  $theme = $d['bbs']['skin']?$d['bbs']['skin']:$d['bbs']['skin_main'];
}
include_once $g['dir_module'].'themes/'.$theme.'/_var.php';

$result=array();
$result['error'] = false;

$RCD = getDbArray($table['bbsdata'],$where,'*',$sort,$orderby,$recnum,$page);
$html='';

$markup_file = 'moreList'; // 기본 마크업 페이지 전달 (테마 내부 _html/moreList.html)
$skin=new skin($markup_file);

while($R = db_fetch_array($RCD)){

 $TMPL['category'] = $R['category'];
 $TMPL['subject'] = $R['subject'];
 $TMPL['bname'] = $B['name'];
 $TMPL['bid'] = $B['id'];
 $TMPL['uid'] = $R['uid'];
 $TMPL['name'] = $R[$_HS['nametype']];
 $TMPL['comment'] = $R['comment'];
 $TMPL['oneline'] = $R['oneline']?'+'.$R['oneline']:'';
 $TMPL['category'] = $R['category'];
 $TMPL['hit'] = $R['hit'];
 $TMPL['likes'] = $R['likes'];
 $TMPL['d_regis'] = getDateFormat($R['d_regis'],'Y.m.d');
 $TMPL['bbs_view_url'] = $bbs_view.$R['uid'];
 $TMPL['datetime'] = getDateFormat($R['d_regis'],'c');
 $TMPL['avatar'] = getAvatarSrc($R['mbruid'],'84');
 $TMPL['featured_img'] = getPreviewResize(getUpImageSrc($R),'120x120');

 $TMPL['check_secret'] = $R['hidden']?' secret':'';
 $TMPL['check_hidden'] = $R['hidden']?'':' d-none';
 $TMPL['check_new'] = getNew($R['d_regis'],24)?'':' d-none';
 $TMPL['check_notice'] = $R['notice']?'':' d-none';
 $TMPL['check_upload'] = $R['upload']?'':' d-none';
 $TMPL['check_category'] = $R['category']?'':' d-none';
 $TMPL['check_timeago'] = $d['theme']['timeago']?'data-plugin="timeago"':'';
 $TMPL['check_depth'] = $R['depth']?' rb-reply rb-reply-0'.$R['depth']:'';

 // 미디어 오브젝트 (아바타=1/대표이미지=2/감춤=0)
 if ($d['theme']['media_object']=='1' && !$R['depth']) {

   $TMPL['check_avatar'] = '';
   $TMPL['check_preview'] = 'd-none';
   $TMPL['check_replay'] = 'd-none';

 } elseif ($d['theme']['media_object']=='2' && !$R['depth']) {

   $TMPL['check_avatar'] = 'd-none';
   $TMPL['check_replay'] = 'd-none';
   if (getUpImageSrc($R)) $TMPL['check_preview'] = '';
   else $TMPL['check_preview'] = 'd-none';

 } else {

   $TMPL['check_avatar'] = 'd-none';
   $TMPL['check_preview'] = 'd-none';
   $TMPL['check_replay'] = '';
 }

 $html.=$skin->make();

}

$result['content'] = $html;

echo json_encode($result);
exit;
?>
