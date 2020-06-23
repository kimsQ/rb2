<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$R = getDbData($table['s_module'],"id='".$moduleid."'",'*');
if (!$R['id']) getLink('','','존재하지 않는 모듈입니다.','');
if ($R['sys'] || $R['system']) getLink('','','시스템모듈은 삭제할 수 없습니다.','');

getDbDelete($table['s_module'],"id='".$moduleid."'");

include_once $g['path_core'].'function/dir.func.php';

$table_db  = $g['path_module'].$moduleid.'/_setting/db.table.php.done';
$_tmptfile = $g['path_var'].'table.info.php';

if(is_file($table_db))
{
	$module= $moduleid;
	$_table= $table;
	$table = array();
	include_once $table_db;

	$fp = fopen($_tmptfile,'w');
	fwrite($fp, "<?php\n");
	foreach($_table as $key => $val)
	{
		if (!$table[$key])
		{
			fwrite($fp, "\$table['$key'] = \"$val\";\n");
		}
	}
	fwrite($fp, "?>");
	fclose($fp);
	@chmod($_tmptfile,0707);

	foreach($table as $key => $val)
	{
		db_query('drop table '.$val,$DB_CONNECT);
	}
}


DirDelete($g['path_module'].$R['id']);

getLink($g['s'].'/?r='.$r.'&m=admin&panel=Y&pickmodule='.$m,'parent.parent.','','');

?>
