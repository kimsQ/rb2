<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);

$snsSet = array('n','k','g','f','t','i');

$_tmpdfile = $g['path_var'].'site/'.$r.'/'.$m.'.var.php';

$fp = fopen($_tmpdfile,'w');
fwrite($fp, "<?php\n");

foreach ($snsSet as $val)
{
	fwrite($fp, "\$d['connect']['key_".$val."'] = \"".${'key_'.$val}."\";\n");
	fwrite($fp, "\$d['connect']['secret_".$val."'] = \"".${'secret_'.$val}."\";\n");
	fwrite($fp, "\$d['connect']['use_".$val."'] = \"".${'use_'.$val}."\";\n");
}

fwrite($fp, "\$d['connect']['jskey_k'] = \"".${'jskey_k'}."\";\n");  // 카카오 JavaScript 키

fwrite($fp, "?>");
fclose($fp);
@chmod($_tmpdfile,0707);

setrawcookie('connect_config_result', rawurlencode('저장 되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.','','');
?>
