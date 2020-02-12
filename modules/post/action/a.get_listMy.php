<?php
if(!defined('__KIMS__')) exit;

$recnum = $_POST['recnum'];

require_once $g['path_core'].'function/sys.class.php';

$listque	= 'mbruid='.$my['uid'];
$RCD = getDbArray($table[$m.'list'],$listque,'*','gid','asc',30,1);
$NUM = getDbRows($table[$m.'list'],$listque);

// 포스트 공개관련
$d['displaySet'] = "||비공개,lock||일부공개,how_to_reg||미등록,insert_link||회원공개,people_alt||전체공개,public";
$g['displaySet']['label'] = [];
$g['displaySet']['icon'] = [];
$displaySet=explode('||',$d['displaySet']);
foreach ($displaySet as $displayLine) {
	$dis=explode(',',$displayLine);
	array_push($g['displaySet']['label'], $dis[0]);
	array_push($g['displaySet']['icon'], $dis[1]);
}

$g['postVarForSite'] = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';
$svfile = file_exists($g['postVarForSite']) ? $g['postVarForSite'] : $g['dir_module'].'var/var.php';
include_once $svfile;

if ($g['mobile']&&$_SESSION['pcmode']!='Y') {
  $theme = $d['post']['skin_mobile'];
} else {
  $theme = $d['post']['skin_main'];
}

$result=array();
$result['error'] = false;

// 로그인한 사용자가 게시물을 저장했는지 여부 체크
$check_saved_qry = "mbruid='".$my['uid']."' and module='".$m."' and entry='".$uid."'";
$is_saved = getDbRows($table['s_saved'],$check_saved_qry);
$result['is_saved']=$is_saved;

$list='';

foreach ($RCD as $R) {
  $is_list =  getDbRows($table[$m.'list_index'],'data='.$uid.' and list='.$R['uid']);
  $TMPL['name']=stripslashes($R['name']);
  $TMPL['uid']=$R['uid'];
  $TMPL['is_list']=$is_list?' checked':'';
  $TMPL['display_label']=$g['displaySet']['label'][$R['display']];
  $TMPL['display_icon']=$g['displaySet']['icon'][$R['display']];
  $skin=new skin($markup_file);
  $list.=$skin->make();
}

$result['list'] = $list;
$result['num'] = $NUM;

echo json_encode($result);
exit;
?>
