<?php
if(!defined('__KIMS__')) exit;

$recnum = $_POST['recnum'];

require_once $g['path_core'].'function/sys.class.php';

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
  $TMPL['start']=$start;
} else {
  $theme = $d['post']['skin_main'];
}

include_once $g['dir_module'].'themes/'.$theme.'/_var.php';

$sort	= $sort ? $sort : 'gid';
$orderby= $orderby ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 201 ? $recnum : 15;
$where = 'name|tag';
$listque	= 'mbruid='.$my['uid'].' and site='.$s;

if ($display) $listque .= ' and display='.$display;

if ($where && $keyword) {
	if (strstr('[id]',$where)) $listque .= " and ".$where."='".$keyw."'";
	else $listque .= getSearchSql($where,$keyword,$ikeyword,'or');
}

$RCD = getDbArray($table['postlist'],$listque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['postlist'],$listque);
$TPG = getTotalPage($NUM,$recnum);

$formats = explode(',', $d['theme']['format']);array_unshift($formats,'');

$result=array();
$result['error'] = false;
$list='';

$TMPL['start']=$start;

foreach ($RCD as $R) {
  $TMPL['name']=stripslashes($R['name']);
  $TMPL['format'] = $formats[$R['format']];
  $TMPL['uid']=$R['uid'];
	$TMPL['id']=$R['id'];
	$TMPL['num']=$R['num'];
  $TMPL['featured_16by9'] = getPreviewResize(getListImageSrc($R['uid']),'480x270');
  $TMPL['d_modify'] = getDateFormat($R['d_modify']?$R['d_modify']:$R['d_regis'],'c');
  $TMPL['nic'] = getProfileInfo($R['mbruid'],'nic');
  $TMPL['display']=$R['display']!=5?$g['displaySet']['icon'][$R['display']]:'';

  $skin=new skin($markup_file);
  $list.=$skin->make();
}

$result['list'] = $list;
$result['num'] = $NUM;
$result['tpg']= $TPG;

echo json_encode($result);
exit;
?>
