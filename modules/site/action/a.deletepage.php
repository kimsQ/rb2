<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$R = getUidData($table['s_page'],$uid);

getDbDelete($table['s_page'],'uid='.$R['uid']);
getDbDelete($table['s_seo'],'rel=2 and parent='.$R['uid']);

$_xfile = $g['path_page'].$r.'-pages/'.$R['id'];

unlink($_xfile.'.php');

@unlink($_xfile.'.mobile.php');
@unlink($_xfile.'.css');
@unlink($_xfile.'.js');

@unlink($_xfile.'.txt');
@unlink($_xfile.'.cache');
@unlink($_xfile.'.mobile.cache');

if($_HS['startpage'] && $_HS['startpage'] == $R['uid'])
{
	getDbUpdate($table['s_site'],'startpage=0','uid='.$s);
}

db_query("OPTIMIZE TABLE ".$table['s_page'],$DB_CONNECT);

setrawcookie('result_page', rawurlencode('페이지가 삭제 되었습니다.|success'));  // 처리여부 cookie 저장

if ($back=='Y')
{
	getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=page','parent.','','');
}
else {
	getLink('reload','parent.','','');
}
?>
