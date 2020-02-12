<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$tmpname	= $_FILES['upfile']['tmp_name'];
$realname	= $_FILES['upfile']['name'];
$nameinfo	= explode('_',str_replace('.zip','',$realname));
$plFolder	= $nameinfo[2];
$plVersion	= $nameinfo[3];
$fileExt	= strtolower(getExt($realname));
$extPath	= $g['path_tmp'].'app';
$extPath1	= $extPath.'/';
$saveFile	= $extPath1.$date['totime'].'.zip';
$plfldPath	= $g['path_switch'].$plFolder;
$plverPath	= $plfldPath.'/'.$plVersion;
$tgFolder	= $plverPath.'/';

if (is_uploaded_file($tmpname))
{
	if ($fileExt != 'zip' || substr($realname,0,10) != 'rb_switch_')
	{
		getLink('reload','parent.','킴스큐 공식 스위치 파일이 아닙니다.','');
	}

	move_uploaded_file($tmpname,$saveFile);

	require $g['path_core'].'opensrc/unzip/ArchiveExtractor.class.php';
	require $g['path_core'].'function/dir.func.php';

	$extractor = new ArchiveExtractor();
	$extractor -> extractArchive($saveFile,$extPath1);
	unlink($saveFile);
	mkdir($plfldPath,0707);
	mkdir($plverPath,0707);
	@chmod($plfldPath,0707);
	@chmod($plverPath,0707);
	DirCopy($extPath1,$tgFolder);
	DirDelete($extPath);
	mkdir($extPath,0707);
	@chmod($extPath,0707);


	$_switchset = array('start','top','head','foot','end');
	$_ufile = $g['path_var'].'switch.var.php';
	$fp = fopen($_ufile,'w');
	fwrite($fp, "<?php\n");

	foreach ($_switchset as $_key)
	{
		foreach ($d['switch'][$_key] as $name => $sites)
		{
			fwrite($fp, "\$d['switch']['".$_key."']['".$name."'] = \"".$sites."\";\n");
		}
	}
	fwrite($fp, "\$d['switch']['".$plFolder."']['".$plVersion."'] = \"\";\n");
	fwrite($fp, "?>");
	fclose($fp);
	@chmod($_ufile,0707);
}
else {
	getLink('','','스위치 파일을 선택해 주세요.','');
}

?>
<script>
var pt = parent.parent.parent ? parent.parent.parent : parent.parent;
var ex = pt.location.href.split('&_admpnl_');
var gx = ex[0] + '&_admpnl_=' + escape(pt.frames._ADMPNL_.location.href);
pt.location.href = gx;
</script>
<?php
exit;
//if ($reload == 'Y') getLink('reload',"parent.parent.",sprintf('스위치[%s]가 추가되었습니다.',$plFolder.'/'.$plVersion),'');
//else getLink('',"parent.parent.$('#modal_window').modal('hide');",sprintf('스위치[%s]가 추가되었습니다.',$plFolder.'/'.$plVersion),'');
?>
