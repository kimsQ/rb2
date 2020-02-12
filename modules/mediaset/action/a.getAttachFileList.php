<?php
if(!defined('__KIMS__')) exit;

$p_module = $_POST['p_module'];
$uid = $_POST['uid'];
$mod = $_POST['mod'];
$theme_file = $_POST['theme_file'];
$theme = $theme_file;

$R = getUidData($table[$p_module.'data'],$uid);

$result=array();
$result['error']=false;

include_once $g['path_module'].'mediaset/themes/'.$theme_file.'/main.func.php';

if($R['upload']) {
  $result['file'] =  getAttachFileList($R,$mod,'file',$p_module);
  $result['photo'] = getAttachFileList($R,$mod,'photo',$p_module);
  $result['photo_full'] = getAttachPhotoSwipeFull($R);
  $result['video'] = getAttachFileList($R,$mod,'video',$p_module);
  $result['audio'] = getAttachFileList($R,$mod,'audio',$p_module);
}

echo json_encode($result);
exit;
?>
