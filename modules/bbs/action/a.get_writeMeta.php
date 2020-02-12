<?php
if(!defined('__KIMS__')) exit;

include_once $g['path_core'].'function/sys.class.php';
require_once $g['dir_module'].'lib/base.class.php';
require_once $g['dir_module'].'lib/module.class.php';

$result=array();
$result['error']=false;

$bid = $_POST['bid'];

$B = getDbData($table['bbslist'],'id="'.$bid.'"','*');

//게시판 공통설정 변수
$g['bbsVarForSite'] = $g['path_var'].'site/'.$r.'/bbs.var.php';
include_once file_exists($g['bbsVarForSite']) ? $g['bbsVarForSite'] : $g['path_module'].'bbs/var/var.php';

include_once $g['path_var'].'bbs/var.'.$bid.'.php';

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['bbs']['m_skin']?$d['bbs']['m_skin']:$d['bbs']['skin_mobile'];
} else {
  $theme = $d['bbs']['skin']?$d['bbs']['skin']:$d['bbs']['skin_main'];
}

include_once $g['dir_module'].'themes/'.$theme.'/_var.php';

$bbs = new Bbs();
$bbs->theme_name = $theme;

$TMPL['bid']=$bid;

$html = '';
$html .= $bbs->getHtml('write-meta-tag');
if ($B['category']) $html .= $bbs->getHtml('write-meta-category');
if ($d['theme']['use_hidden']==1) $html .= $bbs->getHtml('write-meta-hidden');
if ($my['admin']) $html .= $bbs->getHtml('write-meta-notice');

$result['has_category']=$B['category']?true:false;
$result['list']=$html;

echo json_encode($result);
exit;
?>
