<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if (!$cat) getLink('./?m=admin&module='.$m.'&front=menu','parent.','','');

include $g['path_core'].'function/menu.func.php';
$subQue = getMenuCodeToSql($table['s_menu'],$cat,'uid');

if ($subQue)
{
	$DAT = getDbSelect($table['s_menu'],$subQue,'*');
	while($R=db_fetch_array($DAT))
	{
		getDbDelete($table['s_menu'],'uid='.$R['uid']);
		getDbDelete($table['s_seo'],'rel=1 and parent='.$R['uid']);

		$_xfile = $g['path_page'].$r.'-menus/'.$R['id'];

		unlink($_xfile.'.php');
		@unlink($_xfile.'.mobile.php');
		@unlink($_xfile.'.css');
		@unlink($_xfile.'.js');
		@unlink($_xfile.'.header.php');
		@unlink($_xfile.'.footer.php');

		@unlink($_xfile.'.txt');
		@unlink($_xfile.'.cache');
		@unlink($_xfile.'.mobile.cache');

		@unlink($g['path_var'].'menu/'.$R['imghead']);
		@unlink($g['path_var'].'menu/'.$R['imgfoot']);
	}

	if ($parent)
	{
		if (!getDbRows($table['s_menu'],'parent='.$parent))
		{
			getDbUpdate($table['s_menu'],'is_child=0','uid='.$parent);
		}
	}
	db_query("OPTIMIZE TABLE ".$table['s_menu'],$DB_CONNECT);
}

setrawcookie('result_menu', rawurlencode('메뉴가 삭제 되었습니다.|success'));  // 처리여부 cookie 저장

if ($back=='Y')
{
	getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=menu','parent.','','');
}
else {
	getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=menu&cat='.$parent.'&amp;code='.$code,'parent.','','');
}
?>
