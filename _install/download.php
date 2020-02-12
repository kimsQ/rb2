<?php
if(!defined('__KIMS__')) exit;

if ($sitelang)
{
	include $g['path_root'].'_install/rss.func.php';
	$_langfile = $g['path_root'].'_install/language/'.$sitelang.'/lang.action.php';
	if (is_file($_langfile)) include $_langfile;
}

if (!is_file($g['path_root'].'LICENSE'))
{
	include $g['path_root'].'_install/dir.func.php';
	require $g['path_root'].'_install/unzip/ArchiveExtractor.class.php';

	if (!is_writable($g['path_root']))
	{
		$_filePath = explode('/',$_SERVER['SCRIPT_NAME']);
		$_instPath = $_filePath[count($_filePath)-2];
		echo '<script>';
		echo "parent.errDownload('[".($_instPath?$_instPath:_LANG('a001','install'))."]');";
		echo '</script>';
		exit;
	}

	if ($version == '1')
	{
		$tmpname	= $_FILES['upfile']['tmp_name'];
		$realname	= $_FILES['upfile']['name'];

		if (is_uploaded_file($tmpname))
		{
			if (substr($realname,0,3) != 'rb-' || substr($realname,-4) != '.zip')
			{
				echo '<script>';
				echo "parent.errDownload('1');";
				echo '</script>';
				exit;
			}

			$extPath	= './';
			$saveFile	= $extPath.'rb2-package.zip';
			move_uploaded_file($tmpname,$saveFile);

			$extractor = new ArchiveExtractor();
			$extractor -> extractArchive($saveFile,$g['path_root']);
			DirChmod($g['path_root'],0707);
			unlink($saveFile);
		}
	}
	else {
		$rbPackage = getUrlData('http://www.kimsq.co.kr/__update/core/'.$version.'.zip',10);
		if (!trim($rbPackage))
		{
			echo '<script>';
			echo "parent.errDownload('');";
			echo '</script>';
			exit;
		}

		$rbPackageFile = $g['path_root'].$version.'.zip';
		$fp = fopen($rbPackageFile,'w');
		fwrite($fp,$rbPackage);
		fclose($fp);

		$zip = new ZipArchive;
		if ($zip->open($rbPackageFile) === TRUE) {
		    $zip->extractTo($g['path_root']);
		    $zip->close();
		} else {
		    echo 'failed';
		}

		DirChmod($g['path_root'],0707);
		unlink($rbPackageFile);
	}
}
?>

<script>
window.onload = function()
{
	parent.location.href = './index.php?sitelang=<?php echo $sitelang?>';
}
</script>
