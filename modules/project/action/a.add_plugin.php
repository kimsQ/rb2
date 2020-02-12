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
$plfldPath	= $g['path_plugin'].$plFolder;
$plverPath	= $plfldPath.'/'.$plVersion;
$tgFolder	= $plverPath.'/';

if (is_uploaded_file($tmpname))
{
	if ($fileExt != 'zip' || substr($realname,0,10) != 'rb_plugin_')
	{
		getLink('reload','parent.','킴스큐 공식 플러그인 파일이 아닙니다.','');
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

	if (!$plVersion)
	{
		$dirh = opendir($plfldPath);
		while(false !== ($filename = readdir($dirh)))
		{
			if($filename == '.' || $filename == '..' || is_file($plfldPath.'/'.$filename)) continue;
			$plVersion = $filename;
		}
		closedir($dirh);
	}

	if (!$d['ov'][$plFolder])
	{
		$_tmpdfile = $g['path_var'].'plugin.var.php';
		$fp = fopen($_tmpdfile,'w');
		fwrite($fp, "<?php\n");
		foreach ($d['ov'] as $_key_ => $_val_)
		{
			fwrite($fp, "\$d['ov']['".$_key_."'] = '".trim($_val_)."';\n");
		}
		fwrite($fp, "\$d['ov']['".$plFolder."'] = '".$plVersion."';\n");
		fwrite($fp, "?>");
		fclose($fp);
		@chmod($_tmpdfile,0707);
	}
	if (is_file($g['path_plugin'].$plFolder.'/size.txt'))
	{
		unlink($g['path_plugin'].$plFolder.'/size.txt');
	}
}
else {
	getLink('','','플러그인 파일을 선택해 주세요.','');
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
//if ($reload == 'Y') getLink('reload',"parent.parent.",sprintf('플러그인[%s]이 추가되었습니다.',$plFolder.' - v.'.$plVersion),'');
//else getLink('',"parent.parent.$('#modal_window').modal('hide');",sprintf('플러그인[%s]이 추가되었습니다.',$plFolder.' - v.'.$plVersion),'');
?>
