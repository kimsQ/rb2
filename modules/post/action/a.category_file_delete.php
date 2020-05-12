<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$R = getUidData($table[$m.'category'],$cat);
if ($R['img'.$dtype]){
  getDbUpdate($table[$m.'category'],"img".$dtype."=''",'uid='.$R['uid']);
  unlink($g['path_file'].$m.'/category/'.$R['img'.$dtype]);
}

getLink('reload','parent.','','');
?>
