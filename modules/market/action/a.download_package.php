<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

require $g['path_core'].'opensrc/unzip/ArchiveExtractor.class.php';
require $g['path_core'].'function/dir.func.php';
include $g['path_core'].'function/rss.func.php';

$rbPackage = getUrlData('http://download.kimsq.co.kr/__update/package/'.$package.'.zip',10);

if (!trim($rbPackage))
{
	echo '<script>';
	echo "parent.alert('다운로드 실패    ');";
	echo '</script>';
	exit;
}

$rbPackageFile = $g['path_tmp'].'app/'.$package.'.zip';
$fp = fopen($rbPackageFile,'w');
fwrite($fp,$rbPackage);
fclose($fp);

$extractor = new ArchiveExtractor();
$extractor -> extractArchive($rbPackageFile,$g['path_tmp'].'app/'.$package.'/');
DirChmod($g['path_tmp'].'app/',0707);
unlink($rbPackageFile);

getLink($g['s'].'/?r='.$r.'&iframe=Y&m=admin&module='.$m.'&front=modal.package&package_step=2&package_folder='.$package,'parent.','','');
?>
