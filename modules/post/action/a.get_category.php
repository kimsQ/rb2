<?php
if(!defined('__KIMS__')) exit;

$result=array();
$result['error'] = false;
$tree='';

if (getDbRows($table[$m.'category'],'site='.$s.' and reject=0 and hidden=0')) {
  include_once $g['dir_module'].'_main.php';
  $_treeOptions=array('site'=>$s,'table'=>$table[$m.'category'],'dispNum'=>true,'dispHidden'=>false,'dispCheckbox'=>true,'allOpen'=>true);
  $tree = getTreePostCategoryCheck($_treeOptions,$uid,0,0,'');
}

$result['category_tree'] = $tree;

echo json_encode($result);
exit;
?>
