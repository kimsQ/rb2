<?php
function LIB_getUploadImage($upfiles,$d,$content,$ext)
{
	$imgs = getImgs($content,$ext);
	if ($imgs[0])
	{
		if (!$upfiles) return $imgs[0];
		$basename = basename($imgs[0]);
		$encname  = md5($basename);
		$folder   = substr($d,0,4).'/'.substr($d,4,2).'/'.substr($d,6,2);
		if (is_file($GLOBALS['g']['path_file'].$folder.'/'.$encname)) return str_replace($basename,'',$imgs[0]).$encname;
	}
	if ($upfiles)
	{
		$upArray = getArrayString($upfiles);
		foreach($upArray['data'] as $_val)
		{
			$U = getUidData($GLOBALS['table']['s_upload'],$_val);
			if (!$U['uid']) continue;
			if (strpos('_jpg,gif,png',$U['ext']))
			{
				return $U['url'].$U['folder'].'/'.$U['thumbname'];
			}
		}
	}
}
?>