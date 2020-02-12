<?php
if(!defined('__KIMS__')) exit;

$result=array();
$result['error']=false;

$bid = $_POST['bid'];
$mod = $_POST['mod'];

$B = getDbData($table['bbslist'],'id="'.$bid.'"','*');

if (!$B['uid']) {
  $result['error']='존재하지 않는 게시판 입니다.';
  echo json_encode($result);
  exit;
}

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
include_once $g['path_core'].'function/sys.class.php';

$bbsque = 'site='.$s.' and notice=0';
$bbsque .= ' and bbs='.$B['uid'];

$recnum = $d['bbs']['recnum'];
$NUM = getDbRows($table[$m.'data'],$bbsque);
$TPG = getTotalPage($NUM,$recnum);

//게시물 쓰기 권한체크
$check_permWrite = true;
if (!$my['admin'] && !strstr(','.($d['bbs']['admin']?$d['bbs']['admin']:'.').',',','.$my['id'].',')) {
	if ($d['bbs']['perm_l_write'] > $my['level'] || strpos('_'.$d['bbs']['perm_g_write'],'['.$my['mygroup'].']')) {
    $check_permWrite = false;
	}
}

$TMPL['show_bbs_category'] = $B['category']?'':'d-none';
$TMPL['show_bbs_search'] = $d['theme']['search']==1?'':'d-none';
$TMPL['show_bbs_write'] = $check_permWrite?'':'d-none';
$TMPL['bbs_name'] = $B['name'];
$TMPL['bbs_id'] = $bid;
$TMPL['bbs_write'] = '/b/'.$bid.'/write';

$skin=new skin('bar-tab'); //게시판 테마폴더 > _html > bar-tab.html
$result['bar_tab']=$skin->make();
$result['theme'] = $theme;
$result['sort'] = 'gid';
$result['orderby'] = 'asc';
$result['recnum'] = $recnum;
$result['NUM'] = $NUM;
$result['TPG'] = $TPG;

echo json_encode($result);
exit;
?>
