<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if ($type == 'pc')
{
	getDbUpdate($table['s_site'],"layout='".$layout."/main.php'",'uid='.$s);
	getWindow(RW(0),'PC모드 대표 레이아웃으로 적용되었습니다.','','','');
	exit;
}
else {
	getDbUpdate($table['s_site'],"m_layout='".$layout."/main.php'",'uid='.$s);
	getLink('','','모바일웹 대표레이아웃으로 적용되었습니다.  \n\n모바일기기나 에뮬레이터로 확인하세요.','');
}
?>