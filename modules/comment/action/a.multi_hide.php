<?php
if(!defined('__KIMS__')) exit;


checkAdmin(0);

include_once $g['path_module'].'upload/var/var.php';

foreach ($post_members as $val)
{

	$R = getUidData($table[$m.'data'],$val);
	if (!$R['uid']) continue;
	
    getDbUpdate($table[$m.'data'],'display=0','uid='.$val);

	
}


getLink('reload','parent.','선택한 게시물이 모두 숨김처리 되었습니다.    ','');
?>