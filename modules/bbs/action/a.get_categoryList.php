<?php
if(!defined('__KIMS__')) exit;

$result=array();
$result['error']=false;

$bid = $_POST['bid'];

if (!$bid ) exit;

//게시판 공통설정 변수
$g['bbsVarForSite'] = $g['path_var'].'site/'.$r.'/bbs.var.php';
include_once file_exists($g['bbsVarForSite']) ? $g['bbsVarForSite'] : $g['path_module'].'bbs/var/var.php';

include_once $g['path_core'].'function/sys.class.php';
include_once $g['path_var'].'bbs/var.'.$bid.'.php';

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['bbs']['m_skin']?$d['bbs']['m_skin']:$d['bbs']['skin_mobile'];
} else {
  $theme = $d['bbs']['skin']?$d['bbs']['skin']:$d['bbs']['skin_main'];
}

$B = getDbData($table['bbslist'],'id="'.$bid.'"','*');
$_catexp = explode(',',$B['category']);
$_catnum=count($_catexp);

$markup_file = ($mod=='write')?'category-list-radio':'category-list-item';

$TMPL['label']=$_catexp[0];
$TMPL['bname']=$B['name'];

$html = '';
for ($i = 1; $i < $_catnum; $i++) {
  if(!$_catexp[$i])continue;

  $TMPL['category']=$_catexp[$i];
  $TMPL['num']=getDbRows($table[$m.'data'],'site='.$s.' and notice=0 and bbs='.$B['uid']." and category='".$_catexp[$i]."'");

  $skin_item=new skin($markup_file);
  $html.=$skin_item->make();
}

$TMPL['items'] = $html;

$skin=new skin('category-list');
$result['list']=$skin->make();


echo json_encode($result);
exit;
?>
