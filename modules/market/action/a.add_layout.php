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
$plfldPath	= $g['path_layout'].$plFolder;
$tgFolder	= $plfldPath.'/';

if (is_uploaded_file($tmpname))
{
	if ($fileExt != 'zip' || substr($realname,0,10) != 'rb_layout_')
	{
		getLink('reload','parent.','킴스큐 공식 레이아웃 파일이 아닙니다.','');
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
	getLink('','','레이아웃 파일을 선택해 주세요.','');
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
//if ($reload == 'Y') getLink('reload',"parent.parent.",'레이아웃이 추가되었습니다.','');
//else getLink('',"parent.parent.$('#modal_window').modal('hide');",'레이아웃이 추가되었습니다.','');
?>
