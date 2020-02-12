<?php
if(!defined('__KIMS__')) exit;

if (!$my['uid'])
{
	getLink('','','정상적인 접근이 아닙니다.','');
}

$tmpname	= $_FILES['upfile']['tmp_name'];
$realname	= strtolower($_FILES['upfile']['name']);
$fileExt	= strtolower(getExt($realname));
$fileExt	= $fileExt == 'jpeg' ? 'jpg' : $fileExt;
$photo		= md5($realname).substr($date['totime'],8,14).'.'.$fileExt;
$saveFile	= $g['path_file'].'cover/'.$photo;

if (is_uploaded_file($tmpname))
{
	if (!strstr('[gif][jpg][png]',$fileExt))
	{
		getLink('','','gif/jpg/png 파일만 등록할 수 있습니다.','');
	}
	if (is_file($saveFile))
	{
		unlink($saveFile);
	}

	$wh = getimagesize($tmpname);
	if ($wh[0] < 860 )
	{
		getLink('','','가로 860픽셀 이상이어야 합니다.','');
	}

	include_once $g['path_core'].'function/thumb.func.php';

	if ($fileExt == 'gif')
	{
		move_uploaded_file($tmpname,$saveFile);
	}
	else {
		move_uploaded_file($tmpname,$saveFile);

		if ($fileExt == 'jpg') {
			exifRotate($saveFile); //가로세로 교정
		}
		ResizeWidth($saveFile,$saveFile,1200);
	}

	getDbUpdate($table['s_mbrdata'],"cover='".$photo."'",'memberuid='.$my['uid']);
}
setrawcookie('member_settings_result', rawurlencode('커버 이미지가 수정되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
