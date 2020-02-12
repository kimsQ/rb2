<?php
if(!defined('__KIMS__')) exit;

require_once $g['path_core'].'function/sys.class.php';
include_once $g['dir_module'].'lib/action.func.php';
include_once $g['dir_module'].'var/var.php';

$result=array();
$result['error']=false;

$B = getDbData($table[$m.'list'],"id='".$bid."' and site=".$s,'*');

if (!$B['uid']) {
  $result['error']='존재하지 않는 게시판 입니다.';
  echo json_encode($result);
  exit;
}

$sort='uid';
$orderby='desc';
$recnum=0;
$p=0;

include_once $g['path_var'].'bbs/var.'.$bid.'.php';
include_once $g['dir_module'].'mod/_list.php';

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['bbs']['m_skin']?$d['bbs']['m_skin']:$d['bbs']['skin_mobile'];
} else {
  $theme = $d['bbs']['skin']?$d['bbs']['skin']:$d['bbs']['skin_main'];
}

include_once $g['dir_module'].'themes/'.$theme.'/_var.php';

$mbruid = $my['uid'];

$html='';
foreach ($NCD as $R) {
  $TMPL['title']=$B['name'];
  $TMPL['subject']=htmlspecialchars($R['subject']);
  $TMPL['uid']=$R['uid'];
  $TMPL['name']=$R['name'];
  $TMPL['d_regis']=getDateFormat($R['d_regis'],'Y-m-d');
  if ($collapse) $TMPL['article'] = getContents($R['content'],$R['html']);
  $skin_item=new skin('list-item-notice');
  $html.=$skin_item->make();
}

foreach ($RCD as $R) {
  $TMPL['title']=$B['name'];
  $TMPL['subject']=htmlspecialchars($R['subject']);
  $TMPL['uid']=$R['uid'];
  $TMPL['name']=$R['name'];
  $TMPL['d_regis']=getDateFormat($R['d_regis'],'Y-m-d');
  if ($collapse) $TMPL['article'] = getContents($R['content'],$R['html']);
  $skin_item=new skin('list-item');
  $html.=$skin_item->make();
}
$TMPL['items']=$html;

if($my['admin'] || $my['uid']==$R['mbruid']) {  // 수정,삭제 버튼 출력여부를 위한 참조
  $result['bbsadmin'] = 1;
}

if ($NUM) $markup_file = 'list'; // 기본 마크업 페이지 전달 (테마 내부 _html/view.html)
else $markup_file = 'none';

if ($B['category']) {
  $_catexp = explode(',',$B['category']);
  $_catnum=count($_catexp);
  $category='<option value="" data-bid="'.$bid.'" data-collapse="'.$collapse.'">'.$_catexp[0].'</option>';

  for ($i = 1; $i < $_catnum; $i++) {
    if(!$_catexp[$i])continue;
    $category.= '<option value="'.$_catexp[$i].'"';
    $category.= 'data-bid="'.$bid.'"';
    $category.= ' data-collapse="'.$collapse.'"';
    $category.= 'data-markup="'.$markup_file.'"';
    if ($_catexp[$i]==$cat) $category.= ' selected';
    $category.= '>';
    $category.= $_catexp[$i];
    $category.= '</option>';
  }

  $result['category']=$category;
}

// 최종 결과값 추출 (sys.class.php)
$skin=new skin($markup_file);
$result['list']=$skin->make();

echo json_encode($result);
exit;
?>
