<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if (!$cat) getLink($g['r'].'/?m=admin&module='.$m,'parent.','','');

include_once $g['path_core'].'function/menu.func.php';
$subQue = getMenuCodeToSql($table['s_domain'],$cat,'uid');

if ($subQue)
{
	$DAT = db_query('select * from '.$table['s_domain'].' where '.$subQue,$DB_CONNECT);
	while($R=db_fetch_array($DAT))
	{
		db_query('delete from '.$table['s_domain'].' where uid='.$R['uid'],$DB_CONNECT);
	}
	
	if ($parent)
	{
		if (!getDbRows($table['s_domain'],'parent='.$parent))
		{
			db_query('update '.$table['s_domain'].' set is_child=0 where uid='.$parent,$DB_CONNECT);
		}
	}
}
getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&cat='.$parent.'&code='.$code,'parent.','','');
?>