<?php
if(!defined('__KIMS__')) exit;

checkAdmin(0);
$device = $mobile?'mobile':'desktop';
$_ufile = $g['path_module'].$m.'/var/var.order.'.$device.'.php';

$fp = fopen($_ufile,'w');
fwrite($fp, "<?php\n");

foreach ($searchmembers as $_key)
{
	$_val = explode('|',$_key);
	fwrite($fp, "\$d['search_order']['".$_val[0]."'] = array('".$_val[1]."','".$_val[2]."','".$_val[3]."');\n");

}
fwrite($fp, "?>");
fclose($fp);
@chmod($_ufile,0707);

if ($autoCheck) exit;
setrawcookie('search_config_result', rawurlencode('정보가 갱신되었습니다.|success'));  // 처리여부 cookie 저장
getLink('reload','parent.',$auto?'':'','');
?>
