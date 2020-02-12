<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$cut_modules = '';
foreach($module_members as $mds)
{
	$cut_modules .= '['.$mds.']';
}

$_tmpdfile = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';

$fp = fopen($_tmpdfile,'w');
fwrite($fp, "<?php\n");
fwrite($fp, "\$d['ntfc']['sec'] = \"".trim($sec)."\";\n");
fwrite($fp, "\$d['ntfc']['num'] = \"".trim($num)."\";\n");
fwrite($fp, "\$d['ntfc']['cut_modules'] = \"".trim($cut_modules)."\";\n");
fwrite($fp, "?>");
fclose($fp);
@chmod($_tmpdfile,0707);


getLink('reload','parent.','반영 되었습니다.','');
?>
