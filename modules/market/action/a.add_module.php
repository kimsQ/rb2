<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$tmpname	= $_FILES['upfile']['tmp_name'];
$realname	= $_FILES['upfile']['name'];
$nameinfo	= explode('_',str_replace('.zip','',$realname));
$plFolder	= $nameinfo[2];

for($_i = 3; $_i < count($nameinfo); $_i++)
{
	$plFolder .= '_';
	$plFolder .= $nameinfo[$_i];
}
$fileExt	= strtolower(getExt($realname));
$extPath	= $g['path_tmp'].'app';
$extPath1	= $extPath.'/';
$saveFile	= $extPath1.$date['totime'].'.zip';
$plfldPath	= $g['path_module'].$plFolder;
$tgFolder	= $plfldPath.'/';

if (is_uploaded_file($tmpname))
{
	if ($fileExt != 'zip' || substr($realname,0,10) != 'rb_module_')
	{
		getLink('reload','parent.','킴스큐 공식 모듈 파일이 아닙니다.','');
	}

	if (is_file($g['path_module'].$plFolder.'/main.php'))
	{
		getLink('','',sprintf('이미 동일한 코드의 모듈(%s)이 존재합니다.',$plFolder),'');
	}

	move_uploaded_file($tmpname,$saveFile);

	require $g['path_core'].'function/dir.func.php';

	$zip = new ZipArchive;
	if ($zip->open($saveFile) === TRUE) {
			$zip->extractTo($extPath1);
			$zip->close();
	} else {
			echo 'failed';
	}

	unlink($saveFile);
	mkdir($plfldPath,0707);
	@chmod($plfldPath,0707);
	DirCopy($extPath1,$tgFolder);
	DirDelete($extPath);
	mkdir($extPath,0707);
	@chmod($extPath,0707);
}
else {
	getLink('','','모듈 파일을 선택해 주세요.','');
}



$module		= $plFolder;
$_tmptable2 = $table;
$table		= array();
$table_db	= $g['path_module'].$module.'/_setting/db.table.php';
$table_sc	= $g['path_module'].$module.'/_setting/db.schema.php';
if(is_file($table_db))
{
	$_tmptable1 = array();
	$_tmptfile  = $g['path_var'].'table.info.php';
	include $table_db;
	include $table_sc;

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
	if(is_file($table_db.'.done')) include $table_db.'.done';
}

$maxgid = getDbCnt($_tmptable2['s_module'],'max(gid)','');

$QKEY = "gid,sys,hidden,mobile,name,id,tblnum,icon,d_regis";
$QVAL = "'".($maxgid+1)."','0','0','1','".getFolderName($g['path_module'].$module)."','$module','".count($table)."','kf-module','".$date['totime']."'";

getDbInsert($_tmptable2['s_module'],$QKEY,$QVAL);

?>
<script>
var pt = parent.parent.parent ? parent.parent.parent : parent.parent;
var ex = pt.location.href.split('&_admpnl_');
var gx = ex[0] + '&_admpnl_=' + escape(pt.frames._ADMPNL_.location.href);
pt.location.href = gx;
</script>
<?php
// exit;
if ($reload == 'Y') getLink('reload',"parent.parent.",'모듈이 추가되었습니다.','');
else getLink('',"parent.parent.$('#modal_window').modal('hide');",'모듈이 추가되었습니다.','');
?>
