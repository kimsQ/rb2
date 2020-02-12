<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$isModule = getDbRows($table['s_module'],"id='".$module."'");
if ($isModule)
{
	getLink('','','이미 설치된 모듈입니다.','');
}
else {
	if (!is_file($g['path_module'].$module.'/main.php'))
	{
		getLink('','','존재하지 않는 모듈입니다.','');
	}
	$_tmptable2 = $table;
	$table		= array();
	$table_db	= $g['path_module'].$module.'/_setting/db.table.php';
	$table_sc	= $g['path_module'].$module.'/_setting/db.schema.php';
	if(is_file($table_db)) 
	{	
		$_tmptable1 = array();
		$_tmptfile  = $g['path_var'].'table.info.php';
		include_once $table_db;
		include_once $table_sc;

		$_tmptable1 = $table;
		rename($table_db,$table_db.'.done');

		$fp = fopen($_tmptfile,'w');
		fwrite($fp, "<?php\n");
		foreach($_tmptable2 as $key => $val) fwrite($fp, "\$table['$key'] = \"$val\";\n");
		foreach($_tmptable1 as $key => $val) fwrite($fp, "\$table['$key'] = \"$val\";\n");
		fwrite($fp, "?>");
		fclose($fp);
		@chmod($_tmptfile,0707);
	}
	else {
		if(is_file($table_db.'.done')) include_once $table_db.'.done';
	}
	
	$maxgid = getDbCnt($_tmptable2['s_module'],'max(gid)','');

	$QKEY = "gid,system,hidden,mobile,name,id,tblnum,d_regis";
	$QVAL = "'".($maxgid+1)."','0','0','1','".getFolderName($g['path_module'].$module)."','$module','".count($table)."','".$date['totime']."'";

	getDbInsert($_tmptable2['s_module'],$QKEY,$QVAL);

	getLink('reload','parent.','모듈이 정상적으로 설치되었습니다.','');
}
?>