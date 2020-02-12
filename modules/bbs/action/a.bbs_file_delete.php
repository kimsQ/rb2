<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$R = getDbData($table[$m.'list'],"id='".$bid."'",'*');

if ($R['img'.$dtype])
{
	getDbUpdate($table[$m.'list'],"img".$dtype."=''",'uid='.$R['uid']);
	unlink($g['dir_module'].'var/files/'.$R['img'.$dtype]);
}
setrawcookie('result_bbs_main', rawurlencode('파일이 삭제 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
