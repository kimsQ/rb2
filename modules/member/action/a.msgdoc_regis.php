<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

if ($newdoc)
{
	if (is_file($g['dir_module'].'doc/'.$doc.'/'.$newdoc.'.txt'))
	{
		getLink('','','이미 존재하는 양식명칭입니다.    ','');
	}
	else {
		$type = $newdoc;
	}
}
$vfile = $g['dir_module'].'doc/'.$doc.'/'.$type.'.txt';

$fp = fopen($vfile,'w');
fwrite($fp, trim(stripslashes($content)));
fclose($fp);
@chmod($vfile,0707);

if ($newdoc)
{
	setrawcookie('msgdoc_result', rawurlencode('등록 되었습니다.|success'));
	getLink($g['s'].'/?r='.$r.'&m=admin&module='.$m.'&front=msgdoc&doc='.$doc.'&type='.$newdoc,'parent.','','');
}
else {
	setrawcookie('msgdoc_result', rawurlencode('수정 되었습니다.|success'));
	getLink('reload','parent.','','');
}
?>
