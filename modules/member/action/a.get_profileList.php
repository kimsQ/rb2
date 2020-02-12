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

//리스트 목록
$sort	= $sort ? $sort : 'gid';
$orderby= $orderby ? $orderby : 'asc';
$recnum	= $recnum && $recnum < 200 ? $recnum : 12;
$listque = 'mbruid='.$mbruid.' and site='.$s;
$where = 'name|tag';

if ($sort != 'gid') $orderby= 'desc';

if ($my['uid']) $listque .= ' and display > 3';  // 회원공개와 전체공개 포스트 출력
else $listque .= ' and display = 5'; // 전체공개 포스트만 출력

if ($where && $keyword)
{
	if (strstr('[name][nic][id][ip]',$where)) $listque .= " and ".$where."='".$keyword."'";
	else if ($where == 'term') $listque .= " and d_regis like '".$keyword."%'";
	else $listque .= getSearchSql($where,$keyword,$ikeyword,'or');
}
$RCD = getDbArray($table['postlist'],$listque,'*',$sort,$orderby,$recnum,$p);
$NUM = getDbRows($table['postlist'],$listque);
$TPG = getTotalPage($NUM,$recnum);


$listList = '';

if ($NUM) {
  foreach ($RCD as $LIST) {
    $TMPL['list_name']=stripslashes($LIST['name']);
    $TMPL['list_uid']=$LIST['uid'];
    $TMPL['list_id']=$LIST['id'];
    $TMPL['list_num']=$LIST['num'];
    $TMPL['list_featured_16by9_sm'] = getPreviewResize(getListImageSrc($LIST['uid']),'480x270');
    $TMPL['list_d_modify'] = getDateFormat($LIST['d_modify']?$LIST['d_modify']:$LIST['d_regis'],'c');
    $TMPL['list_nic'] = getProfileInfo($LIST['mbruid'],'nic');
    $skin_listList=new skin('_listList');
    $listList.=$skin_listList->make();
  }
} else {
  $TMPL['none_txt'] = '게시된 리스트가 없습니다.';
  $skin_listList=new skin('_none');
  $listList.=$skin_listList->make();
}

$result['list']=$listList;
$result['num']=$NUM;

echo json_encode($result);
exit;
?>
