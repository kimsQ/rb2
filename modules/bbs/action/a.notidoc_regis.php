<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$fdset = array('noti_title','noti_body','noti_button');
$vfile = $g['path_var'].$m.'/noti/'.$type.'.php';

if (!is_dir($g['path_var'].$m.'/noti')) mkdir($g['path_var'].$m.'/noti');

$fp = fopen($vfile,'w');
fwrite($fp, "<?php\n");
foreach ($fdset as $val)
{
	fwrite($fp, "\$d['bbs']['".$val."'] = \"".trim(${$val})."\";\n");
}
fwrite($fp, "?>");
fclose($fp);
@chmod($vfile,0707);

setrawcookie('msgdoc_result', rawurlencode('수정 되었습니다.|success'));
getLink('reload','parent.','','');
?>
