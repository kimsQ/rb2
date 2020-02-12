<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$tmpname	= $_FILES['upfile']['tmp_name'];
$realname	= $_FILES['upfile']['name'];
$fileExt	= strtolower(getExt($realname));
$extPath	= $g['path_tmp'].'app';
$extPath1	= $extPath.'/';
$saveFile	= $extPath1.$date['totime'].'.zip';
$tgFolder	= './';

if (is_uploaded_file($tmpname))
{
	if ($fileExt != 'zip' || substr($realname,0,7) != 'rb_etc_')
	{
		getLink('reload','parent.','킴스큐 공식 기타자료 파일이 아닙니다.','');
	}

	move_uploaded_file($tmpname,$saveFile);

	require $g['path_core'].'opensrc/unzip/ArchiveExtractor.class.php';
	require $g['path_core'].'function/dir.func.php';

	$extractor = new ArchiveExtractor();
	$extractor -> extractArchive($saveFile,$extPath1);
	unlink($saveFile);
	DirCopy($extPath1,$tgFolder);
	DirDelete($extPath);
	mkdir($extPath,0707);
	@chmod($extPath,0707);
}
else {
	getLink('','','기타자료 파일을 선택해 주세요.','');
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
//if ($reload == 'Y') getLink('reload',"parent.parent.",'기타자료가 추가되었습니다.','');
//else getLink('',"parent.parent.$('#modal_window').modal('hide');",'기타자료가 추가되었습니다.','');
?>
