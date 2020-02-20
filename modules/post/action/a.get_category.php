<?php
if(!defined('__KIMS__')) exit;

$g['postVarForSite'] = $g['path_var'].'site/'.$r.'/post.var.php';
$_tmpvfile = file_exists($g['postVarForSite']) ? $g['postVarForSite'] : $g['dir_module'].'var/var.php';
include_once $_tmpvfile;

$result=array();
$result['error'] = false;

if (!$my['admin']) {
	if ($d['post']['perm_l_category'] > $my['level'] || strpos('_'.$d['post']['perm_g_category'],'['.$my['mygroup'].']') || !$my['uid']) {
		$error_msg = '카테고리 권한이 없습니다.';
    $result['error'] = $error_msg;
    echo json_encode($result);
    exit;
	}
}

$tree='';

if (getDbRows($table[$m.'category'],'site='.$s.' and reject=0 and hidden=0')) {
  include_once $g['dir_module'].'_main.php';
  $_treeOptions=array('site'=>$s,'table'=>$table[$m.'category'],'dispNum'=>true,'dispHidden'=>false,'dispCheckbox'=>true,'allOpen'=>false);
  $tree = getTreePostCategoryCheck($_treeOptions,$uid,0,0,'');
}

$result['category_tree'] = $tree;

echo json_encode($result);
exit;
?>
